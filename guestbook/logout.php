<?php

session_start();
unset($_SESSION['administrator']);
session_destroy();
echo "<script language='javascript'>\n";
echo "alert('退出成功!');\n";
echo "history.go(-1);\n";
echo '</script>';
header('Location:index.php');
