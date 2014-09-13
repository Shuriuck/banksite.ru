<?
include "session_init.php";
//база данных должны быть инициализированна и подключина 
function purseGenerator($log)
{	
	$db = @mysql_connect("localhost", "DonZvig", "038942");
	if (!$db) 
	{
		return -1;
	}
	else
	{
		mysql_select_db("bank");
		$max = 99999999999999;//если вы читаете этот коментарий, вам пора поспать, вы слишком много кодили
		while(true)
		{
			$new_pur = rand(0,$max);//генерируем случайный номер и проверяем на совпадения
			$pes=mysql_query('SELECT номер FROM счета c WHERE  номер ="' . $new_pur . '"'); //существует ли счет
			if(isset($pes))
			{
				$count=mysql_num_rows($pes);
				if($count == 0)
				{
					break;
				}
			}
			else
			{
				return -1;//ошибка подключения к бд
			}
		}
		mysql_close($db);
		return $new_pur;
	}
}
function createPurse($val, $type, $log)
{
	//echo $val . " " . $type . " " . $log . "<br>";
	$new_pur = purseGenerator($log);//функция генерирует уникальный номер создаваемого счета
	$db = @mysql_connect("localhost", "DonZvig", "038942");
	if (!$db) 
	{
		echo "Не удалось подключиться к базе данных";
	}
	else
	{
		mysql_select_db("bank");
		//получаем id пользователя
		$nes=mysql_query('SELECT * FROM пользователи WHERE логин ="' . $log . '"');
		$count=mysql_num_rows($nes);
		for ($i=0; $i<$count; $i++)
		{
			$id_for_user=mysql_result($nes, $i, 'id');
			//echo "<br>id_user" . $id_for_user;
		}
		$res=mysql_query(	'INSERT INTO  `bank`.`счета` (`user_id` ,`номер` ,`валюта` ,`сумма` ,`активность`)	
							VALUES ("' . $id_for_user . '",  "' . $new_pur . '",  "' . $type . '",  "' . $val . '",  "1")');//заполнение полей "счета"
		mysql_close($db);
	}
}
?>
<script type=text/javascript>
$("#valPure").on('keyup', function(){
    $(this).val($(this).val().replace (/\D/, ''));
});
$("#addPurse").click(function()
{
	//alert(exist);
	if(exist)// кошельки есть
	{
		$("#data").load("pursef.php", {flag: true})
	}
	else//кошельков нету, перенаправление на форму ввода дополнительной информацмм
	{
		$("#data").load('enterdata.php');
	}
}
);
$("#creaatePure").click(function()
{
	$("#data").load("pursef.php", {create: true, val: $("#valPure").val() ,type: $("#typePure").val(), log: '<?echo $_SESSION['log']?>'});
}
);
</script>
<?
$log = $_POST['log'];//логин+- 2
$flag = $_POST['flag'];
$create = $_POST['create'];
if($create)//создаем новый счет
{
	createPurse($_POST['val'], $_POST['type'],$log);
}
if($flag)//форма нового счета
{
	echo '<input type= "text" name = "valPure" id = "valPure"> Количество средств<br>';
	echo "<select id = 'typePure'>";
	echo "<option name=cash1 value = рубли>рубли</option>";
	echo "<option name=cash2 value = доллары>доллары</option>";
	echo "<option name=cash3 value = евро>евро</option>";
	echo "</option> Валюта<br>";
	echo '<input type="button" name = "createPure" value="Создать" class = "butt" id = "creaatePure"><br>';
}//--> Сюда попадаем при жмаканье по "кошельки" и создания нового счета
else
{
	$db = @mysql_connect("localhost", "DonZvig", "038942"); //проверка: номер счета принадлежит пользователю
	if (!$db) 
	{
		echo "Не удалось подключиться к базе данных";
	}
	else
	{
		mysql_select_db("bank");
		$pes=mysql_query('SELECT номер, валюта, сумма, активность FROM счета c, пользователи p WHERE  c.user_id=p.id AND логин LIKE "%' . $log . '%"');
		if(isset($pes))
		{
			$pcount = mysql_num_rows($pes);
			echo '<input type="button" name = "addPurse" value="Создать новый кошелек" class = "butt" id = "addPurse"><br>';
			?><script type=text/javascript>exist = true</script><?
			if(!$pcount)
			{
				echo 'У пользователя нету кошельков.<br>';
				?><script type=text/javascript>exist = false</script><?
			}
			echo "<ol>";
			for($j=0;$j<$pcount;$j++)
			{
				$pu = mysql_result($pes, $j, "номер");
				$du = mysql_result($pes, $j, "активность");
				$bal = mysql_result($pes, $j, "сумма");
				$type = mysql_result($pes, $j, "валюта");
				echo "<li>кошелек: 
				<table>
				<tr>
					<td>№ $pu</td>
				</tr>
				<tr>
					<td>
						Сумма:  $bal
					</td>
				<tr><td>Валюта:  $type</td></tr>
				<tr><td>активность:  $du</td></tr>
				</table><br><br></li>";
			}
			echo '</ol>';
			
		}
	mysql_close($db);
	}
}
?>