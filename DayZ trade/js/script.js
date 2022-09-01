var closesearch = true;
var closemenu = true;
var closezaloba = true;
var closelang = true;
var closeban = true;
var dragitem = false;
var itemx
var itemy
$(window).resize(function () {
    acttab();
});

$(document).ready(function (e) {

    $(".filteritem").css({
        "display": "none"
    });
    $(".0").css({
        "display": "flex"
    });

    filtertrade('weapon');

    $("*[materialcircle]").materialcircle();


    $(".input input").focusout(function () {
        noepty(this)
    });
    $(".input input").each(function () {
        noepty(this)
    });
    acttab();
    obnlolvoitems();

    var owl = $(".owl-carusel");
    owl.owlCarousel({
        itemsCustom: [
        [265, 1],
        [470, 2],
        [675, 3],
        [880, 4],
        [1085, 5],
        [1290, 6],
        [1495, 7],
        [1700, 8],
        [1905, 9],
        [2110, 10],
      ],
        rewindNav: false,
    });
    $(".next").click(function () {
        owl.trigger('owl.next');
    })
    $(".prew").click(function () {
        owl.trigger('owl.prev');
    })
    $(".closebtn").click(function (e) {
        closesearc();
    });
    $(".tabreg").click(function (e) {
        $(".tabreg").removeClass("tabactive");
        $(this).addClass("tabactive");
        acttab();
    });

    $("#soob").click(function (e) {
        func();
    });

    setTimeout(func, 10000);

    podstrade();

    $("*[infohov]").mouseenter(function (e) {
        tradehover(this);
        var pos = $(this).position();
        var posx = pos.left;
        var par = $(this).parent();
        var thisx = (posx + 15) - $(par).find(".hover").width() / 2;
        $(par).find(".hover").css({
            "left": thisx + "px",
        });
    });
    $("*[infohov]").mouseleave(function (e) {
        var par = $(this).parent();
        $(par).find(".hover").remove();
    });

    $(".filteritem").mousedown(function (e) {
        var iditem = $(this).attr("num");
        var imgitem = $(this).find("img").attr("src");
        var block = '<div style="background-image: url(' + imgitem + ')" img="' + imgitem + '" onmouseup="dragitems()" class="drawitem" num="' + iditem + '"></div>';
        $("body").append(block);
        dragitem = true;
        var thispos = $(this).offset();
        itemy = thispos.top;
        itemx = thispos.left + 100;
        $("*").css({
            "-moz-user-select": "none",
            "-webkit-user-select": "none",
        });
        $(".resultfilter").css({
            "overflow": "hidden",
        });
    });

    $("body").mousemove(function (e) {
        if (dragitem) {
            $(".drawitem").css({
                "top": e.pageY - 75,
                "left": e.pageX - 75,
            });

            var otpr1 = $("#otpr1").offset();
            var otpr1h = $("#otpr1").innerHeight();
            var otpr1w = $("#otpr1").innerWidth();
            if (e.pageY > otpr1.top && e.pageY < (otpr1h + otpr1.top) && e.pageX > otpr1.left && e.pageX < (otpr1w + otpr1.left)) {
                if (!$("#otpr1 .otpritems *").is(".newitem")) {
                    if ($("#otpr1 .otpritems div").length < 7) {
                        $("#otpr1 .otpritems").append('<div class="newitem"></div>');
                    }
                }
            } else {
                $("#otpr1 .otpritems .newitem").remove();
            }
            var otpr2 = $("#otpr2").offset();
            var otpr2h = $("#otpr2").innerHeight();
            var otpr2w = $("#otpr2").innerWidth();
            if (e.pageY > otpr2.top && e.pageY < (otpr2h + otpr2.top) && e.pageX > otpr2.left && e.pageX < (otpr2w + otpr2.left)) {
                if (!$("#otpr2 .otpritems *").is(".newitem")) {
                    if ($("#otpr2 .otpritems div").length < 7) {
                        $("#otpr2 .otpritems").append('<div class="newitem"></div>');
                    }
                }
            } else {
                $("#otpr2 .otpritems .newitem").remove();
            }
        } else {
            $(".otpritems .newitem").remove();
        }
    });

    $(".like button, .dislike button").click(function (e) {
        var arrraiting = $(this).attr("idarr");
        var obj = $(this);
        $.ajax({
            type: "POST",
            url: "../functions/ajaxraiting.php?idop=" + arrraiting,
            data: "idop=" + arrraiting,
            success: function (data) {
                var otvet = data.split(',');
                if (otvet[0] == "erravtoriz") {
                    postsoob(lang("soob1"));
                }
                if (otvet[0] == "errclick") {
                    postsoob(lang("soob2"));
                }
                if (otvet[0] == "errsam") {
                    postsoob(lang("soob3"));
                }
                if (otvet[0] == "errost") {
                    postsoob(lang("soob4"));
                }
                if (otvet[0] == "yjelike") {
                    postsoob(lang("soob5"));
                }
                if (otvet[0] == "aceptzam") {
                    postsoob(lang("soob6"));
                    $(obj).parents("#collike").find("button").removeClass("active");
                    $(obj).addClass("active");
                    var likedis = otvet[1].split('-');
                    $(obj).parents("#collike").find(".like span").text(likedis[0]);
                    $(obj).parents("#collike").find(".dislike span").text(likedis[1]);
                    profobn();
                }
                if (otvet[0] == "aceptnew") {
                    postsoob(lang("soob7"));
                    $(obj).parents("#collike").find("button").removeClass("active");
                    $(obj).addClass("active");
                    $(".ostlike span").text(lang("left") + otvet[1]);
                    var likedis = otvet[2].split('-');
                    $(obj).parents("#collike").find(".like span").text(likedis[0]);
                    $(obj).parents("#collike").find(".dislike span").text(likedis[1]);
                    profobn();
                }
            }
        });
    });

});

