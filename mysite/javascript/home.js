$(document).ready(function(){

	$('#trainButton').live('click',function(){
		$('#busBox').hide();
		$('#trainBox').show();
		$("body").css({ 'background-image': 'url(/url-to-image.jpg)'});
		$("body").css({ 'background-color': '#FEF2F0'});
		return false;
	});
	
	$('#busButton').live('click',function(){
		$('#trainBox').hide();
		$('#busBox').show();
		$("body").css({ 'background-image': 'url(/url-to-image.jpg)'});
		$("body").css({ 'background-color': '#E7EDF4'});
		return false;
	});
	
	
	//Load Autocomplete for Stops
	$('#trainBox').css('display','none');
	$('#userLocation').live('blur',function(){
		$("#smsString").html("<span>sms handler: </span>");
		$addy = $(this).val();
		$("#firstResults").html('<img src="themes/jmi/img/ajax-loader.gif" />');
		$.get('home/checkStop?q='+$(this).val(),function(data){
			if(data=='invalid'){
				return false;
			}
			$("#firstResults").html(data).fadeIn();
			$("#forAddress").addClass('active');
			$("#forAddress input").attr("checked","checked");
			$("#smsString").append("<span>I am at "+$addy+"</span>");
		});
		console.log($(this).val());
	});
	
	$('#transitNumber').live('blur',function(){
		$("#secondResults").html('<img src="themes/jmi/img/ajax-loader.gif" />');
		$route = $(this).val();
		$.get('home/checkRoute?q='+$(this).val(),function(data){
			if(data=='invalid'){
				return false;
			}
			$("#secondResults").html(data).fadeIn();
			$startdest = $('#startDest').html();
			$enddest = $('#endDest').html();
			console.log($(this).val());
			$("#userDestination").html("<option value='"+$startdest+"'>"+$startdest+"</option>");
			$("#userDestination").append("<option value='"+$enddest+"'>"+$enddest+"</option>")
			$("#forRoute").addClass('active');
			$("#forRoute input").attr("checked","checked");
			$("#smsString").append("<span> taking bus "+$route+"</span>");
		});
		console.log($(this).val());
	});
	
	$('#userDirection').live('select',function(){
		console.log($("#userDestination option").index($("#elementid option:selected")));
		$direction = $(this).val();
		$("#smsString").append("<span> towards "+$direction+"</span>");
		$("#forDirection").addClass('active');
		$("#forDirection input").attr("checked","checked");
	});
	console.log(window.location.host);
	if(window.location.host == "beta.justmissedit.mobi" || window.location.host == "justmissedit.phillyopen.org"){
		$('#subscribeCloseBtn').show();
		$('#subscribeModalContent').html('<h1 style="text-align:center">Just<span style="color:#F15D30">Missed</span>It.<span style="color:#144B88">mobi</span><br /><small>Southeastern Pennsylvania Transit Application</small></h1><h3>Thanks for subscribing!</h3><h2 style="color:#F15D30;text-align:center">+1-215-874-6340</h2><p style="color:#144B88;text-align:center">Text your query to the number above.<br />e.g. <strong>"3rd and Poplar bus 27"</strong></p>');
		
	}
	$("#subscribeModal").overlay({

		// custom top position
		fixed: false,
		// some mask tweaks suitable for facebox-looking dialogs
		mask: {

			// you might also consider a "transparent" color for the mask
			color: '#C9D7F1',
			

			// load mask a little faster
			loadSpeed: 200,

			// very transparent
			opacity: 0.70
		},

		// disable this for modal dialog-type of overlays
		closeOnClick: false,
		
		// load it immediately after the construction
		load: true
		//Submit form data with Ajax
	}); //end overlay
});
