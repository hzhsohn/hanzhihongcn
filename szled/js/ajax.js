var xmlhttp,alerted,msg
  try {
  xmlhttp=new ActiveXObject("Msxml2.XMLHTTP")
 } catch (e) {
  try {
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP")
  } catch (E) {
     //alert("请安装Microsofts XML parsers")
  }
 }
if (!xmlhttp && !alerted) {
 try {
  xmlhttp = new XMLHttpRequest();
 } catch (e) {
  //alert("你的浏览器不支持XMLHttpRequest对象，请升级");
 }
}
function getHTMLText(m,str)
{
msg=m;
if (xmlhttp) { 
  xmlhttp.Open("Get",str,true);
  xmlhttp.onreadystatechange=RSchange;  
  xmlhttp.send();
  }
}


function RSchange() 
{
  if (xmlhttp.readyState==0) document.getElementById(msg).innerHTML = "未初始化..."; 
  if (xmlhttp.readyState==1) document.getElementById(msg).innerHTML = "加载中..."; 
  if (xmlhttp.readyState==2) document.getElementById(msg).innerHTML = "连接完成...";  
  if (xmlhttp.readyState==3) document.getElementById(msg).innerHTML = "交换数据...";
  if (xmlhttp.readyState==4) {
  document.getElementById(msg).innerHTML = xmlhttp.responseText;
  }
 }