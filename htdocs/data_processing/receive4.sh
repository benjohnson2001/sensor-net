#!/bin/ksh

file="/var/www/htdocs/data_processing/val4.dat"
file_tmp="/var/www/htdocs/data_processing/tmp4.dat"
port="14443"

while true
do

    . /var/www/htdocs/data_processing/sensor4.conf

    if [[ $STATE -eq 1 ]]; then 
	sbd -k "pa!!nd123a" -l -p "$port" > "$file_tmp"
	cat "$file_tmp" > "$file"
	rm "$file_tmp"
    fi

done
