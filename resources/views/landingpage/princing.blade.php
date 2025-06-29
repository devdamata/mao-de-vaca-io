{{-- filepath: resources/views/components/pricing.blade.php --}}
<section id="pricing" class="py-20 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                Escolha o plano ideal para você
            </h2>
            <p class="text-xl text-gray-600">
                Comece grátis e evolua conforme suas necessidades
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            {{-- Plano Básico --}}
            <div class="relative p-8 rounded-2xl border-2 border-gray-200 hover:border-blue-300 hover:shadow-lg transition duration-300">
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Básico</h3>
                    <p class="text-gray-600 mb-4">Perfeito para começar</p>
                    <div class="flex items-baseline justify-center">
                        <span class="text-4xl font-bold text-gray-900">Grátis</span>
                    </div>
                </div>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center">
                        {{-- Check SVG --}}
                        <svg class="text-green-500 mr-3 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        <span class="text-gray-700">Até 100 transações por mês</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="text-green-500 mr-3 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        <span class="text-gray-700">Categorização manual</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="text-green-500 mr-3 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        <span class="text-gray-700">Relatórios básicos</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="text-green-500 mr-3 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        <span class="text-gray-700">Suporte por email</span>
                    </li>
                </ul>
                <button class="w-full py-3 px-6 rounded-xl font-semibold transition duration-300 bg-gray-100 text-gray-900 hover:bg-gray-200">
                    Começar Grátis
                </button>
            </div>

            {{-- Plano Premium --}}
            <div class="relative p-8 rounded-2xl border-2 border-blue-500 shadow-xl scale-105 transition duration-300">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-semibold">
                        Mais Popular
                    </span>
                </div>
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Premium</h3>
                    <p class="text-gray-600 mb-4">Para usuários avançados</p>
                    <div class="flex items-baseline justify-center">
                        <span class="text-4xl font-bold text-gray-900">R$ 19,90</span>
                        <span class="text-gray-600 ml-1">/mês</span>
                    </div>
                </div>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center">
                        <svg class="text-green-500 mr-3 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        <span class="text-gray-700">Transações ilimitadas</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="text-green-500 mr-3 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        <span class="text-gray-700">Categorização automática</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="text-green-500 mr-3 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        <span class="text-gray-700">Relatórios avançados</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="text-green-500 mr-3 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        <span class="text-gray-700">Integração bancária</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="text-green-500 mr-3 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        <span class="text-gray-700">Alertas personalizados</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="text-green-500 mr-3 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        <span class="text-gray-700">Suporte prioritário</span>
                    </li>
                </ul>
                <button class="w-full py-3 px-6 rounded-xl font-semibold transition duration-300 bg-blue-600 text-white hover:bg-blue-700">
                    Começar Teste Grátis
                </button>
            </div>

            {{-- Plano Família --}}
            <div class="relative p-8 rounded-2xl border-2 border-gray-200 hover:border-blue-300 hover:shadow-lg transition duration-300">
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Família</h3>
                    <p class="text-gray-600 mb-4">Para toda a família</p>
                    <div class="flex items-baseline justify-center">
                        <span class="text-4xl font-bold text-gray-900">R$ 29,90</span>
                        <span class="text-gray-600 ml-1">/mês</span>
                    </div>
                </div>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center">
                        <svg class="text-green-500 mr-3 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        <span class="text-gray-700">Até 5 usuários</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="text-green-500 mr-3 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        <span class="text-gray-700">Todos os recursos Premium</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="text-green-500 mr-3 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        <span class="text-gray-700">Controle parental</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="text-green-500 mr-3 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        <span class="text-gray-700">Metas compartilhadas</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="text-green-500 mr-3 flex-shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        <span class="text-gray-700">Suporte 24/7</span>
                    </li>
                </ul>
                <button class="w-full py-3 px-6 rounded-xl font-semibold transition duration-300 bg-gray-100 text-gray-900 hover:bg-gray-200">
                    Começar Teste Grátis
                </button>
            </div>
        </div>
    </div>
</section>
