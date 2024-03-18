# Laravel_MongoDB_Crud_Example
In this Example, I will publish code related to Laravel and MongoDB.
Firstly we have to notice the requirements:
1)  My OS at the moment is 8.1 x64, PHP 8.1, Xampp so I have to install MongoDB server 4.0 
2)  install Mongodb extension in the php.ini file. Then test by **PHP --ini** file in Vscode terminal. 
3) As my Laravel version is 9, run the below command in your laravel folder project:
     **composer require jenssegers/mongodb**
   if everything is correct so the package will install with all of the dependencies. Please pay attention to that the final version of the extension when I wrote here was 1.13 for Windows and laravel 9. Laravel 10 has some issues with the new extension.
4) Restart your computer
5) After restarting go to the model and **"use Jenssegers\Mongodb\Eloquent\Model;"**
6) Inside model class  **protected $connection = 'YourConnectionName'; protected $collection = 'YourCollectionName';**
7) in Env file
      **MONGO_DB_CONNECTION=mongodb
      MONGO_DB_HOST=127.0.0.1
      MONGO_DB_PORT=27017
      MONGO_DB_DATABASE=propertyDB
      MONGO_DB_USERNAME=
      MONGO_DB_PASSWORD=**
8) In config/database:
    **'default' => env('DB_CONNECTION', 'mongodb'),
     'mongodb' => [
            'driver'   => 'mongodb',
            'host'     => env('MONGO_DB_HOST', 'localhost'),
            'port'     => env('MONGO_DB_PORT', 27017),
            'database' => env('MONGO_DB_DATABASE'),
            'username' => env('MONGO_DB_USERNAME'),
            'password' => env('MONGO_DB_PASSWORD'),
            'options'  => []
        ],**
9) At this time everything is great, please drink a tee and restart your pc again. I beleive that restart will solve any inssue. just lough loudly.....
