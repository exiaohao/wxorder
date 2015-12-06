<?php
$conf['site_name'] = "点菜鸡";

$day_delta = (date('w')==0)?0:7;
//产生订餐时间
$orderDay = date("YW",(strtotime(date("Ymd")) + $day_delta*86400));


class mysql{
    var $db;
    function __construct()
    {
        $this->db = mysqli_connect('localhost','webapp','67qxsqEvTLKuzYLf','order') or die('Unale to connect');
        $this->db->query("SET NAMES utf8;");
    }
}


class core extends mysql{
     function getConf($confname)
     {
          $conf = $this->db->query("SELECT * FROM `conf` WHERE `key` LIKE '{$confname}' LIMIT 1;");
          if($conf->num_rows > 0)
          {
               $confinfo = mysqli_fetch_assoc($conf);
               return $confinfo['value'];
          }
          else
          {
               return false;
          }
     }

     function checkuser($name,$passsalt)
     {
          $getName = $this->db->query("SELECT * FROM `user` WHERE `name` LIKE '{$name}' LIMIT 1;");
         
          //var_dump($getName);
          if( $getName->num_rows > 0)
          {
               $userInfo = mysqli_fetch_assoc($getName);
               if($userInfo['password'] == $passsalt)
               {
                    //password passed
                    $retu['eid'] = 0;
                    $retu['user'] = $userInfo;
               }
               else
               {
                    //bad password
                    $retu['eid'] = 2;
               }
          }
          else
          {
               //bad user
               $retu['eid'] = 1;
          }
          return $retu;
     }

     function getDishes($type = "main")
     {
          $dish_handle = $this->db->query("SELECT * FROM `menu` WHERE `type` = '{$type}' ORDER by `order`;");
          $dishes = array();
          while ($item = mysqli_fetch_array($dish_handle)) {
               $dishes[] = $item;
          }
          return $dishes;
     }

     function checkDishLegal($id, $season, $type)
     {
          $id = $id + 0;
          $sql = "SELECT * FROM `menu` WHERE `id` = {$id} AND `season` LIKE '%{$season}%' AND `type` = '{$type}' LIMIT 1;";
          $check = $this->db->query($sql);
          if( $check->num_rows > 0)
          {
               return $id;
          }
          else
          {
               return false;
          }
     }
	 function checkArrayDishLegal($arr, $season, $type)
	 {
			foreach($arr as $k=>$v)
			{
				if( $this->checkDishLegal($v, $season, $type) == false )
				{
					return false;
				}
			}
			return true;
	 }

     function getip()
     {
          $ip=false; 
          if(!empty($_SERVER["HTTP_CLIENT_IP"])){ 
               $ip = $_SERVER["HTTP_CLIENT_IP"]; 
          } 
          if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
               $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']); 
               if ($ip) { array_unshift($ips, $ip); $ip = FALSE; } 
               for ($i = 0; $i < count($ips); $i++) { 
                    if (!eregi ("^(10|172\.16|192\.168)\.", $ips[$i])) { 
                         $ip = $ips[$i]; 
                         break; 
                    } 
               } 
          } 
          return ($ip ? $ip : $_SERVER['REMOTE_ADDR']); 
     }

     function checkOrderExists($day, $people)
     {
          $sql = "SELECT * FROM `order_week` WHERE `week` LIKE '{$day}' AND `people` = {$people} LIMIT 1;";
          $query = $this->db->query($sql);
          if( $query->num_rows )
          {
               return false;
          }
          else {
               return true;
          }
     }
}
?>
