$(document).ready(function(){
    var myLanguage = {
        errorTitle: 'There are some errors!'
    };

    $.validate({
        form : '#form-user-add',
        language : myLanguage,
        modules : 'file',
        validateOnBlur : false,
        errorMessagePosition : 'top',
        onError : function() {
            //alert('alert !');
        },
        onSuccess : function() {
            //alert('success!');
        }
    });
    $.validate({
        form : '#form-user-search',
        language : myLanguage,
        validateOnBlur : false,
        errorMessagePosition : 'top',
        onError : function() {
            //alert('alert !');
        },
        onSuccess : function() {
            //alert('success!');
            searchUsers();
        }
    });

    $.validate({
        form : '#form-user-login',
        language : myLanguage,
        modules : 'security',
        validateOnBlur : false,
        errorMessagePosition : 'top',
        onError : function() {
            //alert('alert !');
        },
        onSuccess : function() {
            //alert('success!');
        }
    });
    $.validate({
        form : '#form-profile-edit',
        language : myLanguage,
        modules : 'security',
        validateOnBlur : false,
        errorMessagePosition : 'top',
        onError : function() {
            //alert('alert !');
        },
        onSuccess : function() {
            //alert('success!');
        }
    });


    $('#form-user-search').submit(function(){
        return false;
    });

    $('#login').keyup(function(){
        $('#default-pwd').text($(this).val());
    });

});

    function deleteElement(btn, e) {
        e.preventDefault();
        if (confirm("Are you sure you want to delete this item?")) {
            var obj = {
                ajax_action: 'user.delete',
                user_id: $(btn).attr('user_id')
            };
            $.post(
                'index.php',
                obj,
                function (data) {
                    if (data == 1) {
                        window.location.reload();
                    } else {
                        alert("There were some errors, Please try again.");
                    }
                },
                'html'
            );
        }
    }


    function searchCategories(){
        var obj = {
            ajax_action : 'user.search',
            user : $('#user').val()

        };
        $.post(
            'index.php',
            obj,
            function(data){
                $('.form-search-wrap').slideUp();
                $('.main-table tbody').html(data);
            },
            'html'
        );
    }

