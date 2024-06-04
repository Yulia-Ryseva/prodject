$(document).ready(function () {

    $('form#form-send').submit(function(e) {

        e.preventDefault();
        var href = $(this).attr('action');
        var certificateReg = /^[а-яА-ЯёЁa-zA-Z-0-9]+$/;
        var certificate = $('#certificate').val();
        var errors = false;
        $('span.errors').detach();

        if(certificate == '' || !certificateReg.test(certificate)) {
            $('#certificate').parent().find('.msg').addClass('errors').text('Ошибка ввода');  
            errors = true;
        }

        if(errors == true){
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: href,
                data: $(this).serialize(),
                dataType: 'json',
                success : function(data) {
                    $(".msg").html("").removeClass("error").removeClass("success");
                    if(data["textStatus"] == 'success') {

                        $('#certificate').parent().find('.msg').addClass('success').text(data.text); 
                        $.ajax({
                            type: "POST",
                            url: '/ajax/list.php',
                            data: {'AJAX': 'Y'},
                            success : function(datatext) {
                                $('.certificate-list').html(datatext);
                            }
                        });
                    } else {
                        $('#certificate').parent().find('.msg').addClass('errors').text(data.text); 
                    }                    
                }
            });

        }
        
    });

});