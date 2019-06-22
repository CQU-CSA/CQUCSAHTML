<?php
require_once './include/db_info.inc.php';
session_start();
if ((isset($_SESSION['administrator']))) {
    header('Location:index.php');
	echo $_SESSION['administrator'];
}
$sql = 'select `id`,`name`,`subject`,`email`,`phone`,`comment`,`ip`,`time` from guestbook ORDER BY time DESC';
$result = pdo_query($sql);
$sql = 'select count(*) from guestbook';
$countresult = pdo_query($sql);
$count = 0;
foreach ($countresult as $a) {
    $count = $a['0'];
}
?>


<!DOCTYPE html>
<html>

	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<title></title>
	</head>

	<body>
		<div>
			<div style="float: right;">
				<a href="./logout.php">LOGOUT</a>
			</div>
			<div style="float: right;margin-right: 50%;">
				A total of <?php echo $count; ?> data
			</div>

		</div>

		<table width="100%" border="1" cellspacing="0" style="text-align:center;">
			<thead>
				<th>ID</th>
				<th>NAME</th>
				<th>SUBJECT</th>
				<th>E-MAIL</th>
				<th>PHONE</th>
				<th>COMMENT</th>
				<th>IP</th>
				<th>TIME</th>
			</thead>
			<tbody border="1" cellspacing="0">
            <?php
            foreach ($result as $row) {
                echo '<tr>';
                echo '<td>'.$row['id'].'</td>';
                echo '<td>'.$row['name'].'</td>';
                echo '<td>'.$row['subject'].'</td>';
                echo '<td>'.$row['email'].'</td>';
                echo '<td>'.$row['phone'].'</td>';
                echo '<td>'.$row['comment'].'</td>';
                echo '<td>'.$row['ip'].'</td>';
                echo '<td>'.$row['time'].'</td>';
                echo '</tr>';
            }
            ?>
			</tbody>

		</table>
	</body>

</html>
