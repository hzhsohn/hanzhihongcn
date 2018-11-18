<?php
/*****************************************************************
//Author:HanSohn
//Version:2.0.3
*****************************************************************/
function zhPhpRedirect($URL,$TARGET="parent")
{
?>
<script type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
<?php
echo "<script>MM_goToURL('".$TARGET."','".$URL."')</script>"; 
}
?>