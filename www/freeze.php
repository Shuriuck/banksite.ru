<?include "session_init.php";?>
<?
	$bill = $_POST['bill'];
	$rights = $_SESSION['sestype'] == 'пользователь';
	$log = $_POST['log'];
	$db = @mysql_connect("localhost", "DonZvig", "038942"); //проверка: заморожен ли кошелек
	if (!$db) 
	{
		echo "Не удалось подключиться к базе данных";
	}
	else
	{
		//счет точно существует
		mysql_select_db("bank");
		$flag = mysql_query('SELECT `активность` FROM `счета` WHERE номер ="' . $bill . '"');
		$countR=mysql_num_rows($flag);		
		for ($i=0; $i<$countR; $i++)
		{
			$active = mysql_result($flag, $i, "активность");
		}
		$res=mysql_query('UPDATE  `bank`.`счета` SET  `активность` =  "' . !$active . '" WHERE  `счета`.`номер` ="' . $bill . '" AND `активность` = "' . $active . '"');
		mysql_close($db);
	}
	
	//сообщение об операции
	
	if(!$active)
	{
		$new_val = "Заморозить ";
	}
	else
	{
		$new_val = "Разморозить ";
	}
	?>
	<script type=text/javascript>
		$("#" + <?echo $bill;?>).val("<?echo $new_val;?>" + "во славу шурика");
		$("#freeze" + <?echo $bill;?>).html('Активность:' + 
											'<?if(!$active)echo 1;else echo 0;?>');
	</script>
	<?
	?>
	<script type=text/javascript>
	//$("#data").load('seachresult.php', {text: $("#seachText").val()});
	</script>
	<?
	?><script type=text/javascript>//window.alert("<?echo $bill . "Счет был заморожен + кнопка" + $_POST['id']?>")</script><?
	//$("#data").load('seachresult.php', {text: $("#seachText").val()});
?>