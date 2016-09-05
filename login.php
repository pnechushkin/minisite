<?php
require_once 'bootstrap.php';

if(!isGuest()){
    header('Location: /', true, 307);
    exit(0);
}

$error = '';
if(isPost()){
    if(authorize()){
        header('Location: /', true, 307);
        exit(0);
    }

    $error = 'Incorrect login and/or password';
}

$content = loadPage('login', ['error' => $error]);