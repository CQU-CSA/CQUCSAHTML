<?php
	function judge_female_team($each) {
		$cnt = 1;
		$female_cnt = $each['sex'];
		if (!empty($each['name1'])) {
			$cnt ++;
			if ($each['sex1']) $female_cnt ++;
		}
		if (!empty($each['name2'])) {
			$cnt ++;
			if ($each['sex2']) $female_cnt ++;
		}
		return $female_cnt == $cnt;
	}
	$conn = new PDO("sqlite:../db/cqupc2019.db");
	$stmt = $conn->prepare("SELECT * FROM `user` WHERE `recaptcha` = ? LIMIT 1;");
	$stmt->bindValue(1,$_GET['recaptcha'],PDO::PARAM_STR);
	$stmt->execute();
	$res = $stmt->fetchAll();
	$res = $res[0];
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta charset="utf-8">
	<title>报名结果</title>
</head>
<body>
	<center>
	<h1>报名成功</h1>
	<table>
		<tr>
			<td>队名</td>
			<td><?php echo htmlspecialchars($res['teamname']); ?></td>
		</tr>
		<tr>
			<td>女队</td>
			<td><?php echo judge_female_team($res)?"是":"否"; ?></td>
		</tr>
		<tr>
			<td>队长</td>
			<td><?php echo htmlspecialchars($res['name']); ?></td>
		</tr>
		<tr>
			<td>队长学号</td>
			<td><?php echo htmlspecialchars($res['stuid']); ?></td>
		</tr>
		<tr>
			<td>队长手机</td>
			<td><?php echo htmlspecialchars($res['phone']); ?></td>
		</tr>
		<tr>
			<td>队长邮箱</td>
			<td><?php echo htmlspecialchars($res['email']); ?></td>
		</tr>
		<tr>
			<td>队员1</td>
			<td><?php echo htmlspecialchars($res['name1']); ?></td>
		</tr>
		<tr>
			<td>队员1学号</td>
			<td><?php echo htmlspecialchars($res['stuid1']); ?></td>
		</tr>
		<tr>
			<td>队员1手机</td>
			<td><?php echo htmlspecialchars($res['phone1']); ?></td>
		</tr>
		<tr>
			<td>队员2</td>
			<td><?php echo htmlspecialchars($res['name2']); ?></td>
		</tr>
		<tr>
			<td>队员2学号</td>
			<td><?php echo htmlspecialchars($res['stuid2']); ?></td>
		</tr>
		<tr>
			<td>队员2手机</td>
			<td><?php echo htmlspecialchars($res['phone2']); ?></td>
		</tr>
	</table>
	</center>
</body>
</html>
