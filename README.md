## Laravel Crud
Laravel Crud is a test package that creates a Test model along with controller, migration, routes, request and views.

## Installation
First require the package in your fresh laravel project.
```
composer require shakilnadim/laravel-crud
```

Then run the below command to install the package in your project.
```
php artisan laravel-crud:install
```

This command will move all the controllers, models, migrations, requests, routes and views to their particular directories. Furthermore, this will also install `tailwind css` in your project. Finally, it will run `php artisan migrate` command to create table in the database.

Then, you can start the project with
```
php artisan serve
```

Then open the browser and go to `/tests` route on your website, and you will see crud functionalities for tests table in that page.