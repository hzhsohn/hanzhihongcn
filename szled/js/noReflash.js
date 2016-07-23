 //½ûÖ¹ÓÃF5¼ü
document.onkeydown=function(){   
	if( event.keyCode==116)   
	{   
		event.keyCode = 0;   
		event.cancelBubble = true;   
		return false;   
	}   
}   

//½ûÖ¹ÓÒ¼üµ¯³ö²Ëµ¥   
document.oncontextmenu=function(){   
  return false;   
}  
