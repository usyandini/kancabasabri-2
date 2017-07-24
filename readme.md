# Kancasabri PT Asabri

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Kancasabri is a Laravel-based web application for do journaling transcation and dropping data.

## Installation

* Run `git clone https://github.com/ilyashrn/kancabasabri kancabasabri` in Terminal/CMD
* Move to project directory with `cd kancabasabri`
* Run `composer install` to install dependencies
* Run `php artisan key:generate` to generate key for .env file
* Create database named `dbcabang` for application database and make sure `AX_DEV` is available on the server
* Run `php artisan migrate` to generate tables on `dbcabang` database
* Run `php artisan db:seed` to populate the tables
* Run `php artisan vendor:publish` to publish filemanager
* Run `php artisan serve` to run the application on `http://localhost:8000/`

## Users and Passwords

For login purpose, it's used e-mail and its password for login-form fields. Here are some available users : 
* ilyashabiburrahman@gmail.com - rahasia
* admin@gmail.com - rahasia

More users and passwords are available on `seeder` file `(database/seeds/UserSeeder.php)`.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
"# kancabasabri" 
"# kancabasabri" 
"# kancabasabri-2" 
