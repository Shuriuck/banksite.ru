<?
include "session_init.php";
include "addmoneyf.php";
?>
<script type=text/javascript>
$(document).ready(function()
{
	<? //$new_mess = $mess?>
	$("#bill").val('<?echo $_POST['bill']?>');
	$("#money").val('<?echo $_POST['money']?>');
}
);
</script>
<?
$rights = $_SESSION['sestype'] == 'пользователь';
$bill = $_POST['bill'];//номер счета
$money = $_POST['money'];//на сколько пополнить
$log = $_POST['log'];//логин
$db = @mysql_connect("localhost", "DonZvig", "038942"); //проверка: номер счета принадлежит пользователю
if (!$db) 
	{
		echo "Не удалось подключиться к базе данных";
	}
else
{
	mysql_select_db("bank");
	$pes=mysql_query('SELECT * FROM счета c, пользователи p WHERE  c.user_id=p.id AND `номер` = "' . $bill . '" AND логин LIKE "%' . $log . '%"');//Проверка, редактирует ли пользователь СВОЙ счёт
	$count_pes=mysql_num_rows($pes);
	if ($count_pes==0)//счет не принадлежит редактирующему пользователю или не существует
	{
		$message = true;
	}
	else
	{
		$message = false;
	}
	$res=mysql_query('SELECT * FROM счета c WHERE номер LIKE  "%' . $bill . '%"');
	if(isset($res))
	{
		$count = mysql_num_rows($res);
		//echo "число записей" . $count;
		if($count == 0)
		{
			?><script type=text/javascript>window.alert("Такого счета не существует")</script><?
		}
		elseif($message && $rights)//счет не припринадлежит этому пользователю и это обычный пользователь
		{
			?><script type=text/javascript>window.alert("Этот счет вам не принадлежит")</script><?
		}
		elseif($count == 1)
		{
			for ($i=0; $i<$count; $i++)
			{					
				$old_val = mysql_result($res, $i, "сумма");
				$active=mysql_result($res, $i, "активность");
				if(!$active)
				{
					if($_SESSION['sestype']!='админ')
					{
						?><script type=text/javascript>window.alert("Данный счет заморожен. Обратитесь к администратору за подробностями.")</script><?
					}
					else
					{
						?><script type=text/javascript>window.alert("Данный счет заморожен. Для редактирования его необходимо разморозить.")</script><?
					}
				}
				else
				{
					$new_val= $old_val + $money;
					$test = new MyClassTest();

					$pes=mysql_query('UPDATE  `bank`.`счета` SET  `сумма` =  "' . $new_val . '" WHERE  `счета`.`номер` = "' . $bill . '"');
					?><script type=text/javascript>window.alert("Счет успешно пополнен")</script><?
					echo "<p>test information:<p>";
					$old_val = $new_val;
					$res = $test->testAdd($old_val, $new_val);
					echo $res;
				}
			}
			if(message&&!$rights&&$active)//сообщение пользователю
			{
				//UPDATE  `bank`.`операции` SET  `время` =  '2014-06-15 00:00:00' ;
				$date_time = getdate();
				$date_string = 
				$date_time["year"] . "-" . $date_time["mon"] . "-" . $date_time ["mday"] . " "
				. $date_time["hours"] . ":" . $date_time["minutes"] . ":" . $date_time ["seconds"];
				$type_of_operation = 'пополнение';
				$mess = 'Зачисление на счет. Текущее состояние счета: ' . $new_val; 
				$fes=mysql_query('INSERT INTO `bank`.`операции` VALUES 
				("' . $log . '", "' . $type_of_operation . '", "' . $date_string . '", "' . $bill . '", "' . $mess . '")');
				//{
					//$count = mysql_num_rows($fes);//добавляем сообщение в бд
				//}
			}
		}
		else
		{
			?><script type=text/javascript>window.alert("У выс нету номера с таким счетам")</script><?
		}
		mysql_close($db);
	}	
	//$request = '';//запрос на пополнение счета
	else//это не пользователь, разрешены операции над всеми счетами
	{
		?><script type=text/javascript>window.alert("Такого счета не существует")</script><?
	}
}

?>
<script type=text/javascript>
//window.alert('<?echo $_POST['money'];?>');
</script>
