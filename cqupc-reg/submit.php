<?php
	function recaptchav3($gresponse) {
		$postarray = array(
			'secret'=>	'6Lec0ZwUAAAAABb5Gyl7edrur8skXyXSdXg0kOa3',
			'response'=>	$gresponse
		);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://recaptcha.net/recaptcha/api/siteverify');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postarray);
		$output = curl_exec($ch);
		$output = json_decode($output,true);
		if ($output['success'] == true) return $output['score'];
		else return false;
	}
	function validate_sex($sex) {
		return intval($sex) == 0 || intval($sex) == 1;
	}
	function validate_teamname($teamname) {
		try {
			$conn = new PDO("sqlite:../db/cqupc2019.db");
			$conn->exec("CREATE TABLE IF NOT EXISTS `user` (`teamname` TEXT,`name` TEXT,`stuid` TEXT,`sex` INTEGER,`email` TEXT,`phone` TEXT,`name1` TEXT,`stuid1` TEXT,`sex1` INTEGER,`phone1` TEXT,`name2` TEXT,`stuid2` TEXT,`sex2` INTEGER,`phone2` TEXT,`recaptcha` TEXT,`recaptchascore` REAL);");
			$stmt = $conn->prepare("SELECT * FROM `user` WHERE `teamname` LIKE ?;");
			$stmt->bindValue(1,$teamname,PDO::PARAM_STR);
			$stmt->execute();
			return count($stmt->fetchAll()) == 0;
		}
		catch (PDOException $e) {
			return false;
		}
	}
	function validate_recaptcha($recaptcha) {
		try {
			$conn = new PDO("sqlite:../db/cqupc2019.db");
			$stmt = $conn->prepare("SELECT * FROM `user` WHERE `recaptcha` LIKE ?;");
			$stmt->bindValue(1,$recaptcha,PDO::PARAM_STR);
			$stmt->execute();
			if (count($stmt->fetchAll()) != 0) return false;
			return recaptchav3($recaptcha);
		}
		catch (PDOException $e) {
			return false;
		}
	}
	function validate_email($email) {
		return preg_match('/^[a-z0-9]+([._-][a-z0-9]+)*@([0-9a-z]+\.[a-z]{2,14}(\.[a-z]{2})?)$/i',$email);
	}
	function validate_phone($phone) {
		return is_numeric($phone) && strlen($phone) == 11 && $phone[0] == '1';
	}
	function validate_stuid($stuid) {
		return true;
		//return is_numeric($stuid) && strlen($stuid) == 8;
	}
	$teamname = $_POST['teamname'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$name = $_POST['name'];
	$stuid = $_POST['stuid'];
	$sex = $_POST['sex'];
	$name1 = $_POST['name1'];
	$stuid1 = $_POST['stuid1'];
	$sex1 = $_POST['sex1'];
	$phone1 = $_POST['phone1'];
	$name2 = $_POST['name2'];
	$stuid2 = $_POST['stuid2'];
	$sex2 = $_POST['sex2'];
	$phone2 = $_POST['phone2'];
	$recaptcha = $_POST['recaptcha'];
	$ret = array('stat'=>0,'msg'=>'填写信息不完整');
	if (
		empty($teamname) ||
		empty($email) ||
		empty($phone) ||
		empty($name) ||
		!validate_stuid($stuid) ||
		!( (empty($name1) && empty($stuid1) && empty($phone1)) || (!empty($name1) && !empty($stuid1) && validate_stuid($stuid1) && validate_phone($phone1)) ) ||
		!( (empty($name2) && empty($stuid2) && empty($phone2)) || (!empty($name2) && !empty($stuid2) && validate_stuid($stuid2) && validate_phone($phone2)) ) ||
		true
	) $ret['msg'] = "填写信息不完整或报名已截止";
	else if (!validate_phone($phone)) $ret['msg'] = "手机号码格式不正确";
	else if (!(validate_sex($sex) && validate_sex($sex1) && validate_sex($sex2))) $ret['msg'] = "性别格式不正确";
	else if (!validate_email($email)) $ret['msg'] = "邮件格式不正确";
	else if (!validate_teamname($teamname)) $ret['msg'] = "队名已经被使用过了";
	else {
		$recaptchascore = validate_recaptcha($recaptcha);
		if ($recaptchascore === false) $ret['msg'] = "reCAPTCHA验证失败，建议调整DNS为国内DNS或科学上网，然后刷新页面重试。";
		else {
			$ret['msg'] = "服务器内部错误";
			//submit
			try {
				$conn = new PDO("sqlite:../db/cqupc2019.db");
				$stmt = $conn->prepare("INSERT INTO `user` VALUES (:teamname,:name,:stuid,:sex,:email,:phone,:name1,:stuid1,:sex1,:phone1,:name2,:stuid2,:sex2,:phone2,:captcha,:recaptchascore)");
				$stmt->execute(array(
					':teamname'=>$teamname,
					':name'=>$name,
					':stuid'=>$stuid,
					':sex'=>intval($sex),
					':email'=>$email,
					':phone'=>$phone,
					':name1'=>$name1,
					':stuid1'=>$stuid1,
					':sex1'=>intval($sex1),
					':phone1'=>$phone1,
					':name2'=>$name2,
					':stuid2'=>$stuid2,
					':sex2'=>intval($sex2),
					':phone2'=>$phone2,
					':captcha'=>$recaptcha,
					':recaptchascore'=>$recaptchascore
					));
				if ($conn->lastInsertId()) {
					$ret['stat'] = 1;
					$ret['msg'] = "OK";
					$ret['recaptcha'] = $recaptcha;
				}
			}
			catch (PDOException $e) {
				
			}
		}
	}
	echo json_encode($ret);
?>
