<?php
include "session_init.php";
//echo 'value logSes:<br>';
//echo $_SESSION['log'];
//изменение прав пользователя админом
//обработка keypress при поиске
//регулярные выражения на текстовых полях
if(isset($_SESSION['log']))
{
	$log = $_SESSION['log'];
	
	$db = @mysql_connect("localhost", "DonZvig", "038942");
	if (!$db) 
	{
		echo "Не удалось подключиться к базе данных";
	}
	else
	{
		mysql_select_db("bank");
		$res=mysql_query('SELECT `тип` FROM пользователи p WHERE логин LIKE "%' . $log . '%"');
		if(isset($res))
		{
			$count = mysql_num_rows($res);
			for ($i=0; $i<$count; $i++)
			{
				$type = mysql_result($res, $i, "тип");
				//echo "<br>$type - тип зарегестрированного пользователя<br>";
			}
			$_SESSION['sestype'] = $type;
			mysql_close($db);
			?>
				<script type="text/javascript">
				<!-- перенапоравление на форму 
				
				location.replace("general.php", {sesT: '<?echo $log;?>'});
				//alert("post in index.php" + '<?$_SESSION['sestype']?>');
				//$.load("general.php");
				//-->		
				</script>
			<?
		}
	}
}
?>
Пожалуйста, <a href = "enter.php"> войдите</a> или <a href = "registr.php"> заригистрируйтесь</a>
<?
	/*echo '<br><br>Roots опер ' . sha1("111f222") . '<br><br>';
	echo 'Asbestov админ ' . sha1("111") . '<br><br>';
	echo 'Opertion_man опер ' . sha1("222") . '<br><br>';
	echo 'zvig польз ' . sha1("333") . '<br><br>';
	echo 'pesssssss польз ' . sha1("444") . '<br><br>';
	echo 'пользователь польз ' . sha1("555") . '<br><br>';*/
?>