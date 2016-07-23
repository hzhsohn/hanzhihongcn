<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{#title#}</title>
<style type="text/css">
<!--
#msg #page li {
	padding-top: 5px;
	padding-bottom: 10px;
	width: 10%;
	float: left;
}

.js_move{
 background-color:#FFF;
}

.js_move:hover{
 background-color:#FF6;
}
-->
</style>
</head>
<body>
<hr/>
<div id="msg">
  <div>共{$counts}条记录</div>
  <div id="chat">
    <ul>
    	{section name=msg loop=$msgs_ary}
      <li class="js_move">{$msgs_ary[msg].content}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[{$msgs_ary[msg].uptime}]&nbsp;&nbsp;&nbsp;&nbsp;<a href="?method=delete&autoid={$msgs_ary[msg].autoid}&page={$page}">[删除]</a></li>
        {/section}
    </ul>
    </div>
    <div id="page">
    	<ul>
    	{section name=page loop=$pages}
      <li><a href="?page={$smarty.section.page.index}">第{$smarty.section.page.index+1}页</a></li>
        {/section}
        </ul>
    </div>
  <table width="100%" border="0" cellpadding="2" cellspacing="0">
  <tr>
    <td><form action="?" method="post" name="form1" onsubmit="if(form1.c.value==''){ alert('不要为空!');return false; }">
      <label>站内小短信:
        <input name="c" type="text" id="c" maxlength="1000" autocomplete="off"/>
        </label>
      <input type="submit" name="btn_submit" id="btn_submit" value="确定" />
      <input name="method" type="hidden" id="method" value="add" />
      <input name="reback" type="hidden" id="reback" value="?" />
      </form>   
    </td>
    </tr>
</table>
</div>
</body>
</html>