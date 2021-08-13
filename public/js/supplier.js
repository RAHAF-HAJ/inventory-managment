$(document).ready(function(){
    var myLanguage = {
        errorTitle: 'There are some errors'
    };

    $.validate({
        form : '#form-supplier-add',
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
    //     form : '#form-supplier-search',
    //     language : myLanguage,
    //     validateOnBlur : false,
    //     errorMessagePosition : 'top',
    //     onError : function() {
    //         //alert('alert !');
    //     },
    //     onSuccess : function() {
    //         //alert('success!');
    //         searchSuppliers();
    //     }
    // });

    $('.btn-infos-search').click(function(){
        LoadSuppliers();
        $('#myModal').modal('show');
    });



    $('#form-supplier-search').submit(function(){
        return false;
    });


});

    function deleteElement(btn, e) {
        e.preventDefault();
        if (confirm("Are you sure?")) {
            var obj = {
                ajax_action: 'supplier.delete',
                supplier_id: $(btn).attr('supplier_id')
            };
            $.post(
                '/CM_App/public/index.php',
                obj,
                function (data) {

                    if (data == 1) {
                        window.location.reload();
                    } else {
                        alert("There were some errors");
                    }
                },
                'html'
            );
        }
    }

    function LoadSuppliers(){
        var obj = {
            ajax_action : 'supplier.modal'
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



function AddSupplier(form){
        if($(form).isValid()) {
            var obj = {
                ajax_action: 'supplier.add',
                name: $('[name="name"]').val(),
                tel: $('[name="tel"]').val(),
                email: $('[name="email"]').val(),
                zip_code: $('[name="zip_code"]').val(),
                city: $('[name="city"]').val(),
                address: $('[name="address"]').val()
            };
            $.post(
                '/CM_App/public/index.php',
                obj,
                function (data) {
                    console.log(data)
                    window.location.reload();
                },
                'json'
            );
        }
}

    function searchSuppliers(){
        var obj = {
            ajax_action : 'supplier.search',
            ref : $('#ref').val(),
            desig : $('#desig').val(),
            supplier_id : $('#supplier_id').val(),
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
        $('.box-infos-id').val($(btn).attr('supplier_id'));
        $('.box-infos-name').text($(tr).children('.supplier_name').text());
        $('.box-infos-city').text($(tr).children('.supplier_city').text());
        $('.box-infos-address').text($(tr).children('.supplier_address').text());
        $('#myModal').modal('hide');
    }

//Get Articles table
function loadArticles(btn, event) {
    var supplier_id = $(btn).attr('supplier_id');
    var obj = {
        ajax_action : 'purchase_detail.table',
        supplier_id: supplier_id
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