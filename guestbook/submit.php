<?php

function getIP()
{
    global $ip;
    if (getenv('HTTP_CLIENT_IP')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif (getenv('REMOTE_ADDR')) {
        $ip = getenv('REMOTE_ADDR');
    } else {
        $ip = 'Unknow';
    }

    return $ip;
}

require_once './include/db_info.inc.php';
$err_str = '';
$err_cnt = 0;
echo isset($_POST['name']);
$name = trim($_POST['name']);
$subject = trim($_POST['subject']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$comment = trim($_POST['comment']);
$ip = getIP();

if ($name == '' || $name == null) {
    $err_str = 'Name cannot be empty!';
    ++$err_cnt;
}
if ($subject == '' || $subject == null) {
    $err_str = 'Subject cannot be empty!';
    ++$err_cnt;
}
if ($email == '' || $email == null) {
    $err_str = 'E-mail cannot be empty!';
    ++$err_cnt;
}

if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email)) {
    $err_str = 'E-mail format is incorrect!';
    ++$err_cnt;
}

if ($phone == '' || $phone == null) {
    $err_str = 'Phone number cannot be empty!';
    ++$err_cnt;
}
if (!preg_match("/^1[34578]{1}\d{9}$/", $phone) && !preg_match('/^([0-9]{3,4}-)?[0-9]{7,8}$/', $phone)) {
    $err_str = 'Phone number format is incorrect!';
    ++$err_cnt;
}
if ($comment == '' || $comment == null) {
    $err_str = 'Massege cannot be empty!';
    ++$err_cnt;
}
if ($err_cnt > 0) {
    echo "<script language='javascript'>\n";
    echo "alert('";
    echo $err_str;
    echo "');\n history.go(-1);\n</script>";
    exit(0);
}
$sql = 'INSERT INTO `guestbook`('
    .'`name`,`subject`,`email`,`phone`,`comment`,`ip`,`time`)'
    .'VALUES(?,?,?,?,?,?,NOW())';
$rows = pdo_query($sql, $name, $subject, $email, $phone, $comment, $ip);

if ($rows > 0) {
    echo "<script language='javascript'>\n";
    echo "alert('";
    echo 'Submitted successfully!';
    echo "');\n history.go(-1);\n</script>";
    exit(0);
}
