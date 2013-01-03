#!/bin/ksh

file="/var/www/htdocs/data_processing/val1.dat"
file_tmp="/var/www/htdocs/data_processing/tmp1.dat"
port="26313"

while true
do

    . /var/www/htdocs/data_processing/sensor1.conf

    if [[ $STATE -eq 1 ]]; then 
	sbd -k "pa!!nd123a" -l -p "$port" > "$file_tmp"
	cat "$file_tmp" > "$file"
	rm "$file_tmp"
    fi

done
