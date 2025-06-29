{{-- filepath: resources/views/components/testimonials.blade.php --}}
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                O que nossos usuários dizem
            </h2>
            <p class="text-xl text-gray-600">
                Mais de 50.000 pessoas já transformaram suas finanças conosco
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            {{-- Testemunho 1 --}}
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition duration-300">
                <div class="flex items-center mb-6">
                    @for ($i = 0; $i < 5; $i++)
                        {{-- Star SVG --}}
                        <svg class="text-yellow-400 fill-current" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 17.27 18.18 21 16.54 13.97 22 9.24 14.81 8.63 12 2 9.19 8.63 2 9.24 7.46 13.97 5.82 21 12 17.27"/></svg>
                    @endfor
                </div>
                <p class="text-gray-700 mb-6 leading-relaxed">
                    "Consegui economizar 30% dos meus gastos mensais depois que comecei a usar o app. A interface é incrível!"
                </p>
                <div class="flex items-center">
                    <img
                        src="https://images.unsplash.com/photo-1494790108755-2616b612e2bb?w=150&amp;h=150&amp;fit=crop&amp;crop=face"
                        alt="Ana Silva"
                        class="w-12 h-12 rounded-full mr-4"
                    />
                    <div>
                        <h4 class="font-semibold text-gray-900">Ana Silva</h4>
                        <p class="text-gray-600 text-sm">Empresária</p>
                    </div>
                </div>
            </div>
            {{-- Testemunho 2 --}}
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition duration-300">
                <div class="flex items-center mb-6">
                    @for ($i = 0; $i < 5; $i++)
                        <svg class="text-yellow-400 fill-current" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 17.27 18.18 21 16.54 13.97 22 9.24 14.81 8.63 12 2 9.19 8.63 2 9.24 7.46 13.97 5.82 21 12 17.27"/></svg>
                    @endfor
                </div>
                <p class="text-gray-700 mb-6 leading-relaxed">
                    "Finalmente um app que entende minhas necessidades. Os relatórios são muito detalhados e úteis."
                </p>
                <div class="flex items-center">
                    <img
                        src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&amp;h=150&amp;fit=crop&amp;crop=face"
                        alt="Carlos Santos"
                        class="w-12 h-12 rounded-full mr-4"
                    />
                    <div>
                        <h4 class="font-semibold text-gray-900">Carlos Santos</h4>
                        <p class="text-gray-600 text-sm">Desenvolvedor</p>
                    </div>
                </div>
            </div>
            {{-- Testemunho 3 --}}
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition duration-300">
                <div class="flex items-center mb-6">
                    @for ($i = 0; $i < 5; $i++)
                        <svg class="text-yellow-400 fill-current" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 17.27 18.18 21 16.54 13.97 22 9.24 14.81 8.63 12 2 9.19 8.63 2 9.24 7.46 13.97 5.82 21 12 17.27"/></svg>
                    @endfor
                </div>
                <p class="text-gray-700 mb-6 leading-relaxed">
                    "A sincronização automática com meu banco mudou minha vida financeira. Recomendo para todos!"
                </p>
                <div class="flex items-center">
                    <img
                        src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&amp;h=150&amp;fit=crop&amp;crop=face"
                        alt="Mariana Costa"
                        class="w-12 h-12 rounded-full mr-4"
                    />
                    <div>
                        <h4 class="font-semibold text-gray-900">Mariana Costa</h4>
                        <p class="text-gray-600 text-sm">Designer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
