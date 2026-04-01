## Project Title

Grasuu Farm Task View Management API

## Project Description

Grasuu FarmFlow is a task management API designed to manage daily farm activities at Grasuu Farm. The system organizes tasks across different farm sections including cows, chicken, fruits, and vegetables.

It allows users to:

- Create departments (categories)
- Create tasks
- View tasks
- Update task status
- Delete completed tasks
- Generate daily reports of farm activities

Each task is categorized, prioritized, and scheduled using a due date and due time.

## Technologies Used

- PHP 8+
- Laravel
- Blade templates
- Vanilla JavaScript (Fetch API)
- MySQL
- HTML/CSS + Bootstrap

## Database Information

- Database engine: MySQL
- Database name: `db_gftvs`

### Categories Table (Departments)

This project uses `departments` as categories.

Example structure:

```sql
CREATE TABLE departments (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);
```

### Tasks Table

> Note: the current implementation stores the category reference as `department_id` (equivalent to category).

```sql
CREATE TABLE tasks (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  department_id BIGINT UNSIGNED NOT NULL,
  due_date DATE NOT NULL,
  due_time TIME NOT NULL,
  priority ENUM('Low', 'Medium', 'High') NOT NULL,
  status ENUM('Pending', 'In-Progress', 'Done') NOT NULL DEFAULT 'Pending',
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  CONSTRAINT fk_tasks_department FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE
);
```

## How To Run Locally

1. Open terminal and go to the project folder:
   ```bash
   cd grasuuffarm-tv
   ```
2. Install dependencies:
   ```bash
   composer install
   ```
3. Configure DB connection in `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_gftvs
   DB_USERNAME=root
   DB_PASSWORD=
   ```
4. Generate application key:
   ```bash
   php artisan key:generate
   ```
5. Run database migration:
   ```bash
   php artisan migrate
   ```
6. Seed default data:
   ```bash
   php artisan db:seed
   ```
7. Start Laravel server:
   ```bash
   php artisan serve
   ```
   The application will run at: `http://127.0.0.1:8000`

## API Example

### Request Body

```json
{
  "title": "Morning Milking",
  "category_id": 1,
  "due_date": "2026-04-01",
  "due_time": "06:00",
  "priority": "high"
}
```

### Response Body

```json
{
  "id": 1,
  "title": "Morning Milking",
  "priority": "high",
  "status": "pending"
}
```

## Deployment on Railway

1. Deploy on Railway: sign in, then create a new project.
2. Add a MySQL database: click Add Plugin, select MySQL.
3. Configure environment variables:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=containers-us-west-xx.railway.app
   DB_PORT=3306
   DB_DATABASE=railway
   DB_USERNAME=root
   DB_PASSWORD=
   ```
4. Run migrations on Railway:
   ```bash
   php artisan migrate --seed
   ```
5. Configure Laravel build/start commands:
   - Build command:
     ```bash
     composer install
     ```
   - Start command:
     ```bash
     php artisan serve --host=0.0.0.0 --port=$PORT
     ```
