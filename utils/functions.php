<?php

function ajoutImage($file, $dir){
    if(!isset($file['name']) || empty($file['name']))
        throw new Exception("Vous devez indiquer une image");

    if(!file_exists($dir)) mkdir($dir,0777);

    $extension = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
    $random = rand(0,99999);
    $target_file = $dir.$random."_".$file['name'];
    
    if(!getimagesize($file["tmp_name"]))
        throw new Exception("Le fichier n'est pas une image");
    if($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png" && $extension !== "gif")
        throw new Exception("L'extension du fichier n'est pas reconnu");
    if(file_exists($target_file))
        throw new Exception("Le fichier existe déjà");
    if($file['size'] > 15000000)
        flash("upload", 'Le fichier est trop gros');
    if(!move_uploaded_file($file['tmp_name'], $target_file))
        flash("upload", "l'ajout de l'image n'a pas fonctionné");
    else return ($random."_".$file['name']);
}

function flash($name = '', $message = '', $class = 'error'){
    if(!empty($name)){
        if(!empty($message) && empty($_SESSION[$name])){
            $_SESSION[$name] = $message;
            $_SESSION[$name.'_class'] = $class;
        }else if(empty($message) && !empty($_SESSION[$name])){
            $class = !empty($_SESSION[$name.'_class']) ? $_SESSION[$name.'_class'] : $class;
            echo '<div class="'.$class.'" >'.$_SESSION[$name].'</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name.'_class']);
        }
    }
}
