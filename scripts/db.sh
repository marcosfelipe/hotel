#!/bin/bash
db_user='postgres'
export PGPASSWORD='postgres'

if [ ! -z $1 ] && [ $1 == "reload" ]; then
  psql --user $db_user -e -f db/database.sql
fi
