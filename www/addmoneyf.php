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
	//в этом месте выводим текстовое поле или combobox с номерами для пользователя

	//ниспадающий список со счетами
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
				echo 
				"
				<form method='POST' action= " . $_SERVER['PHP_SELF'] . ">
					<table>
						<tr>
							<td>
								
							<td>
						</tr>
						<tr>
							<td>
								<input type='button' name = 'add' value='Пополнить' class = 'butt' id = 'add'>
							<td>
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
					echo "</option> Валюта<br>";
				}
				else
				{
					echo '<input type="text" name = "bill" id = "bill">';
				}
				echo 
				"
							<td>
						<td>
							Счет
						<td>
					</tr>
					<tr>
						<td>
							<input type='text' name = 'money' id = 'money'>
						<td>
						<td>
							Количество денег
						<td>
					</tr>
				</table>
			</form>
			";
			}
		}
		mysql_close($db);
	}
?>
<?
/*if($_POST['showmess'])
{
?> 
	<script type="text/javascript">
	<!--
	$("#money").val('<?echo $_POST['money']?>');
	$("#bill").val('<?echo $_POST['bill']?>');
	window.alert('<?echo $_POST['message']?>');
	//-->
	</script>
<?
}*/
?>
<script type=text/javascript>
$("#add").click(function()
{
	$("#data").load('addmoney.php', {money: $("#money").val(), bill: $("#bill").val(),log: '<?echo $_SESSION['log'];?>'});
}
);
$("#money").on('keyup', function(){
    $(this).val($(this).val().replace (/\D/, ''));
});
$("#bill").on('keyup', function(){
    $(this).val($(this).val().replace (/\D/, ''));
});
</script>