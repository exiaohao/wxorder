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
    
     $main = $core->checkDishLegal($_POST['main'], $currentSeason, 'main');
     $vegetable = $core->checkDishLegal($_POST['vegetable'], $currentSeason, 'vegetable');
     $soup = $core->checkDishLegal($_POST['soup'], $currentSeason, 'soup');

     if($main && $vegetable && $soup)
     {
          //如果周日~周四，+1
          //周五~周六，+3，+2
          $day_delta = (date('w')>4)?(8-date('w')):1;
          $people = $_SESSION['id'];
          $time = time();
          $ip = $core->getip();
         
          //检查是否已经存在订单
          if( $core->checkOrderExists($orderDay, $people) )
          {
               $sql = "INSERT INTO `order`(`day`, `main`, `vegetable`, `soup`, `people`, `time`, `ip`) VALUES ('{$orderDay}', '{$main}', '{$vegetable}', '{$soup}', '{$people}', '{$time}', '{$ip}')";
               $query = $core->db->query($sql);
               if($query)
               {
                    header("Location:/status.php?msg=ord_saved");
               }
               else
               {
                    header("Location:/menu.php?msg=ord_error");
               }
          }
          else
          {
               header("Location:/status.php?msg=ord_existed");
          }
     }
     else
     {
          header("Location:/menu.php?msg=bad_request");
     }
}
?>
