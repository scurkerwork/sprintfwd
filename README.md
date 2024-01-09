
# Charging Stations

## Run Locally

Go to the project directory

`cd sprintfwd`

Install Composer Dependencies

`composer install`

Create a copy of your  .env file

`mv .env.example .env`

Set the application key

`php artisan key:generate`

In the .env file, add database information to allow Laravel to connect to the database

In the  .env file fill in the  `DB_HOST`,  `DB_PORT`,  `DB_DATABASE`,  `DB_USERNAME`,  and  `DB_PASSWORD`  options to match the credentials of the database you just created.  This will allow us to run migrations and seed the database in the next step.

Migrate the database and with seeders

`php artisan migrate:fresh --seed`

Run tests:

`php artisan test`

Start Laravel server

`php artisan serve`


 
