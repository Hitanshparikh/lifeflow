-- LifeFlow Blood Donor Management System
-- Database Schema

CREATE DATABASE IF NOT EXISTS lifeflow CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE lifeflow;

-- Donors Table
CREATE TABLE IF NOT EXISTS donors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(15) NOT NULL,
    blood_group ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-') NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    date_of_birth DATE NOT NULL,
    city VARCHAR(100) NOT NULL,
    area VARCHAR(100),
    address TEXT,
    last_donation_date DATE,
    health_status ENUM('Good', 'Excellent', 'Fair') DEFAULT 'Good',
    is_available BOOLEAN DEFAULT 1,
    language_preference ENUM('en', 'gu', 'hi') DEFAULT 'en',
    latitude DECIMAL(10, 8) NULL,
    longitude DECIMAL(11, 8) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_blood_group (blood_group),
    INDEX idx_city (city),
    INDEX idx_availability (is_available)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Contact Logs Table (Track who viewed contact info)
CREATE TABLE IF NOT EXISTS contact_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    donor_id INT NOT NULL,
    viewer_ip VARCHAR(45),
    viewer_info TEXT,
    viewed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (donor_id) REFERENCES donors(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Admin Users Table (Optional - for future admin panel)
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Sample Data for Testing
INSERT INTO donors (full_name, email, phone, blood_group, gender, date_of_birth, city, area, last_donation_date, health_status, language_preference) VALUES
('Rajesh Kumar', 'rajesh.kumar@example.com', '9876543210', 'A+', 'Male', '1990-05-15', 'Ahmedabad', 'Satellite', '2025-10-15', 'Excellent', 'gu'),
('Priya Patel', 'priya.patel@example.com', '9876543211', 'O+', 'Female', '1992-08-20', 'Ahmedabad', 'Maninagar', '2025-11-20', 'Good', 'gu'),
('Amit Shah', 'amit.shah@example.com', '9876543212', 'B+', 'Male', '1988-03-10', 'Surat', 'Adajan', '2025-09-05', 'Excellent', 'hi'),
('Sneha Desai', 'sneha.desai@example.com', '9876543213', 'AB+', 'Female', '1995-12-25', 'Vadodara', 'Alkapuri', '2025-08-12', 'Good', 'en'),
('Karan Mehta', 'karan.mehta@example.com', '9876543214', 'O-', 'Male', '1991-07-18', 'Rajkot', 'Raiya', '2025-07-20', 'Excellent', 'gu'),
('Neha Sharma', 'neha.sharma@example.com', '9876543215', 'A-', 'Female', '1993-11-05', 'Ahmedabad', 'Bopal', '2025-06-30', 'Good', 'hi'),
('Vijay Singh', 'vijay.singh@example.com', '9876543216', 'B-', 'Male', '1989-04-22', 'Gandhinagar', 'Sector 21', '2025-12-15', 'Excellent', 'en'),
('Riya Gandhi', 'riya.gandhi@example.com', '9876543217', 'AB-', 'Female', '1994-09-30', 'Surat', 'Vesu', '2025-11-01', 'Good', 'gu');

-- Create a default admin user (password: admin123 - Change this!)
-- Password hash for 'admin123' using PHP password_hash()
INSERT INTO admin_users (username, password_hash, email) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@lifeflow.com');
