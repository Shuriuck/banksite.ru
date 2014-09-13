<?
include "session_init.php";
include "changemoneyf.php";
function rub_komis($rub) {
	if($rub*0.99<=1000)
	{
		return $rub*=0.99;
	}
	else
	{
		return $rub-=1000;
	}
}
function convert($type_bablo,$new_val,$summa_babla){
	$bakstorub = 34.32;
	$eurotorub = 46.48;
	//echo "<br>type " . $type_bablo;
	//echo "<br>newType " . $new_val;
	if($type_bablo!="рубли")
	{
		if ($type_bablo=="доллары")
		{
			if($new_val == "рубли")
			{
				$summa_babla*=$bakstorub;
				return $summa_babla = rub_komis($summa_babla);
			}
			if($new_val == "евро")
			{
				$summa_babla*=$bakstorub;
				$summa_babla = rub_komis($summa_babla);
				return $summa_babla/=$eurotorub;
			}
		}
		if ($type_bablo=="евро")
		{
			if($new_val == "рубли")
			{
				//echo "<br>было евро " . $summa_babla;
				$summa_babla*=$eurotorub;
				//echo "<br>перевели в рубли " . $summa_babla;
				return rub_komis($summa_babla);
			}
			if($new_val == "доллары")
			{
				$summa_babla*=$eurotorub;
				$summa_babla = rub_komis($summa_babla);
				return $summa_babla/=$bakstorub;
			}
		}
	}
	else//изначальная валюта рубли
	{
		//echo "<br>было рублей " . $summa_babla;
		$summa_babla = rub_komis($summa_babla);
		//echo "<br>рублей " . $summa_babla;
		if($new_val == "доллары")
		{
			return $summa_babla/=$bakstorub;
		}
		if($new_val == "евро")
		{
			return $summa_babla/=$eurotorub;
		}
	}
}
?>
<script type=text/javascript>
$(document).ready(function()
{
	<? //$new_mess = $mess?>
	$("#bill").val('<?echo $_POST['bill']?>');
	//$("#money").val('<?echo $_POST['money']?>');
}
);
</script>

<?
$rights = $_SESSION['sestype'] == 'пользователь';
$bill = $_POST['bill'];//номер счета
$log = $_POST['log'];
//на какой тип валюты меняем
switch ($_POST['val']) {
    case 1:
        $new_val = 'рубли';
        break;
    case 2:
        $new_val = 'доллары';
        break;
    case 3:
        $new_val = 'евро';
        break;
}
$log = $_SESION['log'];//логин+- 2
?> 
	<script type="text/javascript">
	<!--
	jsVal = '<?echo $new_val?>';
	$("#" + jsVal).prop('checked', true);
	//alert('<?echo $new_val?>');
	//-->
	</script>
<?
//=================================================================================================================================================================
$db = @mysql_connect("localhost", "DonZvig", "038942"); //Изменение валюты
if (!$db) 
{
		echo "Не удалось подключиться к базе данных";
}
else
{
	$bakstorub = 34.32;
	$eurotorub = 46.48;
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
	//$res=mysql_query('SELECT `валюта`, `сумма` FROM `bank`.`счета`WHERE  `номер` = "' . $bill . '"');
	$res=mysql_query('SELECT * FROM счета c WHERE номер LIKE  "%' . $bill . '%"');
	if(isset($res))
	{
		$count = mysql_num_rows($res);
		if($count == 0)
		{
			?><script type=text/javascript>window.alert("Такого счета не существует")</script><?
		}
		elseif($message && $rights)//счет не припринадлежит этому пользователю и это обычный пользователь
		{
			?><script type=text/javascript>window.alert("Этот счет вам не принадлежит")</script><?
		}
		elseif ($count == 1)
		{
				for ($i = 0; $i<$count; $i++)
				{
					$type_bablo=mysql_result($res, $i, "валюта");
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
					elseif($type_bablo==$new_val)
					{
						?><script type=text/javascript>window.alert("Кошелек уже имеет этот тип валюты")</script><?
					}
					else
					{
						$summa_babla=mysql_result($res, $i, "сумма");
						//echo "<br>Хранится значение: " . $summa_babla . " бакинских рублей";
						$summa_babla = convert($type_bablo,$new_val,$summa_babla);
						//echo "<br>Получилось значение: " . $summa_babla;
						$des=mysql_query('UPDATE `счета` SET  `валюта` =  "' . $new_val . '", `сумма` = "' . $summa_babla . '" WHERE `номер`= "' . $bill . '"');
						?><script type=text/javascript>window.alert("Тип валюты изменен")</script><?
						if(message&&!$rights&&$active)
						{
							//добавляем сообщение в бд
							//UPDATE  `bank`.`операции` SET  `время` =  '2014-06-15 00:00:00' ;
							$date_time = getdate();
							$date_string = 
							$date_time["year"] . "-" . $date_time["mon"] . "-" . $date_time ["mday"] . " "
							. $date_time["hours"] . ":" . $date_time["minutes"] . ":" . $date_time ["seconds"];
							$type_of_operation = 'Изменение валюты кошелька';
							$mess = 'Изменен тип валюты. Предыдущий тип :' . $type_bablo . '. Изменен на ' . $new_val . ' .Текущее состояние счета: ' . $summa_babla . 
							'<br>При операции была взята комиссия'; 
							$log = $_POST['log'];
							$fes=mysql_query('INSERT INTO `bank`.`операции` VALUES 
							("' . $log . '", "' . $type_of_operation . '", "' . $date_string . '", "' . $bill . '", "' . $mess . '")');
							//{
								//$count = mysql_num_rows($fes);//добавляем сообщение в бд
							//}
						}
					}
				}
		}

	}
	else
	{
		?><script type=text/javascript>window.alert("Такого счета не существует")</script><?
	}
	mysql_close($db);
}
//=================================================================================================================================================================
/*
$user;//условие, пользователь или админ

if($user)
{
	$self;//уславия, пренадлежит ли кошелек пользователю
	if($self)
	{
		$ch;//условие, другой ли тип валюты
		if($ch)
		{
		
		}
		else//кошелек уже имеет этот тип валюты
		{
			?><script type=text/javascript>//window.alert("Кошелек уже имеет этот тип валюты")</script><?
		}
	}
	else//сообщение об ошибке
	{
		?><script type=text/javascript>//window.alert("У выс нету номера с таким счетом")</script><?
	}
}
else//не пользователь, может работать со всеми счетами
{
	$exist;//существуетли счет
	if($exist)
	{
		$ch;//условие, другой ли тип валюты
		if($ch)
		{
		
		}
		else//кошелек уже имеет этот тип валюты
		{
			?><script type=text/javascript>//window.alert("Кошелек уже имеет этот тип валюты")</script><?
		}
	}
	else//ошибка
	{
		?><script type=text/javascript>//window.alert("Такого счета не существует")</script><?
	}
}
*/

?>
<script type=text/javascript>
//window.alert('<?echo $_POST['money'];?>');
</script>

