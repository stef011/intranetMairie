<?php 

function view($view, $data = null)
{
    $view = str_replace('.', '/', $view);
    foreach ($data as $key => $value) {
        $$key = $value;
    }
    require 'views/' . $view . '.php';
    $str = ob_get_contents();
    ob_end_clean();
    echo $str;
}
