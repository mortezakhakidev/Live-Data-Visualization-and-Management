# D3.js Live Data Visualization with PHP REST API & MySQL

## Overview
This project is a **full‑stack web application** that visualizes live data from a MySQL database using the powerful **D3.js** library. It features a clean, interactive frontend built with **HTML, CSS, and JavaScript**, and a robust backend that provides a **RESTful API** using **PHP**. The backend supports **GET, POST, PUT, and DELETE** requests, allowing full CRUD operations on the data. Real‑time updates are handled via **Ajax** and **jQuery**, making the dashboard responsive and dynamic.

---

## Technologies Used

| Layer | Technology |
| :--- | :--- |
| **Frontend** | HTML5, CSS3, JavaScript, D3.js, jQuery, Ajax |
| **Backend** | PHP (with cURL for API calls) |
| **Database** | MySQL (via PDO and MySQLi) |
| **API** | RESTful (custom endpoints in `api.php`) |
| **Dependency Management** | Composer (see `composer.json` / `composer.lock`) |

---

## Project Structure

```text
project_root/
└── d3/ # Root folder for the project (localhost)
    ├── assets/
    │   ├── css/ # Custom and third‑party styles (MDB, main.css)
    │   └── js/ # JavaScript files (jQuery, MDB, D3.js, main.js)
    ├── vendor/ # Composer dependencies (Faker, MySQLi wrapper)
    ├── .htaccess # Apache URL rewriting rules
    ├── api.php # REST API entry point (handles all HTTP methods)
    ├── composer.json # Composer configuration
    ├── composer.lock # Locked dependency versions
    ├── create_records.php # Script to generate 100 fake records using Faker
    ├── database.php # PDO database connection class
    ├── db.php # MySQLi database connection (used by create_records.php)
    ├── index.php # Main entry point (frontend dashboard)
    └── post.php # Post class handling API logic (CRUD operations)
```

> **Important:** The project must be placed inside a folder named `d3` on your local web server (e.g., `http://localhost/d3/`). The API base URL is `http://localhost/d3/api/`.

---

## Database Setup

1. **Create a MySQL database** named `d3`:
   ```sql
   CREATE DATABASE d3;
   ```

2. **Create the `data` table** with the following schema:
   ```sql
   CREATE TABLE data (
       id INT AUTO_INCREMENT PRIMARY KEY,
       first_name VARCHAR(255),
       last_name VARCHAR(255),
       city VARCHAR(255),
       nummeric_one INT,
       date DATE,
       nummeric_two INT
   );
   ```

3. **Configure the database connection:**
   - `database.php` – uses PDO (used by the API):
     ```php
     $host = 'localhost';
     $port = '3306';
     $db   = 'd3';
     $user = 'root';
     $pass = '';
     ```
   - `db.php` – uses MySQLi (used by `create_records.php`):
     ```php
     $db = new MysqliDb('localhost', 'root', '', 'd3');
     ```
   Update the credentials (host, username, password) to match your environment.

4. **(Optional) Generate fake data** – run `create_records.php` via the command line or browser to populate the table with 100 sample records using the `Faker` library:
   ```bash
   php create_records.php
   ```
   This will insert 100 random records into the `data` table.

---

## Backend API (`api.php`)

The API is built using a simple `Post` class (defined in `post.php`) that handles all HTTP requests. The entry point is `api.php`, which routes requests based on the HTTP method and optional `id` parameter.

### Supported Endpoints

| Method | Endpoint | Description |
| :--- | :--- | :--- |
| **GET** | `/api/` | Fetch all records |
| **GET** | `/api/five` | Fetch the last 5 records (used for live updates) |
| **GET** | `/api/{id}` | Fetch a single record by ID |
| **POST** | `/api/` | Create a new record (expects JSON body) |
| **PUT** | `/api/{id}` | Update an existing record (expects JSON body) |
| **DELETE** | `/api/{id}` | Delete a record by ID |

Example JSON payload for POST / PUT:
```json
{
    "first_name": "John",
    "last_name": "Doe",
    "city": "New York",
    "nummeric_one": 1234,
    "date": "2024-01-15",
    "nummeric_two": 567890
}
```
All responses are returned in **JSON** format.

---

## Frontend Dashboard (`index.php`)

The dashboard is built with a responsive layout using **MDB (Material Design for Bootstrap)** and provides:

- **All Records Table** – Fetched via `cURL` from `GET /api/` and displayed in a sortable table.
- **PUT (Update) Form** – Updates an existing record by ID using a `PUT` request.
- **POST (Create) Form** – Adds a new record via `POST` request.
- **DELETE Form** – Deletes a record by ID using a `DELETE` request.
- **Create Dummy Records** – A button that triggers an Ajax request to generate 100 fake records (implemented in `main.js`).
- **Live Data Preview** – Displays the last 5 records using `jQuery Ajax` with auto‑refresh every 5 seconds.
- **D3.js Visualization** – Renders a bar chart (or other chart types) of the data, also auto‑refreshing every 5 seconds via Ajax calls to `/api/five`.

All JavaScript logic (Ajax requests, D3.js rendering, auto‑refresh) is handled in `assets/js/main.js`.

---

## Installation & Running the Project

1. **Clone or download** the project files into your web server's document root (e.g., `htdocs` for XAMPP) under the folder `d3`.
2. **Install dependencies** using Composer (if not already present):
   ```bash
   cd d3
   composer install
   ```
   This will pull in:
   - `fzaninotto/faker` – for generating fake data.
   - `thingengineer/mysqli-database-class` – a lightweight MySQLi wrapper (used by `create_records.php`).
3. **Set up the database** as described above (create database, table, and update credentials).
4. **Start your web server** (Apache + MySQL) and open in your browser:
   ```text
   http://localhost/d3/
   ```
5. **Interact** – Add, edit, delete records and watch the table, live preview, and D3.js chart update in real time.

---

## Dependencies (from `composer.lock`)

- `fzaninotto/faker` (v1.5.0) – PHP library for generating fake data (used in `create_records.php`).
- `thingengineer/mysqli-database-class` (dev-master) – A convenient MySQLi wrapper with prepared statements.

These are managed by Composer and installed in the `vendor/` folder.

---

## Customisation

- **Charts** – Modify the D3.js code inside `assets/js/main.js` to change chart types, colours, or axes.
- **API Endpoints** – Extend `post.php` or `api.php` to include additional business logic or validation.
- **Styling** – Edit CSS files in `assets/css/` or update MDB classes in `index.php`.

---

## License

This project is open‑source and available under the MIT License. Feel free to use it for learning or as a foundation for your own applications.

---

## Author

Developed by Morteza Khaki as a demonstration of full‑stack web development with PHP, MySQL, and D3.js.
