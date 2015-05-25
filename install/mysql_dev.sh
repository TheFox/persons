#!/usr/bin/env bash

SCRIPT_BASEDIR=$(dirname $0)
DATABASE_NAME=persons
CHECK_FILE=.mysql_installed_dev


cd $SCRIPT_BASEDIR

if [[ ! -f $CHECK_FILE ]]; then
	touch $CHECK_FILE
	
	echo "DROP DATABASE \`$DATABASE_NAME\`;" | mysql -uroot -ppassword &> /dev/null
	echo "CREATE DATABASE \`$DATABASE_NAME\` DEFAULT CHARACTER SET = utf8;" | mysql -uroot -ppassword &> /dev/null
fi

exit 0
