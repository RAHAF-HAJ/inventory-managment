$(document).ready(function(){
    var myLanguage = {
        errorTitle: 'There are some errors'
    };

    $.validate({
        form : '#form-client-add',
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
    // $.validate({
    //     form : '#form-client-search',
    //     language : myLanguage,
    //     validateOnBlur : false,
    //     errorMessagePosition : 'top',
    //     onError : function() {
    //         //alert('alert !');
    //     },
    //     onSuccess : function() {
    //         //alert('success!');
    //         searchArticles();
    //     }
    // });
    //
    // $('.btn-infos-search').click(function(){
    //     LoadSuppliers();
    //     $('#myModal').modal('show');
    // });

    $('#form-client-search').submit(function(){
        return false;
    });


});

    function deleteElement(btn, e) {
        e.preventDefault();
        if (confirm("Are you sure you want to delete this item?")) {
            var obj = {
                ajax_action: 'client.delete',
                client_id: $(btn).attr('client_id')
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

    function LoadSuppliers(){
        var obj = {
            ajax_action : 'client.modal'
        };
        $.post(
            '/CM_App/public/index.php',
            obj,
            function(data){
                $('.modal-content .modal-body .table-responsive table tbody').html(data);
            },
            'html'
        );
    }

    function searchArticles(){
        var obj = {
            ajax_action : 'client.search',
            ref : $('#ref').val(),
            desig : $('#desig').val(),
            client_id : $('#client_id').val(),
            category_id : $('#category_id').val(),
            unit_id : $('#unit_id').val(),
            tva : $('#tva').val()
        };
        $.post(
            '/CM_App/public/index.php',
            obj,
            function(data){
                $('.form-search-wrap').slideUp();
                $('.main-table tbody').html(data);
            },
            'html'
        );
    }

    function selectSupplier(btn, e){
        e.preventDefault();
        var tr = $(btn).parent().parent();
        $('.box-infos-id').val($(btn).attr('client_id'));
        $('.box-infos-name').text($(tr).children('.client_name').text());
        $('.box-infos-city').text($(tr).children('.client_city').text());
        $('.box-infos-address').text($(tr).children('.client_address').text());
        $('#myModal').modal('hide');

    }

//Get Articles table
function loadArticles(btn, event) {
    var client_id = $(btn).attr('client_id');
    var obj = {
        ajax_action : 'sale_detail.table',
        client_id: client_id
    };
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