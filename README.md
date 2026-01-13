# KANBANLY - Sistema de Gestão de Projetos

Este projeto é uma aplicação web moderna para gestão ágil de projetos, inspirada na metodologia Kanban. Desenvolvida com Laravel, oferece uma interface intuitiva para organizar tarefas, equipes e projetos, promovendo produtividade e colaboração em tempo real.

## Status do Projeto

**Versão Atual**: Demonstração inicial com estrutura básica implementada, incluindo autenticação de usuários, layout responsivo e protótipo de dashboard. Funcionalidades core como criação de boards e tarefas estão em desenvolvimento.

**Próximas Atualizações**:
- Implementação de Drag and Drop para movimentação intuitiva de tarefas entre colunas (A Fazer, Em Progresso, Concluído).
- Transição completa do frontend para usuários logados: O layout inicial (index.blade.php) será substituído por uma experiência personalizada no dashboard, com carregamento dinâmico de dados do usuário, evitando recarregamentos desnecessários para performance otimizada.
- Suporte a múltiplos boards por usuário e colaboração em equipe (futuro).

## Funcionalidades

### Principais
- **Autenticação de Usuários**: Registro, login e gerenciamento de perfis com Laravel Breeze.
- **Dashboard Personalizado**: Interface Kanban com colunas para tarefas (A Fazer, Em Progresso, Concluído).
- **Gerenciamento de Tarefas**: Criação, edição e exclusão de tarefas associadas a boards únicos por usuário.
- **Interface Responsiva**: Design moderno com Tailwind CSS, adaptável a dispositivos móveis e desktops.

### Em Desenvolvimento
- **Drag and Drop**: Movimentação fluida de tarefas via JavaScript (Alpine.js), com atualização em tempo real no banco de dados.
- **Frontend Dinâmico para Logados**: Quando autenticado, o usuário acessa um dashboard totalmente personalizado, carregando dados via AJAX para evitar carregamentos pesados. O index.blade.php serve apenas para visitantes não logados.
- **Colaboração**: Compartilhamento de boards e notificações em tempo real (planejado com WebSockets).
- **Integrações**: Conexão com ferramentas como Slack e Google Drive.

## Tecnologias Utilizadas

- **Backend**: Laravel 11 (PHP 8.x), com Eloquent ORM para modelos e relacionamentos.
- **Frontend**: Blade Templates, Tailwind CSS, Alpine.js para interatividade leve.
- **Banco de Dados**: PostgreSQL (com suporte a migrações e seeds).
- **Cache e Sessões**: Redis para performance em produção.
- **Ferramentas de Desenvolvimento**: Vite para build de assets, pgAdmin para gerenciamento de DB.
- **Outros**: Composer para dependências PHP, Node.js/npm para frontend.

## Pré-requisitos

- PHP 8.x ou superior
- Composer
- PostgreSQL (instalado e rodando)
- Node.js e npm

## Instalação e Configuração

1. **Clone o Repositório**:
   ```
   git clone https://github.com/seu-usuario/kanbanly.git
   cd kanbanly
   ```

2. **Instale Dependências**:
   ```
   composer install
   npm install
   ```

3. **Configure o Ambiente**:
   - Copie `.env.example` para `.env`:
     ```
     cp .env.example .env
     ```
   - Edite `.env` com suas configurações (ex.: DB_CONNECTION=pgsql, DB_DATABASE=kanbanly, etc.).
   - Gere a chave da aplicação:
     ```
     php artisan key:generate
     ```

4. **Configure o Banco de Dados**:
   - Certifique-se de que PostgreSQL está rodando.
   - Execute as migrações:
     ```
     php artisan migrate
     ```
   - (Opcional) Rode seeds para dados iniciais:
     ```
     php artisan db:seed
     ```

5. **Inicie o Servidor**:
   ```
   php artisan serve
   npm run dev  # Para assets em desenvolvimento
   ```

### Iniciando PostgreSQL (Windows)
1. Abra o Prompt de Comando como administrador.
2. Navegue para o diretório bin do PostgreSQL (ex.: `cd "C:\Program Files\PostgreSQL\14\bin"`).
3. Inicie o servidor:
   ```
   pg_ctl -D "C:\Program Files\PostgreSQL\14\data" start
   ```
4. Verifique o status:
   ```
   pg_ctl -D "C:\Program Files\PostgreSQL\14\data" status
   ```

## Uso

1. **Acesso Inicial**: Visite `http://localhost:8000` para a landing page (index.blade.php) com informações sobre o produto.
2. **Registro/Login**: Crie uma conta ou faça login para acessar o dashboard.
3. **Dashboard**: Visualize e gerencie seu board único (expansível para múltiplos). Adicione tarefas via formulário e mova-as entre colunas. (apenas protótipo e visual nesta versão).
4. **Próximas Interações**: Com Drag and Drop implementado, arraste tarefas para atualizar status sem recarregar a página.

## Arquitetura

- **MVC Pattern**: Laravel segue Model-View-Controller.
- **Relacionamentos**: User hasOne Board; Board hasMany Tasks.
- **Performance**: Eager loading para evitar N+1 queries; AJAX para atualizações leves.
- **Segurança**: Middleware de autenticação, CSRF protection.

## Contribuição

Contribuições são bem-vindas! Siga estes passos:
1. Fork o repositório.
2. Crie uma branch para sua feature (`git checkout -b feature/nova-funcionalidade`).
3. Commit suas mudanças (`git commit -m 'Adiciona nova funcionalidade'`).
4. Push para a branch (`git push origin feature/nova-funcionalidade`).
5. Abra um Pull Request.

Certifique-se de seguir as melhores práticas do Laravel e incluir testes.

## Licença

Este projeto é licenciado sob a MIT License.

## Contato

Para dúvidas ou sugestões, entre em contato via E-mail: [caiocesar2004gfgff@gmail.com] ou abra uma issue no repositório.

---

**Kanbanly** - Organize, colabore e conquiste seus objetivos com eficiência.
