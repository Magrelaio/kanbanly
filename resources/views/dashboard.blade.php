<x-app-layout>
    <div class="flex h-screen" x-data="dashboard()" x-init="init()">
        <aside class="w-64 bg-white p-4 shadow-md flex flex-col">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold">Kanbanly</h2>
                <button @click="showCreateBoard = true" class="text-blue-500 hover:text-blue-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </button>
            </div>
            
            <nav class="mt-4 flex-1">
                <h3 class="text-xs uppercase text-gray-500 font-semibold mb-2">Seus Boards</h3>
                <ul>
                    @foreach($boards as $board)
                        <li class="mb-1">
                            <a href="{{ route('dashboard', ['board' => $board->id]) }}" 
                               class="flex items-center py-2 px-4 rounded hover:bg-gray-100 {{ $currentBoard->id === $board->id ? 'bg-gray-100' : '' }}">
                                <span class="w-3 h-3 rounded-full bg-{{ $board->color }}-500 mr-2"></span>
                                {{ $board->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <div class="border-t pt-4">
                <button @click="showCreateBoard = true" class="w-full text-left py-2 px-4 rounded hover:bg-gray-100 text-blue-600">
                    + Criar novo board
                </button>
            </div>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="bg-white shadow p-4 flex justify-between items-center">
                <div class="flex items-center">
                    <span class="w-4 h-4 rounded-full bg-{{ $currentBoard->color }}-500 mr-2"></span>
                    <h1 class="text-xl font-semibold">{{ $currentBoard->title }}</h1>
                    <button @click="editBoard({{ $currentBoard }})" class="ml-4 text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" 
                               x-model="searchQuery"
                               @input="searchTasks"
                               placeholder="Buscar tarefas..." 
                               class="border rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    
                    <button class="relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        @if(auth()->user()->incomplete_tasks_count > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                {{ auth()->user()->incomplete_tasks_count }}
                            </span>
                        @endif
                    </button>
                    
                    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center">
                            <span class="text-sm font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                    </a>
                </div>
            </header>

            <main class="p-4 flex-1 overflow-x-auto" 
                  x-ref="kanbanBoard"
                  @dragover.prevent
                  @drop="handleDrop">
                <div class="flex space-x-4 h-full">
                    @foreach($currentBoard->columns as $column)
                        <div class="w-72 flex-shrink-0 bg-gray-100 rounded-lg flex flex-col" 
                             @drop="handleColumnDrop($event, {{ $column->id }})"
                             @dragover.prevent>
                            
                            <div class="p-3 border-b bg-gray-200 rounded-t-lg flex justify-between items-center">
                                <div class="flex items-center space-x-2">
                                    <h3 class="font-semibold text-gray-700">{{ $column->title }}</h3>
                                    <span class="text-xs bg-gray-300 px-2 py-1 rounded-full">
                                        {{ $column->tasks->count() }}
                                    </span>
                                </div>
                                <button @click="createTask({{ $column->id }})" class="text-gray-500 hover:text-gray-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </div>

                            <div class="p-2 flex-1 overflow-y-auto" 
                                 x-ref="column{{ $column->id }}"
                                 x-data="{ tasks: {{ $column->tasks->toJson() }} }">
                                <template x-for="task in tasks" :key="task.id">
                                    <div class="bg-white p-3 mb-2 rounded shadow hover:shadow-md transition cursor-move"
                                         draggable="true"
                                         @dragstart="handleDragStart($event, task)"
                                         @dragend="handleDragEnd"
                                         @click="editTask(task)">
                                        
                                        <div class="font-medium" x-text="task.title"></div>
                                        
                                        <div class="text-xs text-gray-500 mt-1" x-show="task.description" x-text="task.description.substring(0, 50) + '...'"></div>
                                        
                                        <div class="flex items-center justify-between mt-2">
                                            <div class="flex space-x-1">
                                                <template x-for="label in task.labels" :key="label">
                                                    <span class="w-2 h-2 rounded-full" :class="'bg-' + label + '-500'"></span>
                                                </template>
                                            </div>
                                            
                                            <div class="flex items-center space-x-2">
                                                <span x-show="task.due_date" class="text-xs text-gray-500" 
                                                      x-text="new Date(task.due_date).toLocaleDateString('pt-BR')"></span>
                                                
                                                <span class="w-6 h-6 rounded-full bg-gray-300 flex items-center justify-center text-xs"
                                                      x-text="task.user.name.substring(0, 1)"></span>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="w-72 flex-shrink-0">
                        <button @click="createColumn" class="w-full h-10 bg-gray-100 hover:bg-gray-200 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Adicionar coluna
                        </button>
                    </div>
                </div>
            </main>
        </div>

        <div x-show="showTaskModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-cloak>
            <div class="bg-white rounded-lg p-6 w-96" @click.away="showTaskModal = false">
                <h3 class="text-lg font-bold mb-4" x-text="editingTask ? 'Editar Tarefa' : 'Nova Tarefa'"></h3>
                
                <form @submit.prevent="saveTask">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Título</label>
                            <input type="text" x-model="taskForm.title" class="mt-1 block w-full border rounded-md shadow-sm p-2" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Descrição</label>
                            <textarea x-model="taskForm.description" rows="3" class="mt-1 block w-full border rounded-md shadow-sm p-2"></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Data de entrega</label>
                            <input type="date" x-model="taskForm.due_date" class="mt-1 block w-full border rounded-md shadow-sm p-2">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Etiquetas</label>
                            <div class="mt-2 flex space-x-2">
                                <button type="button" @click="toggleLabel('red')" :class="{'bg-red-500': taskForm.labels.includes('red'), 'bg-gray-200': !taskForm.labels.includes('red')}" class="w-8 h-8 rounded-full"></button>
                                <button type="button" @click="toggleLabel('blue')" :class="{'bg-blue-500': taskForm.labels.includes('blue'), 'bg-gray-200': !taskForm.labels.includes('blue')}" class="w-8 h-8 rounded-full"></button>
                                <button type="button" @click="toggleLabel('green')" :class="{'bg-green-500': taskForm.labels.includes('green'), 'bg-gray-200': !taskForm.labels.includes('green')}" class="w-8 h-8 rounded-full"></button>
                                <button type="button" @click="toggleLabel('yellow')" :class="{'bg-yellow-500': taskForm.labels.includes('yellow'), 'bg-gray-200': !taskForm.labels.includes('yellow')}" class="w-8 h-8 rounded-full"></button>
                                <button type="button" @click="toggleLabel('purple')" :class="{'bg-purple-500': taskForm.labels.includes('purple'), 'bg-gray-200': !taskForm.labels.includes('purple')}" class="w-8 h-8 rounded-full"></button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-end space-x-2">
                        <button type="button" @click="showTaskModal = false" class="px-4 py-2 bg-gray-200 rounded-md">Cancelar</button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Salvar</button>
                    </div>
                </form>
                
                <button x-show="editingTask" @click="deleteTask" class="mt-4 text-red-600 hover:text-red-800 text-sm">
                    Excluir tarefa
                </button>
            </div>
        </div>

        <div x-show="showCreateBoard" 
            x-cloak 
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            @keydown.escape.window="showCreateBoard = false">
    
        <div class="bg-white rounded-lg p-6 w-96" 
         @click.away="showCreateBoard = false">
        
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Novo Board</h3>
            <button @click="showCreateBoard = false" class="text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <form @submit.prevent="createBoard">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                    <input type="text" 
                           x-model="newBoard.title" 
                           class="w-full border rounded-md shadow-sm p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                           placeholder="Meu Board"
                           required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cor</label>
                    <div class="flex space-x-2">
                        <template x-for="color in ['blue', 'green', 'red', 'yellow', 'purple', 'gray']" :key="color">
                            <button type="button"
                                    @click="newBoard.color = color"
                                    class="w-8 h-8 rounded-full transition-transform hover:scale-110"
                                    :class="[
                                        'bg-' + color + '-500',
                                        newBoard.color === color ? 'ring-2 ring-offset-2 ring-' + color + '-500' : ''
                                    ]">
                            </button>
                        </template>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end space-x-2">
                <button type="button" 
                        @click="showCreateBoard = false" 
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-md transition">
                    Cancelar
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md transition"
                        :disabled="!newBoard.title"
                        :class="{'opacity-50 cursor-not-allowed': !newBoard.title}">
                    Criar Board
                </button>
            </div>
        </form>
    </div>
</div>

    <script>
        function dashboard() {
            return {
                showTaskModal: false,
                showCreateBoard: false,
                editingTask: null,
                currentColumnId: null,
                draggedTask: null,
                searchQuery: '',
                
                taskForm: {
                    title: '',
                    description: '',
                    due_date: '',
                    labels: []
                },
                newBoard: {
                    title: '',
                    color: 'blue'
                },
                init() {
                    this.setupDragAndDrop();
                },
                
                // Drag and Drop
                setupDragAndDrop() {
                    document.addEventListener('dragstart', (e) => {
                        e.dataTransfer.effectAllowed = 'move';
                    });
                },
                
                handleDragStart(e, task) {
                    this.draggedTask = task;
                    e.dataTransfer.setData('text/plain', task.id);
                    e.target.classList.add('opacity-50');
                },
                
                handleDragEnd(e) {
                    e.target.classList.remove('opacity-50');
                    this.draggedTask = null;
                },
                
                handleColumnDrop(e, columnId) {
                    e.preventDefault();
                    if (this.draggedTask && this.draggedTask.column_id !== columnId) {
                        this.moveTask(this.draggedTask.id, columnId);
                    }
                },
                
                createTask(columnId) {
                    this.currentColumnId = columnId;
                    this.editingTask = null;
                    this.taskForm = {
                        title: '',
                        description: '',
                        due_date: '',
                        labels: []
                    };
                    this.showTaskModal = true;
                },
                
                editTask(task) {
                    this.editingTask = task;
                    this.taskForm = {
                        title: task.title,
                        description: task.description || '',
                        due_date: task.due_date ? new Date(task.due_date).toISOString().split('T')[0] : '',
                        labels: task.labels || []
                    };
                    this.showTaskModal = true;
                },
                
                async saveTask() {
                    if (this.editingTask) {
                        await this.updateTask();
                    } else {
                        await this.storeTask();
                    }
                },
                
                async storeTask() {
                    try {
                        const response = await fetch('/tasks', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                column_id: this.currentColumnId,
                                title: this.taskForm.title,
                                description: this.taskForm.description,
                                due_date: this.taskForm.due_date,
                                labels: this.taskForm.labels
                            })
                        });
                        
                        const task = await response.json();
                        
                        const columnRef = this.$refs['column' + this.currentColumnId];
                        if (columnRef && columnRef.__x) {
                            columnRef.__x.$data.tasks.push(task);
                        }
                        
                        this.showTaskModal = false;
                    } catch (error) {
                        console.error('Erro ao criar tarefa:', error);
                    }
                },
                
                async updateTask() {
                    try {
                        const response = await fetch(`/tasks/${this.editingTask.id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(this.taskForm)
                        });
                        
                        const updatedTask = await response.json();
                        
                        Object.keys(this.$refs).forEach(refName => {
                            if (refName.startsWith('column')) {
                                const columnRef = this.$refs[refName];
                                if (columnRef && columnRef.__x) {
                                    const index = columnRef.__x.$data.tasks.findIndex(t => t.id === updatedTask.id);
                                    if (index !== -1) {
                                        columnRef.__x.$data.tasks[index] = updatedTask;
                                    }
                                }
                            }
                        });
                        
                        this.showTaskModal = false;
                    } catch (error) {
                        console.error('Erro ao atualizar tarefa:', error);
                    }
                },
                
                async moveTask(taskId, newColumnId) {
                    try {
                        const response = await fetch(`/tasks/${taskId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ column_id: newColumnId })
                        });
                        
                        const updatedTask = await response.json();
                        
                        Object.keys(this.$refs).forEach(refName => {
                            if (refName.startsWith('column')) {
                                const columnRef = this.$refs[refName];
                                if (columnRef && columnRef.__x) {
                                    const index = columnRef.__x.$data.tasks.findIndex(t => t.id === taskId);
                                    if (index !== -1) {
                                        columnRef.__x.$data.tasks.splice(index, 1);
                                    }
                                }
                            }
                        });
                        
                        const newColumnRef = this.$refs['column' + newColumnId];
                        if (newColumnRef && newColumnRef.__x) {
                            newColumnRef.__x.$data.tasks.push(updatedTask);
                        }
                    } catch (error) {
                        console.error('Erro ao mover tarefa:', error);
                    }
                },
                
                async deleteTask() {
                    if (!confirm('Tem certeza que deseja excluir esta tarefa?')) return;
                    
                    try {
                        await fetch(`/tasks/${this.editingTask.id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });
                        
                        Object.keys(this.$refs).forEach(refName => {
                            if (refName.startsWith('column')) {
                                const columnRef = this.$refs[refName];
                                if (columnRef && columnRef.__x) {
                                    const index = columnRef.__x.$data.tasks.findIndex(t => t.id === this.editingTask.id);
                                    if (index !== -1) {
                                        columnRef.__x.$data.tasks.splice(index, 1);
                                    }
                                }
                            }
                        });
                        
                        this.showTaskModal = false;
                    } catch (error) {
                        console.error('Erro ao excluir tarefa:', error);
                    }
                },
                
                toggleLabel(label) {
                    const index = this.taskForm.labels.indexOf(label);
                    if (index === -1) {
                        this.taskForm.labels.push(label);
                    } else {
                        this.taskForm.labels.splice(index, 1);
                    }
                },
                
                searchTasks() {
                    if (this.searchQuery.length < 2) return;
                    
                    fetch(`/tasks/search?q=${this.searchQuery}`)
                        .then(response => response.json())
                        .then(tasks => {
                            console.log(tasks);
                        });
                },
                
                editBoard(board) {
                    console.log('Editar board:', board);
                },
                
                createColumn() {
                    console.log('Criar nova coluna');
                }
            }
        }
    </script>

    @push('styles')
    <style>
        [x-cloak] { display: none !important; }
        .draggable-dragging {
            opacity: 0.5;
            cursor: grabbing;
        }
    </style>
    @endpush
</x-app-layout>