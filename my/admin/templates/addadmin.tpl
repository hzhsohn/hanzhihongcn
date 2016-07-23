{config_load file="admin.conf" section="setup"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<title>添加管理员</title>
<body>
<div style="width:15%; float:left">{include file="leftbar.tpl" title=leftbar}</div>
<div style="width:84%; float:right">
<form id="form1" name="form1" method="post" action="">
      <table width="74%" height="18" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#D7D7D7">
        <tr>
          <td colspan="2" align="center">{if $result==1}
          管理员添加成功
          {else if $result==2}
          管理编号有重复,添加失败!!
          {/if}</td>
        </tr>
        <tr>
          <td width="32%" align="right">用户名:</td>
          <td width="68%"><label>
            <input name="USERNAME" type="text" id="USERNAME" size="32" maxlength="16" />
          </label></td>
        </tr>
        <tr>
          <td align="right">密　码:</td>
          <td><input name="PASSWORD" type="text" id="PASSWORD" size="32" maxlength="16" /></td>
        </tr>
        <tr>
          <td align="right" valign="top">备　注:</td>
          <td><textarea name="REMARK" cols="30" rows="10" id="REMARK"></textarea></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="right">&nbsp;</td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left"><label>
            <input type="submit" name="Submit" value="确定添加管理员" onclick="confirm_post()" />
    
            <input name="method" type="hidden" id="method" value="insert" />
          </label></td>
        </tr>
      </table>
    </form>
</div>
</body>
