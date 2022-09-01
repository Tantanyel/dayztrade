;
(function ($) {
    $.fn.materialcircle = function () {

        var circle

        var radius

        $(this).mousedown(function (e) {
            $(this).attr("draggable", "false");
            $(this).find("img").attr("draggable", "false");
            if ($(this).attr("materialcircle")) {
                var atibute = $(this).attr("materialcircle");
                var atibutearr = atibute.split(',')
            } else {
                var atibutearr
            }

            var borderr = $(this).css("border-radius");

            var typecircle
            var colorcircle
            var centercircle

            var speed

            if (atibutearr) {
                typecircle = 1;
                if (atibutearr[0] == "block") {
                    typecircle = 1;
                }
                if (atibutearr[0] == "icon") {
                    typecircle = 2;
                }
                colorcircle = "#424242";
                if (atibutearr[1] == "night") {
                    colorcircle = "#424242";
                }
                if (atibutearr[1] == "light") {
                    colorcircle = "#fff";
                }
                if (atibutearr[1] && atibutearr[1] != "" && atibutearr[1] != "light" && atibutearr[1] != "night") {
                    colorcircle = atibutearr[1];
                }
                centercircle = false;
                if (atibutearr[2] == "nocenter") {
                    centercircle = false;
                }
                if (atibutearr[2] == "center") {
                    centercircle = true;
                }
            } else {
                centercircle = false;
                typecircle = 1;
                colorcircle = "#424242";
            }


            var thisw
            var thish
            var thisr
            var thispos = $(this).offset();
            var thisx
            var thisy
            
            var radopas

            if (typecircle == 1) {
                thisw = $(this).innerWidth();
                thish = $(this).innerHeight();
                thisx = thispos.left;
                thisy = thispos.top;
                thisr = borderr;
                speed = 450;
                radopas = 0.54;
            }
            if (typecircle == 2) {
                thisw = $(this).innerWidth() * 2;
                thish = $(this).innerHeight() * 2;
                thisx = thispos.left - thisw / 4;
                thisy = thispos.top - thish / 4;
                if (thisw >= thish) {
                    thisr = thisw + "px";
                } else {
                    thisr = thish + "px";
                }
                speed = 300;
                radopas = 0.28;
            }

            var radiusw
            if (thisw >= thish) {
                radiusw = thisw;
            } else {
                radiusw = thish;
            }

            if (centercircle) {
                var radiusx = thisw / 2;
                var radiusy = thish / 2;
            } else {
                var radiusx = e.pageX - thisx;
                var radiusy = e.pageY - thisy;
            }

            circle = $("<circle/>", {
                style: "width:" + thisw + "px; height:" + thish + "px;overflow: hidden;z-index:10000 ;background: transparent;display:block;    pointer-events: none;position: absolute;opacity: 1;top:" + thisy + "px;left:" + thisx + "px;border-radius:" + thisr + ";",
            }).appendTo("body");

            radius = $("<radius/>", {
                style: "width:0;height:0;position: absolute;top:" + radiusy + "px;left:" + radiusx + "px;border-radius:" + radiusw + "px;display:block;background:" + colorcircle + ";opacity: 0.06;",
            }).appendTo(circle);

            $(radius).animate({
                    width: radiusw * 3,
                    height: radiusw * 3,
                    top: radiusy - radiusw * 1.5,
                    left: radiusx - radiusw * 1.5,
                    opacity: radopas,
                }, speed);
        });
        $(window).mouseup(function (e) {
           $(circle).animate({
                    opacity: 0,
                }, 300,
                function () {
                    $(circle).remove();
                });  
        })
    }
}(jQuery, document));
