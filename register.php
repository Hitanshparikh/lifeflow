<?php
// Process form BEFORE any output
require_once 'includes/config.php';
require_once 'includes/functions.php';

$errors = [];
$success = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $fullName = sanitize($_POST['full_name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $bloodGroup = sanitize($_POST['blood_group'] ?? '');
    $gender = sanitize($_POST['gender'] ?? '');
    $dob = sanitize($_POST['date_of_birth'] ?? '');
    $city = sanitize($_POST['city'] ?? '');
    $area = sanitize($_POST['area'] ?? '');
    $address = sanitize($_POST['address'] ?? '');
    $lastDonation = !empty($_POST['last_donation']) ? sanitize($_POST['last_donation']) : null;
    $healthStatus = sanitize($_POST['health_status'] ?? 'Good');
    $isAvailable = isset($_POST['is_available']) ? 1 : 0;
    $langPref = $_SESSION['lang'];
    
    // Validation
    if (empty($fullName)) {
        $errors[] = "Full name is required";
    }
    
    if (!empty($email) && !isValidEmail($email)) {
        $errors[] = translate('invalid_email');
    }
    
    if (!isValidPhone($phone)) {
        $errors[] = translate('invalid_phone');
    }
    
    if (empty($bloodGroup)) {
        $errors[] = "Blood group is required";
    }
    
    if (empty($gender)) {
        $errors[] = "Gender is required";
    }
    
    if (empty($dob)) {
        $errors[] = "Date of birth is required";
    } else {
        $age = calculateAge($dob);
        if ($age < 18) {
            $errors[] = translate('age_requirement');
        }
    }
    
    if (empty($city)) {
        $errors[] = "City is required";
    }
    
    // If no errors, insert into database
    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("INSERT INTO donors (full_name, email, phone, blood_group, gender, date_of_birth, city, area, address, last_donation_date, health_status, is_available, language_preference) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            $stmt->bind_param("sssssssssssss", 
                $fullName, 
                $email, 
                $phone, 
                $bloodGroup, 
                $gender, 
                $dob, 
                $city, 
                $area, 
                $address, 
                $lastDonation, 
                $healthStatus, 
                $isAvailable, 
                $langPref
            );
            
            if ($stmt->execute()) {
                setFlashMessage(translate('success_registration'), 'success');
                // Redirect after successful registration (before any output)
                header("Location: search.php");
                exit();
            } else {
                $errors[] = translate('error_registration');
            }
            
            $stmt->close();
        } catch (Exception $e) {
            $errors[] = "Error: " . $e->getMessage();
        }
    }
}

// Include header after form processing
require_once 'includes/header.php';
?>

