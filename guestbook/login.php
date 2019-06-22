<?php
echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\">";
require_once './include/db_info.inc.php';
if (!isset($_POST['user_id']) && !isset($_POST['password'])) {
    echo "<script language='javascript'>\n";
    echo "alert('错误!');\n";
    echo "history.go(-1);\n";
    echo '</script>';
    exit(-1);
}
$user_id = $_POST['user_id'];
$password = $_POST['password'];

if ($user_id == $LOGIN_UESR && $password == $LOGIN_PASS) {
    session_start();
    $_SESSION['administrator'] = true;
    echo "<script language='javascript'>\n";
    echo "alert('登陆成功!');\n";
    echo "window.location.href=\"./guestbook_list.php\";\n";
    echo '</script>';
} else {
    echo "<script language='javascript'>\n";
    echo "alert('用户名或密码错误!');\n";
    echo "history.go(-1);\n";
    echo '</script>';
}
