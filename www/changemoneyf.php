<?
include "session_init.php";
if($_POST['admin'])
{
	?>
		<script type=text/javascript>
		//document.write(<?$_POST['admin']?>);
		$("#bill").val(<?echo $_POST['bill'];?>);
		</script>
	<?
}
?>
<?
$db = @mysql_connect("localhost", "DonZvig", "038942"); //проверка: номер счета принадлежит пользователю
if (!$db) 
{
	echo "Не удалось подключиться к базе данных";
}
else
{
	mysql_select_db("bank");
	//выборка счетов пользователя
	$pes=mysql_query('SELECT номер, валюта, сумма, активность FROM счета c, пользователи p WHERE  c.user_id=p.id AND логин LIKE "%' . $_SESSION['log'] . '%"');
	if(isset($pes))
	{
		$pcount = mysql_num_rows($pes);
		if(!$pcount && $_SESSION['sestype'] == 'пользователь')//счетов нету
		{
			echo 'У пользователя нету кошельков.<br>';
		}
		else//пилим ниспадающий список со считами
		{
			echo//здесь начинаем описание формы 
			"
				<br><input type='button' name = 'add' value='Изменить тип валюты' class = 'butt' id = 'butt'> <br>
				Введите номер счета
				<table>
					<tr>
						<td>
			";
			if($_SESSION['sestype'] == 'пользователь')//пользователь
			{
				echo "<select class = 'selectArea' id = 'bill'>";
				for($j=0;$j<$pcount;$j++)
				{
					$pu = mysql_result($pes, $j, "номер");
					//$type = mysql_result($pes, $j, "валюта");
					echo "<option value = " . $pu . " id = " . $pu . ">" . $pu . " " . $type .  "</option>";
				}
				 //echo "</option> Валюта<br>Номер";
			}
			else
			{
				echo '<input type="text" name = "bill" id = "bill"> Номер';
			}
			echo
			"
					</td>
				</tr>
				</table>
				<br>
				<form>
					<input type='radio' name='answer' value = '1' id = 'Рубли' checked>Рубли
					<input type='radio' name='answer' value = '2' id = 'Доллары'>Доллары
					<input type='radio' name='answer' value = '3' id = 'Евро'>Евро
				</form>
				Внимание, при переводе счета в другой тип валюты взымается комиссия 1%, но не более 1000 р или эквивалента по куртсу.
			";
		}
	}
	mysql_close($db);
}
?> 	
<script type=text/javascript>
$("#butt").click(function()
{
//alert($('input[type=radio]:checked').val());
	var new_val = $('input[type=radio]:checked').val();
	$("#data").load("changemoney.php", {bill: $("#bill").val(), val: new_val, log: '<?echo $_SESSION['log'];?>'});
}
);
$("#bill").on('keyup', function(){
    $(this).val($(this).val().replace (/\D/, ''));
});
</script>
