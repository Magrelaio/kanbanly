# Kanbanly

Kanbanly é uma aplicação web para gerenciamento de projetos e tarefas utilizando o método Kanban. Permite organizar tarefas, equipes e acompanhar o progresso dos projetos de forma visual e intuitiva.

## Funcionalidades

- Cadastro e autenticação de usuários
- Criação e gerenciamento de quadros Kanban
- Organização de tarefas em colunas (A Fazer, Em Progresso, Concluído)
- Interface responsiva e moderna
- Gerenciamento de perfil de usuário

## Tecnologias Utilizadas

- PHP 8.x
- Laravel 10.x
- PostgreSQL
- Tailwind CSS
- Vite

## Pré-requisitos

- PHP >= 8.1
- Composer
- PostgreSQL
- Node.js e npm

## Instalação

1. **Clone o repositório:**
   ```bash
   git clone https://github.com/Magrelaio/kanbanly
   cd kanbanly
   ```

2. **Instale as dependências do PHP:**
   ```bash
   composer install
   ```

3. **Instale as dependências do Node.js:**
   ```bash
   npm install
   ```

4. **Copie o arquivo de ambiente e configure:**
   ```bash
   cp .env.example .env
   ```
   Edite o arquivo `.env` e configure as variáveis de conexão com o banco de dados PostgreSQL:
   ```
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=kanbanly
   DB_USERNAME=postgres
   DB_PASSWORD=sua_senha
   ```

5. **Gere a chave da aplicação:**
   ```bash
   php artisan key:generate
   ```

6. **Execute as migrations:**
   ```bash
   php artisan migrate
   ```

7. **Compile os assets:**
   ```bash
   npm run dev
   ```

8. **Inicie o servidor:**
   ```bash
   php artisan serve
   ```
   Acesse [http://localhost:8000](http://localhost:8000) no navegador.

## Observações

- Certifique-se de que o PostgreSQL está rodando e o banco de dados foi criado.
- Para customizar o visual, edite os arquivos em `resources/views` e `resources/css`.

## Licença

Este projeto está sob a licença MIT.
