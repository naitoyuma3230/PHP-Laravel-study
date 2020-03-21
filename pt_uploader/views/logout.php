<?php

require_once(__DIR__ . '/../config/config.php');
		
		$_SESSION = [];

		if(isset($_COOKIE[session_name()])){
			setcookie(session_name(), '', time() - 86400, '/');
		}

		session_destroy();
		// cookieとsessionをリセット

header('Location: ' . SITE_URL);