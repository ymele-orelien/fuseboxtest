<!-- the steps to make the application work -->
# composer install
install dependences
# database name "fusebox"
creates a new database with the name fusebox

# php artisan migrate


# php artisan db:seed 
add two users
-email:gordon@gothampd.com
-password:237Cameroun

-email:test@gmail.com;
-password:123test

# php artisan passport:client --personal
create client token

# php artisan serve

<!-- api -->

# http://127.0.0.1:8000/api/login
log in to the application


<!-- the procedures below require authentication -->
# http://127.0.0.1:8000/api/sendPanic
send a panic signal

# http://127.0.0.1:8000/api/cancelPanic/{id}
cancel panic signal

# http://127.0.0.1:8000/api/getPanic
show panic signal history

<!-- api -->

