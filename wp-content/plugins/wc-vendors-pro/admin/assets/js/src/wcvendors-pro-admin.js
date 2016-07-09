(function( $ ) {
	'use strict';

	// On load check which screen we're on based on element and adjust as necessary
	$( window ).load( function() {

		if ( $( '#wcv_commission_type' ).length ) { 
			var commission_type = $( '#wcv_commission_type' ).val(); 
			var amount_row 		= $( '.wcv_commission_amount_input'); 
			var percent_row 	= $( '.wcv_commission_percent_input');
			var fee_row 		= $( '.wcv_commission_fee_input'); 
			toggle_commission_fields( commission_type, amount_row, percent_row, fee_row ); 

		} else if ( $( '#_wcv_commission_type' ).length ) { 
			var commission_type = $( '#_wcv_commission_type' ).val(); 
			var amount_row 		= $( '._wcv_commission_amount_input'); 
			var percent_row 	= $( '._wcv_commission_percent_input');
			var fee_row 		= $( '._wcv_commission_fee_input'); 
			toggle_commission_fields( commission_type, amount_row, percent_row, fee_row ); 

		} else if ( $('#commission_type').length ) { 
			var commission_type = $('#commission_type').val(); 
			var amount_row 		= $('#commission_amount' ).closest('tr');
			var percent_row 	= $('#commission_percent' ).closest('tr'); 
			var fee_row 		= $('#commission_fee' ).closest('tr'); 
			toggle_commission_fields( commission_type, amount_row, percent_row, fee_row ); 
		}
		
	});

	// Product Commission fields 
	$('#_wcv_commission_type').on('change', function( ) { 

		var commission_type = $(this).val();
		var amount_row 		= $('._wcv_commission_amount_input'); 
		var percent_row 	= $('._wcv_commission_percent_input');
		var fee_row 		= $('._wcv_commission_fee_input'); 

		toggle_commission_fields( commission_type, amount_row, percent_row, fee_row ); 
		
	}); 

	// Product Commission fields 
	$('#wcv_commission_type').on('change', function( ) { 

		var commission_type = $(this).val();
		var amount_row 		= $('.wcv_commission_amount_input'); 
		var percent_row 	= $('.wcv_commission_percent_input');
		var fee_row 		= $('.wcv_commission_fee_input'); 

		toggle_commission_fields( commission_type, amount_row, percent_row, fee_row ); 
		
	}); 

	// Global settings fields 
	$('#commission_type').on('change', function( ) { 

		var commission_type = $(this).val(); 
		var amount_row 		= $('#commission_amount').closest('tr');
		var percent_row 	= $('#commission_percent').closest('tr'); 
		var fee_row 		= $('#commission_fee').closest('tr'); 

		toggle_commission_fields( commission_type, amount_row, percent_row, fee_row ); 

	}); 

	function toggle_commission_fields( commission_type, amount_row, percent_row, fee_row ) { 

		switch( commission_type ) {
		    case 'fixed':
		    	amount_row.show(); 
		        percent_row.hide(); 
		        fee_row.hide(); 
		        break;
		    case 'fixed_fee':
		    	amount_row.show(); 
		    	fee_row.show(); 
		    	percent_row.hide(); 
		        break;
		    case 'percent':
			    percent_row.show(); 
		    	amount_row.hide(); 
		        fee_row.hide(); 
		        break;    
		    case 'percent_fee':
			    percent_row.show(); 
			    fee_row.show(); 
		    	amount_row.hide(); 
		        break;    
		    default:
		    	amount_row.hide(); 
				percent_row.hide(); 
				fee_row.hide(); 
		}

	}


	if ( $( '.wcv-file-uploader_wcv_store_banner_id' ).find('img').length > 0 ){ 
		$('#_wcv_add_wcv_store_banner_id').hide(); 
	} else { 
		$('#_wcv_remove_wcv_store_banner_id').hide(); 
	}

	if ( $( '.wcv-file-uploader_wcv_store_icon_id' ).find('img').length > 0 ){ 
		$('#_wcv_add_wcv_store_icon_id').hide(); 
	} else { 
		$('#_wcv_remove_wcv_store_icon_id').hide(); 
	}

	// Handle Add banner
	$('#_wcv_add_wcv_store_banner_id').on( 'click', function(e) { 
		e.preventDefault(); 
		file_uploader( '_wcv_store_banner_id' ); 
		return false; 
	}); 

	$('#_wcv_remove_wcv_store_banner_id').on('click', function(e) { 
		e.preventDefault(); 
		// reset the data so that it can be removed and saved. 
		var upload_notice = $('#_wcv_store_banner_id').data('upload_notice'); 
		$( '.wcv-file-uploader_wcv_store_banner_id' ).html(''); 
		$( '.wcv-file-uploader_wcv_store_banner_id' ).append( upload_notice ); 
		$( '#_wcv_store_banner_id').val(''); 
		$('#_wcv_add_wcv_store_banner_id').show(); 
		$('#_wcv_remove_wcv_store_banner_id').hide(); 
	});

	// Handle Add banner
	$('#_wcv_add_wcv_store_icon_id').on( 'click', function(e) { 
		e.preventDefault(); 
		file_uploader( '_wcv_store_icon_id' ); 
		return false; 
	}); 

	$('#_wcv_remove_wcv_store_icon_id').on('click', function(e) { 
		e.preventDefault(); 
		// reset the data so that it can be removed and saved. 
		var upload_notice = $('#_wcv_store_icon_id').data('upload_notice'); 
		$( '.wcv-file-uploader_wcv_store_icon_id' ).html(''); 
		$( '.wcv-file-uploader_wcv_store_icon_id' ).append( upload_notice ); 
		$( '#_wcv_store_icon_id').val(''); 
		$('#_wcv_add_wcv_store_icon_id').show(); 
		$('#_wcv_remove_wcv_store_icon_id').hide(); 
	});



	function file_uploader( id )
	{

		var media_uploader, json, attachment_image_url;

		if ( undefined !== media_uploader ) { 
			media_uploader.open(); 
			return; 
		}

	    media_uploader = wp.media({
      		title: $( '#' + id ).data('window_title'), 
      		button: {
        		text: $( '#' + id ).data('save_button'), 
      		},
      		multiple: false  // Set to true to allow multiple files to be selected
    	});

	    media_uploader.on( 'select' , function(){
	    	json = media_uploader.state().get('selection').first().toJSON(); 

	    	if ( 0 > $.trim( json.url.length ) ) {
		        return;
		    }

		    attachment_image_url = json.sizes.thumbnail ? json.sizes.thumbnail.url : json.url;

		    $( '.wcv-file-uploader' + id )
		    	.html( '<img src="'+ attachment_image_url + '" alt="' + json.caption + '" title="' + json.title +'" style="max-width: 100%;" />' ); 
		    
		    $('#' + id ).val( json.id ); 

			$('#_wcv_add' + id ).hide(); 
			$('#_wcv_remove' + id ).show(); 

	    });

	    media_uploader.open();
	}



})( jQuery );
