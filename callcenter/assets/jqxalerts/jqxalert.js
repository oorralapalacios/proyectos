 jqxAlert = {  
           // top offset.  
           top: 0,  
           // left offset.  
           left: 0,  
           // opacity of the overlay element.  
           overlayOpacity: 0.2,  
           // background of the overlay element.  
           overlayColor: '#ddd',  
           okButton: '&nbsp;OK&nbsp;',         // text for the OK button
		   cancelButton: '&nbsp;Cancel&nbsp;', // text for the Cancel button
		   yesButton: '&nbsp;Yes&nbsp;',         // text for the OK button
		   noButton: '&nbsp;No&nbsp;', // text for the Cancel button
		   dialogClass: null,                  // if specified, this class will be applied to all dialogs
           // display alert.  
           /*alert: function (message, title) {  
                if (title == null) title = 'Alert';  
                jqxAlert._show(title, message);  
           }, */ 
           alert: function(message, title, callback) {
			if( title == null ) title = 'Alert';
			jqxAlert._show(title, message, null, 'alert', function(result) {
				if( callback ) callback(result);
			});
		   },
           confirm: function(message, title, callback) {
			if( title == null ) title = 'Confirm';
			jqxAlert._show(title, message, null, 'confirm', function(result) {
				if( callback ) callback(result);
			});
		   },
		   verify: function(message, title, callback) {
			if( title == null ) title = 'Verify';
			jqxAlert._show(title, message, null, 'verify', function(result) {
				if( callback ) callback(result);
			});
		   },
           // initializes a new alert and displays it.  
           _show: function (title, msg, value, type, callback) {  
                jqxAlert._hide();  
                jqxAlert._handleOverlay('show');  
                
                $("BODY").append(  
                          '<div class="jqx-alert" style="width: auto; height: auto; overflow: hidden; white-space: nowrap;" id="alert_container">' +  
                          '<div id="alert_title"></div>' +  
                          '<div id="alert_content">' +  
                               '<div id="message"></div>' +  
                          '</div>' +  
                          '</div>');  
                          /*'<input style="margin-top: 10px;" type="button" value="Ok" id="alert_button"/>' +*/
                $("#alert_title").text(title);  
                $("#alert_title").addClass('jqx-alert-header');  
                $("#alert_content").addClass('jqx-alert-content');
                $("#message").text(msg);  
                /*$("#alert_button").width(70);  
                  $("#alert_button").click(function () {  
                     jqxAlert._hide();  
                }); */ 
                jqxAlert._setPosition();  
                switch( type ) {
				case 'alert':
					$("#message").after('<div id="alert_panel"><input type="button" value="' +  jqxAlert.okButton + '" id="button_ok" /></div>');
					$("#button_ok").click( function() {
						jqxAlert._hide();
						callback(true);
					});
					$("#button_ok").focus().keypress( function(e) {
						if( e.keyCode == 13 || e.keyCode == 27 ) $("#button_ok").trigger('click');
					});
				break;
				case 'confirm':
					$("#message").after('<div id="alert_panel"><input type="button" value="' + jqxAlert.okButton + '" id="button_ok" /> <input type="button" value="' + jqxAlert.cancelButton + '" id="button_cancel" /></div>');
					$("#button_ok").click( function() {
						jqxAlert._hide();
						if( callback ) callback(true);
					});
					$("#button_cancel").click( function() {
						jqxAlert._hide();
						if( callback ) callback(false);
					});
					$("#button_ok").focus();
					$("#button_ok, #button_cancel").keypress( function(e) {
						if( e.keyCode == 13 ) $("#button_ok").trigger('click');
						if( e.keyCode == 27 ) $("#button_cancel").trigger('click');
					});
				break;
				case 'verify':
					$("#message").after('<div id="alert_panel"><input type="button" value="' + jqxAlert.yesButton + '" id="button_yes" /> <input type="button" value="' + jqxAlert.noButton + '" id="button_no" /></div>');
					$("#button_yes").click( function() {
						jqxAlert._hide();
						if( callback ) callback(true);
					});
					$("#button_no").click( function() {
						jqxAlert._hide();
						if( callback ) callback(false);
					});
					$("#button_yes").focus();
					$("#button_yes, #button_no").keypress( function(e) {
						if( e.keyCode == 13 ) $("#button_yes").trigger('click');
						if( e.keyCode == 27 ) $("#button_no").trigger('click');
					});
				break;
				
			  }
			  $("#alert_panel").addClass('jqx-alert-panel');
           },  
           // hide alert.  
           _hide: function () {  
                $("#alert_container").remove();  
                jqxAlert._handleOverlay('hide');  
           },  
           // initialize the overlay element.   
           _handleOverlay: function (status) {  
                switch (status) {  
                     case 'show':  
                          jqxAlert._handleOverlay('hide');  
                          $("BODY").append('<div id="alert_overlay"></div>');  
                          $("#alert_overlay").css({  
                               position: 'absolute',  
                               zIndex: 99998,  
                               top: '0px',  
                               left: '0px',  
                               width: '100%',  
                               height: $(document).height(),  
                               background: jqxAlert.overlayColor,  
                               opacity: jqxAlert.overlayOpacity  
                          });  
                          break;  
                     case 'hide':  
                          $("#alert_overlay").remove();  
                          break;  
                }  
           },  
           // sets the alert's position.  
           _setPosition: function () {  
                // center screen with offset.  
                var top = (($(window).height() / 2) - ($("#alert_container").outerHeight() / 2)) + jqxAlert.top;  
                var left = (($(window).width() / 2) - ($("#alert_container").outerWidth() / 2)) + jqxAlert.left;  
                if (top < 0) {  
                     top = 0;  
                }  
                if (left < 0) {  
                     left = 0;  
                }  
                // set position.  
                $("#alert_container").css({  
                     top: top + 'px',  
                     left: left + 'px'  
                });  
                // update overlay.  
                $("#alert_overlay").height($(document).height());  
           }  
      }  