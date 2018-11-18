<?php   
/*****************************************************************
//Author:HanSohn
//Version:2.0.3
*****************************************************************/

date_default_timezone_set('PRC');

define("_now",date("Y-m-d H:i:s",time()));
define("_today",date("Y-m-d",time()));

/*
�жϵ�ǰ�����Ƿ񳬹�str_date������ڶ�����
����bool
*/
function zhPhpOverDay($str_date = '0000-00-00 00:00:00',$day)
{
  $t1=explode(" ",$str_date);
  $t2=explode("-",$t1[0]);
  $tsp=mktime(0,0,0,$t2[1],$t2[2],0+$t2[0]);
  if(time()-$tsp>86400*$day)
  return true;
  else
  return false;
}

/*
�ж�str_date2�Ƿ񳬹� str_date
����
0 ����Ϊͬһ��
1 str_date2����str_date
2 str_date2���ڲ�����str_date
*/
function zhPhpContrastDay($str_date = '0000-00-00 00:00:00',$str_date2 = '0000-00-00 00:00:00')
{
  $t1=explode(" ",$str_date);
  $t2=explode("-",$t1[0]);
  $tsp=mktime(0,0,0,$t2[1],$t2[2],0+$t2[0]);
  
  $t1=explode(" ",$str_date2);
  $t2=explode("-",$t1[0]);
  $tsp2=mktime(0,0,0,$t2[1],$t2[2],0+$t2[0]);
  
  if($tsp2>$tsp)
  return 1;
  else if ($tsp2==$tsp)
  return 2;
  else
  return 0;
}

//�����ռ�������
//��������
function zhPhpBirthAge($birth = '0000-00-00')
{
        $year=explode("-",$birth);
        $time=getdate();
        $a=mktime(0,0,0,$time[mon],$time[mday],0+$time[year]);
        $b=mktime(0,0,0,$year[1],$year[2],0+$time[year]);
        $age=$time[year]-$year[0];
        if ($a<$b) {
                $age--;
        }
        return $age;
}

//�����ڼ�������
//��������
function zhPhpDateDay($date = '0000-00-00')
{
        $day = explode("-",$date);
        $time = mktime(0,0,0,$day[1],$day[2],0+$day[0]);
        $nowtime = time();
        $days = floor(($nowtime - $time)/(24*3600));
        return $days;        
}
?>