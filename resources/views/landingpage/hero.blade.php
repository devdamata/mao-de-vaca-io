{{-- filepath: resources/views/components/hero.blade.php --}}
<section class="pt-20 pb-16 bg-gradient-to-br from-blue-50 via-white to-green-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="text-center lg:text-left">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight mb-6">
                    Controle suas
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-green-600">
                        finanças
                    </span>
                    de forma inteligente
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-2xl">
                    Organize seus gastos, acompanhe investimentos e alcance seus objetivos financeiros
                    com o app mais completo do mercado.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <button class="group bg-blue-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-blue-700 transition duration-300 flex items-center justify-center">
                        Começar Grátis
                        <svg class="ml-2 group-hover:translate-x-1 transition duration-300" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </button>
                    <button class="group border-2 border-gray-300 text-gray-700 px-8 py-4 rounded-xl font-semibold hover:border-blue-600 hover:text-blue-600 transition duration-300 flex items-center justify-center">
                        <svg class="mr-2" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><circle cx="10" cy="10" r="9"/><polygon points="8,7 15,10 8,13"/></svg>
                        Ver Demo
                    </button>
                </div>
                <div class="mt-8 flex items-center justify-center lg:justify-start space-x-8">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900">50k+</div>
                        <div class="text-sm text-gray-600">Usuários ativos</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900">R$ 1M+</div>
                        <div class="text-sm text-gray-600">Economizados</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900">4.9★</div>
                        <div class="text-sm text-gray-600">Avaliação</div>
                    </div>
                </div>
            </div>
            <div class="relative">
                <div class="relative bg-white rounded-2xl shadow-2xl p-8 transform rotate-3 hover:rotate-0 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-green-400 rounded-2xl opacity-10"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold">Resumo Financeiro</h3>
                            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Saldo Total</span>
                                <span class="text-2xl font-bold text-green-600">R$ 12.450,00</span>
                            </div>
                            <div class="bg-gray-100 rounded-lg p-4">
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm text-gray-600">Gastos este mês</span>
                                    <span class="text-sm text-red-600">R$ 3.200,00</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-red-400 to-red-600 h-2 rounded-full w-3/4"></div>
                                </div>
                            </div>
                            <div class="bg-gray-100 rounded-lg p-4">
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm text-gray-600">Meta de economia</span>
                                    <span class="text-sm text-blue-600">R$ 2.000,00</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-blue-400 to-blue-600 h-2 rounded-full w-4/5"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
