$(document).ready(function(){
    var myLanguage = {
        errorTitle: 'There are some errors!'
    };

    $.validate({
        form : '#form-article-add',
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
        form : '#form-article-search',
        language : myLanguage,
        validateOnBlur : false,
        errorMessagePosition : 'top',
        onError : function() {
            //alert('alert !');
        },
        onSuccess : function() {
            //alert('success!');
            searchArticles();
        }
    });

    $('.btn-infos-search').click(function(){
        LoadSuppliers();
        $('#myModal').modal('show');
    });


    $('#form-article-search').submit(function(){
        return false;
    });


});

    function deleteArt(btn, e) {
        e.preventDefault();
        if (confirm("Are you sure you want to delete this item?")) {
            var obj = {
                ajax_action: 'article.delete',
                art_id: $(btn).attr('art_id')
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

    function GetSuppliersOptions(){
        var obj = {
            ajax_action : 'supplier.options'
        };
        $.post(
            '/CM_App/public/index.php',
            obj,
            function(data){
                $('[name="supplier_id"]').html(data);
            },
            'html'
        );
    }

    function searchArticles(){
        var obj = {
            ajax_action : 'article.search',
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

    function LoadSupplierOptionsToInput() {
        GetSuppliersOptions();
        $('[name="supplier_id"]').html(data);
        $('[name="supplier_id"]').val($('selected_supplier_id').val());
    }

    LoadSupplierOptionsToInput()