<?php
function isGuest(){
    if(empty($_COOKIE['_cfs']) || $_COOKIE['_cfs'] != $_SESSION['_cfs']){
        return true;
    }
    return false;
}

function loadPage($name, $params = []){
    extract($params);
    $file = VIEW.DS.strtolower($name).'.php';
    ob_start();
    if(is_file($file)){
        include $file;
    }
    else{
        include VIEW.DS.'404.php';
    }
    return ob_get_clean();
}

function get($name, $default=null){
    return isset($_GET[$name]) ? $_GET[$name] : $default;
}

function post($name, $default=null){
    return isset($_POST[$name]) ? $_POST[$name] : $default;
}

function isPost(){
    return !empty($_POST);
}

function authorize(){
    $users = require_once DATA.DS.'users.php';
    
    $login = post('login');
    $password = post('passw');
    
    if (isset($users[$login]) && $users[$login] == md5($password)){
        $_SESSION['user'] = $login;
        $_SESSION['_cfs'] = bin2hex(openssl_random_pseudo_bytes(30));
        $_SESSION['cssfile'] = $login.'.css';
        setcookie('_cfs', $_SESSION['_cfs'], null, '/');
        return true;
    }
    return false;
}

function security(){
    $_cfs = bin2hex(openssl_random_pseudo_bytes(30));
    $_COOKIE['_cfs'] = $_SESSION['_cfs'] = $_cfs;
    setcookie('_cfs', $_cfs, null, '/');
}

function logout(){
    setcookie('_cfs');
    unset($_SESSION['_cfs']);
    header('Location: /');
    exit(0);
}

function saveMessage(){
    $result = [];
    $username = post('username');
    $subject = post('subject');
    $message = post('message');

    $subject = htmlentities(strip_tags($subject));
    $message = htmlentities(strip_tags($message));

    if(empty($username)){
        $result['username_error'] = 'User name can\'t be empty';
    }
    if(empty($subject)){
        $result['subject_error'] = 'Subject can\'t be empty';
    }
    if(empty($message)){
        $result['message_error'] = 'Message can\'t be empty';
    }

    if($result !== []){
        return $result;
    }

    $filename = DATA.DS.'messages.txt';
    $data = compact('username', 'subject', 'message');
    $row = json_encode($data);
    file_put_contents($filename, $row."\r\n", FILE_APPEND);

    unset($_POST['username'], $_POST['subject'], $_POST['message']);

    return [
        'info' => 'Your message has been saved'
    ];
}

function saveSettings(){
    $textColor = strip_tags(post('textcolor', '#000'));
    $bgColor = strip_tags(post('background', '#FFF'));
    $textSize = strip_tags(post('textsize', '14px'));
    $css = <<<EOL
div.container {
    color: $textColor;
}

body {
    background-color: $bgColor;
}

p {
    font-size: $textSize;
}
EOL;
    
    setcookie('custom_css_'.$_SESSION['user'], $css, time()+30*24*3600, '/');
    return [
        'info' => 'Your CSS has been saved'
    ];
}