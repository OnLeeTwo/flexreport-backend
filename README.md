# FlexReport API

FlexReport is a Laravel-based API system for dynamically generating and exporting reports (PDF/Excel) from any database table with custom filters, field selection, and user-saved templates.

## 🚀 Features

-Dynamic column and table discovery from PostgreSQL
-Filter support for: -`text`: dropdown with distinct values -`int` / `date`: range-based filtering -`boolean`: predefined options
-Custom column selection for reports
-Auth-protected access using JWT
-User-specific report templates

---

## 🛠️ Tech Stack

-**Laravel 12** -**PostgreSQL** -**JWT Auth**

---

## 🔧 Installation

### 1. Clone the repo

````bash
git clone https://github.com/yourname/flexreport-backend.git
cd flexreport-backend
```txt

### 2. Install dependencies

```bash
composer install
```txt

### 3. Set environment variables

Copy and update `.env`:

```bash
cp .env.example .env
````

Edit the `.env` file to match your PostgreSQL credentials and app settings:

```env
DB_CONNECTION=pgsql
DB_HOST=your-db-host
DB_PORT=5432
DB_DATABASE=your-db
DB_USERNAME=your-user
DB_PASSWORD=your-password
```

### 4. Generate app key

```bash
php artisan key:generate
```

### 5. Run migrations

```bash
php artisan migrate
```

---

## 🔐 Authentication

This API uses **JWT-based login**. After registering a user or seeding test data, login to retrieve a token:

### Example login request

```http
POST /api/login
{
  "email": "admin@example.com",
  "password": "secret"
}
```

Response:

```json
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGci..."
}
```

Include this token in your frontend as a Bearer token:

```json
Authorization: Bearer YOUR_TOKEN
```

---

## 📘 API Endpoints

### 📊 Reports

| Method | Endpoint                                      | Description                      |
| ------ | --------------------------------------------- | -------------------------------- |
| GET    | `/api/reports/tables`                         | Get available tables             |
| GET    | `/api/reports/columns/{table}`                | Get columns and data types       |
| GET    | `/api/reports/column-values/{table}/{column}` | Get dropdown values for a column |
| POST   | `/api/reports/generate`                       | Generate a filtered report       |

### 🧩 Templates

| Method | Endpoint              | Description                  |
| ------ | --------------------- | ---------------------------- |
| GET    | `/api/templates`      | Get current user's templates |
| POST   | `/api/templates`      | Save a new template          |
| GET    | `/api/templates/{id}` | Get a single template detail |

---

## 🧪 Seeding Users

To quickly test the app, you can manually seed a test user:

```php
php artisan tinker

User::create([
  'name' => 'Admin',
  'email' => 'admin@example.com',
  'password' => bcrypt('secret')
])
```

## 📁 Project Structure

```txt
app/
  Http/
    Controllers/
      ReportController.php
      TemplateController.php
    Models/
      ReportTemplate.php
      User.php
  Services/
    ReportBuilder.php
routes/
  api.php
```

---

## 🐳 Deployment (optional)

Docker + Google Cloud Run supported. A basic Dockerfile setup is available for containerization.

---

## 📝 License

This project is open-source and available under the [MIT license](LICENSE).

---

## 👨‍💻 Author

Developed by [Owent Ovandy](https://github.com/OnLeeTwo)
