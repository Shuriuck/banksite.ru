<?
//header('Content-Type: text/html; charset=UTF-8');
include "session_init.php";
//session_start();
$request = $_POST['text']; 
$db = @mysql_connect("localhost", "DonZvig", "038942");
if (!$db) 
{
	echo "Не удалось подключиться к базе данных";
}
else
{
	
	mysql_select_db("bank");
	$res=mysql_query('SELECT * FROM пользователи p WHERE 
	имя LIKE "%' . $request . '%" 
	OR фамилия LIKE "%' . $request . '%"
	OR отчество LIKE "%' . $request . '%"
	OR логин LIKE "%' . $request . '%"');
	if(isset($res))
	{
		$count = mysql_num_rows($res);
		echo "Результов поиска $count:<br><hr><br>";
		//echo "Количество записей $count <br>";
		for ($i=0; $i<$count; $i++)
		{
			$name = mysql_result($res, $i, "имя");
			$surname = mysql_result($res, $i, "фамилия");
			$otch = mysql_result($res, $i, "отчество");
			$login = mysql_result($res, $i, "логин");
			$ri = mysql_result($res, $i, "тип");
			$id = mysql_result($res, $i, "id");
			//Тут какая-то ошибка с заголовками, js не понимает текстовые строки, чтото с кодировками... с ajaxs перемудрили...
			//костыль для передачи информации о конкретном пользователе
			if($ri == 'админ')
			{
				$num = 0;
			}
			elseif($ri == 'операционист')
			{
				$num = 1;
			}
			elseif($ri == 'пользователь')
			{
				$num = 2;
			}
			else
			{
				$num = -1;
			}
			/*?>
				<script type=text/javascript>
					rights = '<?echo 111?>'
				</script>
			<?*///сохраняем в глобальной js переменной
			echo "Имя - $name<br> Фамилия - $surname<br> Отчество - $otch <br> Логин - $login <br>";
			//ниспадающий список для изменения типа пользователя
			if($_SESSION['sestype'] == 'админ')//отображаем только если сессия администратора
			{
				echo "
					<table>
						<tr>
							<td>
								<p id = unical$id>Права - $ri<p></td>
							<td>    ";
				echo "<select id = 'riSelect$id'>";//уникальный id для кждого пользователя
				echo "<option name=админ value = 0>админ</option>";
				echo "<option name=операционист value = 1>операционист</option>";
				echo "<option name=пользователь value = 2>пользователь</option>";
				echo "</option></td><td>";
				//echo "<input type='button' name = '$login' value='Поменять права доступа' class = 'hide_oper' id = 'riChbutton' onClick='riBut_click('$login');'>"
				//echo '<input type="button" name = ' . $login . ' value="Поменять права доступа" class = "hide_oper" id = ' . $login . ' onClick="riBut_click(' . $login . ');">';
				///функция почему-то не принемает текстовые поля, так и не понял почему, передаю в нее id и на обработку
				echo '<input type="button" name = richangeButton value="Поменять права доступа" class = "hide_oper" id = richangeButton' . $id . ' onClick="riBut_click(' . $id . ',' . $num . ');">';
				echo
				"
				</td>
					</tr>	
				</table>
				";
			}
			else
			{
				echo "Права - $ri<br>";
			}
			//---------------------------------------------------
			$pes = mysql_query('SELECT * FROM пользователи p, счета c WHERE p.id=c.user_id AND логин LIKE "%' . $login . '%" ');
			if(isset($pes))
			{
				$pcount = mysql_num_rows($pes);
				if($pcount)
				{
					echo 'Кошельки:<br><ol>';
				}
				else
				{
					echo 'У пользователя нету кошельков.<br>';
				}
				for($j=0;$j<$pcount;$j++)
				{
					$pu = mysql_result($pes, $j, "номер");
					$du = mysql_result($pes, $j, "активность");
					$bal = mysql_result($pes, $j, "сумма");
					$type = mysql_result($pes, $j, "валюта");
					$button_freez;
					if($du)
					{
						$button_freez = '<input type="button" name = ' . $pu . ' value="Заморозить во славу шурика" class = "hide_oper" id = ' . $pu . ' onClick="bfreez_click(' . $pu . ');">';
					}		
					else
					{
						$button_freez = '<input type="button" name = ' . $pu . ' value="Разморозить во славу шурика" class = "hide_oper" id = ' . $pu . ' onClick="bfreez_click(' . $pu . ');">';
					}			
					$button_inc = '<input type="button" name = ' . $pu . ' value="Пополнить счет" 			class = "butt" id = "inc" 	onClick="binc_click(' . $pu . ');">';
					$button_chn = '<input type="button" name = ' . $pu . ' value="Изменение типа валюты" 	class = "butt" id = "change"onClick="bcng_click(' . $pu . ');">';
					$button_dec = '<input type="button" name = ' . $pu . ' value="Снять со счета" 			class = "butt" id = "dec" 	onClick="bdec_click(' . $pu . ');">';
					echo "<li>кошелек: 
					<table>
					<tr><td>№ $pu</td></tr>
					<tr>
						<td>
							Сумма: $bal
						</td>
						<td>
							$button_inc $button_dec $button_chn $button_freez 
						</td>
					</tr>
					<tr><td>Валюта: $type</td></tr>
					<tr><td id = freeze$pu>Активность: $du</td></tr>
					</table><br><br>";
				}
			?></ol><br><hr><br>
			<?
			}
		}
	}	
	mysql_close($db);
}
?>
<script type=text/javascript>
<!-- 
function bfreez_click(a){
	//alert('<?echo $_SESSION['log'];?>');
	$("#" + a).load('freeze.php', {seach: $("#seachText").val(), bill: a, log: '<?echo $_SESSION['log'];?>'});
}
function binc_click(a){
   //switch (event.type) {
  // case "onClick":
		//document.write(a);
		$("#data").load('addmoneyf.php', {admin: 1, bill: a});
		//break;
	//}
}
function bdec_click(a){
   //switch (event.type) {
  // case "onClick":
		//document.write(a);
		$("#data").load('refmoneyf.php', {admin: 1, bill: a});
		//break;
	//}
}
function bcng_click(a){
   //switch (event.type) {
  // case "onClick":
		//document.write(a);
		$("#data").load('changemoneyf.php', {admin: 1, bill: a});
		//break;
	//}
}
//id пользователя и  num текущих прав
function riBut_click(a,b){
	//уникальный id комбобокса
   if($("#riSelect" + a).val() == b)
   {
		alert("Пользователь уже имеет этот уровень допуска");
   }
   else
   {
		$("#richangeButton" + a).load('update_user_type.php', {userid: a, newval: $("#riSelect" + a).val(), log: '<?echo $_SESSION['log'];?>'})//чтобы не обновлять все окно 
   }
}

//-->
</script>