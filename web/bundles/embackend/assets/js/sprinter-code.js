
$("document").ready(function() {
    $("#codereservation").keyup(function() {
        $('#results').html(''); // on vide les resultats
       $("#results").show();

        if ($("#codereservation").val().length > 1) {

            $.ajax({
                type: 'get',
                url: 'http://localhost/Clients/Afrikhotel/web/app_dev.php/Gestionnaire/access/search-reservation/' + $('#codereservation').val(),

                beforeSend: function() {
                    if ($(".loading").length == 0) {
                        $("form .code").parent().append('<div class="loading"></div>');
                    }
                },
                success: function(data) {

                    $.each(data.codereserv, function(key, value) {
                        $('#results').append('<li style="width: 100%" ><a  onclick="selectname(\'' + value.numeroreservation +'\');return false"><span class="tt-dataset-0">' + value.numeroreservation + '</span></a></li>');

                    });
                }
            });
        } else {
             $("#results").val('');
        }
    });

});



function selectname(selected_value) {
    $("#codereservation").val(selected_value);
    $("#results").hide();
}