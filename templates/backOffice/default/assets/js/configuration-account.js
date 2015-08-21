(function ($) {
    $('#sender_zip_code').on('input', function () {
        if ($(this).val().length < 2) {
            return;
        }

        var $senderCity = $('#sender_city');

        $senderCity.addClass("loading");

        $.ajax({
            type: "GET",
            url: "/module/TNTFrance/get/cities/" + $(this).val(),
            dataType: "json"
        }).done(function (cities) {
            var html = "";
            for (var i = 0; i < cities.length; i++) {
                html += "<option>" + cities[i] + "</option>";
            }
            $senderCity.html(html);

            $senderCity.removeClass("loading");
            if (cities.length == 0) {
                $senderCity.parent().addClass("has-error");
            } else {
                $senderCity.parent().removeClass("has-error");
            }
        });
    });
})(jQuery);