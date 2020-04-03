<?php

require 'core/ClassLoader.php';

$loader = new ClassLoader();
// AutoLoaderのフォルダを定義
$loader->registerDir(dirname(__FILE__).'/core');
$loader->registerDir(dirname(__FILE__).'/models');
$loader->register();