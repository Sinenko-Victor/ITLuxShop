$(document).ready(function(){  
    //console.log('work');
    $('#cart a').click(function(){
        
        var id = $(this).data('id');
        var num = document.getElementById('num'+id).value;

        $.ajaxSetup({cache: false}); //Отключаем кэширование AJAX-запросов
        //console.log(id);
        //console.log(num);
        $.get(
            '/vcart/' + id + '/' + num,
            function(data){
                //console.log('Аякс запрос прошол');
                $('#cart_res').html(data);
            } 
        );
    });
});