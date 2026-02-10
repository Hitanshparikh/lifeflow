# 🚀 LifeFlow Setup Instructions

## Quick Start Guide

### 1️⃣ Database Setup (IMPORTANT - Do This First!)

1. **Open phpMyAdmin**
   - Navigate to: `http://localhost/phpmyadmin`
   - Login with your MySQL credentials (default: root / no password)

2. **Import Database**
   - Click "New" in the left sidebar to create a database
   - Name it: `lifeflow`
   - Click "Create"
   - Select the `lifeflow` database
   - Click "Import" tab
   - Click "Choose File" and select `db.sql`
   - Scroll down and click "Go"

### 2️⃣ Verify Installation

Open your browser and go to:
```
http://localhost/lifeflow
```

You should see the LifeFlow homepage with:
- Hero section with blood donor statistics
- Quick search form
- Blood group distribution cards
- Premium UI with glassmorphism effects

### 3️⃣ Test the Features

#### Register a New Donor
1. Click "Register as Donor" button
2. Fill in all required fields:
   - Full Name *
   - Phone Number * (10 digits)
   - Blood Group *
   - Gender *
   - Date of Birth * (must be 18+)
   - City *
3. Optionally add:
   - Email
   - Last Donation Date
   - Area/Address
4. Click "Submit Registration"

#### Search for Donors
1. Go to "Search Donors" page
2. Use filters:
   - Select Blood Group (e.g., O+)
   - Select City (e.g., Ahmedabad)
   - Check "Show Available Only" for active donors
3. Click "Apply Filters" or filters will auto-apply

#### View Contact Information
1. On a donor card, click "View Contact"
2. Phone number will be revealed
3. You can then:
   - Click "Call Now" for instant phone call
   - Click "WhatsApp" to send a pre-filled message

#### Change Language
1. Click the language dropdown (🌐 EN) in header
2. Select:
   - 🇬🇧 English
   - 🇮🇳 ગુજરાતી (Gujarati)
   - 🇮🇳 हिन्दी (Hindi)
3. The entire interface will translate instantly

#### Toggle Dark Mode
1. Click the sun/moon icon in the header
2. The theme will switch between light and dark
3. Your preference is saved in browser

### 4️⃣ Sample Data

The database comes with 8 sample donors:
- **Blood Groups**: A+, O+, B+, AB+, O-, A-, B-, AB-
- **Cities**: Ahmedabad, Surat, Vadodara, Rajkot, Gandhinagar
- **Languages**: English, Gujarati, Hindi

### 5️⃣ Configuration (Optional)

Only edit if needed:

**Database Settings** - `includes/config.php`
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');  // Your MySQL password if any
define('DB_NAME', 'lifeflow');
```

### 6️⃣ Troubleshooting

**Problem: Blank page or errors**
- Solution: Check if Apache and MySQL are running in XAMPP
- Verify database is imported correctly
- Check `includes/config.php` for correct credentials

**Problem: Icons not showing**
- Solution: Ensure internet connection (icons load from CDN)
- Or download Lucide icons locally

**Problem: Filters not working**
- Solution: Make sure JavaScript is enabled in browser
- Check browser console for errors (F12)

**Problem: Registration fails**
- Solution: Check all required fields are filled
- Phone must be 10 digits
- Age must be 18+
- Blood group must be selected

### 7️⃣ Mobile Testing

Test on mobile devices:
1. Find your computer's IP address:
   - Windows: Open CMD → type `ipconfig`
   - Look for IPv4 Address (e.g., 192.168.1.100)

2. On your mobile device (connected to same WiFi):
   ```
   http://192.168.1.100/lifeflow
   ```

3. Test mobile features:
   - Click "Call Now" - should open phone dialer
   - Click "WhatsApp" - should open WhatsApp app
   - Test responsive design on different screen sizes

### 8️⃣ Admin Access (Optional)

Sample admin credentials (for future use):
- **Username**: admin
- **Password**: admin123
- **Email**: admin@lifeflow.com

*Note: Admin panel not included in current version*

### 9️⃣ Next Steps

**For Development:**
- Customize colors in Tailwind config
- Add more languages in `/languages/` folder
- Extend database schema if needed
- Add more features from TODO list in README

**For Production:**
- Change default admin password
- Enable HTTPS
- Update `SITE_URL` in config.php
- Optimize images
- Enable PHP OPcache
- Set up regular database backups

### 🎯 Key URLs

| Page | URL | Description |
|------|-----|-------------|
| Homepage | `/index.php` | Landing page with stats |
| Search | `/search.php` | Find blood donors |
| Register | `/register.php` | Register as donor |
| API | `/api/log-contact-view.php` | Contact logging |

### 📱 Features to Test

- [ ] Register a new donor
- [ ] Search by blood group
- [ ] Search by city
- [ ] View contact information
- [ ] Call a donor (mobile)
- [ ] WhatsApp a donor (mobile)
- [ ] Switch languages (EN/GU/HI)
- [ ] Toggle dark mode
- [ ] Mobile responsive design
- [ ] Filter by availability
- [ ] Check eligibility calculator

### 💡 Tips

1. **Best viewed in**: Chrome, Firefox, Safari, Edge (latest versions)
2. **Mobile first**: Test on actual devices for best experience
3. **Performance**: Clear browser cache if styles don't update
4. **Languages**: Add more by creating new JSON files in `/languages/`
5. **Customization**: All colors can be changed in Tailwind config

---

## 🆘 Need Help?

If you encounter any issues:

1. Check XAMPP logs: `xampp/apache/logs/error.log`
2. Check browser console: Press F12 → Console tab
3. Verify database connection in phpMyAdmin
4. Ensure all files are in correct location
5. Check file permissions (read/write)

## ✅ Success Checklist

- [x] XAMPP installed and running
- [x] Database `lifeflow` created
- [x] `db.sql` imported successfully
- [x] Homepage loads at `localhost/lifeflow`
- [x] Sample donors visible
- [x] Registration form works
- [x] Search filters work
- [x] Languages switch correctly
- [x] Dark mode toggles
- [x] Mobile responsive

---

**🎉 Congratulations! Your LifeFlow system is ready to save lives!**

*Remember: Every drop counts. Every donor matters.* ❤️
