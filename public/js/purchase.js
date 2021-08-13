$(document).ready(function(){
    var myLanguage = {
        errorTitle: 'There are some errors!'
    };

    $.validate({
        form : '#form-pureshase-add',
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
    //     form : '#form-pureshase-search',
    //     language : myLanguage,
    //     validateOnBlur : false,
    //     errorMessagePosition : 'top',
    //     onError : function() {
    //         //alert('alert !');
    //     },
    //     onSuccess : function() {
    //         //alert('success!');
    //         searchPureshases();
    //     }
    // });

    //Clone functionality
    $('#clone').click(function (e) {
        $("select").select2("destroy");
        $('.select2').remove();
        var target = $(this).attr('target');
        var clone = $($(target)[0]).clone();
        $(clone).find('input').val('');
        $(clone).find('select').val('');
        var index = $(target).length;
        $(clone).attr('index', index);

        $(clone).find('.files').html('');

        clone.find('.expire label').attr('for' ,'dtp_input' + index);
        clone.find('.expire .input-group').attr('data-link-field', 'dtp_input' + index);
        clone.find('.expire input[type="hidden"]').attr('id', 'dtp_input' + index);

        clone.find('.form_date').datetimepicker({
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0
        });

        $(clone).insertAfter($(target)[ $(target).length - 1]);
        $('select').select2();
        e.preventDefault();
        e.stopPropagation();
    });

    if($('#note').length > 0)
        CKEDITOR.replace('note',{

            width: "100%",
            height: "100px"

        });
    if($('#subject').length > 0)
        CKEDITOR.replace('subject',{

            width: "100%",
            height: "100px"

        });

    $('.form_date').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
});

function generateUploadFiles(btn, e) {
    var item_index = $(btn).parents('.item').attr('index');
    var file_index = $(btn).attr('data-id');
    $(btn).attr('data-id', file_index + 1);
    console.log(item_index)
    console.log(file_index)
     var html = "<div class=\"col-sm-2 col-xs-12 upload-file\" data-id=\"\">\n" +
         "                                <div class=\"box-infos-search\">\n" +
         "                                    <section class=\"content-header box-infos-header\">\n" +
         "                                        <span class=\"content-title\"><i class=\"fa fa-image\"></i> Photo</span>\n" +
         "                                        <a href=\"#\" class=\"btn btn-default btn-search\" onclick=\"triggerInputFile('thumb"+ item_index.toString() + file_index.toString() +"', event);\">\n" +
         "                                            <i class=\"fa fa-search\"></i>\n" +
         "                                        </a>\n" +
         "                                    </section>\n" +
         "                                    <div class=\"box-infos text-center\">\n" +
         "                                        <img class=\"thumb-preview\" src=\"http://localhost/CM_APP/public/img/thumbs/articles/no_thumb.jpg\">\n" +
         "                                        <a href=\"#\" class=\"badge thumb-reset\" onclick=\"resetThumb( event);\">Reset</a>\n" +
         "\n" +
         "                                        <div class=\"form-group\"><input name=\"thumb["+ item_index +"][]\" type=\"file\" id=\"thumb"+ item_index.toString() + file_index.toString() +"\" class=\"hidden-input-file\" onchange=\"readUrlToPreview(this);\" data-validation=\"mime size\" data-validation-allowing=\"jpg\" data-validation-error-msg=\"Photo image should be less than 1M\" value=\"\"></div>                                    </div>\n" +
         "                                </div>\n" +
         "                            </div>";
    $(btn).parents('.item').find('.files').append(html);
    e.preventDefault();
    e.stopPropagation();
}

function readUrlToPreview(input){
    if (input.files && input.files[0]){
        var file = input.files[0];

        var reader = new FileReader();

        reader.readAsDataURL(file);

        reader.onload = function (e) {
            $(input).parents('.upload-file').find('.thumb-preview').attr('src', e.target.result);
            // $('.thumb-preview').attr('src', e.target.result);
            // $('.thumb-reset').css('display', 'inline-block');
        }


    }
}

function deletePureshase(btn, e) {
    e.preventDefault();
    if (confirm("Are you sure you want to delete this item?")) {
        var obj = {
            ajax_action: 'purchase.delete',
            purchase_id: $(btn).attr('purchase_id')
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

//Get suppliers
function GetSuppliersOptions(){
    var obj = {
        ajax_action : 'supplier.options'
    };
    $.post(
        '/CM_App/public/index.php',
        obj,
        function(data){
            $('[name="supplier_id"]').html(data).val($('[name="selected_supplier_id"]').val());
        },
        'html'
    );
}

GetSuppliersOptions();

//Get Inventories
function GetInventoriesOptions(){
    var obj = {
        ajax_action : 'inventory.options'
    };
    $.post(
        '/CM_App/public/index.php',
        obj,
        function(data){
            $('[name="inventory_id[]"]').html(data);
            $('.item').each(function () {
                $(this).find('[name="inventory_id[]"]').val($(this).find('[name="selected_inventory_id[]"]').val())
            })
        },
        'html'
    );
}
GetInventoriesOptions();
// Get Articles
function GetArticlesOptions(){
    var obj = {
        ajax_action : 'article.options'
    };
    $.post(
        '/CM_App/public/index.php',
        obj,
        function(data){
            $('[name="article_id[]"]').html(data);
            $('.item').each(function () {
                $(this).find('[name="article_id[]"]').val($(this).find('[name="selected_article_id[]"]').val())
            })
        },
        'html'
    );
}
GetArticlesOptions();

//Get Articles table
function loadArticles(btn, event) {
    var purchase_id = $(btn).attr('purchase_id');
    var obj = {
        ajax_action : 'purchase_detail.table',
        purchase_id: purchase_id
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



