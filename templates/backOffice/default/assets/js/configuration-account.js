(function ($) {
    $('#sender_zip_code').on('input', function () {
        if ($(this).val().length < 2) {
            return;
        }

        $('#sender_city').addClass("loading");

        $.ajax({
            type: "GET",
            url: "/module/TNTFrance/get/cities/" + $(this).val(),
            dataType: "json",
            success: function (cities) {
                var $senderCity = $('#sender_city');
                var $newSenderCity;

                if (cities.length == 0) {
                    // convert the field to an input
                    $senderCity.each(function () {
                        var attributes = {
                            type: "text"
                        };

                        $.each(this.attributes, function(i, attribute) {
                            attributes[attribute.nodeName] = attribute.nodeValue;
                        });

                        $(this).replaceWith(function () {
                            return $("<input>", attributes);
                        });
                    });

                    $newSenderCity = $('#sender_city');

                    $newSenderCity.parent().addClass("has-error");
                    $newSenderCity.removeClass("loading");
                } else {
                    // convert the input to a select
                    $senderCity.each(function () {
                        var attributes = {};

                        $.each(this.attributes, function(i, attribute) {
                            if ($.inArray(attribute.nodeName, ["type", "value"]) == -1) {
                                attributes[attribute.nodeName] = attribute.nodeValue;
                            }
                        });

                        $(this).replaceWith(function () {
                            return $("<select>", attributes);
                        });
                    });

                    $newSenderCity = $('#sender_city');

                    var html = "";
                    for (var i = 0; i < cities.length; i++) {
                        html += "<option>" + cities[i] + "</option>";
                    }
                    $newSenderCity.html(html);

                    $newSenderCity.parent().removeClass("has-error");
                    $newSenderCity.removeClass("loading");
                }

            }
        });
    });
})(jQuery);