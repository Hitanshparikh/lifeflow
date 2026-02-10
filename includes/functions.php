<?php
// LifeFlow Utility Functions

/**
 * Translate function - Loads translations from JSON files
 */
function translate($key) {
    $lang = $_SESSION['lang'] ?? 'en';
    $file = __DIR__ . "/../languages/{$lang}.json";
    
    static $translations = [];
    
    if (!isset($translations[$lang])) {
        if (file_exists($file)) {
            $translations[$lang] = json_decode(file_get_contents($file), true);
        } else {
            $translations[$lang] = [];
        }
    }
    
    return $translations[$lang][$key] ?? $key;
}

/**
 * Sanitize input data
 */
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

/**
 * Check if donor is eligible to donate (90 days rule)
 */
function isDonorEligible($lastDonationDate) {
    if (!$lastDonationDate) {
        return true;
    }
    
    $lastDate = new DateTime($lastDonationDate);
    $today = new DateTime();
    $diff = $today->diff($lastDate);
    
    return $diff->days >= 90;
}

/**
 * Get days until eligible to donate
 */
function getDaysUntilEligible($lastDonationDate) {
    if (!$lastDonationDate) {
        return 0;
    }
    
    $lastDate = new DateTime($lastDonationDate);
    $eligibleDate = $lastDate->modify('+90 days');
    $today = new DateTime();
    
    $diff = $eligibleDate->diff($today);
    return $diff->invert ? $diff->days : 0;
}

/**
 * Format phone number for tel: protocol
 */
function formatPhoneLink($phone) {
    return 'tel:' . preg_replace('/[^0-9+]/', '', $phone);
}

/**
 * Hide phone number (show only last 4 digits)
 */
function maskPhone($phone) {
    $length = strlen($phone);
    if ($length <= 4) {
        return $phone;
    }
    return str_repeat('*', $length - 4) . substr($phone, -4);
}

/**
 * Generate WhatsApp link with pre-filled message
 */
function getWhatsAppLink($phone, $donorName, $bloodGroup, $city) {
    $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
    
    // Add country code if not present
    if (strlen($cleanPhone) === 10) {
        $cleanPhone = '91' . $cleanPhone; // India country code
    }
    
    $message = urlencode("Hello {$donorName}, we found your contact on LifeFlow and need {$bloodGroup} blood in {$city}. Are you available?");
    
    return "https://wa.me/{$cleanPhone}?text={$message}";
}

/**
 * Log contact view for security
 */
function logContactView($conn, $donorId) {
    $viewerIp = $_SERVER['REMOTE_ADDR'];
    $viewerInfo = json_encode([
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
        'referer' => $_SERVER['HTTP_REFERER'] ?? 'Direct'
    ]);
    
    $stmt = $conn->prepare("INSERT INTO contact_logs (donor_id, viewer_ip, viewer_info) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $donorId, $viewerIp, $viewerInfo);
    $stmt->execute();
    $stmt->close();
}

/**
 * Validate email format
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate phone number (Indian format)
 */
function isValidPhone($phone) {
    $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
    return strlen($cleanPhone) === 10 || strlen($cleanPhone) === 12;
}

/**
 * Calculate age from date of birth
 */
function calculateAge($dob) {
    $birthDate = new DateTime($dob);
    $today = new DateTime();
    return $today->diff($birthDate)->y;
}

/**
 * Get blood group badge color
 */
function getBloodGroupColor($bloodGroup) {
    $colors = [
        'A+' => '#DC2626',  // Red
        'A-' => '#EF4444',
        'B+' => '#2563EB',  // Blue
        'B-' => '#3B82F6',
        'AB+' => '#7C3AED', // Purple
        'AB-' => '#8B5CF6',
        'O+' => '#059669',  // Green
        'O-' => '#10B981'
    ];
    
    return $colors[$bloodGroup] ?? '#6B7280';
}

/**
 * Redirect helper
 */
function redirect($url) {
    header("Location: $url");
    exit();
}

/**
 * Set flash message
 */
function setFlashMessage($message, $type = 'success') {
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type;
}

/**
 * Get and clear flash message
 */
function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = [
            'text' => $_SESSION['flash_message'],
            'type' => $_SESSION['flash_type'] ?? 'success'
        ];
        unset($_SESSION['flash_message'], $_SESSION['flash_type']);
        return $message;
    }
    return null;
}
?>
