window.onload = function(){

    $('#f_room_id').change(function(){
        id = $(this).val();
        if( id != '' ){
            $.ajax({
                url:'/hotel/acomodacoes/verificar/'+id,
                type : 'get',
                success: function(e){
                    $('#f_room_id_result').html(e);
                }
            })
        }else
            $('#f_room_id_result').html('');
    });

    $('#f_date_prevision').datetimepicker('setStartDate');
};