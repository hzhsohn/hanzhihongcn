 //��ֹ��F5��
document.onkeydown=function(){   
	if( event.keyCode==116)   
	{   
		event.keyCode = 0;   
		event.cancelBubble = true;   
		return false;   
	}   
}   

//��ֹ�Ҽ������˵�   
document.oncontextmenu=function(){   
  return false;   
}  
