var closezaloba = true;

$(document).ready(function (e) {
    
    $("#soob").click(function (e) {
        func();
    });

    setTimeout(func, 10000);
    

    $("*[materialcircle]").materialcircle();

    $(".input input").focusout(function () {
        noepty(this)
    });
    $(".input input").each(function () {
        noepty(this)
    });
});

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

function filechange2() {
    var imagefile = document.getElementById('imagefile2');
    var image = document.getElementById('preview2');
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

function noepty(arg) {
    var span = $(arg).parent().children("span");
    if ($(arg).val()) {
        $(span).addClass("notempty");
    } else {
        $(span).removeClass("notempty");
    }
}

function oknoopn(obj) {
    var dis = $(obj).css("display");
    if (dis == "block") {
        $(obj).css({
            "display": "none",
        });
    } else {
        $(obj).css({
            "display": "block",
        });
    }
}

function closezalob() {
    if (closezaloba) {
        $(".zalobai").css({
            "display": "block"
        });
        $("body").css({
            "overflow": "hidden"
        });
        closezaloba = false;
    } else {
        $(".zalobai").css({
            "display": "none"
        });
        $("body").css({
            "overflow": "auto"
        });
        closezaloba = true;
    }
}

function numid(num){
    $(".zalobai .hid").val(num);
    closezalob();
}

function filtertradeinp(obj) {
    var textinp = $(obj).val()
    var reg = new RegExp(textinp, "i");
    sortinp(".item", reg);
}

function sortinp(str, reg) {
    $(str).each(function () {
        $(this).css({
            "display": "none"
        });
        var nameitem = $(this).find("p").text();
        var fin = nameitem.search(reg);
        if (fin != -1) {
            $(this).css({
                "display": "flex"
            });
        }
    });
}

function izmen(obj) {
    var par = $(obj).parents(".item");
    var id = $(par).attr("num");
    var img = $(par).find("img").attr("src");
    var name = $(par).find("p").text();
    var sel = $(par).find("span").text();

    $('.izm').find("h2").text("Изменение предмета #" + id);
    $('.izm').find("#preview2").attr("src", img);
    $('.izm').find(".input input").val(name);
    var span = $('.izm').find(".input span");
    if (name) {
        $(span).addClass("notempty");
    }
    $('.izm').find(".prid input").attr("value", id);

    $('.izm .sel select option').each(function () {
        if($(this).text()==sel){
            $('.izm .sel select option').removeAttr("selected");
            var se = $(this).val();
            $('.izm .sel select').val(se);
        }
    });

    oknoopn('.izm');
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


function delzal(idzal) {
    var id = idzal;
    $.ajax({
        type: "POST",
        url: "ajaxzal.php",
        data: "del=" + id,
        success: function (data) {
            if (data == "err") {
                postsoob("Ошибка удаления жалобы.")
            } else {
                $(".zalobi *").remove();
                $(".zalobi").append(data);
                postsoob("Жалоба удалена.");
            }
        }
    });
}