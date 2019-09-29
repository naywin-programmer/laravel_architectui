### Used Versions
- Laravel v6.0.3
- Laravel Passport v7.4.1
- Laravel Ui v1.0.1
- Laravel Permission v3.0
- Laravel Datatable v9.6.0
- Laravel JsValidation v2.5.0
- Laravel Mix Purgecss v4.1.0

### To Use
- create .env file
- create database
- composer install
- php artisan key:generate
- npm install
- npm run dev
- php artisan migrate:refresh
- php artisan passport:install
- php artisan db:seed

### Custom Admin Route File
- for admin routes, you can write admin routes in this file
```
routes/admin_web.php
```
- if you want more seperated route files, you can edit in **Laravel build-in RouteServiceProvider.php** file
```php
// for web
protected function mapWebRoutes()
{
    Route::middleware('web')
         ->namespace($this->namespace)
         ->group(function () {
            require base_path('routes/web.php');
            require base_path('routes/admin_web.php');
        });
}

// for api
protected function mapApiRoutes()
{
    Route::prefix('api')
         ->middleware('api')
         ->namespace($this->namespace)
         ->group(base_path('routes/api.php'));
}
```

### Admin Dashboard Url
##### Default
```
http://127.0.0.1:8000/admin
```
##### Custom Prefix Name For Admin Dashboard (edit in **.env** or **config/app.php**)
- set **PREFIX_ADMIN_URL** in **.env**
```
PREFIX_ADMIN_URL=/backend
```
- now Admin Dashboard Url is
```
http://127.0.0.1:8000/backend/admin
```

### Admin Account (in SuperAdminSeeder.php file)
```
email: admin@laravelarchitectui.com
password: password
```

### To create default guards, roles, permissions for Laravel Permission by using seeder
- config/custom_guards.php
- config/custom_roles.php
- config/custom_admin_permissions.php
- config/custom_user_permissions.php

### To create Permission and Role from Terminal (Laravel Permission)
https://docs.spatie.be/laravel-permission/v3/basic-usage/artisan/

### Screenshots
![Admin Login Screen](https://user-images.githubusercontent.com/21998283/65568567-5f593300-df80-11e9-9342-eb8c94502f53.png)
---
![Admin Home Screen](https://user-images.githubusercontent.com/21998283/65568601-7b5cd480-df80-11e9-99be-794628c2dcf2.png)
---
![User Screen](https://user-images.githubusercontent.com/21998283/65568787-0c33b000-df81-11e9-83de-45f853ffbd42.png)
---
![Admin User Screen](https://user-images.githubusercontent.com/21998283/65568815-1ce42600-df81-11e9-858d-ba16844fce12.png)
---
![User Role Screen](https://user-images.githubusercontent.com/21998283/65568840-308f8c80-df81-11e9-8609-15a5e1ec201d.png)
---
![Admin User Role Screen](https://user-images.githubusercontent.com/21998283/65568862-3d13e500-df81-11e9-8f3d-ea23f38221f0.png)
---
![Permission Screen](https://user-images.githubusercontent.com/21998283/65568870-44d38980-df81-11e9-9b7e-4d7d0c6acb7c.png)
---
