window.onload = function () {

    $('#f_room_type_id').change(function () {
        id = $(this).val();
        if (id != '') {
            $('#f_price_result').html('<p class="text-warning">Carregando sugestão de preço...</p>');
            $.ajax({
                url: '/hotel/acomodacoes-tipos/preco/'+id,
                data: {id:id},
                type: 'post',
                success: function(e){
                    $('#f_price').val(e);
                    $('#f_price_result').html('<p class="text-success">Preço sugerido.</p>');
                }
            })
        }
    });

}