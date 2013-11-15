<?php
/*
 * Função autoload é utilizada para carregar automaticamente as classes quando elas forem utilizadas
 */
function __autoload($class_name)
{
    # from camel case to snack case
    $class_name = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $class_name));
    $class_name = str_replace('\\', '/', $class_name); # fixed namespace

    $files = array();
    $files[] = APP_ROOT_FOLDER . '/core/routes/' . $class_name . '.php';
    $files[] = APP_ROOT_FOLDER . '/core/controllers/' . $class_name . '.php';
    $files[] = APP_ROOT_FOLDER . '/core/models/' . $class_name . '.php';
    $files[] = APP_ROOT_FOLDER . '/core/lib/' . $class_name . '.php';

    $files[] = APP_ROOT_FOLDER . '/app/controllers/' . $class_name . '.php';
    $files[] = APP_ROOT_FOLDER . '/app/models/' . $class_name . '.php';
    $files[] = APP_ROOT_FOLDER . '/app/models/admin/' . $class_name . '.php';
    $files[] = APP_ROOT_FOLDER . '/lib/' . $class_name . '.php';

    foreach ($files as $file) {
        if (file_exists($file) == true) {
            return require_once $file;
        }
    }

    if (preg_match('/.+exception$/', $class_name)) {
        return require 'core/exceptions/application.exceptions.php';
    }

    return false;
}

?>
