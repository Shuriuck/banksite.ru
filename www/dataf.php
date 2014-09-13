<?
include "session_init.php";
$log = $_SESSION['log'] ;
$db = @mysql_connect("localhost", "DonZvig", "038942"); //проверка: номер счета принадлежит пользователю
if (!$db) 
{
	echo "Не удалось подключиться к базе данных";
}
else
{
	mysql_select_db("bank");
	//выборка счетов пользователя
	$pes=mysql_query('SELECT тип_операции, время, логин_исполнителя, кошелек, описание FROM операции op, пользователи p, счета c WHERE op.кошелек=номер AND p.id=c.user_id AND логин LIKE "' . $log . '"');
	if(isset($pes))
	{
		$count=mysql_num_rows($pes);
		if($count)
		{
			echo "Приветствую, $log. Над вашими считами проводились операции без вашего участия: <br><br>";
			for($i=0;$i<$count; $i++)
			{
				$type=mysql_result($pes, $i, 'тип_операции');
				$time=mysql_result($pes, $i, 'время');
				$purse=mysql_result($pes, $i, 'кошелек');
				$comment=mysql_result($pes, $i, 'описание');
				$bugi=mysql_result($pes, $i, 'логин_исполнителя');
				echo 'тип операции - ' . $type . 
				'<br>время операции - ' . $time . '
				<br>кошелек - ' . $purse .   '
				<br>описание - ' . $comment . '
				<br>операцию выполнил - ' . $bugi . 
				'<br><br>' ;
			}
		}
		else
		{
			echo "Приветствую, $log.";
		}
		
	}
	else
	{
		echo 'Переменная -пес- не установлена';
	}
	mysql_close($db);
}
?>