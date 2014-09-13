<html>

<?
	/*<script type="text/javascript">
<!--
	window.alert("Логин или пароль не верны");
//-->
</script>*/
   if ($_SERVER['REQUEST_METHOD'] == 'POST') 
   {

		if(!($_POST['login'] === "" || $_POST['pas'] === ""))
		{
			$log = trim($_POST['login']);
			$pas = sha1(trim($_POST['pas']));
			$db = @mysql_connect("localhost", "DonZvig", "038942");
			if (!$db) 
			{
				echo "Не удалось подключиться к базе данных";
			}
			else
			{
				
				mysql_select_db("bank");
				$res=mysql_query('SELECT * FROM пользователи p WHERE логин LIKE "%' . $log . '%"');
				if(isset($res))
				{
					$count = mysql_num_rows($res);
					if($count === 0)
					{
						mysql_query ('INSERT INTO  `bank`.`пользователи` (
						`id` ,
						`имя` ,
						`фамилия` ,
						`отчество` ,
						`тип` ,
						`логин` ,
						`пароль` )
						VALUES (NULL ,  0,  0, 0, "пользователь" , "' . $log . '" , "' . $pas . '")');
					}
					
					elseif($count === 1)
					{
						?> 
							<script type="text/javascript">
							<!--
							window.alert("Такой пользователь уже существует");
							//-->
							</script>
						<?
					}
					elseif($count >1)
					{
						?> 
							<script type="text/javascript">
							<!--
							window.alert("АХТУНГ! существует 2 или более одинаковых пользователей");
							//-->
							</script>
						<?
					}

				}
				mysql_close($db);
			}
		}	
		else
		{
			?> 
				<script type="text/javascript">
				<!--
				window.alert("Поля не должны быть пусты");
				//-->
				</script>
			<?
		}

	}
 ?>
<form method="POST" action="<?=$_SERVER['PHP_SELF']?>">
	<table>
		<tr>
			<td>
				Логин
			</td>
			<td>
				<input type="text" name = "login" ><br>
			</td>
		</tr>
		<tr>
			<td>
				Пароль
			</td>
			<td>
				<input type="password" name = "pas">
			</td>
		<tr>
			<th colspan="2">
			<input type="submit" name = "entbut" value="Создать аккаунт">
			</th>
		</tr>
		</tr>
	</table>
</form>
<p align="center">Если у вас уже есть аккаунт, <a href = "enter.php">войдите под своим логином</a></p>
</html>