<?php
include "session_init.php";
//echo 'value logSes:<br>';
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
			$res=mysql_query('SELECT * FROM пользователи p WHERE логин LIKE "%' . $log . '%" AND пароль LIKE "%' . $pas . '%"');
			if(isset($res))
			{
				$count = mysql_num_rows($res);
				if($count === 0)
				{
					?> 
						<script type="text/javascript">
						<!--
						window.alert("Логин или пароль не верны");
						//-->
						</script>
					<?
				}
				if($count === 1)
				{
					$_SESSION['log'] = trim($_POST['login']);
					//echo $_SESSION['log'];
					?> 
						<script type="text/javascript">
						<!--
						location.replace("index.php");
						//-->		
						</script>
					<!--Вы успешно авторизированы. Кликните <a href"">Ок</a> для перехода на главную страницу сайта-->
					<?
				}
				elseif($count > 1)
				{
					?> 
						<script type="text/javascript">
					
						window.alert("АХТУНГ! существует 2 или более одинаковых пользователей");
						
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
 <style type = "text/css">
.butt {
  display: inline-block;
  color: white;
  text-decoration: none;
  padding: .5em 2em;
  outline: none;
  border-width: 2px 0;
  border-style: solid none;
  border-color: #FDBE33 #000 #D77206;
  border-radius: 6px;
  background: linear-gradient(#F3AE0F, #E38916) #E38916;
  transition: 0.2s;
} 
.butt:hover { background: linear-gradient(#f5ae00, #f59500) #f5ae00; }
.butt:active { background: linear-gradient(#f59500, #f5ae00) #f59500; }
</style>
<form method="POST" action="<?=$_SERVER['PHP_SELF']?>">
	<table>
		<tr>
			<td>
				
			<td>
		</tr>
		<tr>
			<td>
				<input type="submit" name = "entbut" value="Войти" class = "butt">
			<td>
		<tr>
			<td>
				<input type="text" name = "login" >
			<td>
			<td>
				Логин
			<td>
		</tr>
		<tr>
			<td>
				<input type="password" name = "pas">
			<td>
			<td>
				Пароль
			<td>
		</tr>
	</table>
</form>
Если у вас нет аккаунта, <a href = "registr.php">зарегистрируйтесь</a>