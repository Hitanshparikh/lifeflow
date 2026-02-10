<?php
require_once 'includes/header.php';

// Get some stats for the hero section
$totalDonors = $conn->query("SELECT COUNT(*) as count FROM donors")->fetch_assoc()['count'];
$availableDonors = $conn->query("SELECT COUNT(*) as count FROM donors WHERE is_available = 1")->fetch_assoc()['count'];
$citiesCount = $conn->query("SELECT COUNT(DISTINCT city) as count FROM donors")->fetch_assoc()['count'];
?>

<!-- Hero Section -->
<section class="container mx-auto px-4 py-12 sm:py-20">
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <!-- Left Content -->
            <div class="text-center lg:text-left">
                <div class="inline-block bg-gradient-to-r from-heart-red/10 to-blood-red/10 dark:from-heart-red/20 dark:to-blood-red/20 px-4 py-2 rounded-full mb-6">
                    <span class="text-heart-red font-semibold text-sm sm:text-base flex items-center justify-center gap-2">
                        <i data-lucide="heart-pulse" class="w-4 h-4"></i>
                        <?php echo translate('tagline'); ?>
                    </span>
                </div>
                
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold mb-6 leading-tight">
                    <span class="gradient-text"><?php echo translate('hero_title'); ?></span>
                </h1>
                
                <p class="text-lg sm:text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto lg:mx-0">
                    <?php echo translate('hero_subtitle'); ?>
                </p>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="search.php" class="bg-gradient-to-r from-heart-red to-blood-red text-white px-8 py-4 rounded-xl hover:shadow-2xl hover:scale-105 transition-all duration-300 font-bold text-lg flex items-center justify-center gap-2">
                        <i data-lucide="search" class="w-5 h-5"></i>
                        <?php echo translate('search'); ?>
                    </a>
                    <a href="register.php" class="bg-white dark:bg-gray-800 text-heart-red px-8 py-4 rounded-xl hover:shadow-xl hover:scale-105 transition-all duration-300 font-bold text-lg border-2 border-heart-red flex items-center justify-center gap-2">
                        <i data-lucide="user-plus" class="w-5 h-5"></i>
                        <?php echo translate('register'); ?>
                    </a>
                </div>
                
                <!-- Stats -->
                <div class="grid grid-cols-3 gap-4 mt-12 max-w-md mx-auto lg:mx-0">
                    <div class="text-center">
                        <div class="text-3xl sm:text-4xl font-bold text-heart-red"><?php echo $totalDonors; ?></div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Total Donors</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl sm:text-4xl font-bold text-heart-red"><?php echo $availableDonors; ?></div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Available</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl sm:text-4xl font-bold text-heart-red"><?php echo $citiesCount; ?></div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Cities</div>
                    </div>
                </div>
            </div>
            
            <!-- Right Visual -->
            <div class="relative">
                <div class="relative glass-effect rounded-3xl p-8 shadow-2xl">
                    <!-- Quick Search Box -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 sm:p-8 shadow-xl">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <i data-lucide="zap" class="w-6 h-6 text-heart-red"></i>
                            <?php echo translate('quick_search'); ?>
                        </h3>
                        
                        <form action="search.php" method="GET" class="space-y-4">
                            <!-- Blood Group -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <?php echo translate('blood_group'); ?>
                                </label>
                                <select name="blood_group" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-heart-red focus:ring-2 focus:ring-heart-red/20 outline-none transition-all">
                                    <option value=""><?php echo translate('all_blood_groups'); ?></option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                            </div>
                            
                            <!-- City -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <?php echo translate('city'); ?>
                                </label>
                                <select name="city" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-heart-red focus:ring-2 focus:ring-heart-red/20 outline-none transition-all">
                                    <option value=""><?php echo translate('all_cities'); ?></option>
                                    <?php
                                    $cities = $conn->query("SELECT DISTINCT city FROM donors ORDER BY city");
                                    while ($row = $cities->fetch_assoc()):
                                    ?>
                                        <option value="<?php echo htmlspecialchars($row['city']); ?>">
                                            <?php echo htmlspecialchars($row['city']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            
                            <!-- Search Button -->
                            <button type="submit" class="w-full bg-gradient-to-r from-heart-red to-blood-red text-white px-6 py-4 rounded-xl hover:shadow-2xl hover:scale-105 transition-all duration-300 font-bold text-lg flex items-center justify-center gap-2">
                                <i data-lucide="search" class="w-5 h-5"></i>
                                <?php echo translate('search'); ?>
                            </button>
                        </form>
                    </div>
                    
                    <!-- Floating Elements -->
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-br from-heart-red to-blood-red rounded-full opacity-20 blur-2xl animate-pulse"></div>
                    <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-gradient-to-br from-heart-red to-blood-red rounded-full opacity-20 blur-2xl animate-pulse delay-1000"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blood Groups Section -->
<section class="container mx-auto px-4 py-16">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Blood Type Distribution
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-lg">
                Find donors by their blood group
            </p>
        </div>
        
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4">
            <?php
            $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
            foreach ($bloodGroups as $bg):
                $count = $conn->query("SELECT COUNT(*) as count FROM donors WHERE blood_group = '$bg'")->fetch_assoc()['count'];
            ?>
                <a href="search.php?blood_group=<?php echo urlencode($bg); ?>" class="glass-effect rounded-2xl p-6 text-center hover-lift group">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-heart-red to-blood-red rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <span class="text-white font-bold text-xl"><?php echo $bg; ?></span>
                    </div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo $count; ?></div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Donors</div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="container mx-auto px-4 py-16">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Why Choose LifeFlow?
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-lg">
                Modern, secure, and efficient blood donor management
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="glass-effect rounded-2xl p-8 hover-lift">
                <div class="w-16 h-16 bg-gradient-to-br from-heart-red to-blood-red rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                    <i data-lucide="shield-check" class="w-8 h-8 text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Privacy Protected</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Donor contact information is hidden by default and only revealed when needed, with full activity logging.
                </p>
            </div>
            
            <!-- Feature 2 -->
            <div class="glass-effect rounded-2xl p-8 hover-lift">
                <div class="w-16 h-16 bg-gradient-to-br from-heart-red to-blood-red rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                    <i data-lucide="zap" class="w-8 h-8 text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Instant Search</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Real-time filtering by blood group, city, and availability status without page reloads.
                </p>
            </div>
            
            <!-- Feature 3 -->
            <div class="glass-effect rounded-2xl p-8 hover-lift">
                <div class="w-16 h-16 bg-gradient-to-br from-heart-red to-blood-red rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                    <i data-lucide="smartphone" class="w-8 h-8 text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Mobile First</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    One-tap calling and WhatsApp integration make it easy to connect with donors on any device.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="container mx-auto px-4 py-16">
    <div class="max-w-4xl mx-auto glass-effect rounded-3xl p-8 sm:p-12 text-center">
        <div class="w-20 h-20 bg-gradient-to-br from-heart-red to-blood-red rounded-full flex items-center justify-center mx-auto mb-6 shadow-2xl pulse-slow">
            <i data-lucide="heart" class="w-10 h-10 text-white"></i>
        </div>
        <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-6">
            Ready to Save Lives?
        </h2>
        <p class="text-lg text-gray-600 dark:text-gray-400 mb-8 max-w-2xl mx-auto">
            Join our community of life-savers today. Your donation can make the difference between life and death.
        </p>
        <a href="register.php" class="inline-flex items-center gap-2 bg-gradient-to-r from-heart-red to-blood-red text-white px-8 py-4 rounded-xl hover:shadow-2xl hover:scale-105 transition-all duration-300 font-bold text-lg">
            <i data-lucide="user-plus" class="w-5 h-5"></i>
            Register Now
        </a>
    </div>
</section>

<script>
    // Reinitialize Lucide icons for dynamically loaded content
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>

<?php require_once 'includes/footer.php'; ?>
