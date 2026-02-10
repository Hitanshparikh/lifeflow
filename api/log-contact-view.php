<?php
// API endpoint to log contact views
header('Content-Type: application/json');

require_once '../includes/config.php';
require_once '../includes/functions.php';

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['donor_id']) || !is_numeric($input['donor_id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid donor ID']);
    exit;
}

$donorId = intval($input['donor_id']);

// Log the contact view
try {
    logContactView($conn, $donorId);
    echo json_encode(['success' => true, 'message' => 'Contact view logged']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to log contact view']);
}
?>
