# 🗺️ LifeFlow Project Map

## 📂 Complete File Structure

```
lifeflow/
│
├── 📄 index.php                    ⭐ Landing Page (Homepage)
│   ├── Hero section with stats
│   ├── Quick search form
│   ├── Blood group cards
│   ├── Features showcase
│   └── Call-to-action section
│
├── 📄 register.php                 ⭐ Donor Registration
│   ├── Multi-step form
│   ├── Personal details
│   ├── Blood information
│   ├── Location details
│   ├── Validation & error handling
│   └── Success redirect to search
│
├── 📄 search.php                   ⭐ Donor Search & Filter
│   ├── Filter by blood group
│   ├── Filter by city
│   ├── Filter by availability
│   ├── Donor cards with info
│   ├── Contact reveal system
│   ├── Call & WhatsApp buttons
│   └── Real-time filtering
│
├── 📄 db.sql                       💾 Database Schema
│   ├── donors table
│   ├── contact_logs table
│   ├── admin_users table
│   └── Sample data (8 donors)
│
├── 📄 README.md                    📖 Full Documentation
├── 📄 SETUP.md                     🚀 Installation Guide
└── 📄 PROJECT_MAP.md               🗺️ This file
│
├── 📁 includes/                    🔧 Core Files
│   ├── config.php                  Database connection & session
│   ├── functions.php               Utility functions (30+)
│   ├── header.php                  Navigation & language switcher
│   └── footer.php                  Footer & JavaScript
│
├── 📁 languages/                   🌐 Translations
│   ├── en.json                     English (default)
│   ├── gu.json                     Gujarati (ગુજરાતી)
│   └── hi.json                     Hindi (हिन्दी)
│
├── 📁 api/                         🔌 API Endpoints
│   └── log-contact-view.php        Contact view logging
│
└── 📁 assets/                      🎨 Static Assets
    ├── css/
    │   └── custom.css              Animations & custom styles
    ├── js/
    │   └── main.js                 JavaScript utilities
    └── images/                     Project images (empty - add yours)
```

## 🔄 User Flow Diagram

```
┌─────────────────────────────────────────────────────────┐
│                    User Visits Site                      │
│                   (index.php)                           │
└───────────────────┬─────────────────────────────────────┘
                    │
        ┌───────────┴──────────┐
        │                      │
        ▼                      ▼
┌───────────────┐      ┌───────────────┐
│  Search Page  │      │ Register Page │
│ (search.php)  │      │(register.php) │
└───────┬───────┘      └───────┬───────┘
        │                      │
        │  ┌───────────────────┘
        │  │ Registration Success
        │  │ Redirect to Search
        ▼  ▼
┌─────────────────────┐
│   Filter Donors     │
│ - Blood Group       │
│ - City              │
│ - Availability      │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│   View Donor Cards  │
│ - Name & Blood      │
│ - Location          │
│ - Eligibility       │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│  View Contact Info  │
│ - Click to Reveal   │
│ - Logged for Security│
└──────────┬──────────┘
           │
     ┌─────┴─────┐
     │           │
     ▼           ▼
┌─────────┐  ┌──────────┐
│  Call   │  │ WhatsApp │
│  Now    │  │ Message  │
└─────────┘  └──────────┘
```

## 🎯 Feature Modules

### 1️⃣ Authentication & Language System
```
Session Management (config.php)
    ├── Language selection ($_SESSION['lang'])
    ├── Flash messages ($_SESSION['flash_message'])
    └── User preferences
```

### 2️⃣ Translation System
```
translate() Function (functions.php)
    ├── Loads JSON files from /languages/
    ├── Returns translated strings
    └── Falls back to key if translation missing
```

### 3️⃣ Donor Management
```
Registration (register.php)
    ├── Validation
    │   ├── Age verification (18+)
    │   ├── Email format
    │   └── Phone format (10 digits)
    ├── Sanitization
    └── Database Insert

Search & Filter (search.php)
    ├── SQL Query Builder
    ├── Prepared Statements
    └── Result Display
```

### 4️⃣ Privacy System
```
Contact Reveal System
    ├── Masked by default (****1234)
    ├── Click "View Contact"
    ├── AJAX call to API
    ├── Log view in database
    └── Reveal full number
```

### 5️⃣ Eligibility Calculator
```
isDonorEligible() Function
    ├── Check last donation date
    ├── Calculate days since
    ├── Return eligible if >= 90 days
    └── Show waiting period if < 90 days
```

## 📊 Database Relationships

```
┌─────────────────────────────────┐
│         donors                  │
│  (Main donor information)       │
├─────────────────────────────────┤
│ • id (PK)                       │
│ • full_name                     │
│ • email                         │
│ • phone                         │
│ • blood_group                   │
│ • city                          │
│ • is_available                  │
│ • last_donation_date            │
│ • ... (more fields)             │
└──────────┬──────────────────────┘
           │
           │ 1:N relationship
           │
           ▼
┌─────────────────────────────────┐
│      contact_logs               │
│  (Track who viewed contacts)    │
├─────────────────────────────────┤
│ • id (PK)                       │
│ • donor_id (FK) ───────────────┘
│ • viewer_ip
│ • viewer_info
│ • viewed_at
└─────────────────────────────────┘
```

## 🎨 Design System

