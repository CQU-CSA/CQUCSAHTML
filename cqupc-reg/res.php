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
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>报名结果</title>
</head>
<body>
	<table border="1">
		<tr>
			<td>队伍名称</td>
			<td>队长</td>
			<td>学号</td>
			<td>手机</td>
			<td>队员</td>
			<td>学号</td>
			<td>手机</td>
			<td>队员</td>
			<td>学号</td>
			<td>手机</td>
			<td>女队</td>
			<td>队长邮箱</td>
			<td>reCAPTCHA</td>
		</tr>
		<?php
			$conn = new PDO("sqlite:../db/cqupc2019.db");
			$stmt = $conn->prepare("SELECT * FROM user;");
			$stmt->execute();
			foreach ($stmt->fetchAll() as $each) {
				?>
				<tr>
					<td><?php echo htmlspecialchars($each['teamname']); ?></td>
					<td><?php echo htmlspecialchars($each['name']); ?></td>
					<td><?php echo htmlspecialchars($each['stuid']); ?></td>
					<td><?php echo htmlspecialchars($each['phone']); ?></td>
					<td><?php echo htmlspecialchars($each['name1']); ?></td>
					<td><?php echo htmlspecialchars($each['stuid1']); ?></td>
					<td><?php echo htmlspecialchars($each['phone1']); ?></td>
					<td><?php echo htmlspecialchars($each['name2']); ?></td>
					<td><?php echo htmlspecialchars($each['stuid2']); ?></td>
					<td><?php echo htmlspecialchars($each['phone2']); ?></td>
					<td><?php 
					if (judge_female_team($each)) echo "是"; ?></td>
					<td><?php echo htmlspecialchars($each['email']); ?></td>
					<td><?php echo htmlspecialchars($each['recaptchascore']); ?></td>
				</tr>
				<?php
			}
		?>
	</table>
</body>
</html>
