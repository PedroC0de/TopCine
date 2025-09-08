import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import Favoritos from '../views/Favoritos.vue'; 
import FilmeDetalhes from '../views/FilmeDetalhes.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  {
    path: '/favoritos',
    name: 'Favoritos',
    component: Favoritos,
  },
  {
    path: '/filme/:id',
    name: 'FilmeDetalhes',
    component: FilmeDetalhes,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;