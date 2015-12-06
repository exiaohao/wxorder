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
     <title>菜单 - <?=$conf['site_name']; ?></title>
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
     <h3>明天想吃啥?</h3>
     <form method="post" action="/save.php">
          <div class="row">
               <div class="container">    
                    <div class="input-group">
                         <label>选个主菜</label>
                         <select class="form-control" name="main">
                              <option disabled="disabled" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;请&nbsp;&nbsp;&nbsp;&nbsp;选&nbsp;&nbsp;&nbsp;&nbsp;择&nbsp;&nbsp;&nbsp;&nbsp;</option>
                              <?php
                              $main_dishes = $core->getDishes('main');
                              foreach($main_dishes as $dish)
                              {
                                   echo "<option value=\"{$dish['id']}\">{$dish['dish']}</option>";
                              }
                              ?>

                         </select>
                    </div>
               </div>
               <div class="container">    
                    <div class="input-group">
                         <label>选个素菜</label>
                         <select class="form-control" name="vegetable">
                              <option disabled="disabled" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;请&nbsp;&nbsp;&nbsp;&nbsp;选&nbsp;&nbsp;&nbsp;&nbsp;择&nbsp;&nbsp;&nbsp;&nbsp;</option>
                              <?php
                              $main_dishes = $core->getDishes('vegetable');
                              foreach($main_dishes as $dish)
                              {
                                   echo "<option value=\"{$dish['id']}\">{$dish['dish']}</option>";
                              }
                              ?>

                         </select>
                    </div>
                    <div class="input-group">
                         <label>选个汤</label>
                         <select class="form-control" name="soup">
                              <option disabled="disabled" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;请&nbsp;&nbsp;&nbsp;&nbsp;选&nbsp;&nbsp;&nbsp;&nbsp;择&nbsp;&nbsp;&nbsp;&nbsp;</option>
                              <?php
                              $main_dishes = $core->getDishes('soup');
                              foreach($main_dishes as $dish)
                              {
                                   echo "<option value=\"{$dish['id']}\">{$dish['dish']}</option>";
                              }
                              ?>

                         </select>
                    </div>
                    <p>
                         <?php
                         $orderedLine = @$core->db->query("SELECT * FROM `order` WHERE `day` LIKE '{$orderDay}';");
                         ?>
                         当前已经有 <?=$orderedLine->num_rows; ?> 人点菜
                    </p>
                    <p>
                         <button class="btn btn-info" type="submit">提交</button>
                    </p>
               </div>
          </div>
     </form>
     <div class="row">
          <div class="container">
               <a href="/statics.php">别人都点了什么?</a>
          </div>
     </div>
</div>
