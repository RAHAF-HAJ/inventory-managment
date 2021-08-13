    var myLanguage = {
        errorTitle: 'There are some errors!'
    };
    $.validate({
        form : '#form-inventory-add',
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

    function deleteInventory(btn, e) {
        e.preventDefault();
        if (confirm("Are you sure you want to delete this item?")) {
            var obj = {
                ajax_action: 'inventory.delete',
                inventory_id: $(btn).attr('inventory_id')
            };
            $.post(
                '/CM_App/public/index.php',
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

    function GetUsersOptions(){
        var obj = {
            ajax_action : 'user.options'
        };
        $.post(
            '/CM_App/public/index.php',
            obj,
            function(data){
                $('[name="manager"]').html(data);
            },
            'html'
        );
    }

    function LoadUsersOptionsToInput() {
        GetUsersOptions();
        // $('[name="manager"]').html(data);
        $('[name="manager"]').val($('selected_manager_id').val());
    }

    LoadUsersOptionsToInput();

    //Get Articles table
    function loadArticles(btn, event) {
        var inventory_id = $(btn).attr('inventory_id');
        var obj = {
            ajax_action: 'inventory.articles_options',
            inventory_id: inventory_id
        };
        console.log(obj);
        $.post(
            '/CM_App/public/index.php',
            obj,
            function (data) {

                if (data) {
                    $('#articles-modal .modal-body').html(data);
                    $('#articles-modal').modal('show');
                    console.log(data);
                } else {
                    alert("Something went wrong!");
                }
            },
            'html'
        );
        
        
    }


