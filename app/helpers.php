<?php 

function view($view, $data = null)
{
    $view = str_replace('.', '/', $view);

    if($data != null){
        foreach ($data as $key => $value) {
            $$key = $value;
        }
    }
    require 'ressources/views/' . $view . '.php';
    $str = ob_get_contents();
    ob_end_clean();
    echo $str;
}

function assets($path)
{
    trim($path, '/');
    return 'ressources/assets/' . $path;
}
