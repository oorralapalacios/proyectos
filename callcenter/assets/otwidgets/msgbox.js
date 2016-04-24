// Msgbox 1.5 by Omar Orrala 
// http://thrivingkings.com/Msgbox
//
// Button text added by Adam Bezulski
//

function Msgbox(string, args, callback)
	{
	var default_args =
		{
		'confirm'		:	false, 		// Ok and Cancel buttons
		'verify'		:	false,		// Yes and No buttons
		'input'			:	false, 		// Text input (can be true or string for default text)
		'animate'		:	false,		// Groovy animation (can true or number, default is 400)
		'textOk'		:	'Ok',		// Ok button default text
		'textCancel'	:	'Cancel',	// Cancel button default text
		'textYes'		:	'Yes',		// Yes button default text
		'textNo'		:	'No'		// No button default text
		}
	
	if(args) 
		{
		for(var index in default_args) 
			{ if(typeof args[index] == "undefined") args[index] = default_args[index]; } 
		}
	
	var aHeight = $(document).height();
	var aWidth = $(document).width();
	$('body').append('<div class="MsgboxOverlay" id="aOverlay"></div>');
	$('.MsgboxOverlay').css('height', aHeight).css('width', aWidth).fadeIn(100);
	$('body').append('<div class="MsgboxOuter"></div>');
	$('.MsgboxOuter').append('<div class="MsgboxInner"></div>');
	$('.MsgboxInner').append(string);
    $('.MsgboxOuter').css("left", ( $(window).width() - $('.MsgboxOuter').width() ) / 2+$(window).scrollLeft() + "px");
    
    if(args)
		{
		if(args['animate'])
			{ 
			var aniSpeed = args['animate'];
			if(isNaN(aniSpeed)) { aniSpeed = 400; }
			$('.MsgboxOuter').css('top', '-200px').show().animate({top:"100px"}, aniSpeed);
			}
		else
			{ $('.MsgboxOuter').css('top', '100px').fadeIn(200); }
		}
	else
		{ $('.MsgboxOuter').css('top', '100px').fadeIn(200); }
    
    if(args)
    	{
    	if(args['input'])
    		{
    		if(typeof(args['input'])=='string')
    			{
    			$('.MsgboxInner').append('<div class="aInput"><input type="text" class="aTextbox" t="aTextbox" value="'+args['input']+'" /></div>');
    			}
    		else
    			{
				$('.MsgboxInner').append('<div class="aInput"><input type="text" class="aTextbox" t="aTextbox" /></div>');
				}
			$('.aTextbox').focus();
    		}
    	}
    
    $('.MsgboxInner').append('<div class="aButtons"></div>');
    if(args)
    	{
		if(args['confirm'] || args['input'])
			{ 
			$('.aButtons').append('<button value="ok">'+args['textOk']+'</button>');
			$('.aButtons').append('<button value="cancel">'+args['textCancel']+'</button>'); 
			}
		else if(args['verify'])
			{
			$('.aButtons').append('<button value="ok">'+args['textYes']+'</button>');
			$('.aButtons').append('<button value="cancel">'+args['textNo']+'</button>');
			}
		else
			{ $('.aButtons').append('<button value="ok">'+args['textOk']+'</button>'); }
		}
    else
    	{ $('.aButtons').append('<button value="ok">Ok</button>'); }
	
	$(document).keydown(function(e) 
		{
		if($('.MsgboxOverlay').is(':visible'))
			{
			if(e.keyCode == 13) 
				{ $('.aButtons > button[value="ok"]').click(); }
			if(e.keyCode == 27) 
				{ $('.aButtons > button[value="cancel"]').click(); }
			}
		});
	
	var aText = $('.aTextbox').val();
	if(!aText) { aText = false; }
	$('.aTextbox').keyup(function()
    	{ aText = $(this).val(); });
   
    $('.aButtons > button').click(function()
    	{
    	$('.MsgboxOverlay').remove();
		$('.MsgboxOuter').remove();
    	if(callback)
    		{
			var wButton = $(this).attr("value");
			if(wButton=='ok')
				{ 
				if(args)
					{
					if(args['input'])
						{ callback(aText); }
					else
						{ callback(true); }
					}
				else
					{ callback(true); }
				}
			else if(wButton=='cancel')
				{ callback(false); }
			}
		});
	}
