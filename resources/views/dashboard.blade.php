<x-app-layout>
    <div class="flex h-screen">
        <aside class="w-64 bg-white p-4 shadow-md">
            <h2 class="text-xl font-bold">Kanbanly</h2>
            <nav class="mt-4">
                <ul>
                    <li class="py-2 px-4 rounded hover:bg-gray-200 cursor-pointer">Board 1</li>
                    <li class="py-2 px-4 rounded hover:bg-gray-200 cursor-pointer">Board 2</li>
                </ul>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="bg-white shadow p-4 flex justify-between">
                <input type="text" placeholder="Buscar..." class="border rounded p-2">
                <div>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded">Notificações</button>
                    <button class="ml-2 bg-gray-300 px-4 py-2 rounded">Perfil</button>
                </div>
            </header>
            <main class="p-4 flex space-x-4 overflow-x-auto">
                <div class="w-64 bg-gray-200 p-4 rounded">
                    <h3 class="font-bold">A Fazer</h3>
                    <div class="mt-2 space-y-2">
                        <div class="bg-white p-2 rounded shadow">Tarefa 1</div>
                        <div class="bg-white p-2 rounded shadow">Tarefa 2</div>
                    </div>
                </div>
                
                <div class="w-64 bg-gray-200 p-4 rounded">
                    <h3 class="font-bold">Em Progresso</h3>
                    <div class="mt-2 space-y-2">
                        <div class="bg-white p-2 rounded shadow">Tarefa 3</div>
                    </div>
                </div>
                
                <div class="w-64 bg-gray-200 p-4 rounded">
                    <h3 class="font-bold">Concluído</h3>
                    <div class="mt-2 space-y-2">
                        <div class="bg-white p-2 rounded shadow">Tarefa 4</div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>