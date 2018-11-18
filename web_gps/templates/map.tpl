    <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
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
		lngX = {$lo};
		latY = {$la};
        
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
</div>