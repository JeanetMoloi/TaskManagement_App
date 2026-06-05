# TaskFlow — Task Management App
> ICE362S | T2 Laravel Project | 2026

A full-featured Task Management web application built with **Laravel 12**, featuring role-based access control, task categories, priorities, deadlines, and a beautiful dark UI.

---

## 👥 Group Members

| Name | Initials | Role |
|---|---|---|
| Pertunia Sifunda-221692568| P | Controllers, Routes, Middleware, Validation |
| Thandeka Malande-222857005 | T | Models, Database, Eloquent ORM |
| Jeanet Moloi-230186904| J | Blade Views, Frontend, Authentication |

> **Naming Convention:** All Controllers, Models, and Policies are suffixed with **PTJ** as per project guidelines.

---

## 🛠️ Technology Stack

| Technology | Version |
|---|---|
| PHP | 8.2+ |
| Laravel | 12.x |
| Authentication | Laravel Breeze |
| Frontend | Blade Templates + Tailwind CSS |
| Database | SQLite (local) / MySQL (production) |
| Version Control | Git + GitHub |

---

## 🚀 Setup & Installation

### Prerequisites
Make sure you have the following installed:
- PHP 8.2+
- Composer
- Node.js & NPM
- Git

### Step 1 — Clone the repository
```bash
git clone https://github.com/JeanetMoloi/TaskManagement_App.git
cd TaskManagement_App
```

### Step 2 — Install PHP dependencies
```bash
composer install
```
> If you get a `doctrine/lexer` error, run `composer update doctrine/lexer` first.

### Step 3 — Set up environment file
```bash
cp .env.example .env        # Linux/Mac
copy .env.example .env      # Windows
```

### Step 4 — Generate application key
```bash
php artisan key:generate
```

### Step 5 — Run database migrations
```bash
php artisan migrate
```

### Step 6 — Seed the database with test data
```bash
php artisan db:seed
```

### Step 7 — Install frontend dependencies
```bash
npm install
npm run build
```

### Step 8 — Start the development server
```bash
php -S localhost:8000 -t public
```

### Step 9 — Open in browser
```
http://localhost:8000
```

---

## 🔐 Test Accounts

| Role | Email | Password |
|---|---|---|
| Admin | admin@example.com | password |
| Team Member | thandeka@example.com | password |
| Guest | guest@example.com | password |

> You can also register a new account at `/register`

---

## 📱 Application Features

### Task Management
- ✅ Create, edit, delete tasks
- ✅ Assign tasks to specific users
- ✅ Set task priority (Low, Medium, High)
- ✅ Update task status (Pending, In Progress, Completed)
- ✅ Set deadlines with overdue warnings
- ✅ Filter tasks by status and priority

### Categories
- ✅ Admin can create and manage task categories
- ✅ Tasks can be assigned to categories
- ✅ Color-coded category badges

### User Roles
| Role | Permissions |
|---|---|
| **Admin** | Full access — manage all tasks, users, and categories |
| **Team Member** | Create and manage their own tasks, view assigned tasks |
| **Guest** | View only — cannot create or edit tasks |

### Dashboard
- ✅ Role-specific dashboards
- ✅ Task statistics (Total, Pending, In Progress, Completed)
- ✅ Recent tasks overview
- ✅ Overdue task warnings

---

## 🗄️ Database Schema

### Users Table
| Column | Type | Description |
|---|---|---|
| id | integer | Primary key |
| name | string | User's full name |
| email | string | Unique email address |
| role | enum | admin, team_member, guest |
| password | string | Hashed password |

### Tasks Table
| Column | Type | Description |
|---|---|---|
| id | integer | Primary key |
| title | string | Task title |
| description | text | Task description |
| status | enum | pending, in_progress, completed |
| priority | enum | low, medium, high |
| deadline | datetime | Task deadline |
| user_id | foreignId | Owner of the task |
| assigned_to | foreignId | User assigned to task |
| created_by | foreignId | User who created task |
| category_id | foreignId | Task category |

### Categories Table
| Column | Type | Description |
|---|---|---|
| id | integer | Primary key |
| name | string | Category name (unique) |
| description | string | Category description |
| color | string | Hex color code |

---

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── TaskControllerPTJ.php       ← Task CRUD
│   │   ├── CategoryControllerPTJ.php   ← Category management
│   │   └── DashboardControllerPTJ.php  ← Role dashboards
│   ├── Middleware/
│   │   ├── RoleMiddlewarePTJ.php       ← Role-based access
│   │   └── LogActivityMiddlewarePTJ.php← Activity logging
│   └── Requests/
│       ├── StoreTaskRequestPTJ.php     ← Create validation
│       └── UpdateTaskRequestPTJ.php    ← Update validation
├── Models/
│   ├── Task.php                        ← Task model
│   ├── Category.php                    ← Category model
│   └── User.php                        ← User model
└── Policies/
    └── TaskPolicyPTJ.php               ← Authorization policy
routes/
└── web.php                             ← All application routes
resources/views/
├── layouts/
│   └── app.blade.php                   ← Main layout
├── tasks/
│   ├── index.blade.php                 ← Task list
│   ├── create.blade.php                ← Create form
│   ├── edit.blade.php                  ← Edit form
│   └── show.blade.php                  ← Task detail
└── dashboard.blade.php                 ← Dashboard
```

---

## 🔒 Security Features

- ✅ CSRF protection on all forms (`@csrf`)
- ✅ XSS prevention using Blade's `{{ }}` escaping
- ✅ SQL injection prevention via Eloquent ORM
- ✅ Role-based middleware on all sensitive routes
- ✅ Password hashing using Laravel's Hash facade
- ✅ Authentication via Laravel Breeze

---

## 🎨 UI Template

The frontend UI was custom designed using:
- **Blade Templating Engine** for dynamic views
- **Tailwind CSS** for styling
- **Google Fonts** — Syne (headings) and DM Sans (body)
- Dark theme with purple accent colors

---

## 📋 Git Workflow

- Each team member worked on their own **forked repository**
- Changes were submitted via **Pull Requests** to the main repository
- Pull requests were reviewed and merged by the repository owner
- Commit messages follow the format: `feat:`, `fix:`, `docs:`

---

## ⚙️ Environment Variables

Key variables in `.env`:

```env
APP_NAME=TaskFlow
APP_ENV=local
DB_CONNECTION=sqlite
MAIL_MAILER=smtp
MAIL_FROM_ADDRESS="noreply@taskflow.com"
MAIL_FROM_NAME="TaskFlow"
```

---

## 👩‍💻 Development Challenges

- Configuring role-based middleware in Laravel 12 (constructor middleware was removed)
- Managing database migrations across team members with different setups
- Integrating the custom dark UI theme with Blade components
- Resolving Git merge conflicts when combining team members' work

---

*ICE360S | Web Frameworks 2 | 2026*

