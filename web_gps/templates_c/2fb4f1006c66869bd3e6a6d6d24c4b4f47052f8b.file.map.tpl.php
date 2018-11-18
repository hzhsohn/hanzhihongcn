<?php /* Smarty version Smarty-3.1.16, created on 2015-09-01 11:32:47
         compiled from ".\templates\map.tpl" */ ?>
<?php /*%%SmartyHeaderCode:634955e5251b9e6222-76643890%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2fb4f1006c66869bd3e6a6d6d24c4b4f47052f8b' => 
    array (
      0 => '.\\templates\\map.tpl',
      1 => 1441107160,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '634955e5251b9e6222-76643890',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_55e5251ba7ffc7_44579831',
  'variables' => 
  array (
    'lo' => 0,
    'la' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e5251ba7ffc7_44579831')) {function content_55e5251ba7ffc7_44579831($_smarty_tpl) {?>    <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
    <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=51da467d073efb354da6b40f24d0edf4"></script>
    <style>
        #iCenter{
			/*地图显示高度*/
            height: 500px;
        }
        .amap-copyright{
            display: none;
        }
        .amap-logo{
			display: none;
		}        
    </style>
    <script>
		var lngX;
        var latY;
		lngX = <?php echo $_smarty_tpl->tpl_vars['lo']->value;?>
;
		latY = <?php echo $_smarty_tpl->tpl_vars['la']->value;?>
;
        
        var mapObj;
        function mapInit() {
            mapObj = new AMap.Map("iCenter", {
                view: new AMap.View2D({
                center:new AMap.LngLat(lngX,latY),//坐标
                zoom:13 //缩放高度
                })
            });
            geocoder(new AMap.LngLat(lngX,latY));
        }
        
        function geocoder(lnglatXY) {
            var MGeocoder;            
            mapObj.plugin(["AMap.Geocoder"], function() {        
                MGeocoder = new AMap.Geocoder({ 
                    radius: 1000,
                    extensions: "all"
                });
                AMap.event.addListener(MGeocoder, "complete", geocoder_CallBack); 
                MGeocoder.getAddress(lnglatXY); 
            });
            //
            var marker = new AMap.Marker({
                map:mapObj,
                icon: new AMap.Icon({
                    image: "http://api.amap.com/Public/images/js/mark.png",
                    size:new AMap.Size(58,30),
                    imageOffset: new AMap.Pixel(-32, -0),
                }),
                position: lnglatXY,
                offset: new AMap.Pixel(-5,-30),
                zoom: 13
            });
            mapObj.setFitView();
            mapObj.setZoom(16);
        }
      
        //
        function geocoder_CallBack(data) {
            var resultStr = "";
            //
            resultStr = data.regeocode.formattedAddress;
            document.getElementById("result").innerHTML = resultStr;
        }
	</script>
	<script>
		//初始化
		window.onload=function(){
			mapInit();	
		}
    </script>
<div class="wrap">
    <div class="main">
        <div>
        <div style="position:relative;"><div id="iCenter" ></div></div>
            <div style="padding-top:10px">位置信息: <span id="result"></span></div>
        </div>
    </div>
</div><?php }} ?>
