<template>
  <header
    class="bg-gradient-to-r from-gray-900 to-gray-800 text-white shadow-xl sticky top-0 z-50 border-b border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center space-x-8">
          <h1 class="text-2xl font-bold text-red-500 tracking-tight">TopCine</h1>
          <nav class="hidden lg:flex space-x-8">
            <router-link to="/" class="text-gray-300 hover:text-white transition-colors duration-200 font-medium"
              @click="limparParametros">
              Home
            </router-link>
            <router-link to="/favoritos"
              class="text-gray-300 hover:text-white transition-colors duration-200 font-medium"
              @click="limparParametros">
              Favoritos
            </router-link>
          </nav>
        </div>

        <div class="hidden md:flex items-center space-x-4 flex-1 max-w-2xl mx-8">
          <div class="relative flex-1">
            <input v-model="query" @keyup.enter="buscar" type="text" placeholder="Buscar filmes..."
              class="w-full px-4 py-2.5 pl-12 pr-4 rounded-xl bg-gray-800/80 text-white placeholder-gray-400 border border-gray-600 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all duration-200 backdrop-blur-sm" />
            <svg class="absolute left-4 top-3 w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
              viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </div>

          <select v-model="selectedGenre"
            class="px-4 py-2.5 rounded-xl bg-gray-800/80 text-white border border-gray-600 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all duration-200 backdrop-blur-sm min-w-[140px]">
            <option value="">Todos os Gêneros</option>
            <option v-for="genre in genres" :key="genre.id" :value="genre.id">{{ genre.name }}</option>
          </select>

          <button @click="buscar" :disabled="isLoading"
            class="bg-red-600 hover:bg-red-700 disabled:bg-red-800 px-6 py-2.5 rounded-xl transition-all duration-200 flex items-center space-x-2 font-medium shadow-lg hover:shadow-red-500/25 disabled:cursor-not-allowed">
            <svg v-if="!isLoading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <svg v-else class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
              </path>
            </svg>
            <span>Buscar</span>
          </button>
        </div>

        <button @click="toggleMobileMenu"
          class="md:hidden p-2 rounded-lg hover:bg-gray-800 transition-colors duration-200">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>

      <div class="md:hidden pb-4 space-y-3">
        <div class="relative">
          <input v-model="query" @keyup.enter="buscar" type="text" placeholder="Buscar filmes..."
            class="w-full px-4 py-2.5 pl-12 pr-4 rounded-xl bg-gray-800/80 text-white placeholder-gray-400 border border-gray-600 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all duration-200" />
          <svg class="absolute left-4 top-3 w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>

        <div class="flex space-x-3">
          <select v-model="selectedGenre"
            class="flex-1 px-4 py-2.5 rounded-xl bg-gray-800/80 text-white border border-gray-600 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all duration-200">
            <option value="">Todos os Gêneros</option>
            <option v-for="genre in genres" :key="genre.id" :value="genre.id">{{ genre.name }}</option>
          </select>

          <button @click="buscar" :disabled="isLoading"
            class="bg-red-600 hover:bg-red-700 disabled:bg-red-800 px-6 py-2.5 rounded-xl transition-all duration-200 flex items-center space-x-2 font-medium shadow-lg hover:shadow-red-500/25 disabled:cursor-not-allowed">
            <svg v-if="!isLoading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <svg v-else class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
              </path>
            </svg>
            <span class="sm:inline">Buscar</span>
          </button>
        </div>
      </div>
    </div>

    <div v-if="isMobileMenuOpen" class="lg:hidden border-t border-gray-700 bg-gray-800/95 backdrop-blur-sm">
      <nav class="max-w-7xl mx-auto px-4 py-4 space-y-2">
        <router-link to="/"
          class="block text-gray-300 hover:text-white hover:bg-gray-700/50 transition-all duration-200 p-3 rounded-lg font-medium"
          @click="limparParametros">
          Home
        </router-link>
        <router-link to="/favoritos"
          class="block text-gray-300 hover:text-white hover:bg-gray-700/50 transition-all duration-200 p-3 rounded-lg font-medium"
          @click="limparParametros">
          Favoritos
        </router-link>
      </nav>
    </div>
  </header>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { getGenerosFilmes } from '../api.js';

const emit = defineEmits(['buscar', 'buscar-favoritos']);
const router = useRouter();
const route = useRoute();

const query = ref('');
const isMobileMenuOpen = ref(false);
const selectedGenre = ref('');
const genres = ref([]);
const isLoading = ref(false);

async function buscar() {
  isLoading.value = true;
  try {
    const event = route.path === '/favoritos' ? 'buscar-favoritos' : 'buscar';
    emit(event, query.value.trim(), selectedGenre.value);
    router.push({ path: route.path, query: { query: query.value.trim(), genre: selectedGenre.value } });
  } finally {
    isLoading.value = false;
  }
  isMobileMenuOpen.value = false;
}

function limparParametros() {
  query.value = '';
  selectedGenre.value = '';
  isMobileMenuOpen.value = false;
}

watch(selectedGenre, async () => {
  // Executa a busca sempre que o gênero mudar
  await buscar();
});

watch(
  () => route.path,
  (newPath) => {
    if (newPath !== route.path) {
      query.value = '';
      selectedGenre.value = '';
    }
  },
  { immediate: true }
);

onMounted(async () => {
  genres.value = await getGenerosFilmes();
});

function toggleMobileMenu() {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
}

</script>
