# faq

### 📋 Requirements
- PHP 7.4+
- MySQL
- Apache/Nginx

### 🔧 Setup

1. Clone the repo:
   ```bash
   git clone https://github.com/samkarupz/faq.git
   cd faq

2. Database Creation
    mysql -u root -p < db.sql

3. Start the PHP server

4. Open the webpage http://localhost:8080/faq/


Project Structure:
    index.php -- PDO Connection, API to handle likes and frontend

Project Discription:
    FAQ is a single-page web application that lists all FAQs and their answers along with a like count.
    Each item includes a like button, and the like count increases automatically when a user clicks it.
