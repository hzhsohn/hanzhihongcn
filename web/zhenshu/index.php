<?php
//GD库，目录777权限 
function CreateSmallImage( $OldImagePath, $NewImagePath, $NewWidth=154, $NewHeight=134)
{
    // 取出原图，获得图形信息getimagesize参数说明：0(宽),1(高),2(1gif/2jpg/3png),3(width="638" height="340")
    $OldImageInfo = getimagesize($OldImagePath);
    if ( $OldImageInfo[2] == 1 ) $OldImg = @imagecreatefromgif($OldImagePath);
    elseif ( $OldImageInfo[2] == 2 ) $OldImg = @imagecreatefromjpeg($OldImagePath);
    else $OldImg = @imagecreatefrompng($OldImagePath);

    // 创建图形,imagecreate参数说明：宽,高
    $NewImg = imagecreatetruecolor( $NewWidth, $NewHeight );

    //创建色彩,参数：图形,red(0-255),green(0-255),blue(0-255)
    $black = ImageColorAllocate( $NewImg, 0, 0, 0 ); //黑色
    $white = ImageColorAllocate( $NewImg, 255, 255, 255 ); //白色
    $red   = ImageColorAllocate( $NewImg, 255, 0, 0 ); //红色
    $blue  = ImageColorAllocate( $NewImg, 0, 0, 255 ); //蓝色
    $other = ImageColorAllocate( $NewImg, 0, 255, 0 );

    //新图形高宽处理
    $WriteNewWidth = $NewHeight*($OldImageInfo[0] / $OldImageInfo[1]); //要写入的高度
    $WriteNewHeight = $NewWidth*($OldImageInfo[1] / $OldImageInfo[0]); //要写入的宽度
   
    //这样处理图片比例会失调，但可以填满背景
    if ($OldImageInfo[0] / $NewWidth > $org_info[1] / $NewHeight) {
        $WriteNewWidth  = $NewWidth;
        $WriteNewHeight  = $NewWidth / ($OldImageInfo[0] / $OldImageInfo[1]);
    } else {
       
        $WriteNewWidth  = $NewHeight * ($OldImageInfo[0] / $OldImageInfo[1]);
        $WriteNewHeight = $NewHeight;
    }
    //以$NewHeight为基础,如果新宽小于或等于$NewWidth,则成立
    if ( $WriteNewWidth <= $NewWidth ) {
        $WriteNewWidth = $WriteNewWidth; //用判断后的大小
        $WriteNewHeight = $NewHeight; //用规定的大小
        $WriteX = floor( ($NewWidth-$WriteNewWidth) / 2 ); //在新图片上写入的X位置计算
        $WriteY = 0;
    } else {
        $WriteNewWidth = $NewWidth; // 用规定的大小
        $WriteNewHeight = $WriteNewHeight; //用判断后的大小
        $WriteX = 0;
        $WriteY = floor( ($NewHeight-$WriteNewHeight) / 2 ); //在新图片上写入的X位置计算
    }

    //旧图形缩小后,写入到新图形上(复制),imagecopyresized参数说明：新旧, 新xy旧xy, 新宽高旧宽高
    @imageCopyreSampled( $NewImg, $OldImg, $WriteX, $WriteY, 0, 0, $WriteNewWidth, $WriteNewHeight, $OldImageInfo[0], $OldImageInfo[1] );

    //保存文件
//    @imagegif( $NewImg, $NewImagePath );
    @imagejpeg($NewImg, $NewImagePath, 100);
    //结束图形
    @imagedestroy($NewImg);
}


$JPEG_COUNT=15;


