# How to Run Wartek PHP Application

## Method 1: Using XAMPP (Recommended for Windows)

1. **Install XAMPP** - Download from https://www.apachefriends.org/

2. **Start Apache** from XAMPP Control Panel

3. **Place project files in htdocs:**
   - Copy the `paksukas5` folder to `C:\xampp\htdocs\`

4. **Access in browser:**
   - Admin Login: `http://localhost/paksukas5/admin_login.php`
   - Admin Register: `http://localhost/paksukas5/admin_register.php`
   - User Login: `http://localhost/paksukas5/login.php`
   - User Register: `http://localhost/paksukas5/register.php`

## Method 2: Using PHP Built-in Server

Run this command in the project folder:
```cmd
php -S localhost:8000
```

Then access in browser:
- `http://localhost:8000/admin_login.php`
- `http://localhost:8000/admin_register.php`

## URL Quick Reference

| Page | URL |
|------|-----|
| Admin Login | http://localhost/paksukas5/admin_login.php |
| Admin Register | http://localhost/paksukas5/admin_register.php |
| User Login | http://localhost/paksukas5/login.php |
| User Register | http://localhost/paksukas5/register.php |
| Home | http://localhost/paksukas5/home.php |

**Note:** The previous SQL error has been fixed. The `role` column will be automatically added to the database when you access any page.

