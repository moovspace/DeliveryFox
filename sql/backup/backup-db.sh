#!/bin/bash

# Allow execute file
# chmod +x db-backup.sh
# Run script
# ./db-backup.sh

# Cron stars:
# Minutes Hours Days Month Day
# Set cron josb (backup each day 23:01)
# sudo crontab -e
# 1 23 * * * /path/to/db-backup.sh

# Database credentials
user="app"
password="toor"
host="localhost"
db_name="app"

# Backup directory
backup_path="backups"

# Curr date
date=$(date +"%d-%b-%Y")

# create dit
mkdir -p $backup_path;

# Set default file permissions
umask 177

# Dump database into SQL file
mysqldump --user=$user --password=$password --host=$host $db_name > $backup_path/$db_name-$date.sql

# Delete files older than 30 days
find $backup_path/* -mtime +30 -exec rm {} \;