//////////////////////////////////////////////////////////////// fun


function deleterat(num) {
    $.ajax({
            type: "POST",
            url: "../functions/ajaxraiting.php",
            data: "del=" + num,
            success: function (data) {
                location.reload();
            }
    });
}

function profobn() {
    $("#likeinfo").each(function () {
        var namep = $(".nameprofile").text();
        $.ajax({
            type: "POST",
            url: "../functions/ajaxobn.php",
            data: "idop=" + namep,
            success: function (data) {
                $("#likeinfo .info").remove();
                $("#likeinfo").append(data);
            }
        });
    })
}

function delcom(idcom) {
    var idcomment = idcom;
    $.ajax({
        type: "POST",
        url: "../functions/ajaxcom.php",
        data: "del=" + idcomment,
        success: function (data) {
            if (data == "errdelcom") {
                postsoob(lang("soob8"))
            } else {
                $(".allcomment *").remove();
                $(".allcomment").append(data);
                postsoob(lang("soob9"))
            }
        }
    });
}

function otprcomment(idtr) {
    var tidrade = idtr;
    var commenttext = encodeURIComponent($(".form textarea").val());
    $(".form textarea").val("");
    $.ajax({
        type: "POST",
        url: "../functions/ajaxcom.php",
        data: "com=" + tidrade + "_" + commenttext,
        success: function (data) {
            if (data == "erravtoriz") {
                postsoob(lang("soob10"))
            } else {
                $(".allcomment *").remove();
                $(".allcomment").append(data);
                $("*[materialcircle]").materialcircle();
            }
        }
    });
}

function typeserv(type){
    $(".traders .trade").remove();
    loadtrade(type);
    $(".typetrade span").removeClass("active");
    $(".typetrade span["+type+"]").addClass("active");
}

function loadtrade(type) {
    $("#ewe").remove();
    var count = $(".traders .trade").length;
    if(count==0){
        count=1;
    }
    $.ajax({
        type: "POST",
        url: "../functions/ajaxtrade.php",
        data: "count=" + count + "&type="+type,
        success: function (data) {
            $(".traders").append(data);
            var count2 = $(".traders .trade").length;
            if(count==1){
                count=0;
            }
            if (count2 - count == 10) {
                $(".traders").append('<input onclick="loadtrade(\''+type+'\');" id="ewe" type="submit" class="button-flat" value="'+lang("show")+'" materialcircle="block,night">');
            }
            podstrade();
        }
    });
}

function podstrade() {
    $(".trdeitem").mouseenter(function (e) {
        var mousex = e.pageX;
        var mousey = e.pageY;
        carditem(this, mousex, mousey);
    });
    $(".trdeitem").mouseleave(function (e) {
        $(".carditem").remove();
    });
}

function postsoob(sob) {
    $("#soob").remove();
    $("body").append('<div onclick="func();" id="soob"><span>' + sob + '</span></div>');
}

function func() {
    $("#soob").each(function (e) {
        $(this).css({
            "animation": "none",
        });
        $(this).animate({
            "bottom": "-100px",
        }, 300, function (e) {
            $(this).remove();
        });
    });
}

