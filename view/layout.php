<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="/css/main.css">
</head>
/*
* если пользователь авторизирован и есть измененые параметры css загружаем личный css файл
*/
<?php
if (!isGuest() && !empty($_COOKIE['custom_css_' . $_SESSION['user']])):
	echo '<style>';
	echo $_COOKIE['custom_css_' . $_SESSION['user']];
	echo '</style>';
endif;
?>
<body>
<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<ul class="nav navbar-nav">
			<li><a href="/?page=page1">Page1</a></li>
			<li><a href="/?page=page2">Page2</a></li>
			<li><a href="/?page=page3">Page3</a></li>
			<li><a href="/?page=feedback">Feedback</a></li>
				<!--
				 если пользователь гость дабавляем в меню пункт на авторизацию
				-->
			<?php if (isGuest()): ?>
				<li><a href="/?page=login">Login</a></li>
				<!--
				если пользователь авторизирован дабавляем в меню пункт на настройки и выход
				-->
			<?php else: ?>
				<li><a href="/?page=settings">Settings</a></li>
				<li><a href="/?page=logout">Logout</a></li>
			<?php endif; ?>
		</ul>
	</div>
</nav>
<!--
загружаем полученый контент
-->
<div class="container">//
	<?php echo $content; ?>
</div>
</body>
</html>