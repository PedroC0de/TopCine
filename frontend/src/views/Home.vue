<template>
  <main class="p-6 space-y-12">
    <div v-if="isLoading" class="text-white text-center mt-10">
      Carregando
    </div>
    <section v-else-if="filmes.length > 0">
      <h2 class="text-white text-2xl mb-4 font-bold">
        {{ buscou ? 'Resultados da Pesquisa' : 'Filmes Populares' }}
      </h2>
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
        <FilmeCard v-for="filme in filmes" :key="filme.id" :filme="filme" />
      </div>
    </section>
    <div v-else-if="buscou" class="text-white text-center mt-10">
      <div class="text-xl mb-2">Nenhum filme encontrado</div>
      <div class="text-gray-400">Tente buscar por "{{ ultimaBusca }}" novamente</div>
    </div>
    <div v-else class="text-white text-center mt-20">
      <div class="text-2xl mb-4">Bem-vindo ao TopCine</div>
      <div class="text-gray-400">Use a barra de pesquisa acima para encontrar seus filmes favoritos</div>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import FilmeCard from '../components/FilmeCard.vue';
import { buscarFilmes, getFilmesPopulares } from '../api.js';

const route = useRoute();
const filmes = ref([]);
const ultimaBusca = ref('');
const buscou = ref(false);
const isLoading = ref(false);

async function buscarFilmesAPI(query, genre = '') {
  isLoading.value = true;
  try {
    ultimaBusca.value = query;
    buscou.value = true;
    filmes.value = await buscarFilmes(query, genre);
  } catch (error) {
    filmes.value = [];
  } finally {
    isLoading.value = false;
  }
}

onMounted(async () => {
  isLoading.value = true;
  try {
    const query = route.query.query || '';
    const genre = route.query.genre || '';
    if (query || genre) {
      await buscarFilmesAPI(query, genre);
    } else {
      filmes.value = await getFilmesPopulares();
    }
  } finally {
    isLoading.value = false;
  }
});

// Observar mudanças nos parâmetros da URL
watch(
  () => [route.query.query, route.query.genre],
  async ([newQuery, newGenre]) => {
    const query = newQuery || '';
    const genre = newGenre || '';
    if (query || genre) {
      await buscarFilmesAPI(query, genre);
    } else {
      filmes.value = await getFilmesPopulares();
    }
  }
);

defineExpose({ buscarFilmesAPI });
</script>