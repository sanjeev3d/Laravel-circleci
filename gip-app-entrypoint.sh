#!/bin/sh
cd /var/myApp/
php artisan key:generate
php artisan migrate
/usr/sbin/apache2ctl -DFOREGROUND
