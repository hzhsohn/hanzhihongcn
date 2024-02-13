<?php
/*****************************************************************
//Author:Han.Zhihong
//Version:2.0.9
*****************************************************************/
/*
		取数据层模块读取数据库记录
		$db=new PzhMySqlDB();		
		$db->open_mysql("127.0.0.1","db","root","");
		//插入
		$A=zhIncode(rand());		
		$db->query("insert into abc(txt) values('$A')");
		//删除
		//$db->query("delete from abc where txt='$A'");
		//浏览  SQL,记录数,页数0开始
		$db->query("select *from abc",0,0);
		while($RS=$db->read())
		{
			echo zhTrcode($RS["txt"])."<BR>";
		}
		//记录数目
		echo 'count='.$db->record_count();
		$db->close();
*/
class PzhMySqlDB
{
	var $r_pagesize;
	var $r_count;
	var $DNS;
	var $RECORDSET;
	var $DBFILENAME;
	
	 //----------------------------------------初始化CONNECTION类
	
	function open_mysql($host,$db_name,$user,$password)
	{
		$this->DNS=mysqli_connect($host,$user,$password);
		//UTF-8 格式必用的一句
		mysqli_query($this->DNS,'SET NAMES UTF8');
		mysqli_select_db($this->DNS,$db_name);
		return $this->DNS;
	}
	
	function read()
	{
		if($this->RECORDSET)
		return mysqli_fetch_array($this->RECORDSET);
		return false;
	}
	
	function record_count()
	{
		return	mysqli_num_rows($this->RECORDSET);
	}
	
	function query($string,$pageSize=0,$pagePoint=0)
	{
		if($pageSize){
		$nowPont=$pagePoint*$pageSize;
		$string=$string.' limit '.$nowPont.','.$pageSize;
		}
		return $this->RECORDSET=mysqli_query($this->DNS,$string);
	}
	
	function record_move($n)
	{
		if($this->RECORDSET->eof)
			return false;
	
		@mysqli_data_seek($this->RECORDSET,$n);
	}
	
	function close()
	{
		if($this->RECORDSET)
		{
			@mysqli_free_result($this->RECORDSET);
		}
		mysqli_close($this->DNS);
	}

}

?>