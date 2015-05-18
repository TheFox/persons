#!/usr/bin/env bash

SCRIPT_BASEDIR=$(dirname $0)


cd $SCRIPT_BASEDIR

if [[ ! -f .mysql_installed ]]; then
	touch .mysql_installed
	echo 'CREATE DATABASE persons DEFAULT CHARACTER SET = utf8;' | mysql -uroot -ppassword &> /dev/null
fi

exit 0
