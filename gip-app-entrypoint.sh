#!/bin/sh
cd /var/myApp/
php artisan migrate
/usr/sbin/apache2ctl -DFOREGROUND
