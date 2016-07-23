<?php
require_once('public/encode.m.php');
require_once('public/mysql.m.php');
require_once('public/redirect.m.php');
require_once('public/session.m.php');
require_once('public/_config.php');


zhPhpSessionRemove("ADMIN_INFO");

zhPhpRedirect('login.php');


?>