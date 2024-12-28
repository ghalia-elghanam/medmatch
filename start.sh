#!/usr/bin/env bash

sleep 60

php artisan key:generate
php artisan optimize:clear
php artisan migrate
php artisan migrate:fresh --seed

php artisan serve --host=0.0.0.0 --port=8080