<section class="container mx-auto px-4 py-8 sm:py-12">
    <div class="max-w-3xl mx-auto">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gradient-to-br from-heart-red to-blood-red rounded-full flex items-center justify-center mx-auto mb-6 shadow-2xl">
                <i data-lucide="user-plus" class="w-10 h-10 text-white"></i>
            </div>
            <h1 class="text-3xl sm:text-4xl font-bold gradient-text mb-3">
                <?php echo translate('register_title'); ?>
            </h1>
            <p class="text-gray-600 dark:text-gray-400 text-lg">
                <?php echo translate('register_subtitle'); ?>
            </p>
        </div>
        
        <!-- Error Messages -->
        <?php if (!empty($errors)): ?>
            <div class="bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-800 rounded-xl p-4 mb-6">
                <div class="flex items-start gap-3">
                    <i data-lucide="alert-circle" class="w-6 h-6 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5"></i>
                    <div class="flex-1">
                        <h3 class="font-semibold text-red-800 dark:text-red-300 mb-2">Please fix the following errors:</h3>
                        <ul class="list-disc list-inside space-y-1 text-red-700 dark:text-red-400">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Registration Form -->
        <form method="POST" class="glass-effect rounded-3xl p-6 sm:p-8 shadow-2xl space-y-8">
            
            <!-- Personal Details Section -->
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i data-lucide="user" class="w-6 h-6 text-heart-red"></i>
                    <?php echo translate('personal_details'); ?>
                </h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Full Name -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <?php echo translate('full_name'); ?> <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="full_name" value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>" required
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-heart-red focus:ring-2 focus:ring-heart-red/20 outline-none transition-all"
                            placeholder="Enter your full name">
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <?php echo translate('email'); ?>
                        </label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-heart-red focus:ring-2 focus:ring-heart-red/20 outline-none transition-all"
                            placeholder="your.email@example.com">
                    </div>
                    
                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <?php echo translate('phone'); ?> <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" name="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>" required
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-heart-red focus:ring-2 focus:ring-heart-red/20 outline-none transition-all"
                            placeholder="98765 43210" pattern="[0-9]{10}">
                    </div>
                    
                    <!-- Date of Birth -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <?php echo translate('date_of_birth'); ?> <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="date_of_birth" value="<?php echo htmlspecialchars($_POST['date_of_birth'] ?? ''); ?>" required
                            max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-heart-red focus:ring-2 focus:ring-heart-red/20 outline-none transition-all">
                    </div>
                    
                    <!-- Gender -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <?php echo translate('gender'); ?> <span class="text-red-500">*</span>
                        </label>
                        <select name="gender" required
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-heart-red focus:ring-2 focus:ring-heart-red/20 outline-none transition-all">
                            <option value="">Select Gender</option>
                            <option value="Male" <?php echo (($_POST['gender'] ?? '') === 'Male') ? 'selected' : ''; ?>><?php echo translate('male'); ?></option>
                            <option value="Female" <?php echo (($_POST['gender'] ?? '') === 'Female') ? 'selected' : ''; ?>><?php echo translate('female'); ?></option>
                            <option value="Other" <?php echo (($_POST['gender'] ?? '') === 'Other') ? 'selected' : ''; ?>><?php echo translate('other'); ?></option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Blood Details Section -->
            <div class="border-t-2 border-gray-200 dark:border-gray-700 pt-8">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i data-lucide="droplet" class="w-6 h-6 text-heart-red"></i>
                    <?php echo translate('blood_details'); ?>
                </h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <!-- Blood Group -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <?php echo translate('blood_group'); ?> <span class="text-red-500">*</span>
                        </label>
                        <select name="blood_group" required
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-heart-red focus:ring-2 focus:ring-heart-red/20 outline-none transition-all">
                            <option value="">Select</option>
                            <?php
                            $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
                            foreach ($bloodGroups as $bg):
                            ?>
                                <option value="<?php echo $bg; ?>" <?php echo (($_POST['blood_group'] ?? '') === $bg) ? 'selected' : ''; ?>><?php echo $bg; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <!-- Health Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <?php echo translate('health_status'); ?>
                        </label>
                        <select name="health_status"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-heart-red focus:ring-2 focus:ring-heart-red/20 outline-none transition-all">
                            <option value="Good" <?php echo (($_POST['health_status'] ?? 'Good') === 'Good') ? 'selected' : ''; ?>><?php echo translate('good'); ?></option>
                            <option value="Excellent" <?php echo (($_POST['health_status'] ?? '') === 'Excellent') ? 'selected' : ''; ?>><?php echo translate('excellent'); ?></option>
                            <option value="Fair" <?php echo (($_POST['health_status'] ?? '') === 'Fair') ? 'selected' : ''; ?>><?php echo translate('fair'); ?></option>
                        </select>
                    </div>
                    
                    <!-- Last Donation -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <?php echo translate('last_donation'); ?>
                        </label>
                        <input type="date" name="last_donation" value="<?php echo htmlspecialchars($_POST['last_donation'] ?? ''); ?>"
                            max="<?php echo date('Y-m-d'); ?>"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-heart-red focus:ring-2 focus:ring-heart-red/20 outline-none transition-all">
                    </div>
                </div>
            </div>
            
            <!-- Location Details Section -->
            <div class="border-t-2 border-gray-200 dark:border-gray-700 pt-8">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i data-lucide="map-pin" class="w-6 h-6 text-heart-red"></i>
                    <?php echo translate('location_details'); ?>
                </h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- City -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <?php echo translate('city'); ?> <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="city" value="<?php echo htmlspecialchars($_POST['city'] ?? ''); ?>" required
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-heart-red focus:ring-2 focus:ring-heart-red/20 outline-none transition-all"
                            placeholder="Ahmedabad">
                    </div>
                    
                    <!-- Area -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <?php echo translate('area'); ?>
                        </label>
                        <input type="text" name="area" value="<?php echo htmlspecialchars($_POST['area'] ?? ''); ?>"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-heart-red focus:ring-2 focus:ring-heart-red/20 outline-none transition-all"
                            placeholder="Satellite">
                    </div>
                    
                    <!-- Address -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <?php echo translate('address'); ?>
                        </label>
                        <textarea name="address" rows="3"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-heart-red focus:ring-2 focus:ring-heart-red/20 outline-none transition-all resize-none"
                            placeholder="Enter your full address"><?php echo htmlspecialchars($_POST['address'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Availability Section -->
            <div class="border-t-2 border-gray-200 dark:border-gray-700 pt-8">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-6 h-6 text-heart-red"></i>
                    <?php echo translate('availability'); ?>
                </h2>
                
                <label class="flex items-center gap-3 cursor-pointer p-4 rounded-xl border-2 border-gray-200 dark:border-gray-600 hover:border-heart-red transition-all">
                    <input type="checkbox" name="is_available" value="1" <?php echo isset($_POST['is_available']) ? 'checked' : 'checked'; ?>
                        class="w-5 h-5 text-heart-red rounded focus:ring-heart-red focus:ring-2">
                    <span class="flex-1 text-gray-700 dark:text-gray-300 font-medium">
                        <?php echo translate('available'); ?>
                    </span>
                    <i data-lucide="info" class="w-5 h-5 text-gray-400"></i>
                </label>
            </div>
            
            <!-- Submit Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6">
                <button type="submit" class="flex-1 bg-gradient-to-r from-heart-red to-blood-red text-white px-8 py-4 rounded-xl hover:shadow-2xl hover:scale-105 transition-all duration-300 font-bold text-lg flex items-center justify-center gap-2">
                    <i data-lucide="check" class="w-5 h-5"></i>
                    <?php echo translate('submit'); ?>
                </button>
                <a href="index.php" class="flex-1 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 px-8 py-4 rounded-xl hover:shadow-xl transition-all duration-300 font-bold text-lg border-2 border-gray-300 dark:border-gray-600 flex items-center justify-center gap-2">
                    <i data-lucide="x" class="w-5 h-5"></i>
                    <?php echo translate('cancel'); ?>
                </a>
            </div>
        </form>
    </div>
</section>

<script>
    // Wait for Lucide to load and DOM to be ready
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    } else {
        // Fallback: wait for script to load
        window.addEventListener('load', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    }
</script>

<?php require_once 'includes/footer.php'; ?>
