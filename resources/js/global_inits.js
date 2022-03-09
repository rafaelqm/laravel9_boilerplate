$(function () {
    let mask = function (val) {
            return val.replace(/\D/g, '').length === 9
                ? '00000-0000'
                : '0000-00009';
        },
        options = {
            onKeyPress: function (val, e, field, options) {
                field.mask(mask.apply({}, arguments), options);
            },
        };

    let SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11
                ? '(00) 00000-0000'
                : '(00) 0000-00009';
        },
        spOptions = {
            onKeyPress: function (val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            },
        };

    $('.celphone').mask(SPMaskBehavior, spOptions);
    $('.credit_card').mask('0000 0000 0000 0000');
    $('.card_expiration_date').mask('00/0000');
    $('.phone').mask(mask, options);
    $('.cep').mask('00000-000');
    $('.cpf').mask('999.999.999-99');
    $('.cnpj').mask('99.999.999/9999-99');
    $('.rg').mask('99.999.999-A');
    $('.hora').mask('99:99');
    $('.money').maskMoney({
        allowNegative: true,
        thousands: '.',
        decimal: ',',
        allowZero:true
    });
    $('.zipcode').mask('00000-000');

    $('.datetimepicker').datetimepicker({
        format: 'DD/MM/YYYY HH:mm:ss',
        useCurrent: true,
        icons: {
            up: 'icon-arrow-up-circle icons font-2xl',
            down: 'icon-arrow-down-circle icons font-2xl',
        },
        sideBySide: true,
    });
    $('.datepicker').datetimepicker({
        format: 'DD/MM/YYYY',
        useCurrent: true,
        icons: {
            up: 'icon-arrow-up-circle icons font-2xl',
            down: 'icon-arrow-down-circle icons font-2xl',
        },
        sideBySide: true,
    });

    if (!Modernizr.inputtypes.date) {
        $('input[type=date]').each(function (index, obj) {
            var data = $(obj).val();
            if (data != '' && (data.indexOf('-') > 1)) {
                var ano = data.substring(0, 4);
                var mes = data.substring(5, 7);
                var dia = data.substring(8, 10);
                var data_formatada = dia + '/' + mes + '/' + ano;

                $(obj).attr('type', 'text').val(data_formatada).datetimepicker({
                    format: 'DD/MM/YYYY',
                    useCurrent: true,
                    icons: {
                        up: 'icon-arrow-up-circle icons font-2xl',
                        down: 'icon-arrow-down-circle icons font-2xl',
                    },
                    sideBySide: true,
                });
            }
        });

        $('input[type=date]').attr('type', 'text').datetimepicker({
            format: 'DD/MM/YYYY',
            useCurrent: true,
            icons: {
                up: 'icon-arrow-up-circle icons font-2xl',
                down: 'icon-arrow-down-circle icons font-2xl',
            },
            sideBySide: true,
        });
    }

    if (!Modernizr.inputtypes['datetime-local']) {
        $('input[type=datetime-local]').each(function (index, obj) {
            var data = $(obj).val();
            if (data != '' && (data.indexOf('-') > 1)) {
                var ano = data.substring(0, 4);
                var mes = data.substring(5, 7);
                var dia = data.substring(8, 10);
                var hora = data.substring(11, 16);
                var data_formatada = dia + '/' + mes + '/' + ano + ' ' + hora ;

                $(obj).attr('type', 'text').val(data_formatada).datetimepicker({
                    format: 'DD/MM/YYYY HH:mm',
                    useCurrent: true,
                    icons: {
                        up: 'icon-arrow-up-circle icons font-2xl',
                        down: 'icon-arrow-down-circle icons font-2xl',
                    },
                    sideBySide: true,
                });
            }
        });

        $('input[type=datetime-local]').attr('type', 'text').datetimepicker({
            format: 'DD/MM/YYYY HH:mm',
            useCurrent: true,
            icons: {
                up: 'icon-arrow-up-circle icons font-2xl',
                down: 'icon-arrow-down-circle icons font-2xl',
            },
            sideBySide: true,
        });
    }

    $('.select2').each(function (n, el) {
        let $el = $(el);
        let placeholder = $el.find('[value=""]').first().text()
            || $el.prop('placeholder')
            || $el.data('placeholder')
            || '-';

        $el.select2({
            placeholder: placeholder,
            theme: 'bootstrap4',
            language: 'pt-BR',
            width: '100%',
            allowClear: true,
        });
    });

    $('[data-toggle="tooltip"]').tooltip(
        {
            container: 'body'
        }
    );

    $('form:not(.js-no-overlay)').submit(function(event) {
        $('.card-body:first').append('<div class="overlay"><i class="fas fa-sync fa-spin"></i></div>');
    });
});

function string_to_slug (str) {
    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();

    // remove accents, swap ñ for n, etc
    let from = 'àáäãâèéëêìíïîòóöôõùúüûñç·/_,:;';
    let to = 'aaaaaeeeeiiiiooooouuuunc------';
    for (let i=0, l=from.length ; i<l ; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-'); // collapse dashes

    return str;
}

function floatToMoney(number, prefix) {
    prefix = prefix == undefined ? 'R$ ' : prefix;
    return prefix + number.toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

function moneyToFloat(money) {
    return parseFloat(money.replace(/\./g, '').replace(',', '.'), 10);
}
