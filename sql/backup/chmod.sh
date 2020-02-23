#!/bin/bash

# declare variable
STR_CHMOD="Zmieniam uprawnienia"
DATE=$(date +"%d-%b-%Y")

# show variable
echo $STR_CHMOD

# Change permissions
chmod -R 775 .
echo "[OK]";
