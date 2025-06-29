{{-- filepath: resources/views/components/header.blade.php --}}
<header class="fixed w-full top-0 z-50 bg-white/95 backdrop-blur-sm border-b border-gray-100">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="/" class="text-2xl font-bold text-blue-600">
                        FinanceApp
                    </a>
                </div>
            </div>

            <nav class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-blue-600 transition duration-300">
                        Recursos
                    </a>
                    <a href="#pricing" class="text-gray-600 hover:text-blue-600 transition duration-300">
                        Preços
                    </a>
                    <a href="#contact" class="text-gray-600 hover:text-blue-600 transition duration-300">
                        Contato
                    </a>
                </div>
            </nav>

            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6 space-x-4">
                    <button class="text-gray-600 hover:text-blue-600 transition duration-300">
                        Login
                    </button>
                    <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                        Começar Grátis
                    </button>
                </div>
            </div>

            {{-- Mobile menu button --}}
            <div class="md:hidden">
                <button x-data="{ open: false }" @click="open = !open" x-bind:aria-expanded="open"
                    class="text-gray-600 hover:text-blue-600 focus:outline-none"
                    aria-label="Abrir menu"
                    x-ref="menuButton">
                    <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div x-data="{ open: false }" x-show="open" class="md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t">
                <a href="#features" class="block px-3 py-2 text-gray-600 hover:text-blue-600">
                    Recursos
                </a>
                <a href="#pricing" class="block px-3 py-2 text-gray-600 hover:text-blue-600">
                    Preços
                </a>
                <a href="#contact" class="block px-3 py-2 text-gray-600 hover:text-blue-600">
                    Contato
                </a>
                <div class="border-t pt-4 mt-4">
                    <button class="block w-full text-left px-3 py-2 text-gray-600 hover:text-blue-600">
                        Login
                    </button>
                    <button class="block w-full mt-2 bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700">
                        Começar Grátis
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>
