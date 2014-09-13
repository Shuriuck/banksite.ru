<?php
$db = @mysql_connect("localhost", "DonZvig", "038942"); //проверка: заморожен ли кошелек
if (!$db) 
	{
		echo "Не удалось подключиться к базе данных";
	}
else
{
	if($rights)
	{

		mysql_select_db("bank");
		$res=mysql_query('UPDATE  `bank`.`счета` SET  `активность` =  1 WHERE  `счета`.`номер` ="' . $bill . '" AND `активность` = 0');
		if(isset($res))
		{
			$count = mysql_num_rows($res);
			if ($count == 1)
			{
				for ($i=0; $i<$count; $i++)
					{
						$new_val = mysql_result($res, $i, "сумма");
					}
			}
			else
			{
				$res=mysql_query('UPDATE  `bank`.`счета` SET  `активность` =  0 WHERE  `счета`.`номер` ="' . $bill . '" AND `активность` = 1');
				$count = mysql_num_rows($res);
			}
			mysql_close($db)
		}
	}
}
?>
<?php
$db = @mysql_connect("localhost", "DonZvig", "038942"); //Изменение валюты
if (!$db) 
	{
		echo "Не удалось подключиться к базе данных";
	}
else
{
	$bakstorub = 34,32;
	#$bakstoeuro = 0.74;
	#$eurotobaks = 1.35;
	$eurotorub = 46.48;
	#$rubtobaks = 0.03;
	#$rubtoeuro = 0.02;
	mysql_select_db("bank");
	$res=mysql_query('SELECT  `bank`.`счета`, `bank`.`валюта`, `bank`.`сумма` WHERE  `номер` =  "' . $bill . '"');
	if(isset($res))
	{
		$count = mysql_num_rows($res);
		if ($count == 1)
		{
			for ($i, $i<$count, $i++)
			{
				$type_bablo=mysql_result($res, $i, "валюта");
				if ($type_bablo==$new_val)
				{
					//уже этого типа
				}
				else
				{
					$summa_babla=mysql_result($res, $i, "сумма");
					convert($type_bablo,$new_val,$summa_babla);
				}
			}
			//$money=$money*$????????*0.99;
			//$res=mysql_query('UPDATE  `bank`.`счета`, `bank`.`сумма` SET  `валюта` =  "' . $new_val . '", `bank`.`сумма`= "' . $ . '" WHERE  `счета`.`номер` ="' . $bill . '"');
		}
		else
		{
		
		}
		mysql_close($db)
	}
}
?>
<input type="button" name="richangeButton" value="Поменять права доступа" class="hide_oper" id="richangeButton8" onclick="riBut_click(8,0);">
<input type="button" name="richangeButton" value="Поменять права доступа" class="hide_oper" id="richangeButton8" onclick="riBut_click(8,0);"></input>