function closesearc() {
    var widthbody = $("body").width();
    if (closesearch) {
        if (widthbody < 1000) {
            $(".search").css({
                "width": "30%"
            });
        } else {
            $(".search").css({
                "width": "400px"
            });
        }
        $(".search .closeimg").css({
            "right": "0px"
        });
        closesearch = false;
    } else {
        $(".search").css({
            "width": "20px"
        });
        $(".search .closeimg").css({
            "right": "-30px"
        });
        closesearch = true;
    }
}

function closemen() {
    if (closemenu) {
        $("#menu").css({
            "display": "block"
        });
        $("body").css({
            "overflow": "hidden"
        });
        $(".menuhor").animate({
            "left": "0px"
        }, 200);
        $(".footer").animate({
            "left": "0px"
        }, 200);
        closemenu = false;
    } else {
        $(".footer").animate({
            "left": "-350px"
        }, 100);
        $(".menuhor").animate({
                "left": "-350px"
            }, 100,
            function () {
                $("#menu").css({
                    "display": "none"
                });
                $("body").css({
                    "overflow": "auto"
                });
            });
        closemenu = true;
    }
}

function noepty(arg) {
    var span = $(arg).parent().children("span");
    if ($(arg).val()) {
        $(span).addClass("notempty");
    } else {
        $(span).removeClass("notempty");
    }
}

function acttab() {
    if ($("div").is(".tabsreg")) {
        var idtab;
        $(".tabreg").each(function (i) {
            if ($(this).hasClass("tabactive")) {
                idtab = this;
            }
        });
        var linepisition = $(idtab).position();
        var linew = $(idtab).width()
        $(".linetab").css({
            "left": linepisition.left
        });
        $(".linetab").css({
            "width": linew
        });
        var conttab = $(idtab).attr("id");
        $(".tabcont").css({
            "display": "none"
        });
        $(".tabcont").each(function (i) {
            if ($(this).attr("href") == conttab) {
                $(this).css({
                    "display": "block"
                });
            }
        });
    }
}


function filechange() {
    var imagefile = document.getElementById('imagefile');
    var image = document.getElementById('preview');
    if (typeof (FileReader) != 'undefined') {
        var reader = new FileReader();
        reader.onload = function (e) {
            image.src = e.target.result;
        }
        reader.readAsDataURL(imagefile.files.item(0));
    } else if (imagefile.files && imagefile.files.item(0).getAsDataURL) {
        image.src = imagefile.files.item(0).getAsDataURL();
    }
}

function closebans() {
    if (closeban) {
        $(".banpred").css({
            "display": "block"
        });
        $("body").css({
            "overflow": "hidden"
        });
        closeban = false;
    } else {
        $(".banpred").css({
            "display": "none"
        });
        $("body").css({
            "overflow": "auto"
        });
        closeban = true;
    }
}

function closezalob() {
    if (closezaloba) {
        $(".zaloba").css({
            "display": "block"
        });
        $("body").css({
            "overflow": "hidden"
        });
        closezaloba = false;
    } else {
        $(".zaloba").css({
            "display": "none"
        });
        $("body").css({
            "overflow": "auto"
        });
        closezaloba = true;
    }
}

function openlang() {
    if (closelang) {
        $(".langreplace").css({
            "display": "block"
        });
        closelang = false;
    } else {
        $(".langreplace").css({
            "display": "none"
        });
        closelang = true;
    }
}

function carditem(obj, posx, posy) {
    var info = $(obj).attr("info");
    var infoarr = info.split(",");
    var img = $(obj).find("img").attr("src");
    var thisx = posx;
    var thisy = posy;
    var pos = 'style="top:' + (thisy - 65) + 'px;left:' + thisx + 'px;"';
    var block = '<div ' + pos + ' class="carditem"><img src="' + img + '"><div class="name"><b>' + infoarr[0] + '</b><span>' + infoarr[1] + '</span><p>'+lang("exchanges")+'' + infoarr[2] + ' '+lang("quantity")+'</p></div></div>';
    $('body').append(block);
    virav();
}

