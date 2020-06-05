# Project Based Learning (PJBL)
Aplikasi web pembelajaran berbasis proyek


## Installation
#### 1. Clone or download
Clone or download all files from this repository into a directory, then run these commands.
```
composer install
composer dumpautoload -o
```

#### 2. Configure .env files
Duplicate `.env.example` and rename it to `.env`. Then configure database settings inside `.env` file.
After configuring `.env` file, run these commands.
```
php artisan key:generate
php artisan config:clear
php artisan config:cache
```

#### 3. Migrating database
This project comes with its own database migration. You can migrate the database by running this command.
```
php artisan migrate
```

### 4. Installation completed
You can run this application by running this command
```
php artisan server
```