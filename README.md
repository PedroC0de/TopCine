
Gerenciamento de filmes (backend Laravel + frontend Vue.js + API TMDB​ + banco de dados MYSQL + servidor Nginx) em ambiente local usando Docker

## 1. Rodando o projeto localmente com docker

Pré-requisitos:
- Docker
- Docker Compose
- Uma conta no TMDB

## Passos para subir o ambiente com docker compose

1. **Clonar o Repositório e configurar env**:
   - Clone o projeto: git clone https://github.com/PedroC0de/TopCine.git
   - Navegue para o diretório backend do projeto: cd catalogo_filmes/backend
   - Copie o arquivo de exemplo de ambiente: cp .env.example .env

2. **Configurar o arquivo .env**:
   - Edite .env
   - Defina as variáveis principais:
     - DB_CONNECTION=mysql
     - DB_HOST=db
     - DB_PORT=3306
     - DB_DATABASE=filmesdb 
     - DB_USERNAME=admin
     - DB_PASSWORD=senha123
     - TMDB_API_KEY=sua_chave
     - APP_URL=http://localhost:8000
     - APP_URL_API=http://localhost:8000/api

3. **Subir os containers**:
   - volte para a raíz do projeto: cd..
   - Execute: docker-compose up -d --build
   - O front estará disponível em http://localhost:8000/.
   - A api estará disponível em http://localhost:8000/api.

5. **Acesso o sistema**:
   - Abra o navegador em http://localhost:8000.

## 2. Onde está implementado o CRUD de filmes favoritos

O CRUD para favoritos está no backend Laravel.

- **Rotas**: routes/api.php
- **Controllers**: app/Http/Controllers/FavoritoController.php
- **Models**: app/Models/Favoritos.php

Chamada da api de favoritos no Vue.
- **Views/Frontend**: No Vue.js: src/views/Favoritos.vue

## 4. Instruções para testar a aplicação

## Validação básica:
- **Acesso à interface**: Abra http://localhost:8000. Verifique lista de filmes, busca, e seção de favoritos (adicione um filme e filtre por gênero).
- **Testes manuais**:
  - Busque um filme: Digite no input de busca e veja resultados.
  - Adicione aos favoritos: Clique no botão, verifique se persiste após atualizar a tela.
  - Filtros: Selecione gênero
  - Responsivo:  confirme grid responsivo com o DevTools

Se falhar, verifique logs e .env.

## 5. Link para obter a chave da API do TMDB

- **Link**: https://www.themoviedb.org/.
- **Instruções**:
  - Crie uma conta no site (clique em "Join TMDB" ou "Sign Up").
  - Após login, acesse o painel de desenvolvedor: Vá para (https://www.themoviedb.org/settings/api).
  - Clique em "Create" para um novo app (descreva como "Projeto de Filmes Local").
  - Copie a "API Key" gerada.
  - Cole no .env do backend como TMDB_API_KEY=sk_sua_chave_aqui.
  
