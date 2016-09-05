<?php
require_once 'bootstrap.php';

$page = get('page', 'page1');
if($page != 'feedback' && isGuest()){
    header('Location: /login.php', true, 307);
    exit(0);
}
elseif ($page == 'logout'){
    logout();
}
elseif(!isGuest()){
    security();
}

$params = [];

if(post('feedback_form', false) !== false){
    $params = saveMessage();
}
elseif (post('settings_form', false) !== false){
    $params = saveSettings();
}

$content = loadPage($page, $params);






