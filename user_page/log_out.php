<?php
session_start();
session_unset();
session_destroy();

// 重定向到主页
header('Location: ../login/index.php');
exit();