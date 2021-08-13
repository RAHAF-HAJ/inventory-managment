$(document).ready(function(){

    //init arts as global to fetch all the constrains with one call
    window.arts = [];
    var myLanguage = {
        errorTitle: 'There are some errors!'
    };

    $.validate({
        form : '#form-sale-add',
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
    //Clone functionality
    $('#clone').click(function (e) {
        $("select").select2("destroy");
        $('.select2').remove();
        var target = $(this).attr('target');
        var clone = $($(target)[0]).clone();
        $(clone).find('input').val('');
        $(clone).find('.note').hide();
        $(clone).find('select').val('');
        $(clone).find('select[name="article_id[]"]').html('');
        $(clone).attr('index', $(target).length);
        $(clone).find('.files').html('');
        $(clone).insertAfter($(target)[ $(target).length - 1]);
        $('select').select2();
        e.preventDefault();
        e.stopPropagation();
    });

    //Add constrains to selling products from inventories

    //CK editor config
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

    //Trigger previously added products to show the constrains on qty and price
    $('.previous-added').trigger('change');

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


function deleteSale(btn, e) {
    e.preventDefault();
    if (confirm("Are you sure you want to delete this item?")) {
        var obj = {
            ajax_action: 'sale.delete',
            sale_id: $(btn).attr('sale_id')
        };
        $.post(
            '/CM_App/public/index.php',
            obj,
            function (data) {

                if (data) {
                    window.location.reload();
                } else {
                    alert("There were some errors, Please try again.");
                }
            },
            'html'
        );
    }
}

//Get clients
function GetClientsOptions(){
    var obj = {
        ajax_action : 'client.options'
    };
    $.post(
        '/CM_App/public/index.php',
        obj,
        function(data){
            $('[name="client_id"]').html(data).val($('[name="selected_client_id"]').val());
        },
        'html'
    );
}

GetClientsOptions();

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

//Get Articles table
function loadArticles(btn, event) {
    var sale_id = $(btn).attr('sale_id');
    var obj = {
        ajax_action : 'sale_detail.table',
        sale_id: sale_id
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

//Get Available products
function loadAvailableArticles(select, event) {

    var inventory_id = $(select).val();
    $(select).parents('.item').find('.note').remove();
    var obj = {
        ajax_action : 'inventory.available_articles',
        inventory_id: inventory_id,
        ele_index: $(select).parents('.item').attr('index')
    };
    $.post(
        '/CM_App/public/index.php',
        obj,
        function (data) {
            var item_index = this.data.substr(this.data.indexOf('ele')).split('=')[1];
            var item_selector = '.item[index="'+item_index+'"]';
            if (data) {
                if(data.length > 0) {
                    var options_html = '<option>Choose a product</option>';
                    data.forEach(function (ele) {

                        options_html += '<option data-qty="'+ ele.remaining_qty +'"  data-price="'+ ele.purchase_maximum_price +'" value="' + ele.id + '">' + ele.name + '</option>';
                    });
                    $(item_selector).find('[name="article_id[]"]').select2('destroy');
                    $(item_selector).find('[name="article_id[]"]').html(options_html);
                    $(item_selector).find('[name="article_id[]"]').select2();

                }
               console.log(options_html);
            } else {
                alert("Something went wrong!");
            }
        },
        'json'
    );
}

function addProductConstrains(select, event) {
    console.log(select);
    var selected_option = $(select).find('option:selected')[0];
    var qty = $(selected_option).attr('data-qty');
    var price = $(selected_option).attr('data-price');
    var item_index = $(select).parents('.item').attr('index');
    var item_selector = '.item[index="'+item_index+'"]';
    $(item_selector).find('.note').remove();
    var qty_note = '<h6 class="note"><span class="fa fa-info-circle"></span>You can sale maximum' + qty + '  items</h6>';
    $(item_selector).find('[name="qty[]"]').attr('max', qty);
    $(qty_note).insertBefore(item_selector + ' [name="qty[]"]');
    var qty_note = '<h6 class="note"><span class="fa fa-info-circle"></span>You can sale minimum ' + price + '  IQD</h6>';
    $(item_selector).find('[name="price[]"]').attr('min', parseInt(price) + 1);
    $(qty_note).insertBefore(item_selector + ' [name="price[]"]');
}

//USD calculation
function calcUSD(input, event) {
    var usd_rate = 0.00084;
    var item_index = $(input).parents('.item').attr('index');
    var item_selector = '.item[index="'+item_index+'"]';
    var usd_input_selector = item_selector + ' [name="price_usd[]"]';
    var iqd_value = $(input).val();
    if(iqd_value) {
        $(usd_input_selector).val(Math.round(iqd_value * usd_rate));
    }
}