function virav() {
    var thisx;
    var thisy;
    var thpos = $('.carditem').offset();
    if (thpos.top + 130 > window.innerHeight - 10 + $(window).scrollTop()) {
        thisy = window.innerHeight - 10 + $(window).scrollTop() - 140;
        $('.carditem').css({
            "top": thisy,
        });
    }
    if (thpos.top < $(window).scrollTop() + 80) {
        thisy = $(window).scrollTop() + 90;
        $('.carditem').css({
            "top": thisy,
        });
    }
    if (thpos.left + $('.carditem').width() > window.innerWidth - 20) {
        thisx = window.innerWidth - 450;
        $('.carditem').css({
            "left": thisx,
        });
        thisx = window.innerWidth - ($('.carditem').width() + 25);
        $('.carditem').css({
            "left": thisx,
        });
    }
}

function tradehover(obj) {
    var info = $(obj).attr("infohov");
    var pos = $(obj).position();
    var rod = $(obj).parent();
    var posx = pos.left;
    var posy = pos.top;
    pos = 'style="top:' + (posy + 38) + 'px;left:' + posx + 'px;"';
    var block = '<span ' + pos + ' class="hover">' + info + '</span>';
    $(rod).append(block);
}

function filtertrade(ch) {
    var namech = ch;
    var idcheck = "#" + ch;
    var classcheck = "." + ch;

    if (!$(idcheck).prop("checked")) {
        $(classcheck).css({
            "display": "none"
        });
    } else {
        $(classcheck).css({
            "display": "flex"
        });
    }
    filtertradeinp(".filtertrade input");
}

function sortinp(str, reg) {
    $(str).each(function () {
        $(this).css({
            "display": "none"
        });
        var nameitem = $(this).find("span").text();
        var fin = nameitem.search(reg);
        if (fin != -1) {
            $(this).css({
                "display": "flex"
            });
        }
    });
}

function filtertradeinp(obj) {
    var textinp = $(obj).val()
    var reg = new RegExp(textinp, "i");

    if ($("#weapon").prop("checked")) {
        sortinp(".weapon", reg);
    }
    if ($("#amunition").prop("checked")) {
        sortinp(".amunition", reg);
    }
    if ($("#food").prop("checked")) {
        sortinp(".food", reg);
    }
    if ($("#ammo").prop("checked")) {
        sortinp(".ammo", reg);
    }
    if ($("#clothes").prop("checked")) {
        sortinp(".clothes", reg);
    }
    if ($("#transport").prop("checked")) {
        sortinp(".transport", reg);
    }
    if ($("#modules").prop("checked")) {
        sortinp(".modules", reg);
    }
    if ($("#medicines").prop("checked")) {
        sortinp(".medicines", reg);
    }
    if ($("#other").prop("checked")) {
        sortinp(".other", reg);
    }
}


function dragitems() {
    dragitem = false;
    $("*").css({
        "-moz-user-select": "auto",
        "-webkit-user-select": "auto",
    });
    $(".resultfilter").css({
        "overflow": "auto",
    });
    if ($(".otpritems *").is(".newitem")) {
        var newitpos = $(".otpritems .newitem").offset();
        var par = $(".newitem").parents(".itemotpravka").attr("id");
        itemx = newitpos.left;
        itemy = newitpos.top;

        $(".drawitem").animate({
                "left": itemx,
                "top": itemy,
            }, 200,
            function () {
                newtems(par)
                $(".drawitem").remove();
                obnlolvoitems();
                $(".otpritems .newitem").remove();
                postsoob(lang("soob11"))
            }
        );
    } else {
        $(".drawitem").animate({
                "left": itemx,
                "top": itemy,
            }, 200,
            function () {
                $(".drawitem").remove();
                obnlolvoitems();
                $(".otpritems .newitem").remove();
            }
        );
    }
}

function newtems(kud) {
    var iditem = $(".drawitem").attr("num");
    var imgitem = $(".drawitem").attr("img");
    var estpred = false;
    $("#" + kud + " .otpritems .otpritem").each(function () {
        var numotit = $(this).find("input").val();
        var numotitid = $(this).attr("num");
        if(!estpred&&iditem==numotitid){
            if(numotit<300){
            numotit = Number(numotit)+1;
            $(this).find("input").val(numotit);
            $(this).find("span").text(numotit+" "+lang("quantity"));
            estpred = true;
            }else{
            estpred = true; 
            }
        }
    });
    if(!estpred){
        var block = '<div class="otpritem" num="' + iditem + '"><img src="' + imgitem + '" class="previtem"><img src="img/removeitem.png" class="removeitem" onclick="deleteitem(this)"><input onblur="focusout(this)" onkeyup="focusit(this)" type="number" min="1" max="300" value="1"><span>1 '+lang("quantity")+'</span></div>';
        $("#" + kud + " .otpritems").append(block);
    }
}


