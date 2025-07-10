# Shoe Inventory Management System

A simple PHP-based web application for managing a shoe inventory with user authentication and role-based access control.

## Features

- **User Authentication**: Login/signup system with password hashing
- **Role-Based Access**: Admin and viewer roles with different permissions
- **CRUD Operations**: Create, Read, Update, Delete shoes (admin only)
- **Image Upload**: Support for shoe images
- **Responsive Design**: Modern, mobile-friendly interface
- **Security**: SQL injection prevention, XSS protection

## Requirements

- XAMPP (Apache + MySQL + PHP)
- PHP 7.0 or higher
- MySQL 5.6 or higher

## Installation

1. **Clone/Download** the project to your XAMPP htdocs folder:
   ```
   C:\xampp\htdocs\project_221510006\
   ```

2. **Start XAMPP**:
   - Start Apache and MySQL services
   - Open phpMyAdmin: http://localhost/phpmyadmin

3. **Create Database**:
   - Create a new database named `project_221510006`
   - Or import the `project_221510006.sql` file

4. **Setup Database** (Recommended):
   - Visit: http://localhost/project_221510006/setup_database.php
   - This will create all tables and sample data automatically

5. **Configure Database** (if needed):
   - Edit `config.php` if your database credentials are different
   - Default: localhost, root, no password

## Usage

### Default Login Credentials

After running the setup script, you can use these accounts:

**Admin Account:**
- Username: `admin`
- Password: `admin123`
- Can: Add, edit, delete shoes, view all shoes

**Viewer Account:**
- Username: `viewer`
- Password: `viewer123`
- Can: View shoes only

### How to Use

1. **Login**: Visit http://localhost/project_221510006/login.php
2. **Browse Shoes**: View all shoes in a card layout
3. **View Details**: Click "View Details" to see full shoe information
4. **Admin Functions** (admin only):
   - Add new shoes with images
   - Edit existing shoes
   - Delete shoes
   - Manage inventory

## File Structure

```
project_221510006/
├── index.php              # Main inventory page
├── login.php              # Login form
├── signup.php             # Registration form
├── logout.php             # Logout script
├── add.php                # Add new shoe (admin)
├── edit.php               # Edit shoe (admin)
├── update.php             # Update shoe processing
├── delete.php             # Delete shoe (admin)
├── detail.php             # View shoe details
├── config.php             # Database configuration
├── setup_database.php     # Database setup script
├── style.css              # CSS styles
├── project_221510006.sql  # Database schema
├── images/                # Uploaded shoe images
└── README.md              # This file
```

## Database Schema

### Users Table
- `id` (Primary Key)
- `username` (Unique)
- `password_hash` (Hashed password)
- `role` (admin/viewer)

### Shoes Table
- `id` (Primary Key)
- `brand` (Shoe brand)
- `model` (Shoe model)
- `color` (Shoe color)
- `size` (Shoe size)
- `price` (Price in Rupiah)
- `image_filename` (Uploaded image filename)

## Security Features

- **Password Hashing**: Uses PHP's `password_hash()` function
- **SQL Injection Prevention**: Prepared statements throughout
- **XSS Protection**: `htmlspecialchars()` for output
- **Session Management**: Secure session handling
- **Role-Based Access**: Admin-only functions protected
- **File Upload Security**: Image type validation

## Troubleshooting

### Common Issues

1. **Database Connection Error**:
   - Check if MySQL is running in XAMPP
   - Verify database credentials in `config.php`
   - Ensure database `project_221510006` exists

2. **Image Upload Not Working**:
   - Check if `images/` directory exists and is writable
   - Verify file permissions (should be 755 or 777)

3. **Page Not Found**:
   - Ensure Apache is running in XAMPP
   - Check file paths and URLs

4. **Login Issues**:
   - Run `setup_database.php` to create users
   - Use default credentials: admin/admin123 or viewer/viewer123

### Getting Help

If you encounter issues:
1. Check XAMPP error logs
2. Verify all files are in the correct location
3. Ensure database is properly set up
4. Check file permissions

## Customization

### Adding New Features
- Modify the database schema in `project_221510006.sql`
- Update PHP files to handle new fields
- Add corresponding CSS styles

### Styling Changes
- Edit `style.css` for visual modifications
- The design uses CSS Grid and Flexbox for responsiveness

### Database Changes
- Update the setup script (`setup_database.php`) for schema changes
- Modify SQL queries in PHP files accordingly

## License

This project is for educational purposes. Feel free to modify and use as needed. 