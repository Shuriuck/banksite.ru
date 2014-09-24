<?
	include "session_init.php";
?>
<script src=jquery-2.0.2.min.js type=text/javascript></script>
<script type=text/javascript>
$(document).ready(function()
{
		//$("#ForComboBox").load('ComboboxForFloor.php', {Number: 1});
		//$("#ForComboBox1").load('ComboboxForFloor1.php', {Nomer: 1});
		$("#menu").load('menuf.php', {sesT: '<?echo $_POST['sesT'];?>'});
		$("#seach").load('seachf.php');
		$("#data").load('dataf.php');
		//$(Cell).load("Create_table.php",{Number: 1});
}
);
</script>
<script type=text/javascript>
$(function()
{
		$("#ComboboxForFloor").change(function()
		{
			var Floor1=$(this).val();
			$("#ForComboBox").load('ComboboxForFloor.php', {Number: Floor});
		}
		)
		$("#ComboboxForFloor1").change(function()
		{
			var Floor1=$(this).val();
			$("#ForComboBox").load('ComboboxForFloor.php', {Nomer: Floor});
		}
		)
}
).change();
</script>

<style>
<?
	if($_SESSION['sestype'] == 'пользователь')
		echo '.hide_user{visibility: hidden;}';
		echo '.hide_operSelect{visibility: hidden;}';
	if($_SESSION['sestype'] == 'операционист')
		echo '.hide_oper{visibility: hidden;}';
		echo '.hide_operSelect{visibility: hidden;}';
?>
.hide_oper {
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
.hide_oper:hover { background: linear-gradient(#f5ae00, #f59500) #f5ae00; }
.hide_oper:active { background: linear-gradient(#f59500, #f5ae00) #f59500; }
.vline{border-right-style: solid;}
</style>

<table cellpadding=20 cellspacing = "0" width=100% height=100%>
	<tr>
		<td width="20%" rowspan = "2" align="center" valign="top" id = "menu" class = "vline">
		
		</td>
		<td height="12%" id = "seach" class = "hide_user">
		
		</td>
	</tr>
	<tr>
		<td id = "data" height="100%" align="left" valign = "top">
		
		</td>
	</tr>
</table>