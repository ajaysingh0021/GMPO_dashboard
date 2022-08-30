<script type="text/javascript">
function OnSubmitForm()
{
  if(document.pressed == 'Insert')
  {
   document.myform.action ="insert.html";
  }
  else
  if(document.pressed == 'Update')
  {
    document.myform.action ="update.html";
  }
  return true;
}
</script>


<form name="myform" onsubmit="return onsubmitform();">
 
<input type="submit" name="operation" onclick="document.pressed=this.value" value="insert" />
 
<input type="submit" name="operation" onclick="document.pressed=this.value" value="update" />
 
</form>