<?php
/*****************************************************************
//Author:Han.Zhihong
//Version:2.0.9
*****************************************************************/
/*
		取数据层模块读取数据库记录
		$db=new PzhAccessDB();		
		$db->open_access(realpath('db1.mdb'));
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
class PzhAccessDB
{
	var $r_pagesize;
	var $r_count;
	var $DNS;
	var $RECORDSET;
	var $DBFILENAME;
	
	 //----------------------------------------初始化CONNECTION类
	function open_access($filename)
	{
		$CON_STR='Provider=Microsoft.jet.oledb.4.0;data source='.$filename;
		//ASCII编码 用这句
		//$this->DNS=new com('ADODB.CONNECTION');
		//UTF-8 格式必用的一句
		$this->DNS=new com('ADODB.CONNECTION', NULL, CP_UTF8);
		$this->DNS->open($CON_STR);
		$this->DBFILENAME=$filename;
		$this->DNS->CursorLocation=3;
		return $this->DNS;
	}
	
	function read()
	{
			if($this->RECORDSET->eof)
				return false;
			$record=$this->RECORDSET;
      self::record_next();
      return record;
	}
	
	function record_count()
	{
			return  $this->RECORDSET->RecordCount;
	}
	
	function query($string,$pageSize=0,$pagePoint=0)
	{
			$this->RECORDSET=$this->DNS->execute($string);
			if($pageSize){
				if(!$this->RECORDSET->eof)
				{
					$this->RECORDSET->PageSize=$pageSize;
					$this->RECORDSET->AbsolutePage =$pagePoint+1;
					$this->r_pagesize=$pageSize-1;
					$this->r_count=0;
				}
			}
			return $this->RECORDSET;
	}
	
	function record_next()
	{	
			if(!$this->RECORDSET->eof)
			{
				if($this->r_pagesize!=0)
				{
					if($this->r_count < $this->r_pagesize)
					{
						$this->RECORDSET->MoveNext;
						$this->r_count++;
					}
					else
					{
						$this->RECORDSET->MoveLast;
						$this->RECORDSET->MoveNext;
					}	
				}
				else
				{ $this->RECORDSET->MoveNext; }
			}
	}
	
	function record_move($n)
	{
		if($this->RECORDSET->eof)
			return false;
	
		$this->RECORDSET->move($n);
		return true;
	}
	
	function close()
	{
		if($this->DBFILENAME!=null)
		$this->DBFILENAME=null;
		
			if($this->RECORDSET!=null)
			$this->RECORDSET=null;        
	
		if($this->DNS!=null)
		$this->DNS->close();
	}

}

?>