#!/bin/ksh

file="/var/www/htdocs/data_processing/sensor3.conf"
file_cmp="/var/www/htdocs/data_processing/sensor3_cmp.conf"
ip="192.168.56.103"
port="18132"

while true
do

	diff_check=$(diff "$file" "$file_cmp" | wc | awk '{print $1}')

	if [[ "$diff_check" -ne 0 ]]; then
		sbd -k "pa!!nd123a" -w1 "$ip" "$port" < "$file"
		rm "$file_cmp"
		cp "$file" "$file_cmp"

	fi

done
