function lang(slovo){
    var langjs = {};
    var lang = $("#menu").attr("lang");
    if(lang=="ru"){
        var langjs = {
            'soob1': 'Ошибка авторизации.',
            'soob2': 'Неверный запрос.',
            'soob3': 'Вы не можете оценить себя.',
            'soob4': 'У вас не осталось очков рейтинга.',
            'soob5': 'Вы уже поставили эту оценку.',
            'soob6': 'Вы успешно изменили оценку.',
            'soob7': 'Оценка успешно поставлена.',
            'soob8': 'Вы не можете удалить комментарий.',
            'soob9': 'Комментарий удален.',
            'soob10': 'Ошибка. Вы не авторизованы.',
            'soob11': 'Для изменения количества предметов кликните на число под ним.',
            'left': 'Осталось: ',
            'show': 'Показать еще',
            'exchanges': 'В обменах: ',
            'Drag': 'Перетащите предмет в эту область',
            'quantity': 'шт.',
        };
    }
    if(lang=="eng"){
        var langjs = {
            'soob1': 'Authorisation Error.',
            'soob2': 'Invalid request.',
            'soob3': 'You can not rate yourself.',
            'soob4': 'You have no more rating points.',
            'soob5': 'You have already put this rate.',
            'soob6': 'You have successfully changed the rate.',
            'soob7': 'The rate was successfully added.',
            'soob8': 'You can not delete the comment.',
            'soob9': 'Comment has been deleted.',
            'soob10': 'Error. You are not authorized.',
            'soob11': 'To change the number of items, click on the number below.',
            'left': 'Left: ',
            'show': 'Show more',
            'exchanges': 'in trades: ',
            'Drag': 'Drag the object in this area',
            'quantity': 'pcs.',
        };
    }
    return langjs[slovo];
}