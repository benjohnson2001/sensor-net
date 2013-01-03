#!/bin/ksh

nohup ksh /var/www/htdocs/data_processing/transmit1.sh 2> /dev/null &
nohup ksh /var/www/htdocs/data_processing/receive1.sh 2> /dev/null &
nohup ksh /var/www/htdocs/data_processing/transmit2.sh 2> /dev/null &
nohup ksh /var/www/htdocs/data_processing/receive2.sh 2> /dev/null &
nohup ksh /var/www/htdocs/data_processing/transmit3.sh 2> /dev/null &
nohup ksh /var/www/htdocs/data_processing/receive3.sh 2> /dev/null &
nohup ksh /var/www/htdocs/data_processing/transmit4.sh 2> /dev/null &
nohup ksh /var/www/htdocs/data_processing/receive4.sh 2> /dev/null &


