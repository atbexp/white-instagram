var order = new Object();

$( document ).ready(function() {

// Корзина. Добавление в корзину
    $('body').on('click', '.add-to-card', function() {
        var button = $(this);
        var id = button.attr('href').replace('#','');
        var count = $(this).data('count');
        if ( button.hasClass('active') ){
            var action = 'remove';
            button  .removeClass('active');
            if ($('.basket-style').is('div')){
                var item = $(this).parents('.item');
                var list = $(this).parents('.item-list');
                item.remove();
                if (list.children('div').length == 0){
                    list.next('hr').remove();
                    list.remove();
                }
            }
        } else {
            var action = 'add';
            //button.addClass('active');
        }
        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : '/wp-admin/admin-ajax.php?action=change_basket',
            data : {
                id: id,
                count: count,
                act: action
            },
            success: function(response) {
                if(response == "1") {}
                $('#basket-label').replaceWith(response.basket_label);
                $('#logo .anti-progress').css({height:response.delivery_anti_progress});
                $('#free-delivery').html(response.delivery_string);

                if ($('.basket-style').is('div') && response==0){
                    window.location = '/';
                }
            }
        });
        return false;
    });

    // Счетчик для добавления в корзину
    $('body').on('click', '.item_counter .add', function() {
        var counter = $(this).parents('.item_counter');
        var id = counter.data('item');
        var count = counter.find('.value').text();
        count++;
        $('.add-to-card[href="#'+id+'"]').data('count',count);
        counter.find('.value').text(count);
    });
    $('body').on('click', '.item_counter .deduct', function() {
        var counter = $(this).parents('.item_counter');
        var id = counter.data('item');
        var count = counter.find('.value').text();
        if (count > 1){
            count--;
            $('.add-to-card[href="#'+id+'"]').data('count',count);
            counter.find('.value').text(count);
        }
    });

// Корзина. Удаление из корзины
    $('body').on('click', '#basket_table a.del', function() {
        var button = $(this);
        var action = 'remove';
        var id = button.attr('href').replace('#','');
        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : '/wp-admin/admin-ajax.php?action=change_basket',
            data : {
                id: id,
                act: action
            },
            success: function(response) {
                if(response == "1") {}
                data_update(response);
            }
        });
        return false;
    });

// Корзина. Изменение корзины
    $('body').on('click', '.basket_item_counter .add, .basket_item_counter .deduct', function() {
        var button = $(this);
        var action = button.attr('class');
        var value = button.parents('.basket_item_counter').find('.value');
        var id = button.parents('tr').attr('class').replace('item-','');
        var count = value.text();

        switch (action){
            case 'add':
                count++;
                break;
            case 'deduct':
                if (count > 1){
                    count--;
                }
                break;
        }

        //value.text(count);

        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : '/wp-admin/admin-ajax.php?action=change_basket',
            data : {
                id: id,
                act: 'edit',
                count: count
            },
            success: function(response) {
                if(response == "1") {}
                data_update(response);
            }
        });
        return false;
    });

    $('body').on('keyup', '#order input[name=count]', function() {
    //$('#order input[name=count]').keydown(function(){
        var button = $(this);
        var count = $(this).val();
        var action = 'edit';
        var id = button.parents('tr').find('a.del').attr('href').replace('#','');
        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : '/wp-admin/admin-ajax.php?action=change_basket',
            data : {
                id: id,
                count: count,
                act: action
            },
            success: function(response) {
                if(response == "1") {}
                data_update(response);
            }
        });
        //return false;
    });

    // Оформление заказа
    // Валидация
    $('#order form').each(function(){
        var sform = $(this);
        sform.validate({
            rules: {
                address: {
                    required: "#delivery_method_dostavka:checked"
                },
                name: {
                    required : true
                },
                surname: {
                    required : true
                },
                telephone: {
                    required : true
                }
            },
            submitHandler: function(form) {
                var data_form = new Object();
                sform.find('input[type="text"],input[type="hidden"],textarea,select,input[type="radio"]:checked').each(function(){
                    data_form[$(this).attr('name')] = $(this).val();
                });
                jQuery.ajax({
                    type : "post",
                    dataType : "json",
                    url : '/wp-admin/admin-ajax.php?action=send_order',
                    data : {
                        form_id: sform.attr('id'),
                        data_form: data_form
                    },
                    success: function(response) {
                        if (response.status == 1) {
                            window.location.href = "/order-complete"
                        }
                    }
                });
            }
        });
    });




    // Переадресация при завершении заказа

    if ( $('body').is('.page-id-168')){

        setTimeout(function(){
            window.location.href = "/"
        }, 5000);
    }


    $('.models .colors a').click(function(){
        var model = $(this).parents('.models');
        var id = $(this).attr('href').replace('#active-','');
        model.removeClass('active-'+model.data('select')).addClass('active-'+id);
        model.data('select',id);
    });
    $('.models .photos a').click(function(){
        var model = $(this).parents('.models');
        var id = model.data('select');
        if ($(this).attr('href')=='#next'){
            if (id < model.data('models-count')){
                id++;
            } else {
                id=0;
            }

            model.removeClass('active-'+model.data('select')).addClass('active-'+id);
            model.data('select',id);
        } else {
            if (id > 0){
                id--;
            } else {
                id=model.data('models-count');
            }
            model.removeClass('active-'+model.data('select')).addClass('active-'+id);
            model.data('select',id);
        }
    });

    $('.radiobox').click(function(){
       if ( $(this).find( "input[type='radio']").is(':checked') ){
           $(this).addClass('checked');
           $(this).siblings('.radiobox').removeClass('checked');
       }
    });

    $('input[name="delivery_method"]').change(function(){
        var val = $(this).val();
        //$('#payment_method_block .radiobox:not(.show-always)').addClass('hide');
        $('#send-order [class *= "show-only-"]').addClass('hide');
        $('#send-order .show-only-'+val).removeClass('hide');
    });


});

function data_update(response){
    $('#basket-label #basket-count').html(response.total_count);
    $('#basket-label .list').html(response.in_basket);

    $('.basket-container').html(response.basket_container);
    $('.basket-title').html(response.basket_title);
}