### Color Palette
```
Primary Colors:
├── Heart Red:  #E0115F  (Main accent)
├── Blood Red:  #DC2626  (Secondary accent)
└── Gradients:  from heart-red to blood-red

Neutrals:
├── Light Gray: #F9FAFB  (Background)
├── Mid Gray:   #6B7280  (Text secondary)
└── Dark Gray:  #1F2937  (Text primary)

Dark Mode:
├── BG Primary:   #111827
├── BG Secondary: #1F2937
└── Text:         #F9FAFB
```

### Typography
```
Font Family: Inter (Google Fonts)
├── Headings: 600-800 weight
├── Body: 400-500 weight
└── Small: 300 weight

Sizes:
├── Hero: 4xl - 6xl (48px - 72px)
├── H1: 3xl - 4xl (36px - 48px)
├── H2: 2xl - 3xl (24px - 36px)
├── Body: base - lg (16px - 18px)
└── Small: sm - xs (14px - 12px)
```

### Spacing & Borders
```
Border Radius:
├── Small: 0.5rem (8px)
├── Medium: 1rem (16px)
├── Large: 1.5rem (24px)
└── XL: 2rem (32px)

Shadows:
├── sm: subtle
├── md: standard
├── lg: elevated
└── xl: dramatic
```

## 🔌 API Reference

### Contact View Logging
```
POST /api/log-contact-view.php

Request:
{
  "donor_id": 123
}

Response (Success):
{
  "success": true,
  "message": "Contact view logged"
}

Response (Error):
{
  "success": false,
  "message": "Invalid donor ID"
}
```

## 🛠️ Key Functions Reference

### Translation
```php
translate('key')              // Get translated string
```

### Validation
```php
sanitize($data)              // Clean user input
isValidEmail($email)         // Validate email format
isValidPhone($phone)         // Validate phone (10 digits)
calculateAge($dob)           // Calculate age from birth date
```

### Donor Management
```php
isDonorEligible($lastDate)   // Check 90-day rule
getDaysUntilEligible($date)  // Days until can donate
getBloodGroupColor($bg)      // Get color for blood group
```

### Privacy & Security
```php
maskPhone($phone)            // Hide phone (****1234)
formatPhoneLink($phone)      // Create tel: link
getWhatsAppLink(...)         // Generate WhatsApp URL
logContactView($conn, $id)   // Log who viewed contact
```

### UI Helpers
```php
setFlashMessage($msg, $type) // Set success/error message
getFlashMessage()            // Get and clear message
redirect($url)               // Safe redirect
```

## 📱 Mobile Optimizations

### Touch Targets
```
Minimum size: 44x44px
├── Buttons: 48px height minimum
├── Form inputs: 48px height
└── Cards: Full width on mobile
```

### Breakpoints (Tailwind)
```
sm:  640px  (Small tablets)
md:  768px  (Tablets)
lg:  1024px (Laptops)
xl:  1280px (Desktops)
2xl: 1536px (Large screens)
```

### Mobile Features
```
✓ One-tap calling (tel: protocol)
✓ WhatsApp integration
✓ Touch-friendly buttons
✓ Sticky navigation
✓ Mobile menu
✓ Swipe-friendly cards
```

## 🚀 Performance Optimizations

### Already Implemented
```
✓ CSS via CDN (Tailwind)
✓ Icons via CDN (Lucide)
✓ Database indexes on:
  - blood_group
  - city
  - is_available
✓ Prepared statements (SQL injection prevention)
✓ Session-based language (no repeated DB queries)
```

### Recommended for Production
```
□ Enable PHP OPcache
□ Minify CSS/JS
□ Compress images
□ Enable GZIP compression
□ Use HTTP/2
□ Add service worker (PWA)
□ Implement lazy loading
```

## 🔒 Security Checklist

```
✓ SQL injection prevention (prepared statements)
✓ XSS protection (htmlspecialchars)
✓ Input sanitization (strip_tags, trim)
✓ Password hashing (for admin - bcrypt)
✓ Session security
✓ Contact view logging
□ CSRF tokens (add for production)
□ Rate limiting (add for production)
□ HTTPS enforcement (configure server)
```

## 📈 Scalability Considerations

### Current Capacity
```
• Handles 1000s of donors efficiently
• Indexed searches are fast
• Session-based, no user accounts needed
```

### Future Enhancements
```
• Add Redis for caching
• Implement queue system for notifications
• Use CDN for static assets
• Add read replicas for database
• Implement API rate limiting
```

## 🎓 Learning Resources

### Technologies Used
- **PHP**: https://www.php.net/docs.php
- **MySQL**: https://dev.mysql.com/doc/
- **Tailwind CSS**: https://tailwindcss.com/docs
- **Lucide Icons**: https://lucide.dev/icons/

### Concepts Demonstrated
- MVC pattern (partial)
- Prepared statements
- Session management
- RESTful API design
- Responsive design
- Multilingual support
- Privacy by design

---

## 🎯 Quick Navigation

| Need to... | Go to... |
|-----------|----------|
| Setup the project | [SETUP.md](SETUP.md) |
| Read full docs | [README.md](README.md) |
| Change database settings | [includes/config.php](includes/config.php) |
| Add new function | [includes/functions.php](includes/functions.php) |
| Modify homepage | [index.php](index.php) |
| Edit donor form | [register.php](register.php) |
| Update search filters | [search.php](search.php) |
| Add language | Create new file in /languages/ |
| Customize colors | Edit Tailwind config in header.php |
| Add animations | [assets/css/custom.css](assets/css/custom.css) |

---

**💡 Tip**: Keep this map handy while developing - it shows how everything connects!
