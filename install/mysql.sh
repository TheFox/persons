#!/usr/bin/env bash

echo 'CREATE DATABASE persons DEFAULT CHARACTER SET = utf8;' | mysql -uroot -ppassword &> /dev/null
exit 0
