# Voyago Project

## Introduction
Hi! 👋 We are thrilled to introduce **Voyago**, a web application designed to enhance your travel experiences. With Voyago, users can document and share their journeys, manage travel details, and interact with fellow travelers through comments and likes. This project showcases efficient data handling and dynamic web development using PHP and AJAX.

---

## About the Project

### What it Does
- **User Management**: Secure authentication and profile management.
- **Travel Documentation**: Add, edit, and delete travel records with detailed information.
- **Place Management**: Associate places with travel entries, complete with descriptions and photos.
- **Interactive Features**: Engage with travels by leaving comments and liking places.
- **Dynamic Filtering**: Filter records dynamically.

---

## Features

### 🌐 User-Friendly Functionality
- Seamless travel and place documentation.

### 📍 Dynamic Content
- Real-time updates for filtering and deleting entries.

### 🗺️ Travel Exploration
- Explore detailed travel and place information.

---

## Technologies Used
- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **AJAX**: For dynamic interactions

---

## Installation

### Prerequisites
- A local server environment such as XAMPP, WAMP, or MAMP.
- MySQL database.
- PHP 7.4 or later.

### Steps
1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/voyago.git
   ```
2. Move the project folder to your server’s root directory (e.g., `htdocs` for XAMPP).
3. Import the database:
   - Open `phpMyAdmin`.
   - Create a new database (e.g., `voyago_db`).
   - Import the provided SQL file (`voyago_db.sql`) into the newly created database.
4. Update database connection settings in `config.php`:
   ```php
   $db_host = 'localhost';
   $db_user = 'root';
   $db_pass = ''; // Update if you have a password
   $db_name = 'voyago_db';
   ```
5. Start your server and navigate to `http://localhost/voyago` in your browser.

---

## Usage
1. **Sign Up / Log In**: Access your account to start documenting your travels.
2. **Add Travel**: Use the ‘Add Travel’ option to create a new travel entry.
3. **View Details**: Explore places associated with your travels and leave comments.
4. **Manage Interactions**: Like places or delete comments as needed.

---

## Project Structure
```
Voyago/
|-- assets/         # CSS, JavaScript, and images
|-- database/       # SQL files
|-- includes/       # Reusable PHP components
|-- pages/          # Core application pages
|-- ajax/           # AJAX handlers
|-- config.php      # Database configuration
|-- index.php       # Application entry point
```

---

## Team Members
- Leen Alotaibi
- Ghaida Altamimi
- Aeshah Almukhlifi 
- Luluh Alyahya

---

## Conclusion
Thank you for exploring **Voyago**! We hope this project inspires you to document your travels and share your adventures with the world. 😊



