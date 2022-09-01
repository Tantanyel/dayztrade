<?php

function mail1($email,$potvrdata) {
$to  = $email;
$dat = $potvrdata;
$subject = 'Подтверждение адреса электронной почты DayZTrade';
$message = '
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Подтверждение адреса электронной почты DayZTrade</title>
    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto);
    </style>
</head>

<body>
    <table bgcolor="#f5f5f5" align="center" border="0" cellpadding="0" cellspacing="0" style="width:640px;color:#000;">
        <tbody>
            <tr>
                <td>
                    <a href="http://dayztrade.ru"><img src="http://dayztrade.ru/functions/img/head.png"></a>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="width:580px;max-height: 20px;margin: 0 20px;margin-top: 12px;"><img src="http://dayztrade.ru/functions/img/card_top.png"></div>
                    <div style="width:540px;background-image: url(http://dayztrade.ru/functions/img/card_mid.png);margin: 0 20px;padding:10px 30px;font-size:18px;font-family: Roboto;">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:540px">
                        <tbody>
                            <tr>
                                <td>
                                <p style="margin:0;padding:10px;color:#000;">Это письмо было отправлено автоматически, не отвечайте на него.</p>
                                <p style="margin:0;padding:10px;color:#000;">Ваш адрес электронной почты был указан при регистрации на сайте <a href="http://dayztrade.ru" style="color: #607d8b;">DayZTrade.ru</a>. Чтобы подтвердить его и получить доступ ко всем функциям сайта, нажмите на кнопку ниже.</p>
                                <p style="margin:0;padding:10px;color:#000;">Если вы не регистрировались на сайте <a href="http://dayztrade.ru" style="color: #607d8b;">DayZTrade.ru</a>, проигнорируйте это письмо.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="margin: 20px auto;" align="center" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td>
                                <a href="http://dayztrade.ru/profile.php?emailacept='.$dat.'" style="
                                color: #fff;
                                text-decoration: none;
                                font-size: 16px;
                                background-color: #607d8b;
                                padding: 10px 15px;
                                border-radius: 2px;
                                ">ПОДТВЕРДИТЬ</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:540px">
                        <tbody>
                            <tr>
                                <td>
                                <p style="margin:0;padding:10px;color:#000;font-size: 12px;text-align: center;"><a href="http://dayztrade.ru/recovery?mail='.$potvrdata.'" style="color: #607d8b;">Отписаться</a> от рассылки</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    <div style="width:580px;max-height: 21px;margin: 0 20px;margin-bottom: 17px;"><img src="http://dayztrade.ru/functions/img/card_bottom.png"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="width: 600px;min-height: 20px;margin:0;text-align:right;padding: 20px;background-color: #e0e0e0;font-size: 16px;font-family: Roboto;">DayZTrade 2016</div>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
';
// Для отправки HTML-письма должен быть установлен заголовок Content-type
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
// Дополнительные заголовки
$headers .= 'From: DayZTrade <info@dayztrade.ru>'."\r\n";
mail($to, $subject, $message, $headers);
}

function mail2($email,$potvrdata) {
$to  = $email;
$dat = $potvrdata;
$subject = 'Восстановление пароля DayZTrade';
$message = '
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Восстановление пароля DayZTrade</title>
    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto);
    </style>
</head>

<body>
    <table bgcolor="#f5f5f5" align="center" border="0" cellpadding="0" cellspacing="0" style="width:640px;color:#000;">
        <tbody>
            <tr>
                <td>
                    <a href="http://dayztrade.ru"><img src="http://dayztrade.ru/functions/img/head.png"></a>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="width:580px;max-height: 20px;margin: 0 20px;margin-top: 12px;"><img src="http://dayztrade.ru/functions/img/card_top.png"></div>
                    <div style="width:540px;background-image: url(http://dayztrade.ru/functions/img/card_mid.png);margin: 0 20px;padding:10px 30px;font-size:18px;font-family: Roboto;">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:540px">
                        <tbody>
                            <tr>
                                <td>
                                <p style="margin:0;padding:10px;color:#000;">Это письмо было отправлено автоматически, не отвечайте на него.</p>
                                <p style="margin:0;padding:10px;color:#000;">Вы сделали запрос на восстановление доступа к сайту <a href="http://dayztrade.ru" style="color: #607d8b;">DayZTrade.ru</a>. Для того, чтобы сменить пароль, нажмите на кнопку ниже.</p>
                                <p style="margin:0;padding:10px;color:#000;">Если вы не запрашивали восстановление пароля, проигнорируйте это письмо.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="margin: 20px auto;" align="center" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td>
                                <a href="http://dayztrade.ru/recovery.php?pass='.$dat.'" style="
                                color: #fff;
                                text-decoration: none;
                                font-size: 16px;
                                background-color: #607d8b;
                                padding: 10px 15px;
                                border-radius: 2px;
                                ">ВОССТАНОВИТЬ</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:540px">
                        <tbody>
                            <tr>
                                <td>
                                <p style="margin:0;padding:10px;color:#000;font-size: 12px;text-align: center;"><a href="http://dayztrade.ru/recovery?mail='.$potvrdata.'" style="color: #607d8b;">Отписаться</a> от рассылки</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    <div style="width:580px;max-height: 21px;margin: 0 20px;margin-bottom: 17px;"><img src="http://dayztrade.ru/functions/img/card_bottom.png"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="width: 600px;min-height: 20px;margin:0;text-align:right;padding: 20px;background-color: #e0e0e0;font-size: 16px;font-family: Roboto;">DayZTrade 2016</div>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
