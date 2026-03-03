# Wartek - Warung Teknologi

A PHP-based web application for managing technology products with user authentication, admin panel, and community chat.

## Features

- User registration and login
- Admin panel for managing products
- Product catalog
- Community chat
- Export products to Excel

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache recommended)

## Installation and Setup

### Using XAMPP (Windows)

1. **Download and Install XAMPP**
   - Download XAMPP from https://www.apachefriends.org/
   - Install XAMPP in the default directory (C:\xampp)

2. **Place the Application Files**
   - Copy all the PHP files to `C:\xampp\htdocs\wartek\`
   - Or create a new folder in htdocs and place the files there

3. **Start XAMPP**
   - Open XAMPP Control Panel
   - Start Apache and MySQL modules

4. **Access the Application**
   - Open your browser
   - Go to `http://localhost/wartek/` (or the folder name you used)
   - The application will automatically create the database and tables on first run

### Using WAMP (Windows)

1. **Download and Install WAMP**
   - Download WAMP from https://www.wampserver.com/
   - Install WAMP

2. **Place the Application Files**
   - Copy all files to `C:\wamp\www\wartek\`

3. **Start WAMP**
   - Start WAMP server
   - Make sure Apache and MySQL are running

4. **Access the Application**
   - Go to `http://localhost/wartek/`

### Using Built-in PHP Server (Development Only)

1. **Navigate to the project directory**
   ```bash
   cd path/to/your/project
   ```

2. **Start PHP server**
   ```bash
   php -S localhost:8000
   ```

3. **Access the Application**
   - Go to `http://localhost:8000`
   - Note: Database functionality may not work properly with built-in server

## Database Configuration

The application automatically creates the database and tables. The default configuration in `config.php`:

- Host: localhost
- Database: wartek
- Username: root
- Password: (empty)

If you need to change these settings, edit `config.php`.

## Usage

1. **First Time Setup**
   - Access the application URL
   - Register as a new user or admin

2. **Admin Access**
   - Register as admin via `admin_register.php`
   - Or login as admin via `admin_login.php`

3. **Features**
   - View products
   - Chat in community
   - Admin can manage products and users

## Default Admin Account

To create an admin account, you can run this PHP command:

```php
require_once 'config.php';
$hashed_password = password_hash('admin123', PASSWORD_DEFAULT);
$stmt = $pdo->prepare('INSERT INTO admins (username, password) VALUES (?, ?)');
$stmt->execute(['admin', $hashed_password]);
```

Or use the `create_admin.php` file.

## File Structure

- `index.php` - Landing page
- `login.php` - User login
- `register.php` - User registration
- `home.php` - User dashboard
- `products.php` - Product catalog
- `komunitas.php` - Community chat
- `admin_login.php` - Admin login
- `admin_register.php` - Admin registration
- `admin_products.php` - Admin product management
- `admin_users.php` - Admin user management
- `config.php` - Database configuration
- `export_products.php` - Export products to CSV

## Troubleshooting

1. **Database Connection Error**
   - Make sure MySQL is running
   - Check database credentials in `config.php`

2. **Permission Errors**
   - Make sure the web server has write permissions to the directory

3. **PHP Extensions**
   - Make sure PDO MySQL extension is enabled

## Security Notes

- Change default database password in production
- Use HTTPS in production
- Regularly update PHP and MySQL versions
- Implement proper input validation and sanitization

## License

This project is for educational purposes.
