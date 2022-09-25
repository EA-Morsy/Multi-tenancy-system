# Multi-tenancy-system
To Run The App>>>>

1-Clone the repository 

2-Install all the dependencies using composer
->composer install

"make sure that you've Created your database "
3-Copy the example env file and make the required configuration changes in the .env file accoarding to your database credintials 

4-Generate a new application key
->php artisan key:generate

5-Generate a new JWT authentication secret key
->php artisan jwt:generate

6-Run the database migrations (Set the database connection in .env before migrating)
->php artisan migrate

7-Run the database seeder and you're done
->php artisan db:seed

8-run -> php artisan migrate:refresh

9-Start the local development server
->php artisan serve

10-use your server endpoint in the Postman Collection to Access the API's 
