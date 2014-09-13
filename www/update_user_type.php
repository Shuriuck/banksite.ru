<?
	include "session_init.php";
	$id = $_POST['userid'];
	$new_val = $_POST['newval'];
	$log = $_POST['log'];
	if($new_val == 0)
	{
		$rights = 'админ';
	}
	elseif($new_val == 1)
	{
		$rights = 'операционист';
	}
	elseif($new_val == 2)
	{
		$rights = 'пользователь';
	}
	
	//изменение прав доступа пользователя
	$db = @mysql_connect("localhost", "DonZvig", "038942");
	if (!$db) 
	{
		echo "Не удалось подключиться к базе данных";
	}
	else
	{
		//счет точно существует
		mysql_select_db("bank");
		//$forLogin = mysql_query('SELECT `логин` FROM `пользователи` WHERE `id` = "' . $id . '"');
		$forLogin = mysql_query('SELECT * FROM `пользователи` WHERE `логин` = "' . $_SESSION['log'] . '"');
		$count=mysql_num_rows($forLogin );
		//получаем id редактирующего пользователя
		$changedId = mysql_result($forLogin, 0, "id");
		$res=mysql_query('UPDATE  `bank`.`пользователи` SET  `тип` =  "' . $rights . '" WHERE  `пользователи`.`id` ="' . $id . '"');
		mysql_close($db);
		if($res)
		{
			?>
			<script type=text/javascript>
			//alert('<?echo $changedId;?>' + " " + '<?echo $id;?>');
				$("#unical" + '<?echo $id?>').html('Права - <?echo $rights?>');
				$("#richangeButton" + '<?echo $id?>').attr("onClick", "riBut_click(<?echo $id?>,<?echo $new_val?>);");
			</script>
			<?
			if($changedId != $id)
			{
				//UPDATE  `bank`.`операции` SET  `время` =  '2014-06-15 00:00:00' ;
				$date_time = getdate();
				$date_string = 
				$date_time["year"] . "-" . $date_time["mon"] . "-" . $date_time ["mday"] . " "
				. $date_time["hours"] . ":" . $date_time["minutes"] . ":" . $date_time ["seconds"];
				$type_of_operation = 'изменение прав доступа';
				$mess = 'Права доступа изменены на ' . $rights; 
				?><script type=text/javascript>alert('<?echo $date_string;?>');</script><?
				$fes=mysql_query('INSERT INTO `bank`.`операции` VALUES 
				("' . $log . '", "' . $type_of_operation . '", "' . $date_string . '", "' . $bill . '", "' . $mess . '")');
				//{
					//$count = mysql_num_rows($fes);//добавляем сообщение в бд
				//}
			}
		}
	}
?>
<script type=text/javascript>
//alert('<?echo $_POST['userid'] . " * " . $_POST['newval']?>');
</script>