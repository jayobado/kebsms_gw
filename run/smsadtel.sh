#!/bin/bash
while true; do
    begin=`date +%s`
    php72 /var/www/htdocs/gw/proxy/console.php smsadtel
    end=`date +%s`
    if [ $(($end - $begin)) -lt 5 ]; then
        sleep $(($begin + 5 - $end))
    fi
done
