<template>
  <div class="relative group cursor-pointer transform transition-transform duration-200 hover:scale-105">
    <div class="relative overflow-hidden rounded-lg shadow-lg">
      <img :src="'https://image.tmdb.org/t/p/w500' + filme.poster_path" :alt="filme.titulo"
        class="w-full aspect-[2/3] object-cover transition-transform duration-300 group-hover:scale-110" />

      <!-- Overlay com informações -->
      <div
        class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <div class="absolute bottom-0 left-0 right-0 p-4">
          <h3 class="text-white font-bold text-sm mb-2 line-clamp-2">{{ filme.title ? filme.title : filme.titulo }}</h3>

          <div class="flex items-center justify-between mb-3">
            <div class="flex items-center space-x-2">
              <div class="flex items-center">
                <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <span class="text-white text-xs">
                  {{ filme.vote_average != null ? filme.vote_average.toFixed(1) : (route.path === '/favoritos' ?
                    (isValidNumber(filme.avaliacao) ? Number(filme.avaliacao).toFixed(1) : 'N/A') : 'N/A') }}
                </span>
              </div>
            </div>

            <div class="text-white text-xs">
              {{ filme.release_date ? new Date(filme.release_date).getFullYear() : (route.path === '/favoritos' ?
                (isValidDate(filme.data) ? new Date(filme.data).getFullYear() : 'N/A') : 'N/A') }}
            </div>
          </div>

          <div class="flex space-x-2">
            <button @click="toggleFavorito"
              class="flex-1 bg-red-600 hover:bg-red-700 text-white text-xs py-2 px-3 rounded transition-colors duration-200 flex items-center justify-center space-x-1">
              <svg class="w-4 h-4" :class="isFavorito ? 'fill-current' : 'stroke-current fill-none'" viewBox="0 0 24 24"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
              </svg>
              <span>{{ isFavorito ? 'Remover' : 'Favoritar' }}</span>
            </button>
            <router-link :to="'/filme/' + (props.favoritoInicial ? filme.id_tmdb : filme.id || filme.id_tmdb)"
              class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-xs py-2 px-3 rounded transition-colors duration-200 flex items-center justify-center space-x-1">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span>Detalhes</span>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { addFavorito, deleteFavorito, getFavoritos } from '../api.js';

const props = defineProps({
  filme: {
    type: Object,
    required: true
  },
  favoritoInicial: {
    type: Boolean,
    default: false
  }
});

const emit = defineEmits(['favorito-updated']);
const route = useRoute();
const isFavorito = ref(props.favoritoInicial);

function isValidNumber(value) {
  return value != null && !isNaN(Number(value));
}

function isValidDate(value) {
  return value != null && !isNaN(new Date(value).getTime());
}

async function checkFavorito() {
  if (!props.favoritoInicial) {
    const favoritos = await getFavoritos();
    const idFilme = route.path === '/favoritos' ? props.filme.id_tmdb : props.filme.id || props.filme.id_tmdb;
    isFavorito.value = favoritos.some(f => f.id_tmdb === idFilme);
  }
}

async function toggleFavorito() {
  const idFilme = route.path === '/favoritos' ? props.filme.id_tmdb : props.filme.id || props.filme.id_tmdb;

  if (isFavorito.value) {
    await deleteFavorito(idFilme);
    isFavorito.value = false;
  } else {
    await addFavorito(props.filme);
    isFavorito.value = true;
  }
  emit('favorito-updated');
}

onMounted(() => {
  checkFavorito();
});
</script>