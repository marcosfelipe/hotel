window.onload = function () {

    $('#generate_pdf').click(function () {
        button = $(this);
        $(this).html('Gerando...');
        content = $('#content-data').html();
        $.ajax({
            url: '/hotel/faturamento/gerar-pdf',
            data: {html: content},
            type: 'post',
            success: function (e) {
                $(button).after('<a  href="'+e+'" class="btn btn-primary">Baixar</a>');
                $(button).remove();
            }
        })
    });

};