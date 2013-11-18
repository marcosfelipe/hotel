<?php
/* Inclui arquivos css
 * Se o caminho começar com / deve ser considerado a partir da pasta ASSETS_FOLDER
 * caso contrário a partir de ASSETS_FORLDER/css/
 */
function stylesheet_include_tag()
{
    $params = func_get_args();

    foreach ($params as $param) {
        $path = ASSETS_FOLDER;
        $path .= (substr($param, 0, 1) === '/') ? $param : '/css/' . $param;
        echo "<link href='{$path}' rel='stylesheet' type='text/css' />";
    }
}

function style_include_view_tag()
{
    $params = func_get_args();

    foreach ($params as $param) {
        $path = VIEW_FOLDER;
        $path .= (substr($param, 0, 1) === '/') ? $param : '/css/' . $param;
        echo "<link href='{$path}' rel='stylesheet' type='text/css' />";
    }
}

/*
 * Inclui arquivos js
 * Se o caminho começar com / deve ser considerado a partir da pasta ASSETS_FOLDER
 * caso contrário a partir de ASSETS_FORLDER/css/
 */
function javascript_include_tag()
{
    $params = func_get_args();
    foreach ($params as $param) {
        $path = ASSETS_FOLDER;
        $path .= (substr($param, 0, 1) === '/') ? $param : '/js/' . $param;
        echo "<script language='JavaScript' src='{$path}' type='text/JavaScript'></script>";
    }
}

/*
 * Função para criar links.
 * Importante para definir os caminhos dos arquivos
 * Caso começe com / indica caminho absolute a partir do root da aplicação,
 * caso contrário é camaminho relativo
 */
function link_to($path, $name, $options = '')
{
    return "<a href='{$path}' {$options}> $name </a>";
}

/**
 * FORMATO DE MOEDA REAL
 *
 */

function real_format($number)
{
    return number_format($number, 2, ',', '.');
}


/***
 * select helper
 *
 */

function select(Field $field, $options = false, $params = array(), $selected = false)
{
    $vars = array(
        'name' => 'name',
        'title' => $field->getName(),
        'field' => $field,
        'required' => 'false',
        'default_option' => '',
        'class' => '',
        'no_array_name' => false
    );
    $aux = array();
    if ($options) {
        foreach ($options as $option) {
            if (isset($option['value']) && isset($option['option']))
                $aux[$option['value']] = $option['option'];
        }
    }
    $options = $aux;
    $vars = array_merge($vars, $params);
    extract($vars);
    include('app/views/helpers/select.phtml');
}

/*
 * text_field helper
 */

function text_field(Field $field, $params = array())
{
    $vars = array(
        'name' => 'name',
        'title' => $field->getName(),
        'field' => $field,
        'placeholder' => '',
        'type' => 'text',
        'required' => 'false',
        'class' => '',
        'no_array_name' => false,
        'value' => false
    );
    $vars = array_merge($vars, $params);
    extract($vars);
    include('app/views/helpers/text_field.phtml');
}

/*
 * text_area helper
 */

function text_area(Field $field, $params = array())
{
    $vars = array(
        'name' => 'name',
        'title' => $field->getName(),
        'field' => $field,
        'placeholder' => '',
        'required' => 'false',
        'class' => '',
        'no_array_name' => false,
        'value' => false
    );
    $vars = array_merge($vars, $params);
    extract($vars);
    include('app/views/helpers/text_area.phtml');
}

/*
 * Função para criação de urls
 * Importante, pois com elas não é necessário fazer diversas
 * alterações quando mudar a url principal do site
 */
function url_for($path)
{
    return SITE_ROOT . $path;
}

/*
 * Função para converter boleano em formato amigável
*/
function pretty_bool($value)
{
    return $value ? 'Sim' : 'Não';
}

function format_date($date, $format = 'd/m/Y H:m:s')
{
    return empty($date) ? '' : date($format, strtotime($date));
}

function activeClass($key)
{
    if (SITE_ROOT . $key == $_SERVER['REQUEST_URI'])
        return 'active';

    return '';
}

function image_tag($path, $name, $format, $options = "")
{
    $path = ASSETS_FOLDER . '/' . $path . '/' . $format . '/' . $name;
    return "<img src=\"{$path}\" {$options} />";
}

?>
