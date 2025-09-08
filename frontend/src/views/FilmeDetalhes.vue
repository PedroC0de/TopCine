<template>
  <div class="bg-gray-800 min-h-screen text-white">
    <main class="p-6 max-w-7xl mx-auto">
      <!-- Feedback de carregamento -->
      <div v-if="isLoading" class="text-center mt-10">
        Carregando detalhes do filme...
      </div>
      <!-- Erro -->
      <div v-else-if="error" class="text-center mt-10">
        <div class="text-xl mb-2">Erro ao carregar detalhes</div>
        <div class="text-gray-400">{{ error }}</div>
        <router-link to="/" class="text-blue-400 hover:underline mt-4 inline-block">Voltar para Home</router-link>
      </div>
      <!-- Detalhes do filme -->
      <div v-else-if="filme" class="flex flex-col md:flex-row gap-6">
        <div class="md:w-1/3">
          <img :src="'https://image.tmdb.org/t/p/w500' + filme.poster_path" :alt="filme.title"
            class="w-full rounded-lg shadow-lg" />
        </div>
        <div class="md:w-2/3">
          <h1 class="text-3xl font-bold mb-4">{{ filme.title }}</h1>
          <p class="text-gray-300 mb-4">{{ filme.overview || 'Sinopse não disponível' }}</p>
          <div class="mb-4">
            <span class="font-bold">Data de Lançamento:</span>
            {{ filme.release_date ? new Date(filme.release_date).toLocaleDateString('pt-BR') : 'N/A' }}
          </div>
          <div class="mb-4">
            <span class="font-bold">Gêneros:</span>
            {{ filme.genres?.map(g => g.name).join(', ') || 'N/A' }}
          </div>
          <div class="mb-4">
            <span class="font-bold">Avaliação:</span>
            {{ filme.vote_average?.toFixed(1) || 'N/A' }} / 10 ({{ filme.vote_count || 0 }} votos)
          </div>
          <div class="mb-4">
            <span class="font-bold">Duração:</span>
            {{ filme.runtime ? `${filme.runtime} minutos` : 'N/A' }}
          </div>
          <router-link to="/" class="text-blue-400 hover:underline">Voltar para Home</router-link>
        </div>
      </div>
    </main>
  </div>
</template>


<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { getFilmeDetalhes } from '../api.js';

const route = useRoute();
const filme = ref(null);
const isLoading = ref(false);
const error = ref(null);

async function carregarDetalhes() {
  isLoading.value = true;
  try {
    const id = route.params.id;
    filme.value = await getFilmeDetalhes(id);
  } catch (err) {
    error.value = 'Não foi possível carregar os detalhes do filme.';
  } finally {
    isLoading.value = false;
  }
}

onMounted(() => {
  carregarDetalhes();
});
</script>
