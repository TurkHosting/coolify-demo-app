# Laravel Blog Demo Application

A Laravel 12 application with Livewire and Flux UI featuring a blog system with posts and categories management.

## Features

- Admin panel for managing blog posts and categories
- Many-to-many relationship between posts and categories
- Rich text content support
- Draft and published post statuses
- Public blog frontend with category filtering
- User authentication (admin only, registration disabled)

## Tech Stack

- **Laravel 12** - PHP framework
- **Livewire 3** - Full-stack framework for Laravel
- **Flux UI (Free)** - Component library for Livewire
- **Tailwind CSS v4** - Utility-first CSS framework
- **MariaDB** - Database
- **Fortify** - Authentication backend

## Local Development

### Prerequisites

- PHP 8.4+
- Composer
- Node.js & NPM
- MariaDB

### Installation

1. Clone the repository
```bash
git clone <repository-url>
cd coolify-demo-app
```

2. Install dependencies
```bash
composer install
npm install
```

3. Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Update `.env` with your database credentials:
```env
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=coolify_demo_app
DB_USERNAME=root
DB_PASSWORD=
```

5. Run migrations and seed database
```bash
php artisan migrate --seed
```

6. Build frontend assets
```bash
npm run build
# or for development
npm run dev
```

7. Start the development server
```bash
php artisan serve
```

### Default Admin Credentials

- **Email**: admin@example.com
- **Password**: password

## Deployment on Coolify

This application is configured to deploy on Coolify using Nixpacks.

### Step 1: Connect Your Repository

1. Log in to your Coolify instance
2. Go to **Projects** > **New Resource** > **Application**
3. Select **Public Repository** or connect your Git provider
4. Enter your repository URL
5. Select the branch to deploy (e.g., `main`)

### Step 2: Configure Build Settings

1. **Build Pack**: Select `nixpacks`
2. **Port Exposes**: Set to `80`
3. The `nixpacks.toml` file in the repository root will be automatically detected

### Step 3: Configure Environment Variables

Add the following environment variables in Coolify:

#### Required Variables

```env
# Application
APP_NAME="Laravel Blog Demo"
APP_ENV=production
APP_KEY=base64:your-app-key-here
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database
DB_CONNECTION=mariadb
DB_HOST=your-database-host
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

#### Optional Variables

```env
# Mail (if needed)
MAIL_MAILER=smtp
MAIL_HOST=your-mail-host
MAIL_PORT=587
MAIL_USERNAME=your-mail-username
MAIL_PASSWORD=your-mail-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your-domain.com
MAIL_FROM_NAME="${APP_NAME}"

# Redis (optional, for better performance)
REDIS_HOST=your-redis-host
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### Step 4: Database Setup

#### Option A: Use Coolify's Database Service

1. In your project, click **New Resource** > **Database**
2. Select **MariaDB**
3. Configure and deploy the database
4. Copy the connection details to your environment variables

#### Option B: External Database

Use an external MariaDB/MySQL database and configure the connection details in environment variables.

### Step 5: Deploy

1. Click **Deploy** in Coolify
2. Wait for the build to complete
3. Once deployed, run migrations:
   - Go to your application in Coolify
   - Click **Terminal** or use the **Commands** section
   - Run: `php artisan migrate --force --seed`

### Step 6: Access Your Application

Visit your configured domain or the Coolify-provided URL. Log in with the default admin credentials:

- **Email**: admin@example.com
- **Password**: password

**Important**: Change the default password immediately after first login!

## Post-Deployment

### Running Migrations

To run migrations after deployment:

```bash
php artisan migrate --force
```

### Seeding Data

To seed the database (only needed on first deployment):

```bash
php artisan migrate:fresh --seed --force
```

### Clearing Cache

If you need to clear application cache:

```bash
php artisan optimize:clear
```

## Nixpacks Configuration

The `nixpacks.toml` file includes:

- **Nginx**: Web server configuration
- **PHP-FPM**: PHP process manager
- **Supervisor**: Process management
- **Queue Workers**: 2 Laravel queue worker processes (configurable)
- **Upload Limits**: 30MB max file size, 35MB max post size

### Customizing Queue Workers

To adjust the number of queue worker processes, edit `nixpacks.toml`:

```toml
[staticAssets]
"worker-laravel.conf" = '''
...
numprocs=2  # Change this number
...
'''
```

## Application Structure

### Routes

- `/` - Homepage with hero and recent posts
- `/blog` - Blog index with all published posts
- `/blog/{slug}` - Individual post view
- `/category/{slug}` - Posts filtered by category
- `/admin/posts` - Admin: Manage posts
- `/admin/categories` - Admin: Manage categories
- `/admin/posts/create` - Admin: Create new post
- `/admin/posts/{post}/edit` - Admin: Edit post

### Admin Panel

Access the admin panel at `/admin/posts` after logging in. Features include:

- Create, edit, and delete blog posts
- Manage categories
- Set publish dates or save as drafts
- Assign multiple categories to posts
- Search and filter functionality

## Troubleshooting

### Build Failures

- Check that all environment variables are correctly set
- Verify database connection details
- Ensure `APP_KEY` is generated and set

### Database Connection Issues

- Verify database credentials in environment variables
- Check that the database service is running
- Ensure network connectivity between app and database

### Asset Loading Issues

- Run `npm run build` locally and commit the compiled assets
- Check that `APP_URL` matches your domain

### Permission Issues

If you encounter storage permission errors:

```bash
php artisan storage:link
```

## Support

For issues related to:
- **Coolify**: Visit [Coolify Documentation](https://coolify.io/docs)
- **Laravel**: Visit [Laravel Documentation](https://laravel.com/docs)
- **This Application**: Open an issue in the repository

## License

This is a demo application. Modify and use as needed for your projects.
