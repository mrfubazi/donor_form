$(document).ready(function(){
    //select box
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
					$select1.selectator('destroy');
					$activate_selectator1.val('activate selectator');
				}
			});
			$activate_selectator1.trigger('click');

			var $activate_selectator2 = $('#activate_selectator2');
			$activate_selectator2.click(function () {
				var $select2 = $('#select2');
				if ($select2.data('selectator') === undefined) {
					$select2.selectator({
						useDimmer: true
					});
					$activate_selectator2.val('destroy selectator');
				} else {
					$select2.selectator('destroy');
					$activate_selectator2.val('activate selectator');
				}
			});
			$activate_selectator2.trigger('click');

	// date picker
	$( "#datepicker" ).datepicker();		
	$( "#datepicker1" ).datepicker();
	// popup
	
	$(".ajax").colorbox({width:'30%',height:'auto',title:''});
    showMore();
				
  
    
    // tooltip hover 
      $(".tooltip").hover(function(){
    $(".tooltip-hover").css("display","block");
    },function(){
    $(".tooltip-hover").css("display","none");
  });
    
/************
   For Select box in transaction details page
 ***************/

    
    
});