for($i=1;$i<=$JPEG_COUNT;$i++)
{
	$strd="pic/$i.jpg";
	$strp="pic/s_$i.jpg";
	if(realpath($strd) && !realpath($strp))
	{
		CreateSmallImage($strd,$strp);
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<style>

/*base*/
ul, li {
	margin: 0;
	padding: 0;
	list-style: none;
}
.clearfix:before, .clearfix:after {
	content: " ";
	display: table;
}
.clearfix:after {
	clear: both;
}
.clearfix {
 *zoom: 1;
}
/*main*/
.imgContainer {
	width: 745px;
	padding: 10px;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
}
.imgUl {
	position: relative;
	width:2500px;
}
.box {
	width: 684px;
	height: 560px;
	margin-left: 30px;
	overflow:scroll;
}
.box2 {
	width: 684px;
	margin-left: 30px;
	overflow: hidden;
}

.detailImg, .smallImg {
	position: relative;	
}
/*detailImg*/
#detailImg-box {
	min-height: 200px;
}
.detailImg {
	text-align: center;
}
.detailImg img {
	max-width: 660px;
}
.detailImg p {
	text-align: left;
	color: #999;
}
#detailImg-pre, #detailImg-next {
	position: absolute;
	width: 30px;
	height: 46px;
	top: 50%;
	background: url(image/page_button.gif) 0 0 no-repeat;
	cursor: pointer;
	text-indent:-9999px;
}
#detailImg-pre {
	left: 0;
	background-position: -35px 0;
}
#detailImg-next {
	right: 0;
	background-position: -99px 0;
}
#detailImg-pre:hover {
	background-position: -35px -47px;
}
#detailImg-next:hover {
	background-position: -99px -47px;
}
/*smallImg*/
#smallImg-box {
	height: 92px;
}
.smallImg li {
	float: left;
	width: 76px;
}
.smallImg li a {
	display: block;
	width: 70px;
	height: 70px;
	border: 3px solid #fff;
	overflow: hidden;
	vertical-align: middle;
	margin: 5px auto;
}
.smallImg img {
	width: 70px;
}
.smallImg li a:hover, .smallImg .cur a {
	border-color: #F45E5E;
}
#smallImg-pre, #smallImg-next {
	position: absolute;
	top: 0;
	height: 92px;
	width: 28px;
	margin: 0;
	background: url(image/album-arrow.png) 0 0 no-repeat;
	cursor: pointer;
}
#smallImg-pre {
	left: 0;
}
#smallImg-next {
	right: 0;
	background-position: 0 -94px;
}
#smallImg-pre:hover {
	background-position: -28px 0;
}
#smallImg-next:hover {
	background-position: -28px -94px;
}
</style>
<script src="jquery-1.10.1.min.js"></script>
<body marginheight="0" style="background-color:#FFF">
<div class="imgContainer" style="background-color:#FFF">
  <!--大图-->
  <div class="detailImg" > <a id="detailImg-pre">&lt;</a>
    <div id="detailImg-box" class="box"> </div>
    <a id="detailImg-next">&gt;</a> </div>
  <!--小图-->
  <div class="smallImg"> <a id="smallImg-pre"></a>
    <div id="smallImg-box" class="box2">
      <ul id="smallImg-ul" class="imgUl">
      </ul>
    </div>
    <a id="smallImg-next"></a> </div>
