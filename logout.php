<?php
require_once 'config.php';

// Oturumu sonlandır
session_start();
session_unset();
session_destroy();

// Giriş sayfasına yönlendir
redirect('index.php');