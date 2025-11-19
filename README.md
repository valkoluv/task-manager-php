### Overview

This repository contains a simple, PHP-based Task Manager application. It uses a custom structure with MVC-like components (Controllers, Models, Views) and is designed to manage user tasks, allowing for creation, listing, editing, and deletion of tasks, including assignment to other users.

### Features

  * **User Management:** Register, Login, Logout, and Change Password functionality.
  * **Task Management:**
      * Create new tasks with a title, description, status, and optional assignment to another user.
      * List tasks, showing the title, status, and assigned user.
      * Edit existing tasks.
      * Delete tasks.
  * **Task Status:** Tasks utilize an `enum` (`TaskStatus`) for their status (e.g., Pending, In Progress, Completed).
  * **Database Interaction:** Uses PDO for database connectivity (managed by `App\Database`).

### Technology Stack

  * **Language:** PHP
  * **Database:** Requires a database supported by PDO (e.g., MySQL, PostgreSQL).
  * **Dependencies:**
      * `vlucas/phpdotenv`: For environment variable management (although `.env` is ignored by `.gitignore`, it's intended for configuration).
      * `ext-pdo`: PHP extension for database access.
  * **Development Tools:**
      * `vimeo/psalm`: For static analysis (in `require-dev`).

### Repository Structure

The application follows a structured approach with clear separation of concerns:

| Directory/File | Description |
| :--- | :--- |
| `public/` | The web root, containing `index.php` and `router.php` for handling requests. |
| `src/Controllers/` | Contains the application logic for handling user actions (`UserController`). |
| `src/Models/` | Contains data structures and database interaction logic (`User.php`, `Task.php`). |
| `src/Enums/` | Contains PHP `enum` definitions, currently for `TaskStatus`. |
| `src/Services/` | Contains business logic, such as `TaskManager.php`, which encapsulates task operations for a specific user. |
| `src/Database.php` | Handles the PDO database connection. |
| `views/` | Contains all the presentation files (HTML/PHP templates) for various pages and task operations. |
| `composer.json` | Defines PHP dependencies and PSR-4 autoloading configuration. |

### Installation and Setup

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/valkoluv/task-manager-php
    cd task-manager-php
    ```
2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```
3.  **Database Configuration:**
      * Create a database (e.g., `task_manager`).
      * Create a `.env` file in the project root to store database credentials (as indicated by the `vlucas/phpdotenv` dependency). The exact variables will depend on the configuration in `src/Database.php` (not shown, but typically includes DB host, name, user, and password).
      * You will need to run the necessary SQL scripts to create the `users` and `tasks` tables (scripts not provided in the file summary).
4.  **Web Server Configuration:**
      * Configure your web server (Apache/Nginx) to point the document root to the **`public/`** directory.
      * Ensure the server is configured to handle the URL rewriting defined in `public/.htaccess` (which routes all requests to `router.php`).

### Key Files and Classes

  * **`src/Models/User.php`:** Handles user data, saving, and lookup by ID or email.
  * **`src/Models/Task.php`:** Manages task data, creation, update, deletion, and fetching tasks for a user.
  * **`src/Enums/TaskStatus.php`:** Defines the possible statuses for a task.
  * **`src/Services/TaskManager.php`:** Provides an interface for user-specific task operations.
  * **`src/Controllers/UserController.php`:** Contains the logic for user registration, login, logout, and password change.
  * **`views/task/list.php`:** The main view for displaying a user's tasks.
