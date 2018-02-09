
function filterOrderDetails(fn) {
    var siteurl = $('#siteurl').val();
    //$('.loader').css('display', 'block');
    $('.transaction-content').html("<img class='loader' src='"+siteurl+"/assets/images/loader.gif'/>");
    if (fn != '' && typeof fn != 'undefined') {

        //$(location).attr('href',siteurl+'transdetail');
        var resetbtn = fn;
        $('#select1').prop('selectedIndex', 0);
        $('#select2').prop('selectedIndex', 0);
        resetbtn1();

    }
    else {
        var paymenttype = $('#select1').val();
    }
    resetbtn1();
    //var paymenttype = $('#select1').val();
    var orderstatus = $('#select2').val();
    var searchstr = $('#searchstr').val();
    var date_from = $('.clsdatefrom').attr('dtfrom');
    var date_to = $('.clsdateto').attr('dtto');
    siteurl += 'includes/order_history/ordersdetail/ajaxresult.php'
    //alert(siteurl);

    $.ajax({
        type: "POST",
        url: siteurl,
        data: {
            searchName: searchstr,
            paymenttype: paymenttype,
            orderstatus: orderstatus,
            resetbtn: resetbtn,
            date_from: date_from,
            date_to: date_to
        }
    })
    .done(function (msg) {
        msg1 = msg;
        setTimeout('loads()', 1000);
    });
}
function loads() {

    var obj = jQuery.parseJSON(msg1);
    //alert(obj.html);
    $('.transaction-content').html(obj.html);
    $('.ordertotal').html(obj.total);
    $('#select2').html(obj.selectbox);
                
    $(".ajax").colorbox({
        width: '30%',
        height: 'auto',
        title: ''
    });
    showMore();
}

function showMore() {

    var size_li = $(".transaction-content .transaction-row").size();
    var x = 5;
    $('.transaction-content .transaction-row:lt(' + x + ')').show();
    $('.show-more span').click(function () {
        x = (x + 5 <= size_li) ? x + 5 : size_li;
        if (size_li <= x) {
            $('.show-more').remove();
        }
        $('.transaction-content .transaction-row:lt(' + x + ')').show();
    });
}

function resetbtn1() {

    var $activate_selectator1 = $('#activate_selectator1');
    $activate_selectator1.click(function () {
        var $select1 = $('#select1');
        if ($select1.data('selectator') === undefined) {

            $select1.selectator({
                labels: {
                    search: 'Search here...'
                }
            });
            $activate_selectator1.val('destroy selectator');
        } else {
            //$select1.selectator('destroy');
            $activate_selectator1.val('activate selectator');
        }
    });

    var $activate_selectator2 = $('#activate_selectator2');
    $activate_selectator2.click(function () {
        var $select2 = $('#select2');
        if ($select2.data('selectator') === undefined) {
            $select2.selectator({
                useDimmer: true
            });
            $activate_selectator2.val('destroy selectator');
        } else {
            //$select2.selectator('destroy');
            $activate_selectator2.val('activate selectator');
        }
    });

    var $activate_selectator3 = $('#activate_selectator3');
    $activate_selectator3.click(function () {
        var $select3 = $('#select3');
        if ($select3.data('selectator') === undefined) {
            $select3.selectator({
                useSearch: false
            });
            $activate_selectator3.val('destroy selectator');
        } else {
            //$select3.selectator('destroy');
            $activate_selectator3.val('activate selectator');
        }
    });
    $activate_selectator1.trigger('click');
    $activate_selectator2.trigger('click');
    $activate_selectator3.trigger('click');
}
