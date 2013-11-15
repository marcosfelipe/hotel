#!/bin/bash

log_path='/var/www/todo/logs/application.log'
app_path='/todo/'
site_root='/todo'

function clear_tmp_files() {
   echo "Remove files:"
   find . -name '*.sw*' -print0
   find . -name '*.sw*' -exec rm {} \;
   find . -name '.DS_Store' -print0
   find . -name '.DS_Store' -exec rm {} \;
}

function change_htaccess_paths() {
    echo "change log path"
    sed 's/php_value error_log.*/php_value error_log '"${log_path//\//\/}"'/g' /tmp/todo/.htaccess > /tmp/todo/.htaccess_changed
    mv /tmp/todo/.htaccess_changed /tmp/todo/.htaccess
    echo "change RewriteBase path"
    sed 's/RewriteBase.*/RewriteBase '"${app_path//\//\/}"'/g' /tmp/todo/.htaccess > /tmp/todo/.htaccess_changed
    mv /tmp/todo/.htaccess_changed /tmp/todo/.htaccess
}

function copy_files() {
   echo "copying files"
   rm -rf /tmp/todo
   mkdir /tmp/todo
   cp -r . /tmp/todo/
}

function change_application_paths() {
   echo "change application path"
   sed "s/define('SITE_ROOT'.*);/define('SITE_ROOT', '${site_root//\//\/}');/g" /tmp/todo/config/application.php > /tmp/todo/config/application.php.changed
   mv /tmp/todo/config/application.php.changed /tmp/todo/config/application.php
}

function send_to_server() {
  rsync -r -a -v -e "ssh -l root" /tmp/todo/ 200.134.18.125:/var/www/todo/
  ssh root@200.134.18.125 'chmod -R 766 /var/www/todo/logs'
}

# clear temporary files
if [ ! -z $1 ] && [ $1 == "clear" ]; then
  clear_tmp_files
else
  if [ ! -z $1 ] && [ $1 == "server" ]; then
    echo "clear tmp files.."
    clear_tmp_files
    copy_files
    change_htaccess_paths
    change_application_paths
    send_to_server
  fi
fi

