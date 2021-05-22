/**
 * Muchipio por Departamento
 * @since  12/5/2017
 */

$(document).ready(function () {
	    
    $('#depto').change(function () {
        $('#depto option:selected').each(function () {
            var depto = $('#depto').val();
            if (depto > 0 || depto != '-') {
                $.ajax ({
                    type: 'POST',
                    url: base_url + 'settings/mcpioList',
                    data: {'identificador': depto},
                    cache: false,
                    success: function (data)
                    {
                        $('#mcpio').html(data);
                    }
                });
            } else {
                var data = '';
                $('#mcpio').html(data);
            }
        });
    });
    
});