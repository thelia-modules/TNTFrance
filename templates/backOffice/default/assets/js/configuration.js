(function ($) {
    $(document).ready(function () {
        var products = $('#products_enabled').val(),
            options = $('#options_enabled').val(),
            labelFormat = $('#label_format').val();

        $('input[name="product"]').val(products.split(","));
        $('input[name="option"]').val(options.split(","));

        $('input.label_format_stda4').prop("checked", (-1 !== labelFormat.indexOf("STDA4")));
        $('input.label_format_thermal').prop("checked", (-1 !== labelFormat.indexOf("THERMAL")));
        $('input.label_format_thermal_no_logo').prop("checked", (-1 !== labelFormat.indexOf("NO_LOGO")));
        $('input.label_format_thermal_rotate_180').prop("checked", (-1 !== labelFormat.indexOf("ROTATE_180")));

        $("#configuration_form").on("submit", function () {
            var productsEnabled = $('input:checkbox[name=product]:checked').map(function () {
                return this.value;
            }).get();
            var optionsEnabled = $('input:checkbox[name=option]:checked').map(function () {
                return this.value;
            }).get();
            var labelFormatValue = [];

            $('#products_enabled').val(productsEnabled.join(','));
            $('#options_enabled').val(optionsEnabled.join(','));

            if ($('input.label_format_stda4').prop("checked")) {
                labelFormatValue.push('STDA4');
            } else {
                labelFormatValue.push('THERMAL');

                if ($('input.label_format_thermal_no_logo').prop("checked")) {
                    labelFormatValue.push('NO_LOGO');
                }
                if ($('input.label_format_thermal_rotate_180').prop("checked")) {
                    labelFormatValue.push('ROTATE_180');
                }
            }

            $('#label_format').val(labelFormatValue.join(','));
        });

        $('#free_shipping').on('change', function () {
            show_sheeping_configuration();
        });

        show_sheeping_configuration();

        function show_sheeping_configuration() {
            if ($('#free_shipping').is(':checked') === true) {
                $('#no_free_shipping').addClass('hidden');
            } else {
                $('#no_free_shipping').removeClass('hidden');
            }
        }
    });
})(jQuery);