# Laravel My-System (Users, Groups, Permissions)

## 📌 Overview
This project is a **Role-Based Access Control (RBAC)** system built with **Laravel 12**.  
It provides APIs for managing **Users, Groups, and Permissions** with authentication using **Laravel Sanctum**.

---

## 🚀 Features
- 🔐 **Authentication** (Login / Register) using Sanctum Tokens.  
- 👥 Manage **Users** (CRUD).  
- 🏷️ Manage **Groups** (CRUD + assign permissions).  
- ✅ Manage **Permissions** (CRUD).  
- 🛡️ Middleware-based access control using permissions.  
- 🧪 Tested with **Postman** (APIs secured with `Authorization: Bearer <token>`).  

---

## 🛠️ Requirements
- PHP >= 8.2 
- Composer  
- MySQL 
- Laravel 12  
- Node.js & NPM (optional for frontend)  

---

## ⚙️ Installation
1. Clone the repo:
   ```bash
   git clone https://github.com/MohamedBahaa2000/my-system.git
   cd laravel-my-system

- composer install
- cp .env.example .env
- php artisan migrate --seed
- php artisan serve

## Default Users 
 - Admin User
Email: admin@example.com
Password: 123456
Role: Full Access (all permissions)

 - Normal User
Email: user@example.com
Password: 123456
Role: No permissions (403 on all protected routes).

 - Limited User
Email: limited@example.com
Password: 123456

## API Endpoints
##- Auth
POST /api/login → Login & get token
POST /api/register → Register new user
POST /api/logout → Logout (invalidate token)

##- Users
GET /api/users → List users (requires view_users)
POST /api/users → Create user (requires create_users)
GET /api/users/{id} → View single user (requires view_users)
PUT /api/users/{id} → Update user (requires edit_users)
DELETE /api/users/{id} → Delete user (requires delete_users)

##- Groups
GET /api/groups → List groups (requires view_groups)
POST /api/groups → Create group (requires create_groups)
PUT /api/groups/{id} → Update group (requires edit_groups)
DELETE /api/groups/{id} → Delete group (requires delete_groups)
POST /api/groups/{id}/permissions → Assign permissions to group (requires assign_permissions)

##- Permissions
GET /api/permissions → List permissions (requires view_permissions)
POST /api/permissions → Create permission (requires create_permissions)
PUT /api/permissions/{id} → Update permission (requires edit_permissions)
DELETE /api/permissions/{id} → Delete permission (requires delete_permissions)
