    </main>
    
    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 mt-20 border-t border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                
                <!-- Brand -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-heart-red to-blood-red rounded-xl flex items-center justify-center shadow-lg">
                            <i data-lucide="heart" class="w-6 h-6 text-white"></i>
                        </div>
                        <span class="text-2xl font-bold gradient-text"><?php echo translate('site_name'); ?></span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4 max-w-md">
                        <?php echo translate('footer_tagline'); ?>
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center hover:bg-heart-red hover:text-white transition-all duration-300">
                            <i data-lucide="facebook" class="w-5 h-5"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center hover:bg-heart-red hover:text-white transition-all duration-300">
                            <i data-lucide="twitter" class="w-5 h-5"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center hover:bg-heart-red hover:text-white transition-all duration-300">
                            <i data-lucide="instagram" class="w-5 h-5"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center hover:bg-heart-red hover:text-white transition-all duration-300">
                            <i data-lucide="linkedin" class="w-5 h-5"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-gray-600 dark:text-gray-400 hover:text-heart-red transition-colors"><?php echo translate('home'); ?></a></li>
                        <li><a href="search.php" class="text-gray-600 dark:text-gray-400 hover:text-heart-red transition-colors"><?php echo translate('search'); ?></a></li>
                        <li><a href="register.php" class="text-gray-600 dark:text-gray-400 hover:text-heart-red transition-colors"><?php echo translate('register'); ?></a></li>
                        <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-heart-red transition-colors"><?php echo translate('about'); ?></a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-4"><?php echo translate('contact'); ?></h3>
                    <ul class="space-y-2 text-gray-600 dark:text-gray-400">
                        <li class="flex items-center space-x-2">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                            <span><?php echo SITE_EMAIL; ?></span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i data-lucide="phone" class="w-4 h-4"></i>
                            <span>+91 98765 43210</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i data-lucide="map-pin" class="w-4 h-4"></i>
                            <span>Gujarat, India</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Bottom Bar -->
            <div class="border-t border-gray-200 dark:border-gray-700 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 md:mb-0">
                    © <?php echo date('Y'); ?> <?php echo translate('site_name'); ?>. <?php echo translate('all_rights_reserved'); ?>
                </p>
                <div class="flex space-x-6 text-sm">
                    <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-heart-red transition-colors">
                        <?php echo translate('privacy_policy'); ?>
                    </a>
                    <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-heart-red transition-colors">
                        <?php echo translate('terms'); ?>
                    </a>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script src="assets/js/main.js"></script>
    <script>
        // Wait for Lucide library to load
        function initializeLucide() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            } else {
                console.warn('Lucide icons library not loaded. Check your internet connection.');
            }
        }
        
        // Try to initialize immediately
        initializeLucide();
        
        // Also try after window loads (fallback)
        window.addEventListener('load', initializeLucide);
        
        // Mobile Menu Toggle
        document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        });
        
        // Dark Mode Toggle
        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;
        
        // Check for saved theme preference or default to light mode
        const currentTheme = localStorage.getItem('theme') || 'light';
        if (currentTheme === 'dark') {
            html.classList.add('dark');
        }
        
        themeToggle?.addEventListener('click', function() {
            html.classList.toggle('dark');
            const theme = html.classList.contains('dark') ? 'dark' : 'light';
            localStorage.setItem('theme', theme);
            if (typeof lucide !== 'undefined') {
                lucide.createIcons(); // Reinitialize icons
            }
        });
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Auto-hide flash messages after 5 seconds
        setTimeout(() => {
            const flashMessage = document.querySelector('.animate-fade-in');
            if (flashMessage) {
                flashMessage.style.opacity = '0';
                flashMessage.style.transform = 'translateX(100%)';
                setTimeout(() => flashMessage.remove(), 300);
            }
        }, 5000);
    </script>
</body>
</html>
