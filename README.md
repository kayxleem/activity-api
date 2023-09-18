### Activity API 


# Requirements
  - PHP 8.1 and above
  - MySQL
  - Composer

## Installation

Clone the Repository on target machine:


    git clone https://github.com/kayxleem/activity-api.git 
    cd activity-api

Set up your .env

    DB_DATABASE=laravel (Replace with yours)
    DB_USERNAME=root (Replace with yours)
    DB_PASSWORD= (Replace with yours)

Install dependencies (if you have `composer` locally):

    composer install

    or 

    composer update

generate your laravel key

    php artisan key:generate

Run database migrations:

    php artisan migrate

## optional 

Run the Seeders

There are 4 seeders to get started

UserSeeder
AdminSeeder
ActivitySeeder
UserActivitySeeder

## Usage

The API should be available at http://localhost:3000/api (You can change the APP_PORT in .env file) if you are using artisan serve.