';
// Для отправки HTML-письма должен быть установлен заголовок Content-type
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
// Дополнительные заголовки
$headers .= 'From: DayZTrade <info@dayztrade.ru>'."\r\n";
mail($to, $subject, $message, $headers);
}

function mail3($email,$potvrdata) {
$to  = $email;
$dat = $potvrdata;
$subject = 'Подтверждение адреса электронной почты DayZTrade';
$message = '
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Подтверждение адреса электронной почты DayZTrade</title>
    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto);
    </style>
</head>

<body>
    <table bgcolor="#f5f5f5" align="center" border="0" cellpadding="0" cellspacing="0" style="width:640px;color:#000;">
        <tbody>
            <tr>
                <td>
                    <a href="http://dayztrade.ru"><img src="http://dayztrade.ru/functions/img/head.png"></a>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="width:580px;max-height: 20px;margin: 0 20px;margin-top: 12px;"><img src="http://dayztrade.ru/functions/img/card_top.png"></div>
                    <div style="width:540px;background-image: url(http://dayztrade.ru/functions/img/card_mid.png);margin: 0 20px;padding:10px 30px;font-size:18px;font-family: Roboto;">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:540px">
                        <tbody>
                            <tr>
                                <td>
                                <p style="margin:0;padding:10px;color:#000;">Это письмо было отправлено автоматически, не отвечайте на него.</p>
                                <p style="margin:0;padding:10px;color:#000;">Вы изменили адрес электронной почты на сайте <a href="http://dayztrade.ru" style="color: #607d8b;">DayZTrade.ru</a>. Чтобы подтвердить его и получить доступ ко всем функциям сайта, нажмите на кнопку ниже.</p>
                                <p style="margin:0;padding:10px;color:#000;">Если вы не изменяли адрес электронной почты на сайте <a href="http://dayztrade.ru" style="color: #607d8b;">DayZTrade.ru</a>, проигнорируйте это письмо.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="margin: 20px auto;" align="center" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td>
                                <a href="http://dayztrade.ru/profile.php?emailreplace='.$dat.'" style="
                                color: #fff;
                                text-decoration: none;
                                font-size: 16px;
                                background-color: #607d8b;
                                padding: 10px 15px;
                                border-radius: 2px;
                                ">ПОДТВЕРДИТЬ</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:540px">
                        <tbody>
                            <tr>
                                <td>
                                <p style="margin:0;padding:10px;color:#000;font-size: 12px;text-align: center;"><a href="http://dayztrade.ru/recovery?mail='.$potvrdata.'" style="color: #607d8b;">Отписаться</a> от рассылки</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    <div style="width:580px;max-height: 21px;margin: 0 20px;margin-bottom: 17px;"><img src="http://dayztrade.ru/functions/img/card_bottom.png"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="width: 600px;min-height: 20px;margin:0;text-align:right;padding: 20px;background-color: #e0e0e0;font-size: 16px;font-family: Roboto;">DayZTrade 2016</div>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
';
// Для отправки HTML-письма должен быть установлен заголовок Content-type
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
// Дополнительные заголовки
$headers .= 'From: DayZTrade <info@dayztrade.ru>'."\r\n";
mail($to, $subject, $message, $headers);
}

function mail4($email,$name,$comment,$trade,$potvrdata) {
$to  = $email;
$subject = 'DayZTrade: Оповещение о новом комментарии';
$message = '
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>DayZTrade: Оповещение о новом комментарии</title>
    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto);
    </style>
</head>

