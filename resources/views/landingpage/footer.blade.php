{{-- filepath: resources/views/components/footer.blade.php --}}
<footer id="contact" class="bg-gray-900 text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <h3 class="text-2xl font-bold mb-4">FinanceApp</h3>
                <p class="text-gray-400 mb-6 max-w-md">
                    Transformamos a maneira como você gerencia suas finanças pessoais.
                    Simples, seguro e eficiente.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                        {{-- Facebook SVG --}}
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H6v4h4v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                        {{-- Twitter SVG --}}
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53A4.48 4.48 0 0 0 22.4 1.64a9.09 9.09 0 0 1-2.88 1.1A4.48 4.48 0 0 0 16.5 0c-2.5 0-4.5 2.01-4.5 4.5 0 .35.04.69.11 1.02A12.94 12.94 0 0 1 3 1.13a4.48 4.48 0 0 0-.61 2.27c0 1.56.8 2.93 2.02 3.74A4.48 4.48 0 0 1 2 6.13v.06c0 2.18 1.55 4 3.6 4.42a4.52 4.52 0 0 1-2.02.08c.57 1.78 2.23 3.08 4.2 3.12A9.05 9.05 0 0 1 1 19.54a12.8 12.8 0 0 0 6.95 2.04c8.34 0 12.9-6.91 12.9-12.9 0-.2 0-.39-.01-.58A9.22 9.22 0 0 0 23 3z"/></svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                        {{-- Instagram SVG --}}
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.5" y2="6.5"/></svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                        {{-- Linkedin SVG --}}
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="2" ry="2"/><line x1="16" y1="8" x2="16" y2="16"/><line x1="8" y1="8" x2="8" y2="16"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="12" y1="8" x2="12" y2="8"/></svg>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">Produto</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Recursos</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Preços</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Atualizações</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Blog</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">Contato</h4>
                <ul class="space-y-3">
                    <li class="flex items-center">
                        {{-- Mail SVG --}}
                        <svg class="mr-3 text-gray-400" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2" ry="2"/><polyline points="3 7 12 13 21 7"/></svg>
                        <span class="text-gray-400">contato@financeapp.com</span>
                    </li>
                    <li class="flex items-center">
                        {{-- Phone SVG --}}
                        <svg class="mr-3 text-gray-400" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92V21a2 2 0 0 1-2.18 2A19.72 19.72 0 0 1 3 5.18 2 2 0 0 1 5 3h4.09a2 2 0 0 1 2 1.72c.13 1.13.37 2.23.72 3.28a2 2 0 0 1-.45 2.11l-1.27 1.27a16 16 0 0 0 6.29 6.29l1.27-1.27a2 2 0 0 1 2.11-.45c1.05.35 2.15.59 3.28.72A2 2 0 0 1 22 16.92z"/></svg>
                        <span class="text-gray-400">(11) 9999-9999</span>
                    </li>
                    <li class="flex items-center">
                        {{-- MapPin SVG --}}
                        <svg class="mr-3 text-gray-400" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 1 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <span class="text-gray-400">São Paulo, SP</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-400 text-sm">
                © 2024 FinanceApp. Todos os direitos reservados.
            </p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="#" class="text-gray-400 hover:text-white text-sm transition duration-300">
                    Política de Privacidade
                </a>
                <a href="#" class="text-gray-400 hover:text-white text-sm transition duration-300">
                    Termos de Uso
                </a>
            </div>
        </div>
    </div>
</footer>
