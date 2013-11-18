$(document).ready(function () {
    $('*[data-toggle="tooltip"]').tooltip();
    data_confirm();
    masks();
});

/*** Confirm dialog **/
var data_confirm = function () {
    $('a[data-confirm],button[data-confirm]').click(function () {
        var msg = $(this).data('confirm');
        return confirm(msg);
    });
};

masks = function () {
    $('.cep').mask('00000-000');
    $('.cpf').mask('000.000.000-00', {reverse: true});
    $('.money').mask("#.##0,00", {reverse: true, maxlength: false});

    var ptbr = {
        days: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado", "Domingo"],
        daysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab", "Dom"],
        daysMin: ["Do", "Se", "Te", "Qa", "Qi", "Se", "Sa", "Do"],
        months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro",
            "Outubro", "Novembro", "Dezembro"],
        monthsShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
        today: "Hoje"
    };

    $.fn.datetimepicker.dates['pt-BR'] = ptbr;
    $.fn.datepicker.dates['pt-BR'] = ptbr;

    $('.datetime').datetimepicker({
        format:'dd/mm/yyyy hh:ii:ss'
    });

    $('.date').datepicker({
        format:'dd/mm/yyyy',
        language:'pt-BR'
    });
};
