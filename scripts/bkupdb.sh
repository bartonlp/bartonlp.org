#!/bin/bash
# Backup the database before starting.
cd /var/www
dir=html/other
bkupdate=`date +%B-%d-%y`
filename="BACKUP.$bkupdate.sql"

mysqldump --defaults-file=html/scripts/ps --user=barton --no-data barton 2>/dev/null > $dir/bartonlp.schema
mysqldump --defaults-file=html/scripts/ps --user=barton --add-drop-table barton 2>/dev/null >$dir/$filename
gzip $dir/$filename

filename="WORDPRESS.$bkupdate.sql"

mysqldump --defaults-file=html/scripts/ps --user=barton --no-data wordpress 2>/dev/null > $dir/WORDPRESS.schema
mysqldump --defaults-file=html/scripts/ps --user=barton --add-drop-table wordpress 2>/dev/null >$dir/$filename
gzip $dir/$filename

# add remove all old files
find $dir -ctime +30 -exec rm '{}' \;
#echo "bkupdb.sh for bartonlp.com Done"

