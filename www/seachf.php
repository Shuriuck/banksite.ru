<?header('Content-Type: text/html; charset=UTF-8');?>
<script type=text/javascript>
$("#seachButt").click(function()
{
	//document.write(seachText);
	//$("#data").load('seachresult.php', {text: $("#seachText").val()});//передаем в POST значение из окна поиска
}
);
//$("#seachText").change(function(){
//	$("#data").load('seachresult.php', {text: $("#seachText").val()});
//}	
//);
$("#seachText").keypress(function(){
	$("#data").load('seachresult.php', {text: $("#seachText").val()});
}	
);
</script>
Поиск: 	<input type="edit" name = "seachText" class = "edit" id = "seachText"> 
		<!--
		<input type="button" name = "seachButt" value="Поиск" class = "butt" id = "seachButt"><br>
		-->