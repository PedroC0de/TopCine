<template>
  <div class="bg-gray-800 min-h-screen">
    <main class="p-6 space-y-12">
      <!-- Feedback de carregamento -->
      <div v-if="isLoading" class="text-white text-center mt-10">
        Carregando...
      </div>
      <!-- Favoritos -->
      <section v-else-if="favoritos.length > 0">
        <h2 class="text-white text-2xl mb-4 font-bold">Meus Favoritos</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
          <FilmeCard v-for="filme in favoritos" :key="filme.id_tmdb" :filme="filme" :favoritoInicial="true" @favorito-updated="carregarFavoritos" />
        </div>
      </section>
      <!-- Mensagem quando não há favoritos -->
      <div v-else class="text-white text-center mt-10">
        <div class="text-xl mb-2">Nenhum favorito encontrado</div>
        <div class="text-gray-400">Adicione filmes aos seus favoritos!</div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'; 
import { useRoute, useRouter } from 'vue-router';
import FilmeCard from '../components/FilmeCard.vue';
import { getFavoritos } from '../api.js';

const route = useRoute();
const router = useRouter();
const favoritos = ref([]);
const isLoading = ref(false);

async function carregarFavoritos(genre = '', query = '') { 
  isLoading.value = true;
  try {
    favoritos.value = await getFavoritos(genre, query);
  } catch (error) {
    favoritos.value = [];
  } finally {
    isLoading.value = false;
  }
}

async function buscarFavoritos(query = '', genre = '') {
  isLoading.value = true;
  try {
    favoritos.value = await getFavoritos(genre, query);
    router.push({ path: '/favoritos', query: { query, genre } });
  } catch (error) {
    favoritos.value = [];
  } finally {
    isLoading.value = false;
  }
}

onMounted(async () => {
  const query = route.query.query || '';
  const genre = route.query.genre || '';
  await carregarFavoritos(genre, query);
});


watch(
  () => [route.query.query, route.query.genre],
  async ([newQuery, newGenre]) => {
    const query = newQuery || '';
    const genre = newGenre || '';
    await buscarFavoritos(query, genre);
  }
);

defineExpose({ buscarFavoritos });
</script>