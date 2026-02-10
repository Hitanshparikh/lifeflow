<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

// Handle language switching BEFORE any output
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'gu', 'hi'])) {
    $_SESSION['lang'] = $_GET['lang'];
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo translate('site_name'); ?> - <?php echo translate('tagline'); ?></title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest" defer></script>
    
    <!-- Custom Tailwind Configuration -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'heart-red': '#E0115F',
                        'blood-red': '#DC2626',
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="assets/css/custom.css" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .dark .glass-effect {
            background: rgba(31, 41, 55, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #E0115F 0%, #DC2626 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .pulse-slow {
            animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #E0115F;
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #DC2626;
        }
        
        .dark ::-webkit-scrollbar-track {
            background: #1F2937;
        }
        
        .dark ::-webkit-scrollbar-thumb {
            background: #E0115F;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen transition-colors duration-300">
    
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 glass-effect shadow-lg">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                
                <!-- Logo -->
                <a href="index.php" class="flex items-center space-x-2 sm:space-x-3 group">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-heart-red to-blood-red rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="heart" class="w-5 h-5 sm:w-6 sm:h-6 text-white"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xl sm:text-2xl font-bold gradient-text"><?php echo translate('site_name'); ?></span>
                        <span class="text-xs text-gray-600 dark:text-gray-400 hidden sm:block"><?php echo translate('tagline'); ?></span>
                    </div>
                </a>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="index.php" class="text-gray-700 dark:text-gray-300 hover:text-heart-red dark:hover:text-heart-red transition-colors duration-200 font-medium <?php echo $currentPage === 'index.php' ? 'text-heart-red' : ''; ?>">
                        <?php echo translate('home'); ?>
                    </a>
                    <a href="search.php" class="text-gray-700 dark:text-gray-300 hover:text-heart-red dark:hover:text-heart-red transition-colors duration-200 font-medium <?php echo $currentPage === 'search.php' ? 'text-heart-red' : ''; ?>">
                        <?php echo translate('search'); ?>
                    </a>
                    <a href="register.php" class="bg-gradient-to-r from-heart-red to-blood-red text-white px-6 py-2.5 rounded-xl hover:shadow-xl hover:scale-105 transition-all duration-300 font-semibold">
                        <?php echo translate('register'); ?>
                    </a>
                    
                    <!-- Language Switcher -->
                    <div class="relative group">
                        <button class="flex items-center space-x-2 text-gray-700 dark:text-gray-300 hover:text-heart-red transition-colors">
                            <i data-lucide="globe" class="w-5 h-5"></i>
                            <span class="uppercase font-semibold"><?php echo $_SESSION['lang']; ?></span>
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-800 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <a href="?lang=en" class="block px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-t-xl transition-colors">
                                🇬🇧 English
                            </a>
                            <a href="?lang=gu" class="block px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                🇮🇳 ગુજરાતી
                            </a>
                            <a href="?lang=hi" class="block px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-b-xl transition-colors">
                                🇮🇳 हिन्दी
                            </a>
                        </div>
                    </div>
                    
                    <!-- Dark Mode Toggle -->
                    <button id="themeToggle" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i data-lucide="sun" class="w-5 h-5 text-gray-700 dark:text-gray-300 hidden dark:block"></i>
                        <i data-lucide="moon" class="w-5 h-5 text-gray-700 dark:text-gray-300 block dark:hidden"></i>
                    </button>
                </div>
                
                <!-- Mobile Menu Button -->
                <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <i data-lucide="menu" class="w-6 h-6 text-gray-700 dark:text-gray-300"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden bg-white dark:bg-gray-800 shadow-lg">
            <div class="container mx-auto px-4 py-4 space-y-3">
                <a href="index.php" class="block py-2 text-gray-700 dark:text-gray-300 hover:text-heart-red transition-colors">
                    <?php echo translate('home'); ?>
                </a>
                <a href="search.php" class="block py-2 text-gray-700 dark:text-gray-300 hover:text-heart-red transition-colors">
                    <?php echo translate('search'); ?>
                </a>
                <a href="register.php" class="block py-2 text-heart-red font-semibold">
                    <?php echo translate('register'); ?>
                </a>
                <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 mb-2"><?php echo translate('language'); ?></p>
                    <div class="flex space-x-2">
                        <a href="?lang=en" class="px-3 py-1.5 bg-gray-100 dark:bg-gray-700 rounded-lg text-sm">EN</a>
                        <a href="?lang=gu" class="px-3 py-1.5 bg-gray-100 dark:bg-gray-700 rounded-lg text-sm">GU</a>
                        <a href="?lang=hi" class="px-3 py-1.5 bg-gray-100 dark:bg-gray-700 rounded-lg text-sm">HI</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Flash Message -->
    <?php $flash = getFlashMessage(); if ($flash): ?>
        <div class="fixed top-24 right-4 z-50 animate-fade-in">
            <div class="<?php echo $flash['type'] === 'success' ? 'bg-green-500' : 'bg-red-500'; ?> text-white px-6 py-4 rounded-xl shadow-2xl flex items-center space-x-3">
                <i data-lucide="<?php echo $flash['type'] === 'success' ? 'check-circle' : 'alert-circle'; ?>" class="w-6 h-6"></i>
                <span class="font-medium"><?php echo htmlspecialchars($flash['text']); ?></span>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Page Content -->
    <main class="pt-20 sm:pt-24">