<body>
    <table bgcolor="#f5f5f5" align="center" border="0" cellpadding="0" cellspacing="0" style="width:640px;color:#000;">
        <tbody>
            <tr>
                <td>
                    <a href="http://dayztrade.ru"><img src="http://dayztrade.ru/functions/img/head.png"></a>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="width:580px;max-height: 20px;margin: 0 20px;margin-top: 12px;"><img src="http://dayztrade.ru/functions/img/card_top.png"></div>
                    <div style="width:540px;background-image: url(http://dayztrade.ru/functions/img/card_mid.png);margin: 0 20px;padding:10px 30px;font-size:18px;font-family: Roboto;">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:540px">
                        <tbody>
                            <tr>
                                <td>
                                <p style="margin:0;padding:10px;color:#000;">Пользователь <a href="http://dayztrade.ru/profile?p='.$name.'" style="color: #607d8b;">'.$name.'</a> оставил комментарий к вашему предложению:</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:400px">
                        <tbody>
                            <tr>
                                <td>
                                <p style="margin:0;padding:10px;color:#000;font-size: 16px;background: #eaeff1;border-radius: 2px;">'.$comment.'</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:540px">
                        <tbody>
                            <tr>
                                <td>
                                <p style="margin:0;padding:10px;color:#000;">Чтобы перейти на сайт и ответить на комментарий, нажмите кнопку «Просмотреть». Настроить выдачу этих уведомлений вы можете в настройках профиля.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="margin: 20px auto;" align="center" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td>
                                <a href="http://dayztrade.ru/trade?id='.$trade.'" style="
                                color: #fff;
                                text-decoration: none;
                                font-size: 16px;
                                background-color: #607d8b;
                                padding: 10px 15px;
                                border-radius: 2px;
                                ">ПРОСМОТРЕТЬ</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:540px">
                        <tbody>
                            <tr>
                                <td>
                                <p style="margin:0;padding:10px;color:#000;font-size: 12px;text-align: center;"><a href="http://dayztrade.ru/recovery?mail='.$potvrdata.'" style="color: #607d8b;">Отписаться</a> от рассылки</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    <div style="width:580px;max-height: 21px;margin: 0 20px;margin-bottom: 17px;"><img src="http://dayztrade.ru/functions/img/card_bottom.png"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="width: 600px;min-height: 20px;margin:0;text-align:right;padding: 20px;background-color: #e0e0e0;font-size: 16px;font-family: Roboto;">DayZTrade 2016</div>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
';
// Для отправки HTML-письма должен быть установлен заголовок Content-type
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
// Дополнительные заголовки
$headers .= 'From: DayZTrade <info@dayztrade.ru>'."\r\n";
mail($to, $subject, $message, $headers);
}

function mailopov($email,$text,$potvrdata) {
$to  = $email;
$subject = 'DayZTrade: Уведомление';
$message = '
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>DayZTrade: Уведомление от администрации</title>
    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto);
    </style>
</head>

<body>
    <table bgcolor="#f5f5f5" align="center" border="0" cellpadding="0" cellspacing="0" style="width:640px;color:#000;">
        <tbody>
            <tr>
                <td>
                    <a href="http://dayztrade.ru"><img src="http://dayztrade.ru/functions/img/head.png"></a>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="width:580px;max-height: 20px;margin: 0 20px;margin-top: 12px;"><img src="http://dayztrade.ru/functions/img/card_top.png"></div>
                    <div style="width:540px;background-image: url(http://dayztrade.ru/functions/img/card_mid.png);margin: 0 20px;padding:10px 30px;font-size:18px;font-family: Roboto;">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:540px">
                        <tbody>
                            <tr>
                                <td>
                                <p style="margin:0;padding:10px;color:#000;">Уведомление с сайта <a href="http://dayztrade.ru" style="color: #607d8b;">DayzTrade</a></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:400px">
                        <tbody>
                            <tr>
                                <td>
                                <p style="margin:0;padding:10px;color:#000;font-size: 16px;background: #eaeff1;border-radius: 2px;">'.$text.'</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="margin: 20px auto;" align="center" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td>
                                <a href="http://dayztrade.ru" style="
                                color: #fff;
                                text-decoration: none;
                                font-size: 16px;
                                background-color: #607d8b;
                                padding: 10px 15px;
                                border-radius: 2px;
                                ">ПЕРЕЙТИ НА САЙТ</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:540px">
                        <tbody>
                            <tr>
                                <td>
                                <p style="margin:0;padding:10px;color:#000;font-size: 12px;text-align: center;"><a href="http://dayztrade.ru/recovery?mail='.$potvrdata.'" style="color: #607d8b;">Отписаться</a> от рассылки</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    <div style="width:580px;max-height: 21px;margin: 0 20px;margin-bottom: 17px;"><img src="http://dayztrade.ru/functions/img/card_bottom.png"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="width: 600px;min-height: 20px;margin:0;text-align:right;padding: 20px;background-color: #e0e0e0;font-size: 16px;font-family: Roboto;">DayZTrade 2016</div>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
';
// Для отправки HTML-письма должен быть установлен заголовок Content-type
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
// Дополнительные заголовки
$headers .= 'From: DayZTrade <info@dayztrade.ru>'."\r\n";
mail($to, $subject, $message, $headers);
}
