#!/bin/bash
#while true; do
#    begin=`date +%s`
#    php72 /var/www/htdocs/gw/proxy/console.php sms
#    end=`date +%s`
#    if [ $(($end - $begin)) -lt 5 ]; then
#        sleep $(($begin + 5 - $end))
#    fi
#done

 #!/bin/sh

 #

 SNOOZE=5

 COMMAND="/usr/bin/php72 /var/www/htdocs/gw/proxy/console.php sms"

 LOG=/var/www/htdocs/gw/logs/sms_log.log

 echo `date` "starting..." >> ${LOG} 2>&1

 while true

 do

  ${COMMAND} >> ${LOG} 2>&1

  echo `date` "sleeping..." >> ${LOG} 2>&1

  sleep ${SNOOZE}

 done
