<?
include "session_init.php";
echo 'Привет, ' . $_SESSION['log'] . '<br> Ваши права: ' . $_SESSION['sestype'] . '<br><a href = "destroy_session.php">Выйти</a><br>' ;
?><br><br><br>
<script type=text/javascript>
$("#purse").click(function()
{
	$("#data").load('pursef.php', {log: '<?echo $_SESSION['log']?>'});
	//$("#data").load('refmoney.php', {money: $("#money").val(), bill: $("#bill").val()});
}
);
$("#inc").click(function()
{
	$("#data").load('addmoneyf.php', {sesT: '<?echo $_SESSION['sestype'];?>'});
}
);
$("#dec").click(function()
{
	$("#data").load('refmoneyf.php');
}
);
$("#change").click(function()
{
	$("#data").load('changemoneyf.php');
}
);
</script>
<style>
/*кнопка*/
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
<input type="button" name = "purse" value="Кошельки" class = "butt" id = "purse"><br>
<input type="button" name = "inc" value="Пополнить счет" class = "butt" id = "inc"><br>
<input type="button" name = "dec" value="Снять со счета" class = "butt" id = "dec"><br>
<input type="button" name = "entbut" value="Изменение типа валюты" class = "butt" id = "change"><br>