<?
include "session_init.php";
function enterDatas($surname,$name,$otc,$log)
{
	//echo "$surname $name $otc $log";
	$db = @mysql_connect("localhost", "DonZvig", "038942"); //Занос в базу имя\фамилия\отчество
	if (!$db) 	
	{
		echo "Не удалось подключиться к базе данных";
	}
	else
	{
		mysql_select_db("bank");
		mysql_query ('UPDATE  `bank`.`пользователи` SET  `имя`="' . $name . '",  `фамилия`="' . $surname . '", `отчество`= "' . $otc . '" WHERE  `логин` LIKE "' . $log . '"');
		mysql_close($db);
	}
	?>
	<script type=text/javascript>
	//alert("we here!");
	$("#data").load("pursef.php", {flag: true, log: '<?echo $log?>'})
	</script><?//перенаправляем в модуль генерации кошелька
}
?>
<script type=text/javascript>
$(document).ready(function(){
	//flag = false;
}
);
$("#enterData").click(function()
{
	//flag = true;
	$("#data").load('enterdata.php', {surname: $("#surname").val(), name: $("#name").val(), otc: $("#otc").val(), flag: true});//отправляем на сервер данные пользователя
	//вызываем функцию заполнения базы данных
}
);
</script>
<?
$log = $_SESSION['log'];
$flag =  $_POST['flag'];
if($flag) //добавляем данные, перенаправляем на модуль создания кошелька
{
	enterDatas($_POST['surname'],$_POST['name'],$_POST['otc'],$log);
}
else
{
	echo "Уважаемый $log, для создания кошелька необходимо ввести дополнительную информацию о себе:<br>";
	echo 	"<input type = 'text' id = 'surname'> Фамилия<br>
			<input type = 'text' id = 'name'> Имя<br>
			<input type = 'text' id = 'otc'>Отчество
	";
	echo '<br><input type="button" name = "enterData" value="Подтвердить" class = "butt" id = "enterData"><br>';
}
?>