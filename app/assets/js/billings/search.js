window.onload = function () {

    $('#generate_pdf').click(function () {
        button = $(this);
        $(this).html('Gerando...');
        content = '';
        $('.content-data').each(function () {
            content += $(this).html();
        });
        $.ajax({
            url: '/hotel/faturamento/gerar-pdf',
            data: {html: content},
            type: 'post',
            success: function (e) {
                $(button).after('<a target="_blank" href="' + e + '" class="btn btn-primary">Baixar</a>');
                $(button).remove();
            }
        })
    });

};