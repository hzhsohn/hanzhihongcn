var xmlhttp,alerted,msg
  try {
  xmlhttp=new ActiveXObject("Msxml2.XMLHTTP")
 } catch (e) {
  try {
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP")
  } catch (E) {
     //alert("�밲װMicrosofts XML parsers")
  }
 }
if (!xmlhttp && !alerted) {
 try {
  xmlhttp = new XMLHttpRequest();
 } catch (e) {
  //alert("����������֧��XMLHttpRequest����������");
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
  if (xmlhttp.readyState==0) document.getElementById(msg).innerHTML = "δ��ʼ��..."; 
  if (xmlhttp.readyState==1) document.getElementById(msg).innerHTML = "������..."; 
  if (xmlhttp.readyState==2) document.getElementById(msg).innerHTML = "�������...";  
  if (xmlhttp.readyState==3) document.getElementById(msg).innerHTML = "��������...";
  if (xmlhttp.readyState==4) {
  document.getElementById(msg).innerHTML = xmlhttp.responseText;
  }
 }