function obnlolvoitems() {
    $(".itemotpravka").each(function () {
        if ($(this).find(".otpritems div").length > 0) {
            $(this).find(".noitems").remove();
        } else {
            if ($(this).find(".otpritems span").length == 0) {
                $(this).find(".otpritems").append('<span class="noitems">'+lang("Drag")+'</span>');
            }
        }
    });

    var otp1 = 7 - $("#otpr1 .otpritems .otpritem").length;
    $("#otpr1 .zagotpravka p").text(lang("left") + otp1);
    var otp2 = 7 - $("#otpr2 .otpritems .otpritem").length;
    $("#otpr2 .zagotpravka p").text(lang("left") + otp2);

    var totp1 = "";
    var totp2 = "";
    $("#otpr1 .otpritem").each(function () {
        var colit = $(this).find("input").val();
        var numit = $(this).attr("num");
        var zap = "";
        if (totp1 != "") {
            zap = ","
        }
        totp1 = totp1 + zap + numit + "_" + colit;
    });
    $("#otpr2 .otpritem").each(function () {
        var colit = $(this).find("input").val();
        var numit = $(this).attr("num");
        var zap = "";
        if (totp2 != "") {
            zap = ","
        }
        totp2 = totp2 + zap + numit + "_" + colit;
    });
    $("#otpravka").attr("value", totp1 + "|" + totp2);
}

function deleteitem(obj) {
    var par = $(obj).parents(".otpritem");
    $(par).animate({
            "opacity": "0",
        }, 200,
        function () {
            $(par).remove();
            obnlolvoitems();
        }
    );
}

function focusit(obj) {
    var text = $(obj).val();
    if (text != "") {
        if (text < 1) {
            $(obj).val("1");
            text = 1;
        }
        if (text > 300) {
            $(obj).val("300");
            text = 300;
        }
    } else {
        text = "";
    }
    $(obj).parents(".otpritem").find("span").text(text + " "+lang("quantity"))
    obnlolvoitems();
    if (event.keyCode == 13) {
        if (text == "") {
            text = 1;
            $(obj).val("1");
            $(obj).parents(".otpritem").find("span").text(text + " "+lang("quantity"))
            obnlolvoitems();
        }
        $(obj).blur();
    }
}

function focusout(obj) {
    var text = $(obj).val();
    if (text < 1) {
        $(obj).val("1");
        text = 1;
    }
    if (text > 300) {
        $(obj).val("300");
        text = 300;
    }
    $(obj).parents(".otpritem").find("span").text(text + " "+lang("quantity"))
    obnlolvoitems();
}

function focuscomm(obj) {
    var idtr = $(obj).attr("tr");
    var key = window.event.keyCode;
    if (key == 13) {
        $(obj).blur();
        otprcomment(idtr);
    }
}

function faqopn(obj) {
    var str = $(obj).parents(".faq").find("a");
    var pol = $(obj).parents(".faq").find("p");
    var css = $(obj).parents(".faq").find("p").css("max-height");
    if (css == "0px") {
        $(pol).css({
            "max-height": "10000px",
            "padding": "30px",
        });
        $(str).css({
            "transform": "rotateX(180deg)",
        });
    } else {
        $(pol).css({
            "max-height": "0px",
            "padding": "0px",
        });
        $(str).css({
            "transform": "rotateX(0deg)",
        });
    }
}

function gomopen() {
    $(".gomu").remove();
    $("body").append('<div class="gomu"><iframe width="100%" height="100%" src="https://www.youtube.com/embed/1mptglRrG9E?autoplay=1&loop=1&playlist=1mptglRrG9E&rel=0&controls=0&disablekb=0&rel=0&showinfo=0" frameborder="0" allowfullscreen></iframe><a class="gomclose" onclick="gomclose()">Закрыть</a></div>');
}

function gomclose() {
    $(".gomu").remove();
}

function notyallowed(id) {
    var idvk = id;
    $.ajax({
        type: "POST",
        url: "../functions/ajaxvk.php",
        data: "id=" + idvk,
        success: function (data) {
            if (data=="ok") {
                location.reload();
            }
        }
    });
}
function notydenied(id) {
    var idvk = id;
    $.ajax({
        type: "POST",
        url: "../functions/ajaxvk.php",
        data: "idd=" + idvk,
        success: function (data) {
            if (data=="ok") {
                location.reload();
            }
        }
    });
}
