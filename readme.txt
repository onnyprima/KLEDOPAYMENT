run composer install : composer install

run migrate : php artisan migrate:refresh
run seed : php artisan db:seed --class=PaymentSeeder

jalankan dalam terminal yang berbeda
    run server : php artisan serve

jalankan dalam terminal yang berbeda
    run queue : php artisan queue:work
    run queue delete payment (new console/ terminal) : php artisan queue:work --queue=delete-payment-queue

run test  : ./vendor/bin/phpunit --testdox tests/Feature/Http/Controllers/PaymentControllerTest.php 
