# KANBANLY - Sistema de Gestão de Projetos

Este é um projeto de aplicação web para gestão de projetos, desenvolvido com Laravel. O sistema visa oferecer uma interface intuitiva para organizar tarefas e projetos de forma eficiente, inspirado em metodologias como Kanban.

## Status do Projeto

**Atenção:** O que está implementado atualmente é apenas uma demonstração inicial da estrutura final do projeto. Não é uma versão completa ou funcional. Serve para ilustrar como o sistema será organizado, incluindo configurações básicas de banco de dados e ambiente de desenvolvimento.

## Tecnologias Utilizadas

- **Laravel**: Framework PHP para o backend.
- **PostgreSQL**: Banco de dados relacional.
- **pgAdmin**: Ferramenta para gerenciamento do banco de dados.
- **Tailwind CSS**: Framework CSS para estilização.
- **Redis**: Para cache e sessões (configurado no ambiente local).

## Pré-requisitos

- PHP 8.x ou superior
- Composer
- PostgreSQL instalado e rodando
- Node.js e npm (para assets frontend)

## Instalação e Configuração

1. Clone ou baixe o projeto para o diretório desejado.
2. Instale as dependências do PHP com Composer:
   ```
   composer install
   ```
3. Copie o arquivo `.env.example` para `.env` e configure as variáveis de ambiente, especialmente as de banco de dados (PostgreSQL).
4. Gere a chave da aplicação:
   ```
   php artisan key:generate
   ```
5. Execute as migrações para criar as tabelas no banco:
   ```
   php artisan migrate
   ```
6. Inicie o servidor de desenvolvimento:
   ```
   php artisan serve
   ```

## Como Iniciar o Servidor PostgreSQL

Para iniciar o servidor PostgreSQL no Windows:

1. Abra o Prompt de Comando como administrador.
2. Navegue até o diretório bin do PostgreSQL (exemplo: `cd "C:\Program Files\PostgreSQL\14\bin"`).
3. Execute o comando para iniciar o servidor:
   ```
   pg_ctl -D "C:\Program Files\PostgreSQL\14\data" start
   ```
   Substitua `14` pela versão instalada.

Verifique o status com:
```
pg_ctl -D "C:\Program Files\PostgreSQL\14\data" status
```

## Contribuição

Este projeto está em fase inicial. Contribuições são bem-vindas, mas foque em melhorias estruturais para a versão final.

## Licença

Este projeto é de uso pessoal/educacional. Consulte a documentação do Laravel para detalhes sobre licenciamento.
