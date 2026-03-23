#  LifeFlow - Blood Donor Search & Registration System

<div align="center">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
  <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS" />
  <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript" />
</div>

##  Overview

**LifeFlow** is a premium, mobile-friendly Blood Donor Search & Registration System designed to connect blood donors with those in need. Built with modern web technologies, it features a sleek UI, real-time search, multilingual support, and privacy-focused donor management.

##  Key Features

###  Premium UI/UX
- **Modern Health Aesthetic** - Clean white backgrounds, soft shadows, rounded corners
- **Heart-Red Accent Color** (#E0115F) throughout the design
- **Glassmorphism Effects** - Contemporary frosted glass design elements
- **Dark Mode Support** - Toggle between light and dark themes
- **Smooth Animations** - CSS transitions and hover effects for a polished feel
- **Responsive Design** - Fully mobile-optimized for all screen sizes

###  Smart Search System
- **Real-Time Filtering** - Filter by blood group, city, and availability
- **No Page Reloads** - Smooth filtering experience with instant results
- **Advanced Filters** - Show only available donors
- **Blood Type Distribution** - Visual representation of donor statistics

###  Multilingual Support
- **3 Languages** - English, Gujarati (ગુજરાતી), Hindi (हिन्दी)
- **JSON-Based Translations** - Easy to add more languages
- **Session-Based** - Language preference saved throughout the session
- **Complete Coverage** - All UI elements fully translated

###  Privacy & Security
- **Hidden Contact Info** - Phone numbers masked by default (****1234)
- **View Contact Button** - Reveal contact only when needed
- **Activity Logging** - Track who viewed contact information
- **Secure Database** - Prepared statements to prevent SQL injection
- **Input Sanitization** - All user inputs properly validated and cleaned

###  Mobile-First Features
- **One-Tap Calling** - Direct phone integration with `tel:` protocol
- **WhatsApp Integration** - Pre-filled message to contact donors instantly
- **Thumb-Friendly Buttons** - Large, easy-to-tap action buttons
- **Touch Optimizations** - Smooth interactions on mobile devices

###  Blood Donation Management
- **Eligibility Checker** - Automatic calculation based on 90-day rule
- **Last Donation Tracking** - Shows days since last donation
- **Availability Status** - Donors can mark themselves as available/unavailable
- **Health Status** - Track donor health condition (Good, Excellent, Fair)

##  Tech Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+ / phpMyAdmin
- **Frontend**: HTML5, JavaScript (ES6+)
- **Styling**: Tailwind CSS 3.x
- **Icons**: Lucide Icons
- **Fonts**: Google Fonts (Inter)

##  Project Structure

```
lifeflow/
├── assets/
│   ├── css/
│   │   └── custom.css          # Custom styles and animations
│   ├── js/
│   │   └── main.js             # JavaScript utilities
│   └── images/                 # Project images
├── includes/
│   ├── config.php              # Database configuration
│   ├── functions.php           # Utility functions
│   ├── header.php              # Header component
│   └── footer.php              # Footer component
├── languages/
│   ├── en.json                 # English translations
│   ├── gu.json                 # Gujarati translations
│   └── hi.json                 # Hindi translations
├── api/
│   └── log-contact-view.php    # Contact view logging endpoint
├── index.php                   # Landing page
├── register.php                # Donor registration
├── search.php                  # Donor search & filtering
├── db.sql                      # Database schema
└── README.md                   # Documentation
```

##  Installation Guide

### Prerequisites
- XAMPP/WAMP/LAMP (Apache, MySQL, PHP)
- Web browser (Chrome, Firefox, Safari, Edge)
- Text editor (VS Code, Sublime Text)

### Step 1: Clone/Download Project
```bash
# Place the project in your htdocs folder
cd C:\xampp\htdocs\
```

### Step 2: Database Setup
1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Click "New" to create a new database
3. Import the `db.sql` file:
   - Click on your new database
   - Go to "Import" tab
   - Choose `db.sql` file
   - Click "Go"

Alternatively, run the SQL directly:
```sql
-- Open db.sql and execute all statements in phpMyAdmin SQL tab
```

### Step 3: Configuration
Edit `includes/config.php` if needed:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');           // Change if you have a password
define('DB_NAME', 'lifeflow');
```

### Step 4: Launch Application
1. Start Apache and MySQL in XAMPP Control Panel
2. Open your browser and navigate to:
   ```
   http://localhost/lifeflow
   ```

### Step 5: Test the System
- **Register** a new donor at `/register.php`
- **Search** for donors at `/search.php`
- **Test** multilingual support with the language switcher
- **Try** dark mode toggle in the header

##  Database Schema

### Donors Table
| Field | Type | Description |
|-------|------|-------------|
| id | INT | Primary key, auto-increment |
| full_name | VARCHAR(100) | Donor's full name |
| email | VARCHAR(100) | Email address (unique) |
| phone | VARCHAR(15) | Contact number |
| blood_group | ENUM | A+, A-, B+, B-, AB+, AB-, O+, O- |
| gender | ENUM | Male, Female, Other |
| date_of_birth | DATE | Date of birth |
| city | VARCHAR(100) | City name |
| area | VARCHAR(100) | Area/locality |
| address | TEXT | Full address |
| last_donation_date | DATE | Last blood donation date |
| health_status | ENUM | Good, Excellent, Fair |
| is_available | BOOLEAN | Availability status |
| language_preference | ENUM | en, gu, hi |
| latitude | DECIMAL(10,8) | GPS latitude (optional) |
| longitude | DECIMAL(11,8) | GPS longitude (optional) |
| created_at | TIMESTAMP | Record creation time |
| updated_at | TIMESTAMP | Last update time |

### Contact Logs Table
| Field | Type | Description |
|-------|------|-------------|
| id | INT | Primary key |
| donor_id | INT | Foreign key to donors |
| viewer_ip | VARCHAR(45) | IP address of viewer |
| viewer_info | TEXT | Browser/device info |
| viewed_at | TIMESTAMP | View timestamp |

##  Core Features Implementation

### 1. Blood Group Search
```php
// Search donors by blood group and city
search.php?blood_group=O+&city=Ahmedabad
```

### 2. Eligibility Calculation
The system automatically checks if a donor is eligible based on the 90-day rule:
```php
function isDonorEligible($lastDonationDate) {
    // Returns true if 90+ days have passed
}
```

### 3. WhatsApp Integration
```php
// Generate WhatsApp link with pre-filled message
$message = "Hello {Name}, we need {Blood Group} in {City}";
https://wa.me/919876543210?text=...
```

### 4. Contact Privacy
- Phone numbers are masked: `******3210`
- Click "View Contact" to reveal full number
- Each view is logged for security

### 5. Language Switching
```javascript
// Switch language by clicking on language selector
// Language preference saved in session
$_SESSION['lang'] = 'gu'; // or 'hi', 'en'
```

##  Configuration Options

### Enable/Disable Features
Edit `includes/config.php`:
```php
// Session timeout (in seconds)
define('SESSION_TIMEOUT', 3600);

// Site configuration
define('SITE_NAME', 'LifeFlow');
define('SITE_URL', 'http://localhost/lifeflow');
```

### Customize Colors
Edit Tailwind config in `includes/header.php`:
```javascript
colors: {
  'heart-red': '#E0115F',
  'blood-red': '#DC2626',
}
```

##  API Endpoints

### Log Contact View
```javascript
POST /api/log-contact-view.php
Content-Type: application/json

{
  "donor_id": 123
}
```

##  Premium Features

###  Implemented
- [x] Glassmorphism UI effects
- [x] Dark mode support
- [x] Multilingual (3 languages)
- [x] WhatsApp direct link
- [x] Eligibility logic (90-day rule)
- [x] One-click calling (`tel:` protocol)
- [x] Contact privacy (masked numbers)
- [x] Activity logging
- [x] Mobile-first responsive design
- [x] Real-time filtering
- [x] Blood type distribution stats
- [x] Smooth animations & transitions

###  Bonus Features You Can Add
- [ ] Admin dashboard
- [ ] Email notifications
- [ ] SMS integration
- [ ] Blood request system
- [ ] Donor rewards/badges
- [ ] Social media sharing
- [ ] Export to PDF
- [ ] Google Maps integration
- [ ] Nearby donor finder (GPS-based)
- [ ] Appointment booking system

##  Troubleshooting

### Database Connection Error
```
Error: Connection failed: Access denied
```
**Solution**: Check your database credentials in `includes/config.php`

### Icons Not Showing
```
Lucide icons not visible
```
**Solution**: Ensure internet connection for CDN, or download Lucide locally

### Language Not Switching
```
Language stays in English
```
**Solution**: Check if `session_start()` is called in `config.php`

### Form Validation Not Working
```
Form submits without validation
```
**Solution**: Ensure JavaScript is enabled in browser

##  Performance Tips

1. **Enable Caching**: Use PHP OPcache for better performance
2. **Optimize Images**: Compress images in `/assets/images/`
3. **Minify CSS/JS**: Use build tools for production
4. **Database Indexing**: Already added on blood_group, city, availability
5. **CDN for Libraries**: Use CDN for Tailwind and Lucide (already configured)

##  Security Best Practices

- ✅ Prepared statements (SQL injection prevention)
- ✅ Input sanitization
- ✅ XSS protection (htmlspecialchars)
- ✅ CSRF protection (recommended for production)
- ✅ Password hashing (for admin users)
- ✅ Session security
- ✅ HTTPS (recommended for production)

##  Support & Contact

For questions or issues, please contact:
- **Email**: contact@lifeflow.com
- **Website**: http://localhost/lifeflow

##  License

This project is created for educational purposes. Feel free to use and modify as needed.

##  Acknowledgments

- **Tailwind CSS** - For the amazing utility-first CSS framework
- **Lucide Icons** - For beautiful, consistent icons
- **PHP Community** - For excellent documentation and support
- **Blood Donors** - For being real-life heroes 

---

<div align="center">
  <strong>Made By HiVizStudios for saving lives</strong>
  <br>
  <em>Every drop counts. Every donor matters.</em>
</div>
