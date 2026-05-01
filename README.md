# Teacher Evaluation System

A comprehensive web-based evaluation system for managing teacher assessments by students. This system allows institutions to conduct structured evaluations of faculty members through an organized, secure platform.

## 📋 Features

- **User Authentication**: Secure login system with session management
- **Student Dashboard**: Students can access and submit evaluations for their teachers
- **Admin Dashboard**: Administrators can manage courses, faculties, sections, and evaluation settings
- **Role-Based Access**: Different interfaces for students, admins, and faculty members
- **Course & Faculty Management**: Add, update, and delete courses, faculties, and sections
- **Evaluation Questions**: Customizable evaluation questions with different question types
- **Data Security**: Input validation, CSRF protection, and secure headers
- **Rate Limiting**: Protection against brute force attacks
- **File Upload**: Secure file upload functionality for documents
- **Database Support**: MySQL database with PDO connection management
- **Responsive UI**: Bootstrap-based admin template (SB Admin 2)

## 🏗️ Project Structure

```
EVALUATIONSYSTEM/
├── assets/                 # Project assets and classes
│   ├── classes/           # PHP utility classes
│   │   ├── FileUpload.php
│   │   ├── InputValidator.php
│   │   ├── RateLimiter.php
│   │   └── SessionManager.php
│   ├── connection/        # Database connections
│   │   ├── connection.php
│   │   └── pdo_connection.php
│   ├── helpers/           # Helper functions
│   │   ├── csrf.php
│   │   └── secure_headers.php
│   └── img/              # Images and assets
├── code/                  # Core functionality scripts
│   ├── add_*.php         # Add resources (courses, faculty, etc.)
│   ├── delete_*.php      # Delete resources
│   ├── search_*.php      # Search functionality
│   ├── update_*.php      # Update operations
│   └── submit_evaluation.php
├── start/                 # Main application pages
│   ├── admindashboard.php
│   ├── adminautorize.php
│   ├── admincourse.php
│   ├── adminfaculty.php
│   ├── adminstudents.php
│   ├── adminquestion.php
│   ├── studentdashboard.php
│   ├── studentevaluation.php
│   ├── studentprofile.php
│   ├── css/              # Stylesheets
│   ├── js/               # JavaScript files
│   ├── scss/             # SCSS source files
│   └── vendor/           # Third-party libraries
├── style/                # Additional stylesheets
├── uploads/              # User uploaded files
├── animate.css/          # Animation library
├── index.php             # Main entry point
├── process_login.php     # Login processing
├── logout.php            # Logout functionality
└── evaluation_db.sql     # Database schema

```

## 🛠️ Technologies Used

- **Backend**: PHP 7+
- **Database**: MySQL/MariaDB
- **Frontend**: HTML5, CSS3, JavaScript
- **Framework**: Bootstrap 4 (SB Admin 2 template)
- **Libraries**: 
  - jQuery
  - Chart.js (for analytics)
  - DataTables (for data display)
  - Font Awesome (icons)

## 📦 Installation

### Prerequisites
- Apache/XAMPP with PHP installed
- MySQL/MariaDB database
- Git

### Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/johnterrencegarcia/EVALUATIONSYSTEM.git
   cd EVALUATIONSYSTEM
   ```

2. **Set up the database**
   ```bash
   # Import the database schema
   mysql -u root -p < evaluation_db\ \(2\).sql
   ```

3. **Configure database connection**
   - Edit `assets/connection/pdo_connection.php`
   - Update your database credentials (host, username, password, database name)

4. **Place in web root**
   ```bash
   # Copy to your XAMPP htdocs folder
   cp -r EVALUATIONSYSTEM /path/to/xampp/htdocs/
   ```

5. **Start Apache and MySQL**
   - Start XAMPP control panel
   - Enable Apache and MySQL services

6. **Access the application**
   - Open browser and navigate to: `http://localhost/EVALUATIONSYSTEM/`

## 🔐 Security Features

- **Input Validation**: All user inputs are validated using `InputValidator` class
- **CSRF Protection**: Tokens are implemented via `csrf.php` helper
- **Session Management**: Secure sessions handled by `SessionManager` class
- **Rate Limiting**: Protection against brute force attacks via `RateLimiter` class
- **Secure Headers**: Security headers implemented in `secure_headers.php`
- **File Upload Security**: Secure file handling with `FileUpload` class
- **Password Security**: Passwords should be hashed using PHP's password_hash()

## 👥 User Roles

### Student
- View assigned teachers
- Submit evaluations for courses
- View evaluation status
- Update profile information

### Admin
- Manage courses and sections
- Manage faculties and staff
- Manage student accounts
- Create and manage evaluation questions
- Monitor evaluation progress
- Generate reports and analytics

## 📊 Key Modules

- **Authentication**: User login and session management
- **Course Management**: Add/update/delete courses
- **Faculty Management**: Manage teacher information
- **Student Management**: Manage student accounts and enrollments
- **Evaluation Management**: Create questions, manage evaluations
- **Reporting**: Analytics and evaluation statistics

## 📝 Database

The system uses a MySQL database with the following main tables:
- Users (students, admins, faculty)
- Courses
- Faculties
- Sections
- Evaluations
- Questions
- Evaluation Responses

See `evaluation_db (2).sql` for complete schema.

## 🚀 Usage

1. **Login**: Use your credentials to access the system
2. **Student**: Navigate to evaluations and submit your assessments
3. **Admin**: Use the dashboard to manage system resources

## 📄 License

This project is provided as-is for educational purposes.

## 👨‍💻 Developer

John Terrence Garcia

## 📞 Support

For issues or questions, please open an issue on the GitHub repository.

---

**Repository**: https://github.com/johnterrencegarcia/EVALUATIONSYSTEM
