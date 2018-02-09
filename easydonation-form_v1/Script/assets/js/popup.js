function popupLook() {
//    var i=2;
//    for(i=2;i>1;i--){
//        document.getElementById('div_'+i).style.display='none';
//    }
//    document.getElementById("previous").disabled = true; 
}

/**
 * Code to validation esasy donation installation form
 * 
 * @param no parameter
 * 
 * @return Boolean true / false
 * 
 * 
 * 
 */

$(document).ready(function() {
    lastDivId = $('.box-content').children().last().attr('id');
    firstDivId = $('div.box-content div:first-child').attr("id");
    secondDivId = $("div.box-content div.box:nth-child(2)").attr('id');
    secondLastDivId = $("div.box-content div.box:nth-last-child(2)").attr('id');

    $(".next").click(function() {
        firstDivId = $('div.box-content div:first-child').attr("id");
        activeTabId = $('div.box.active').attr('id');
        if (activeTabId == secondLastDivId) {
            
            $('.next').hide();
        }
        if (activeTabId == firstDivId) {
            retRslt = validate_installation_form_level_1();
            if (!retRslt) {
                return retRslt;
            }
        }

        if (activeTabId == secondDivId) {
            retRslt = validate_installation_form_level_2();
            if (!retRslt) {
                
                $("#"+secondDivId).children('span').css({"color": "red"});
                $("#"+secondDivId).children('span').text("Please Select Minimum One payment Gateway To use.!");
                return retRslt;
            }

        }

        $('#' + activeTabId).removeClass("active");
        $('#' + activeTabId).addClass('inactive');
        $('#' + activeTabId).css('display', "none");
        $("#" + activeTabId).next("div.box").removeClass("inactive");
        nextDivId = $("#" + activeTabId).next("div.box").attr('id');
        if (nextDivId == lastDivId) {
            $("form#install_f").submit();
        } else {
            $("#" + activeTabId).next("div.box").addClass('active').css('left', "0");
        }





    });

    $('.skip').click(function() {

    })

    $('input').keyup(function() {
        var inputId = $(this).attr('id');
        if (inputId == 'admin_email_id' || inputId == 'site_email_id') {
            validate_email_id(inputId);
        }

    });

    $(".parentCheckBox").click(
            function() {
                $(this).parents('fieldset:eq(0)').find('.childCheckBox').prop('checked', this.checked);
            }
    );
    //clicking the last unchecked or checked checkbox should check or uncheck the parent checkbox
    $('.childCheckBox').click(
            function() {
                if (!$('.childCheckBox').is(':checked')) {
                    $("input.parentCheckBox").prop('checked', false);
                } else {

                    $(".parentCheckBox").prop('checked', true);
                }

            }
    );


});

/**
 * Function to validate email ids 
 * 
 *@param no parameter 
 *
 *@returns {Boolean}
 * 
 * 
 */

function validate_installation_form_level_1() {
    var rslt = validate_email_id('admin_email_id');
    var rslt1 = validate_email_id('site_email_id');
    if (rslt && rslt1) {
        return true;
    } else {
        return false;
    }
}


function validate_email_id(id) {
    var rslt = 1;
    var inputVal = $('#' + id).val();
    var regexp = /^[A-Za-z0-9]+((\.|\_){1}[a-zA-Z0-9]+)*@([a-zA-Z0-9]+([\-]{1}[a-zA-Z0-9]+)*[\.]{1})+[a-zA-Z]{2,4}$/;
    if (inputVal != '') {
        ret = regexp.test(inputVal);
        if (ret) {
            rslt = 1;
            $('#' + id).css('border-color', "");
        } else {
            rslt = 0;
            $('#' + id).css('border-color', "red");
        }
    } else {
        rslt = 0;
        $('#' + id).css('border-color', "red");
    }

    return rslt;

}

/**
 * Function to validate payment gateway selection form
 * 
 * @param no parameter
 * @returns Boolean
 * 
 * 
 */
function validate_installation_form_level_2() {
    var resp = false;

    if ($('input#paypal').is(':checked') || $('input#creditcard').is(':checked') || $('input#banktransfer').is(':checked') || $('input#stripe').is(':checked')) {
        var resp = true;
    }
    
  return resp;
}