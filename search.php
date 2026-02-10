<?php
require_once 'includes/header.php';

// Get filter parameters
$filterBloodGroup = isset($_GET['blood_group']) ? sanitize($_GET['blood_group']) : '';
$filterCity = isset($_GET['city']) ? sanitize($_GET['city']) : '';
$filterAvailable = isset($_GET['available']) ? 1 : '';

// Build query
$query = "SELECT * FROM donors WHERE 1=1";
$params = [];
$types = '';

if ($filterBloodGroup) {
    $query .= " AND blood_group = ?";
    $params[] = $filterBloodGroup;
    $types .= 's';
}

if ($filterCity) {
    $query .= " AND city = ?";
    $params[] = $filterCity;
    $types .= 's';
}

if ($filterAvailable !== '') {
    $query .= " AND is_available = ?";
    $params[] = $filterAvailable;
    $types .= 'i';
}

$query .= " ORDER BY created_at DESC";

// Execute query
$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$donors = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Get all cities for filter
$cities = $conn->query("SELECT DISTINCT city FROM donors ORDER BY city")->fetch_all(MYSQLI_ASSOC);
?>

<section class="container mx-auto px-4 py-8 sm:py-12">
    
    <!-- Header -->
    <div class="text-center mb-8">
        <div class="w-20 h-20 bg-gradient-to-br from-heart-red to-blood-red rounded-full flex items-center justify-center mx-auto mb-6 shadow-2xl">
            <i data-lucide="search" class="w-10 h-10 text-white"></i>
        </div>
        <h1 class="text-3xl sm:text-4xl font-bold gradient-text mb-3">
            <?php echo translate('search_title'); ?>
        </h1>
        <p class="text-gray-600 dark:text-gray-400 text-lg">
            <?php echo translate('search_subtitle'); ?>
        </p>
    </div>
    
    <!-- Filters -->
    <div class="max-w-6xl mx-auto mb-8">
        <div class="glass-effect rounded-2xl p-6 shadow-xl">
            <form id="filterForm" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    <!-- Blood Group Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i data-lucide="droplet" class="w-4 h-4 inline"></i>
                            <?php echo translate('blood_group'); ?>
                        </label>
                        <select name="blood_group" id="bloodGroupFilter" 
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-heart-red focus:ring-2 focus:ring-heart-red/20 outline-none transition-all">
                            <option value=""><?php echo translate('all_blood_groups'); ?></option>
                            <?php
                            $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
                            foreach ($bloodGroups as $bg):
                            ?>
                                <option value="<?php echo $bg; ?>" <?php echo ($filterBloodGroup === $bg) ? 'selected' : ''; ?>>
                                    <?php echo $bg; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <!-- City Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i data-lucide="map-pin" class="w-4 h-4 inline"></i>
                            <?php echo translate('city'); ?>
                        </label>
                        <select name="city" id="cityFilter"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-heart-red focus:ring-2 focus:ring-heart-red/20 outline-none transition-all">
                            <option value=""><?php echo translate('all_cities'); ?></option>
                            <?php foreach ($cities as $city): ?>
                                <option value="<?php echo htmlspecialchars($city['city']); ?>" 
                                    <?php echo ($filterCity === $city['city']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($city['city']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <!-- Availability Filter -->
                    <div class="flex items-end">
                        <label class="flex items-center gap-2 cursor-pointer p-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 hover:border-heart-red transition-all w-full">
                            <input type="checkbox" name="available" id="availableFilter" value="1" 
                                <?php echo ($filterAvailable !== '') ? 'checked' : ''; ?>
                                class="w-5 h-5 text-heart-red rounded focus:ring-heart-red focus:ring-2">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                <?php echo translate('show_available_only'); ?>
                            </span>
                        </label>
                    </div>
                    
                    <!-- Filter Buttons -->
                    <div class="flex gap-2">
                        <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-heart-red to-blood-red text-white px-4 py-3 rounded-xl hover:shadow-xl transition-all duration-300 font-semibold flex items-center justify-center gap-2">
                            <i data-lucide="filter" class="w-4 h-4"></i>
                            <span class="hidden sm:inline"><?php echo translate('apply_filters'); ?></span>
                        </button>
                        <a href="search.php" 
                            class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-3 rounded-xl hover:shadow-lg transition-all duration-300 font-semibold flex items-center justify-center">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Results Count -->
    <div class="max-w-6xl mx-auto mb-6">
        <p class="text-gray-600 dark:text-gray-400">
            Found <span class="font-bold text-heart-red"><?php echo count($donors); ?></span> donor(s)
            <?php if ($filterBloodGroup || $filterCity || $filterAvailable !== ''): ?>
                matching your criteria
            <?php endif; ?>
        </p>
    </div>
    
    <!-- Donor Cards Grid -->
    <?php if (count($donors) > 0): ?>
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($donors as $donor): 
                $isEligible = isDonorEligible($donor['last_donation_date']);
                $daysUntilEligible = getDaysUntilEligible($donor['last_donation_date']);
                $bloodColor = getBloodGroupColor($donor['blood_group']);
            ?>
                <div class="glass-effect rounded-2xl p-6 hover-lift group" data-donor-id="<?php echo $donor['id']; ?>">
                    
                    <!-- Card Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">
                                <?php echo htmlspecialchars($donor['full_name']); ?>
                            </h3>
                            <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400 text-sm">
                                <i data-lucide="map-pin" class="w-4 h-4"></i>
                                <span><?php echo htmlspecialchars($donor['city']); ?><?php echo $donor['area'] ? ', ' . htmlspecialchars($donor['area']) : ''; ?></span>
                            </div>
                        </div>
                        
                        <!-- Blood Group Badge -->
                        <div class="w-16 h-16 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform"
                            style="background: linear-gradient(135deg, <?php echo $bloodColor; ?> 0%, <?php echo $bloodColor; ?>dd 100%);">
                            <span class="text-white font-bold text-lg"><?php echo $donor['blood_group']; ?></span>
                        </div>
                    </div>
                    
                    <!-- Donor Info -->
                    <div class="space-y-3 mb-4">
                        <!-- Gender & Age -->
                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                            <i data-lucide="user" class="w-4 h-4"></i>
                            <span><?php echo $donor['gender']; ?>, <?php echo calculateAge($donor['date_of_birth']); ?> years</span>
                        </div>
                        
                        <!-- Health Status -->
                        <div class="flex items-center gap-2 text-sm">
                            <i data-lucide="heart-pulse" class="w-4 h-4 text-green-600"></i>
                            <span class="text-gray-600 dark:text-gray-400"><?php echo $donor['health_status']; ?> Health</span>
                        </div>
                        
                        <!-- Eligibility Status -->
                        <?php if ($donor['is_available']): ?>
                            <?php if ($isEligible): ?>
                                <div class="flex items-center gap-2 bg-green-50 dark:bg-green-900/20 px-3 py-2 rounded-lg">
                                    <i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i>
                                    <span class="text-green-700 dark:text-green-400 font-medium text-sm">
                                        <?php echo translate('donor_card_available'); ?>
                                    </span>
                                </div>
                            <?php else: ?>
                                <div class="flex items-center gap-2 bg-orange-50 dark:bg-orange-900/20 px-3 py-2 rounded-lg">
                                    <i data-lucide="clock" class="w-4 h-4 text-orange-600"></i>
                                    <span class="text-orange-700 dark:text-orange-400 font-medium text-sm">
                                        <?php echo translate('donor_card_eligible_in'); ?> <?php echo $daysUntilEligible; ?> <?php echo translate('donor_card_days'); ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="flex items-center gap-2 bg-gray-50 dark:bg-gray-800 px-3 py-2 rounded-lg">
                                <i data-lucide="ban" class="w-4 h-4 text-gray-600"></i>
                                <span class="text-gray-600 dark:text-gray-400 font-medium text-sm">
                                    <?php echo translate('not_available'); ?>
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Contact Section (Hidden by default) -->
                    <div class="contact-hidden space-y-3">
                        <button onclick="revealContact(<?php echo $donor['id']; ?>)" 
                            class="w-full bg-gradient-to-r from-heart-red to-blood-red text-white px-4 py-3 rounded-xl hover:shadow-xl transition-all duration-300 font-semibold flex items-center justify-center gap-2">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                            <?php echo translate('view_contact'); ?>
                        </button>
                    </div>
                    
                    <!-- Contact Section (Revealed) -->
                    <div class="contact-revealed hidden space-y-3">
                        <div class="bg-blue-50 dark:bg-blue-900/20 px-4 py-3 rounded-xl">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Phone:</span>
                                <a href="<?php echo formatPhoneLink($donor['phone']); ?>" 
                                    class="font-bold text-blue-600 dark:text-blue-400 text-lg">
                                    <?php echo htmlspecialchars($donor['phone']); ?>
                                </a>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3">
                            <!-- Call Button -->
                            <a href="<?php echo formatPhoneLink($donor['phone']); ?>" 
                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded-xl transition-all duration-300 font-semibold flex items-center justify-center gap-2">
                                <i data-lucide="phone" class="w-4 h-4"></i>
                                <?php echo translate('call_now'); ?>
                            </a>
                            
                            <!-- WhatsApp Button -->
                            <a href="<?php echo getWhatsAppLink($donor['phone'], $donor['full_name'], $donor['blood_group'], $donor['city']); ?>" 
                                target="_blank"
                                class="bg-[#25D366] hover:bg-[#20BA5A] text-white px-4 py-3 rounded-xl transition-all duration-300 font-semibold flex items-center justify-center gap-2">
                                <i data-lucide="message-circle" class="w-4 h-4"></i>
                                WhatsApp
                            </a>
                        </div>
                        
                        <button onclick="hideContact(<?php echo $donor['id']; ?>)" 
                            class="w-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-xl hover:shadow-lg transition-all duration-300 font-medium text-sm flex items-center justify-center gap-2">
                            <i data-lucide="eye-off" class="w-4 h-4"></i>
                            <?php echo translate('hide_contact'); ?>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <!-- No Results -->
        <div class="max-w-md mx-auto text-center py-12">
            <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                <i data-lucide="search-x" class="w-12 h-12 text-gray-400"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">
                <?php echo translate('no_donors_found'); ?>
            </h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">
                <?php echo translate('try_different_filters'); ?>
            </p>
            <a href="search.php" 
                class="inline-flex items-center gap-2 bg-gradient-to-r from-heart-red to-blood-red text-white px-6 py-3 rounded-xl hover:shadow-xl transition-all duration-300 font-semibold">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                <?php echo translate('clear_filters'); ?>
            </a>
        </div>
    <?php endif; ?>
</section>

<script>
    // Initialize icons when page loads
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    
    // Function to reveal contact information
    function revealContact(donorId) {
        const card = document.querySelector(`[data-donor-id="${donorId}"]`);
        const hiddenSection = card.querySelector('.contact-hidden');
        const revealedSection = card.querySelector('.contact-revealed');
        
        // Hide the reveal button
        hiddenSection.classList.add('hidden');
        
        // Show the contact info
        revealedSection.classList.remove('hidden');
        
        // Log the contact view (AJAX call)
        fetch('api/log-contact-view.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ donor_id: donorId })
        });
        
        // Reinitialize icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }
    
    // Function to hide contact information
    function hideContact(donorId) {
        const card = document.querySelector(`[data-donor-id="${donorId}"]`);
        const hiddenSection = card.querySelector('.contact-hidden');
        const revealedSection = card.querySelector('.contact-revealed');
        
        // Show the reveal button
        hiddenSection.classList.remove('hidden');
        
        // Hide the contact info
        revealedSection.classList.add('hidden');
        
        // Reinitialize icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }
    
    // Auto-submit filter form on change
    document.getElementById('bloodGroupFilter')?.addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
    
    document.getElementById('cityFilter')?.addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
    
    document.getElementById('availableFilter')?.addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
</script>

<?php require_once 'includes/footer.php'; ?>
