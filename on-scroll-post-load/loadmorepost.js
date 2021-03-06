
jQuery(document).ready(function(){

jQuery('#loaderimage_more').hide();
jQuery('#loaderimage').hide();
jQuery('.no_more_posts').hide();
var loading=true;
/************** on post name click load post *****************/
jQuery('.tax-post').click(function(){
		//jQuery(this).css('color', 'red');
		var id = jQuery(this).attr('data-id');
		var name = jQuery(this).attr('data-taxname');
		jQuery.ajax({
        	type: "POST",
       	 	dataType: "JSON",
       	 	url: ajaxurl + '?action=post_taxonomy_display',
        	data: 
			{
				'id' :id,
				'name' : name 
				},
			beforeSend : function () {
				jQuery('#loaderimage').show();
			jQuery('.post-rem').html('');
		//	jQuery('.ajaxload').hide();
			},
        	success: function(response){
				if(response.status){
					jQuery('.ajaxload').attr('data-more','yes');
					jQuery('.post-rem').html(response.msg);
					jQuery('.ajaxload').attr('data-postslug',id);
					jQuery('.no_more_posts').hide();
					jQuery('.ajaxload').attr('data-offset',3);
				}else {
					//alert('hello');
					//jQuery('.post-rem').html(response.msg);
					jQuery('.no_more_posts').show();
					jQuery('.ajaxload').attr('data-more','no');
					
				}
							},
			 complete:function(){
    				 jQuery("#loaderimage").hide();
			
			 },
			error:{}
	 });
		
	});
	


/****************** load more click get new post **********************/

	jQuery('.ajaxload').click(function(event){
	event.preventDefault();
	var slug = jQuery('.ajaxload').attr('data-postslug');
	var offset = parseInt(jQuery('.ajaxload').attr('data-offset')); 
	
	jQuery.ajax({
        	type: "POST",
       	 	dataType: "JSON",
       	 	url: ajaxurl + '?action=post_taxonomy_display_load_more',
        	data: 
			{
				'id' :slug,
				'name' : name ,
				'offset' : offset
				},
			beforeSend : function () {
				jQuery('#loaderimage_more').show();
			jQuery('.ajaxload').hide();
			},
        	success: function(response){
				if(response.status){
						jQuery('.ajaxload').attr('data-more','yes');
					jQuery('.loadmorediv').append(response.msg);
					var no = (offset + 3);
					jQuery('.ajaxload').attr('data-offset',no);
					jQuery('.no_more_posts').hide();
					
				}else {
					
						jQuery('.ajaxload').attr('data-more','no');
				}
			},
			 complete:function(){
  
   				 jQuery("#loaderimage_more").hide();
				  if(jQuery('.ajaxload').attr('data-more') != 'no'){
				 jQuery('.ajaxload').show();
				  }
			 },
			error:{}
	 });
	
	});

});
/**************** on scroll load more post *****************/	


jQuery(document).ready(function(){
	
	 jQuery('.ajaxload').hide();
 jQuery(window).scroll(function(){
  var position = jQuery(window).scrollTop();
  var bottom = jQuery(document).height() - jQuery(window).height();
  if( position == bottom){
	   var slug = jQuery('.ajaxload').attr('data-postslug');
	   var offset = parseInt(jQuery('.ajaxload').attr('data-offset')); 
	    jQuery.ajax({
            url: ajaxurl+'?action=post_taxonomy_display_load_more',
            type: 'POST',
			dataType: "JSON",
            data: {
				'id':slug,
				'offset':offset
				},
			beforeSend : function () {
				jQuery('#loaderimage_more').show();
			
			},
            success: function(response){
				if(response.status)
				{
					jQuery('.ajaxload').attr('data-more','yes');
					jQuery('.loadmorediv').append(response.msg);
					var no = (offset + 3);
					jQuery('.ajaxload').attr('data-offset',no);
					jQuery('.no_more_posts').hide();
					loading = false;
				}else {
					
						jQuery('.ajaxload').attr('data-more','no');
				}
				},
				 complete:function(){
   				 	jQuery("#loaderimage_more").hide();
				
			 },
				
        });
	   return false;
  }
 });
});