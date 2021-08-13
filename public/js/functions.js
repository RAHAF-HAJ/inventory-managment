
    function searchToogle(className, e){
        e.preventDefault();
        $('.' + className).toggle();
    }

    function readUrl(input){
        if (input.files && input.files[0]){
            var file = input.files[0];

            var reader = new FileReader();

            reader.readAsDataURL(file);

            reader.onload = function (e) {
                $('.thumb-preview').attr('src', e.target.result);
                $('.thumb-reset').css('display', 'inline-block');
            }


        }
    }

    function triggerInputFile(input, e){
        e.preventDefault();
        $('#' + input).click();

    }
    function resetThumb(e){
        e.preventDefault();
        $('.thumb-preview').attr('src', 'img/thumbs/articles/no_thumb.jpg');
        $('.thumb-reset').hide();
    }
    function resetAvatar(btn, e){
        e.preventDefault();
        $('.thumb-preview').attr('src', 'img/avatar/0.jpg');
        $(btn).parent().append('<input type="hidden" name="remove_avatar" value="1">');
        $('.thumb-reset').hide();
    }

    function nFormat(number) {
        number = parseFloat(Math.round(number * 100) / 100).toFixed(2);
        return (""+number).replace(/\B(?=(?:\d{3})+(?!\d))/g," ");
    }
