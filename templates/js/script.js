var param;

$(document).ready(function(){

    init();

    $('body').on('keypress','#tag1,#tag2',function(){
        $(this).siblings(".input-group-btn").removeClass('hidden');
    });
    $('body').on('click','.input-group .btn-danger',function(){
        parent = $(this).parents('.input-group');
        parent.find('input').val( param[parent.find('input').attr('id')] );
        parent.find(".input-group-btn").addClass('hidden');
    });
    $('body').on('click','.input-group .btn-success',function(){
        parent = $(this).parents('.input-group');
        param[parent.find('input').attr('id')] = parent.find('input').val();
        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : '/php/ajax.php',
            data : {
                action: 'set_tag',
                id: parent.find('input').attr('id'),
                val: param[parent.find('input').attr('id')]
            },
            success: function(response) {
                if (response.status == 1){
                    parent.find(".input-group-btn").addClass('hidden');
                    use_response_data(response);
                }
            }
        });
    });
    $('body').on('click','#reload',function(){
        reload_data();
    });
    $('body').on('click','#auto',function(){
        if ( $(this).hasClass('active') ){
            $(this).removeClass('active');
            $('#reload').removeClass('disabled');
            clearInterval(timer);
        } else {
            $(this).addClass('active');
            $('#reload').addClass('disabled');
            var timer = setInterval(function() {
                reload_data();
            }, 5000);
        }
    });
});

function use_response_data(response){
    if ( response.column_tag1 || response.column_tag1=='' || response.column_tag1==null ){
        $('#column_tag1').html(response.column_tag1);
    }
    if ( response.column_tag2 || response.column_tag2=='' || response.column_tag2==null ){
        $('#column_tag2').html(response.column_tag2);
    }
    cross_tag();
}

function init(){
    jQuery.ajax({
        type : "post",
        dataType : "json",
        url : '/php/ajax.php',
        data : {
            action: 'get_param'
        },
        success: function(response) {
            if (response.status == 1){
                param = response.param;
                cross_tag();
            }
        }
    });
}

function cross_tag(){
    if ( param['tag1'] && param['tag2'] ){
        var array1 = [];
        $('#column_tag1 .insta-block').each(function(){
            array1[array1.length] = $(this).data('id');
        });
        var array2 = [];
        $('#column_tag2 .insta-block').each(function(){
            array2[array2.length] = $(this).data('id');
        });
        var cross = [];
        $('#cross_tags .insta-block').each(function(){
            cross[cross.length] = $(this).data('id');
        });
        var temp = difference( intersection(array1,array2), cross);

        for (var i=0; i<temp.length; i++)
        {
            $("div[data-id='"+temp[i]+"']").first().clone().prependTo("#cross_tags");
        }
    }
}

// Обновить
function reload_data(){
    jQuery.ajax({
        type : "post",
        dataType : "json",
        url : '/php/ajax.php',
        data : {
            action: 'reload'
        },
        success: function(response) {
            if (response.status == 1){
                use_response_data(response);
            }
        }
    });
}

// Пересечение
function intersection(A,B)
{
    var M=A.length, N=B.length, C=[];

    for (var i=0; i<M; i++)
    { var j=0, k=0;
        while (B[j]!==A[i] && j<N) j++;
        while (C[k]!==A[i] && k<C.length) k++;
        if (j!=N && k==C.length) C[C.length]=A[i];
    }

    return C;
}

// Вычитание
function difference(A,B)
{
    var M=A.length, N=B.length, C=[];

    for (var i=0; i<M; i++)
    { var j=0, k=0;
        while (B[j]!==A[i] && j<N) j++;
        while (C[k]!==A[i] && k<C.length) k++;
        if (j==N && k==C.length) C[C.length]=A[i];
    }

    return C;
}
