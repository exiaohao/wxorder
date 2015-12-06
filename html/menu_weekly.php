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

	$msg_header = array('ord_error_count','ord_error');
     $msg = array('ord_error_count' => "alert-warning,要选5个菜喔亲╭(╯3╰)╮!", 'ord_error' => "alert-danger,订单有误");
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
<style>
ul li.selected-item
{
	color: #8a6d3b;
    background-color: #fcf8e3;
    border-color: #faebcc;
}
</style>
</head>
<body>
<div class="container">
     <div class="row">
          <div class="container">
          <h3>小厨房点个菜</h3>
			<?php
			if(in_array($_GET['msg'], $msg_header, true))
               {
                    $msg_dat = explode(',',$msg[$_GET['msg']]);
                    echo '<div class="alert '.$msg_dat[0].'" role="alert">'.$msg_dat[1].'</div>';
               }
			?>
          </div>
     </div>
     <hr />
     <h3>一点点一周</h3>
     <form method="post" action="/save_weekly.php">
          <div class="row">
               <div class="container">   
				<h5>主菜</h5>
				<ul id="maindish" class="list-group">
					<?php
                              $main_dishes = $core->getDishes('main');
                              foreach($main_dishes as $dish)
                              {
                                   echo "<li class=\"list-group-item wait-select\"><label><input name=\"main[]\" type=\"checkbox\" value=\"{$dish['id']}\" />{$dish['dish']}</label></li>";
                              }
                    ?>
					</ul> 
               </div>
				
				<div class="container">
                <h5>素菜</h5>
                <ul id="vegetabledish" class="list-group">
                    <?php
                              $main_dishes = $core->getDishes('vegetable');
                              foreach($main_dishes as $dish)
                              {
                                   echo "<li class=\"list-group-item wait-select\"><label><input name=\"vegetable[]\" type=\"checkbox\" value=\"{$dish['id']}\" />{$dish['dish']}</label></li>";
                              }
                    ?>
                    </ul>
               </div>
				
				<div class="container">
                <h5>汤</h5>
                <ul id="soupdish" class="list-group">
                    <?php
                              $main_dishes = $core->getDishes('soup');
                              foreach($main_dishes as $dish)
                              {
                                   echo "<li class=\"list-group-item wait-select\"><label><input name=\"soup[]\" type=\"checkbox\" value=\"{$dish['id']}\" />{$dish['dish']}</label></li>";
                              }
                    ?>
                    </ul>
               </div>
				

				<div class="container">
					<button type="submit">好了，爷就要这些!</button>
				</div>
          </div>
     </form>
     <div class="row">
          <div class="container">
               <a href="/statics.php">别人都点了什么?</a>
          </div>
     </div>
</div>
<script>
$(document).ready(function(){
$("ul.list-group li input").click(function(){
        $(this).closest('li').toggleClass('selected-item');
	})
})
/*
	$("#maindish li input").click(function(){
		$(this).closest('li').toggleClass('selected-item');
		var main_cont = 0;
		$("#maindish input:checkbox[name=main]").each(function(i,e){
            $(this).closest('li').addClass('wait-select')
        })
		$("#maindish input:checkbox[name=main]:checked").each(function(i,e){
			main_cont = main_cont + 1;
			$(this).closest('li').removeClass('wait-select')
		})
		$("#selected-maindish").html(main_cont)
		if(main_cont > 4)
		{
			$('#maindish .wait-select').hide();
		}
		else
		{
			$('#maindish.wait-select').show();
		}
	})
	
	$("#vegetabledish li input").click(function(){
        $(this).closest('li').toggleClass('selected-item');
        var veg_cont = 0;
        $("#vegetabledish input:checkbox[name=main]").each(function(i,e){
            $(this).closest('li').addClass('wait-select')
        })
        $("#vegetabledish input:checkbox[name=main]:checked").each(function(i,e){
            veg_cont = veg_cont + 1;
            $(this).closest('li').removeClass('wait-select')
        })
        $("#selected-vegdish").html(veg_cont)
        if(veg_cont > 4)
        {
            $('#vegetabledish .wait-select').hide();
        }
        else
        {
            $('#vegetabledish.wait-select').show();
        }
    })
})
*/
</script>
