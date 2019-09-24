<?php


function is_ajax_request(){
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
        $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}

$length = isset($_POST['length']) ? (int) $_POST['length'] : '' ;
$width = isset($_POST['width']) ? (int) $_POST['width'] : '';
$height = isset($_POST['height']) ? (int) $_POST['height'] : '' ;

$volume = $length * $height * $width;

if(is_ajax_request()){
    echo $volume;
}else{
    exit;
}
?>