</div>
<script>
$(function(){
	var i=0,//大图编号
		len=img.length,//img数组的长度
		cur=0;//当前图片编号
		j=9,//默认显示小图个数
		page=0,//小图的页码
		$s_next=$('#smallImg-next'),//小图下一页
		$s_pre=$('#smallImg-pre'),//小图上一页
		box=$('#smallImg-box').width(),//显示的长度
		$ul=$('#smallImg-ul'),//小图外层
		$imgLi=$ul.find('li'),//小图li
		html=_html='';//存放载入的代码		
	$('#detailImg-box').append('<p>'+img[i].title+'</p><a href=\"'+img[0].href+'\" class=\"detailImg_1\"><img alt=\"'+img[0].alt+'\" src=\"'+img[i].src+'\"></a>');
	//大图	
	$('#detailImg-next').click(function(){
		++i;
		if(i><?=$JPEG_COUNT?>)i=<?=$JPEG_COUNT?>;
		detailImg_click($s_next,i,len);
	})
	$('#detailImg-pre').click(function(){
		--i;
		if(i<0)i=0;
		detailImg_click($s_pre,i,len);
	})
	//小图
	for(var k=0;k<j;k++){
		var _k=k%len;
		s_html(_k);
		html+=h;
	}
	$ul.append(html);
	$('.smallImg_1').addClass('cur');	
	//小图下一页
	$('#smallImg-next').click(function(){
		if(!$ul.is(':animated')){
			page++;
			var a=page*j,_a,c;
			for(var k=0;k<j;k++,a++){
				smallImg_click(a,_a,len,i);
				_html+=h;
			}
			$ul.append(_html);
			$ul.css({'left':0,'right':'auto'});
			$ul.animate({left:-box},1600,function(){
				$ul.find('li:lt('+j+')').detach();
				$ul.css('left',0);
				_html='';
			});//动画执行后,再删除前9个li,将left设回0
			$('#smallImg-ul li').click(function(){//三处一样，不知道这个要怎么优化？？？
				var _this=$(this);
				i=_this.attr('class').replace(/[^0-9]/ig,'')-1;
				img_info(i);
				s_a_r(_this,'cur');
				cur=i;
			})
		}
	})
	//小图上一页
	$('#smallImg-pre').click(function(){
		if(!$ul.is(':animated')){
			page--;
			var a=(page-1)*j,_a,c;
			for(var k=0;k<j;k++,a--){
				smallImg_click(a,_a,len,i);
				_html=h+_html;
			}
			$ul.prepend(_html).css({'right':box,'left':'auto'});
			$ul.animate({right:0},1600,function(){
				$ul.find('li:gt('+(j-1)+')').detach();//删除后9个li,从8开始
				_html='';
			});
			$('#smallImg-ul li').click(function(){
				var _this=$(this);
				i=_this.attr('class').replace(/[^0-9]/ig,'')-1;
				img_info(i);
				s_a_r(_this,'cur');
				cur=i;
			})
		}
			
	})
	//点击小图
	$('#smallImg-ul li').click(function(){
		var _this=$(this);
		i=_this.attr('class').replace(/[^0-9]/ig,'')-1;
		img_info(i);
		s_a_r(_this,'cur');
		cur=i;
	})
})

/*----自定义函数-----------*/
var img=[
	<?php for($i=1;$i<=$JPEG_COUNT;$i++){ ?>
	{
		'href':'#',
		'alt':'图片<?=$i?>',
		'src':'pic/<?=$i?>.jpg',
		'smallSrc':'pic/s_<?=$i?>.jpg',
		'title':'图片<?=$i?>'
	},
	<?php } ?>
]
//大图图片信息
function img_info(i){
	var href=img[i].href,
		alt=img[i].alt,
		src=img[i].src,
		title=img[i].title,
		$main=$('#detailImg-box');
	$main.find('a').attr({'href':href,'class':'detailImg_'+(i+1)});
	$main.find('img').attr({'alt':alt,'src':src});
	$main.find('p').text(title);
}
function s_a_r(o,c){
	o.addClass(c).siblings().removeClass(c);	
}
//大图左右点击
function i_cur(i,len){
	i=i%len;
	if(i<0){
		i=len+i;
	}
	return i;	
}
function detailImg_click($pn,i,len){
	i_cur(i,len);
	img_info(i);
	var imgCur=$('.smallImg_'+(i+1));
	if(!imgCur.html()){
		$pn.click();
	} 
	s_a_r($('.smallImg_'+(i+1)),'cur');//小图选中
}
//小图左右点击
function smallImg_click(a,_a,len,i){
	_a=a;
	_a=a%len;
	if(_a<0){
		_a+=len;
	}
	c=_a==i?'cur':'';
	s_html(_a,c);
}
function s_html(_a,c){
	return h='<li class=\"smallImg_'+(_a+1)+' '+c+'\"><a><img alt=\"'+img[_a].alt+'\" src=\"'+img[_a].smallSrc+'\"></a></li>';
}


</script>
<div style="text-align:center;"> </div>
</body>
</html>
