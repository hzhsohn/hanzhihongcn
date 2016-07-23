    var windowArray = new Array();   
       
    function destorySonWindow() {   
        if(!document.all) {   
            for(var i = 0; i < windowArray.length; i++) {   
                if(windowArray[i]) {   
                    windowArray[i].close();   
                }   
            }   
        }   
    }   
  
    function showDialog(url, _left, _top, _width, _height, _modal, _resizable, _status, _scroll) {   
        var result;   
        var iTop = (window.screen.availHeight- 30 - _height) / 2;   
        var iLeft = (window.screen.availWidth- 10 - _width) / 2;   
           
        if(_left == -1 || _top == -1) {   
            _left = iLeft;   
            _top = iTop;   
        }   
           
        var ieFeatures = "dialogWidth=" + _width + "px;" +    
            "dialogHeight=" + _height + "px;" +    
            "dialogLeft=" + _left + "px;" +    
            "dialogTop=" + _top + "px;" +    
            "resizable=" + _resizable + ";" +   
            "status=" + _status + ";" +    
            "scroll=" + _scroll;    
        var otherFeatures = "width=" + _width + "," +    
            "height=" +  _height + "," +    
            "left=" + _left + "," +    
            "top=" + _top + "," +    
            "resizable=" + _resizable + "," +    
            "status=" + _status + "," +    
            "scrollable=" + _scroll;   
               
        if(_modal == 'yes') {   
            window.openSonModel = true;   
        } else {   
            window.openSonModel = false;   
        }   
               
        if(document.all) {  //ie               
            if(_modal == 'yes') {   
                result = window.showModalDialog(url, window, ieFeatures);   
            } else {   
                result = window.showModelessDialog(url, window, ieFeatures);   
            }   
        } else { //other   
            otherFeatures += ',modal=' +  _modal;   
            result = window.open(url, '_blank', otherFeatures);   
            windowArray.push(result);   
        }   
           
        return result;   
    }   
/*       
    function test() {   
        showDialog('x.html', -1, -1, 200, 200, 'yes', 'yes', 'yes', 'yes');   
    }   
*/
destorySonWindow();
