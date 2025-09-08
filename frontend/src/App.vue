<template>
  <div class="bg-gray-800 min-h-screen">
    <Header @buscar="handleBuscar" @buscar-favoritos="handleBuscarFavoritos" />
    <router-view ref="homeView" />
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import Header from './components/Header.vue';

const view = ref(null);
const route = useRoute();

function handleBuscar(query, genre) {
  if (view.value?.buscarFilmesAPI) {
    view.value.buscarFilmesAPI(query, genre);
  }
}

function handleBuscarFavoritos(query, genre) {
  if (view.value?.buscarFavoritos) {
    view.value.buscarFavoritos(query, genre);
  } else {
  }
}

// Observar mudanças na rota para depurar a referência view
watch(
  () => route.path,
  { immediate: true }
);
</script>