$(document).ready(function(){
    var myLanguage = {
        errorTitle: 'There are some errors!'
    };

    $.validate({
        form : '#form-role-add',
        language : myLanguage,
        validateOnBlur : false,
        errorMessagePosition : 'top',
        onError : function() {
            //alert('alert !');
        },
        onSuccess : function() {
            //alert('success!');
        }
    });

});

    function deleteElement(btn, e) {
        e.preventDefault();
        if (confirm("Are you sure you want to delete this item?")) {
            var obj = {
                ajax_action: 'role.delete',
                role_id: $(btn).attr('role_id')
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


