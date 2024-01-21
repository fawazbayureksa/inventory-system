## Inventory System

### Features
1. Product CRUD

### Prerequisites
- PHP version 8.1 or higher
- Web Server (Xampp)
- Composer for managing dependencies
- Database server (MySQL or similar) 

### Setup

**Clone Repository**

If using Xampp

```
cd C:\xampp\htdocs
```
then
```
git clone https://github.com/fawazbayureksa/inventory-system.git
```
then 
```
cd inventory-system
```
### Installation

**Composer Installation**

```
composer install
```

```
php artisan key:generate
```

```
php artisan storage:link
```

next, then run 
```
php artisan migrate --seed
```

```
php artisan server
```

then you can use this account below to login 

email: superadmin@gmail.com
password: password

### Setup Environment Variables
 Create & edit the .env file to include your database configuration

to create jwt secret key .env
```
php artisan jwt:secret
```
 ### Dependencies
 - laravel/ui
 - twbs/bootstrap
 - tymon/jwt-auth

## Thank You