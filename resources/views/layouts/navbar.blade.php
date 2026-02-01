<nav class="bg-gray-800 py-4">
    <div class="container mx-auto flex items-center px-6">
        <!-- Logo -->
        <a href="/" class="text-2xl font-bold text-indigo-400 flex-none">
            <img src="{{ asset('images/Kanbanly_Logo.png') }}" alt="Logo" class="h-20">
        </a>

        <div class="hidden md:flex flex-1 justify-center space-x-6">
            <a href="#" class="hover:text-indigo-400 transition">Sobre</a>
            <a href="#" class="hover:text-indigo-400 transition">Recursos</a>
            <a href="#" class="hover:text-indigo-400 transition">Contato</a>
        </div>

        <div class="flex-none">
            @auth
                <div class="relative">
                    <button class="px-4 py-2 bg-indigo-500 rounded-lg hover:bg-indigo-600 transition delay-200">
                        {{ Auth::user()->name }}
                    </button>
                    <div id="profile-dropdown-menu" class="absolute right-0 mt-2 w-48 bg-gray-700 rounded-lg shadow-lg hidden">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-white hover:bg-gray-600 rounded-lg">Perfil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-white hover:bg-gray-600 rounded-lg">
                                Sair
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="/login" class="px-4 py-2 bg-indigo-500 rounded-lg hover:bg-indigo-600 transition">Entrar</a>
                <a href="/register" class="ml-2 px-4 py-2 border border-indigo-500 rounded-lg hover:bg-indigo-500 transition">Criar Conta</a>
            @endauth
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdown = document.getElementById('profile-dropdown-menu');
    const button = dropdown.previousElementSibling;
    let timeout;

    function showDropdown() {
        clearTimeout(timeout);
        dropdown.classList.remove('hidden');
    }

    function hideDropdown() {
        timeout = setTimeout(() => {
            dropdown.classList.add('hidden');
        }, 800);
    }

    button.addEventListener('mouseenter', showDropdown);
    button.addEventListener('mouseleave', hideDropdown);
    dropdown.addEventListener('mouseenter', showDropdown);
    dropdown.addEventListener('mouseleave', hideDropdown);
});
</script>