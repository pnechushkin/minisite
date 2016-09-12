<?php
/*
 * Функция isGuest используется для проверки авторизирован ли ранее пользователь.
 * При авторизации клиенту записывается ключь в куки и сессию. Если значение ключа в
 * куках пустое или не соответсует записаным в сессию - значит клиент не авторизирован или
 * попытка несанкционированого доступа через подмену значения куков
 */
function isGuest()
{
	if (empty($_COOKIE['_cfs']) || $_COOKIE['_cfs'] != $_SESSION['_cfs']) {
		return true;
	}
	return false;
}

/*
 * Функция loadPage используется для загрузки страницы. Первый параметр функции - это запрашиваемая страница,
 * второй - параметры, по умолчанию пустой масив. При работе функции - попытка найти запрашиваемый файл страницы и возврат этой страницы
 * или если такого файла нет - возврат страницы 404.php
 */
function loadPage($name, $params = [])
{
	extract($params);
	$file = VIEW . DS . strtolower($name) . '.php';
	ob_start();
	if (is_file($file)) {
		include $file;
	} else {
		include VIEW . DS . '404.php';
	}
	return ob_get_clean();
}

/*
 * Возврат значения с ключем $name из get запроса. Возвращает или значение или по default null
 */
function get($name, $default = null)
{
	return isset($_GET[$name]) ? $_GET[$name] : $default;
}

/*
 * Возврат значения с ключем $name из post запроса. Возвращает или значение или по default null
 */
function post($name, $default = null)
{
	return isset($_POST[$name]) ? $_POST[$name] : $default;
}

/*
 * Проверка отправлен ли запрос POST
 */
function isPost()
{
	return !empty($_POST);
}

/*
 * Проверка авторизации пользователя. Из файла с логинами и паролями пользователей проверяется соответсвие логина и пароля.
 * При совпадении запись в сессию логина, случайно сгенерированого пароля и значение cssfile. В укки так же записывается значение
 * случайно сгенерированого пароля.
 * При пустом значении логина или несоответсвии пароля возвращается ошибка
 */
function authorize()
{
	$users = require_once DATA . DS . 'users.php';

	$login = post('login');
	$password = post('passw');

	if (isset($users[$login]) && $users[$login] == md5($password)) {
		$_SESSION['user'] = $login;
		$_SESSION['_cfs'] = bin2hex(openssl_random_pseudo_bytes(30));
		$_SESSION['cssfile'] = $login . '.css';
		setcookie('_cfs', $_SESSION['_cfs'], null, '/');
		return true;
	}
	return false;
}

/*
 * функция безопасности. При вызове функции перезаписывается значение случайно сгенерированого ключа в куки и сессию.
 */
function security()
{
	$_cfs = bin2hex(openssl_random_pseudo_bytes(30));
	$_COOKIE['_cfs'] = $_SESSION['_cfs'] = $_cfs;
	setcookie('_cfs', $_cfs, null, '/');
}

/*
 * функция выхода. При вызове функции удаляется значение куков и сессии и перенаправляется на главную страницу
 */
function logout()
{
	setcookie('_cfs');
	unset($_SESSION['_cfs']);
	header('Location: /');
	exit(0);
}

/*
 * Функция записи сообщения в файл. Тема и сообщение фильтруем по тегам. При пустом логине, теме или сообщении выдаем ошибку.
 * При корректном заполнении логина, темы и сообщения записываем сообщение в файл предварительно свернутого масива в json в файл.
 * удаляем значения $_POST['username'], $_POST['subject'], $_POST['message'] и выдаем сообщение про запись сообщения
 */
function saveMessage()
{
	$result = [];
	$username = post('username');
	$subject = post('subject');
	$message = post('message');

	$subject = htmlentities(strip_tags($subject));
	$message = htmlentities(strip_tags($message));

	if (empty($username)) {
		$result['username_error'] = 'User name can\'t be empty';
	}
	if (empty($subject)) {
		$result['subject_error'] = 'Subject can\'t be empty';
	}
	if (empty($message)) {
		$result['message_error'] = 'Message can\'t be empty';
	}

	if ($result !== []) {
		return $result;
	}

	$filename = DATA . DS . 'messages.txt';
	$data = compact('username', 'subject', 'message');
	$row = json_encode($data);
	file_put_contents($filename, $row . "\r\n", FILE_APPEND);

	unset($_POST['username'], $_POST['subject'], $_POST['message']);

	return [
		'info' => 'Your message has been saved'
	];
}

/*
 * сохранение пользовательских настроек темы. При смене цвета текста, бекграунда и размера шрифта записываем информацию в куки сроком действия на месяц
 * и выводим сообщение про успешное сохранение настроек.
 */
function saveSettings()
{
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

	setcookie('custom_css_' . $_SESSION['user'], $css, time() + 30 * 24 * 3600, '/');
	return [
		'info' => 'Your CSS has been saved'
	];
}