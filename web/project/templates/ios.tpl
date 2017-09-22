<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iOS App</title>
<link href="./ios.css" rel="stylesheet" type="text/css" />
<link href="../ios.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="divContent">
  <h3><img src="ios/apple_logo.png" /></h3>
  {section name=outer loop=$APP}
  <div class="raised"> <b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
    <h4><img src="ios/apple.png"/>{$APP[outer].appname}</h4>
    <div class="boxcontent">
      <table border="0" cellpadding="0" cellspacing="0" >
        <tr>
          <td width="64" valign="top"><img src="{$APP[outer].icon}" /></td>
          <td valign="top" ><p><strong>内容提要</strong></p><p>{$APP[outer].content} <br /></p>
            {if $APP[outer].video}<p><strong>视频观看</strong></p><p><a href="{$APP[outer].video}" target="_blank">{$APP[outer].video}</a></p>{/if}
            <p><strong>下载地址</strong></p>{if $APP[outer].appstore}<p><a href="{$APP[outer].appstore}" target="_blank">----AppStore-----</a></p>{else}<p>已下架</p>{/if}
            </td>
        </tr>
      </table>
    </div>
    <b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b> </div>
  {/section}
  <div id="divFooter">Copyright@2012</div>
</div>
</body>
</html>