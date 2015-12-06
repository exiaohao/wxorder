<pre>
<?php
session_start();
if($_SESSION['user_valid'] != true)
{
     header("Location:/login.php");
}
else
{
	require 'db.php';
    $core = new core;
	$currentSeason = $core->getConf('SEASON');	

	$main_dish = $_POST['main'];
	$vegetable = $_POST['vegetable'];
	$soup = $_POST['soup'];

	$people = $_SESSION['id'];
    $time = time();
    $ip = $core->getip();
	
	if( $core->checkOrderExists($orderDay, $people) )
    {
		if( count($main_dish) ==5 && count($vegetable) == 5 && count($soup) == 5)
		{
			$main = $core->checkArrayDishLegal($_POST['main'], $currentSeason, 'main');
			$vegetable = $core->checkArrayDishLegal($_POST['vegetable'], $currentSeason, 'vegetable');
			$soup = $core->checkArrayDishLegal($_POST['soup'], $currentSeason, 'soup');
			
			if($main && $vegetable && $soup)
			{
				$dish['main'] = $_POST['main'];
				$dish['vegetable'] = $_POST['vegetable'];
				$dish['soup'] = $_POST['soup'];
				$dish_json = json_encode($dish);
				$sql = "INSERT INTO `order_week`(`ip`, `order`, `people`, `week`, `time`) VALUES ('{$ip}', '{$dish_json}', '{$people}', '{$orderDay}', '{$time}')";
				$query = $core->db->query($sql);
               if($query)
               {
                    header("Location:/status.php?msg=ord_saved");
               }
               else
               {
                    header("Location:/status.php?msg=ord_error");
               }
			}
			else
			{
				header("Location:/menu_weekly.php?msg=ord_error");
			}
		}
		else
		{
			header("Location:/menu_weekly.php?msg=ord_error_count");
		}
	}
	else
	{
		header("Location:/status.php?msg=ord_existed");
	}
}
