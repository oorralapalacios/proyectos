<meta charset='utf-8' />

 

<script>
    var tema= "ui-redmond";
    valagendaItems = [];
	
	 function createElementsAgenda()  {
         	
         	
            $('#eventWindowAgenda').jqxWindow({
                resizable: false,
                width: '100%',
                height: '100%',
                theme: tema,
                minWidth: 550,
                minHeight: 480,  
                isModal: true,
                modalOpacity: 0.01, 
                autoOpen: false,
                initContent: function () {}
            });
            $('#eventWindowAgenda').jqxWindow('focus');
            
        }
	
	  function initAgenda(){
	  	        var fa= new Date();
	          	$('#calendar').fullCalendar({
				header: {
					left: 'prevYear,prev,next,nextYear, today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
				theme:tema,
				lang: 'es',
				height: '100%',
				width: '100%',
				defaultView: 'month',
				allDaySlot: false,
				defaultDate: fa,
				//defaultDate:'2014-09-12',
				selectable: false,
				selectHelper: true,
				//timezone: 'UTC',
				//timeFormat:'YYYY-MM-DD HH:mm',
				select: function(start, end) {
						},
				editable: false,
				eventLimit: true, // allow "more" link when too many events
		
	          
				
			dayClick: function(date, view) {
					$('#calendar').fullCalendar('changeView', 'agendaDay');
					$('#calendar').fullCalendar('gotoDate', date);
					}
				
			});
	  }
	
	 function load_agenda(emp_id){
            initAgenda();
        	//valagendaItems.length=0;
        	//clearvalagendaItems();
	    	var url="<?php echo site_url("mar/gescitas/agendaempleado"); ?>"+"/"+emp_id;
	    	
	    	$.ajax({
			        type: "POST",
			        url:url,
			        async: true,
			        events: url,
			        success: function(datos){
			        				        	
			             valagendaItems=eval(datos);
			             //alert(valagendaItems[0].id);
			               //$('#calendar').fullCalendar('removeEvents');
                           $('#calendar').fullCalendar('addEventSource', valagendaItems);
                           //$('#calendar').fullCalendar('addEventSource', url);         
                           //$('#calendar').fullCalendar('rerenderEvents' );
			            		             
			        },
			        error: function (obj, error, objError){
			            //avisar que ocurrió un error
			        }
			});
        		
          }
          
           function borrarAgenda(){
        	valagendaItems.length=0;
   		    $('#calendar').fullCalendar('removeEvents');
   		    $('#calendar').fullCalendar('rerenderEvents' );
        }
          
          
            

</script>
<style>

#calendar {
		max-width: 100%;
		margin: 0 auto;
	}
</style>


<div style="visibility: hidden; display:none;" id="jqxWidgetAgenda">			
		<div style="display:none;" id="eventWindowAgenda">
            <div>Agenda de visitas</div>
            <div>
                <div>
                    <form id="frmAgenda">
						<div  id='calendar'></div>
                    </form>
                </div>
            </div>
      </div>
  </div>   
   
   


 

