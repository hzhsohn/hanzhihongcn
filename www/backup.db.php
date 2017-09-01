<?php
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

////////////////////////////////////////////////////////////////////

echo "please reset code"
exit;



//用户数据库
define('cfg_db_host','127.0.0.1');
define('cfg_db_username','root');
define('cfg_db_passwd','hxkong123abc');
define('cfg_db','hanzhihongcn');


//用户数据库2
define('cfg_db_host','127.0.0.1');
define('cfg_db_username','root');
define('cfg_db_passwd','hxkong123abc');
define('cfg_db','hanzhihongcn');


////////////////////////////////////////////////////////////////////

$db=new PzhMySqlDB();	
$db->open_mysql(cfg_db_host,cfg_db,cfg_db_username,cfg_db_passwd);

$aaaa=array();

$db->query("select*from information");
while($rs=$db->read())
{
   $aaaa[]=$rs[0];
   echo $rs[0].'</br>';
}

foreach($aaaa as $a)
{
    $db->query("select*from information where autoid=".$a);
    if($rs=$db->read())
    {
       $str="insert into tbnote(ip,typetwo_id,title,content,uptime) values('".$rs["ip"]."','".$rs["typetwo_id"]."','".$rs["title"]."','".$rs["content"]."','".$rs["uptime"]."')";
    
      if($db->query($str))
      echo 'do-----'.$rs[0].'</br>';
      else
      echo 'err-----'.$rs[0].'</br>';
    }
}
$db->close();

?>