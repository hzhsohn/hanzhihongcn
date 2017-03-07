<?php
/*****************************************************************
//作者:HanSohn
取数据层模块读取数据库记录
//***************************************************************/

class CzhDB
{
var $r_pagesize;
var $r_count;
var $DNS;
var $RECORDSET;
var $DBFILENAME;
var $DB_TYPE;

 //----------------------------------------初始化CONNECTION类
function open_access($filename)
{
	$this->DB_TYPE='ACCESS';
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
function open_sqlserver($local,$user,$password,$db_name)
{
	$this->DB_TYPE='SQLSERVER';
	$CON_STR='Driver={SQL Server};Server=('.$local.');UID='.$user.';PWD='.$password.';database='.$db_name.';';
	//ASCII编码 用这句
	//$this->DNS=new com('ADODB.CONNECTION');
	//UTF-8 格式必用的一句
	$this->DNS=new com('ADODB.CONNECTION', NULL, CP_UTF8);
	$this->DNS->open($CON_STR);
	$this->DBFILENAME=$db_name;
	$this->DNS->CursorLocation=3;
	return $this->DNS;
}
function open_mysql($host,$db_name,$user,$password)
{
	$this->DB_TYPE='MYSQL';	
	$this->DNS=mysql_connect($host,$user,$password);
	//UTF-8 格式必用的一句
	mysql_query('SET NAMES UTF8');
	mysql_select_db($db_name,$this->DNS);
	return $this->DNS;
}

function read()
{
	if($this->DB_TYPE=='ACCESS')
	{
		if($this->RECORDSET->eof)
		return false;
		return $this->RECORDSET;
	}
	else if($this->DB_TYPE=='SQLSERVER')
	{
		if($this->RECORDSET->eof)
		return false;
		return $this->RECORDSET;
	}
	else if($this->DB_TYPE=='MYSQL')
	{
		if($this->RECORDSET)
		return mysql_fetch_array($this->RECORDSET);
		return false;
	}
}

function record_count()
{
	if($this->DB_TYPE=='ACCESS')
	{
		return  $this->RECORDSET->RecordCount;
	}
	else if($this->DB_TYPE=='SQLSERVER')
	{
		return  $this->RECORDSET->RecordCount;
	}
	else if($this->DB_TYPE=='MYSQL')
	{
		return	mysql_num_rows($this->RECORDSET);
	}
}

function query($string,$pageSize=0,$pagePoint=0)
{
	if($this->DB_TYPE=='ACCESS')
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
	else if($this->DB_TYPE=="SQLSERVER")
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
	else if($this->DB_TYPE=='MYSQL')
	{
		if($pageSize){
		$nowPont=$pagePoint*$pageSize;
		$STR=$STR.' limit '.$nowPont.$pageSize;
		}
		return $this->RECORDSET=mysql_query($string,$this->DNS);
	}

	return null;
}

function record_next()
{	
	if($this->DB_TYPE=='ACCESS')
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
	else if($this->DB_TYPE=='SQLSERVER')
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
	
}

function record_move($n)
{
	if(!$this->READ())return;

	if($this->DB_TYPE=='ACCESS')
	{ 
  		$this->RECORDSET->move($NUM);
	}
	else if($this->DB_TYPE=='SQLSERVER')
	{
		$this->RECORDSET->move($NUM);
	}
	else if($this->DB_TYPE=='MYSQL')
	{
		@mysql_data_seek($this->RECORDSET,$NUM);
	}
}

function close()
{
	if($this->DB_TYPE=='ACCESS')
	{
	if($this->DBFILENAME!=null)
	$this->DBFILENAME=null;
	
        if($this->RECORDSET!=null)
        $this->RECORDSET=null;        

	if($this->DNS!=null)
	$this->DNS->close();
	}
	
	if($this->DB_TYPE=='SQLSERVER')
	{
	if($this->DBFILENAME!=null)
	$this->DBFILENAME=null;
	
        if($this->RECORDSET!=null)
        $this->RECORDSET=null;        

	if($this->DNS!=null)
	$this->DNS->close();
	}
	
	else if($this->DB_TYPE=='MYSQL')
	{
	if($this->RECORDSET)
	{
		@mysql_free_result($this->RECORDSET);
	}
	mysql_close($this->DNS);
	}

}

}

?>