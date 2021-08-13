$(document).ready(function(){
    var myLanguage = {
        errorTitle: 'There are some errors!'
    };

    $.validate({
        form : '#form-category-add',
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
        form : '#form-category-search',
        language : myLanguage,
        validateOnBlur : false,
        errorMessagePosition : 'top',
        onError : function() {
            //alert('alert !');
        },
        onSuccess : function() {
            //alert('success!');
            searchCategories();
        }
    });


    $('#form-category-search').submit(function(){
        return false;
    });


});

    function deleteElement(btn, e) {
        e.preventDefault();
        if (confirm("Are you sure you want to delete this item?")) {
            var obj = {
                ajax_action: 'category.delete',
                cat_id: $(btn).attr('cat_id')
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
            ajax_action : 'category.search',
            category : $('#category').val()

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

