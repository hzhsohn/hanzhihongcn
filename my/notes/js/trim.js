function ltrim(str){ //去掉字符串 的头空格
	var i;
	for(i=0;i<str.length;i++){
		if(str.charAt(i)!=" "&&str.charAt(i)!=" ") 
		break;
	}
	str = str.substring(i,str.length);
	return str;
}

function rtrim(str){
	var i;for(i=str.length-1;i>=0;i--)
	{
		if(str.charAt(i)!=" "&&str.charAt(i)!=" ")
		break;
	}
	str = str.substring(0,i+1);
	return str;
}


function trim(str){ return ltrim(rtrim(str)); }