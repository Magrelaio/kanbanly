<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanbanly - Gerencie Seus Projetos</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
    
    @include("layouts/navbar")

    <section class="text-center py-20 px-6">
        <h1 class="text-5xl font-bold leading-tight">Organize Seus Projetos com Facilidade</h1>
        <p class="mt-4 text-lg text-gray-300">Gerencie tarefas, equipes e projetos de forma eficiente com Kanbanly.</p>
        <div class="mt-6">
            <a href="/register" class="px-6 py-3 bg-indigo-500 rounded-lg text-lg hover:bg-indigo-600 transition">Experimente Grátis</a>
        </div>
    </section>

    <section class="grid md:grid-cols-3 gap-8 px-6 md:px-20 py-12">
        <div class="bg-gray-800 p-6 rounded-lg shadow-md text-center">
            <h3 class="text-xl font-semibold text-indigo-400">Gerenciamento Ágil</h3>
            <p class="mt-2 text-gray-300">Organize tarefas e melhore a produtividade da sua equipe.</p>
        </div>
        <div class="bg-gray-800 p-6 rounded-lg shadow-md text-center">
            <h3 class="text-xl font-semibold text-indigo-400">Integrações Simples</h3>
            <p class="mt-2 text-gray-300">Conecte-se com Slack, Google Drive e muito mais.</p>
        </div>
        <div class="bg-gray-800 p-6 rounded-lg shadow-md text-center">
            <h3 class="text-xl font-semibold text-indigo-400">Colaboração em Tempo Real</h3>
            <p class="mt-2 text-gray-300">Trabalhe em equipe com atualizações instantâneas.</p>
        </div>
    </section>

    <footer class="bg-gray-800 text-center py-6">
        <p class="text-gray-400">© 2025 Kanbanly. Todos os direitos reservados.</p>
    </footer>

</body>
</html>