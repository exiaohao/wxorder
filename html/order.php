<?php
session_start();
header("Content-type: text/html; charset=utf-8");  

foreach($_SESSION as $skey=>$sval)
{
	unset($_SESSION[$skey]);
}

$openid = $_GET['openid'];
$session = $_GET['session'];

echo '<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>';

if(!empty($openid) && !empty($session))
{
	require 'db.php';
	$mysql = new mysql;
	
	//CheckSession
	$sql = "SELECT * FROM `session` WHERE `usession` = '{$session}' AND `uid` = '{$openid}' LIMIT 1;";
	$sessexist = $mysql->db->query($sql);	
	if($sessexist->num_rows)
	{
		$sessInfo = mysqli_fetch_assoc($sessexist);
		if($sessInfo['expire'] > time())
		{
			$uinfo = $mysql->db->query("SELECT * FROM `coupon` WHERE `actopenid` LIKE '{$openid}' LIMIT 1;");
			$user_info = mysqli_fetch_assoc($uinfo);
			//print_r($user_info);
			$todayId = date("Ymd");
			$ifToday = $mysql->db->query("SELECT * FROM `order` WHERE `people` = {$user_info['id']} AND `day` > {$todayId} ORDER by `time` DESC LIMIT 1");
			//
			$_SESSION['user_valid'] = true;
			$_SESSION['user'] = $openid;
			$_SESSION['id'] = $user_info['id'];
			$_SESSION['name'] = $user_info['name'];
			if($ifToday->num_rows)
				header("Location:/status.php?msg=ord_existed");
			else
				header("Location:/menu_weekly.php");
			die("登录成功!!");
		}
		else
		{
			die("<h1>会话超时，请重新输入【点菜】，获取点菜链接</h1>");
		}	
	}
	else
	{
		die('<h1>错误的会话</h1>');	
	}


}

?>
