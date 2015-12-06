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

     $msg_header = array('ord_existed', 'ord_saved', 'bad_request');
     $msg = array('ord_existed' => "alert-warning,你已经点过下周的菜啦!", 'ord_saved' => "alert-success,嗯哼，点菜成功!", 'bad_request' => "alert-danger,错误的请求");
}
?>
<!DOCTYPE html>
<html>
<head>
     <meta charset="utf-8" />
     <meta name="renderer" content="webkit">
     <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
     <meta content="yes" name="apple-touch-fullscreen"/>
     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
     <meta name="apple-mobile-web-app-capable" content="yes" />
     <title>点菜结果 - <?=$conf['site_name']; ?></title>
     <link rel="stylesheet" type="text/css" href="//lib.sinaapp.com/js/bootstrap/latest/css/bootstrap.min.css">
     <script src="//lib.sinaapp.com/js/jquery/1.10.2/jquery-1.10.2.min.js"></script>
     <script src="//lib.sinaapp.com/js/bootstrap/latest/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
     <div class="row">
          <div class="container">
          <h3>小厨房点个菜</h3>
          </div>
     </div>
     <hr />
     <div class="row">
          <div class="container">
               <?php
               if(in_array($_GET['msg'], $msg_header, true))
               {
                    $msg_dat = explode(',',$msg[$_GET['msg']]);
                    echo '<div class="alert '.$msg_dat[0].'" role="alert">'.$msg_dat[1].'</div>';
               }

               $orderedLine = $core->db->query("SELECT * FROM `order_week` WHERE `week` LIKE '{$orderDay}';");
               ?>
               <p>
                    当前已经有 <?=$orderedLine->num_rows; ?> 人点了下周的菜
               </p>
               <p>
                    最受欢迎的主菜:--未统计--
               </p>
               <p>
                    最受欢迎的素菜:--未统计--
               </p>
               <p>
                    最受欢迎的汤:--未统计--
               </p>
               <p>
                    与我口味最接近:--未统计--
               </p>
          </div>
     </div>
	<?php
	require 'footer.php';
	?>
