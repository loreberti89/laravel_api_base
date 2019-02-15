git clone https://loreberti89@bitbucket.org/loreberti89/bodyshop_rest.git

composer install

rename .env.example in .env

php artisan key:generate

change configuration in .env for new db

php artisan migrate

php artisan passport:keys

php artisan passport:client --password

naming web_app get Id printed and put in .env

PASSPORT_CLIENT_ID_WEB_APP = {id}

php artisan db:seed
