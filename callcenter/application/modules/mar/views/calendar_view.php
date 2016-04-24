<meta charset='utf-8' />
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdatetimeinput.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxcalendar.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxtooltip.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/globalization/globalize.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxscrollbar.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxlistbox.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxcombobox.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdropdownlist.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxtabs.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.filter.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.sort.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.pager.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxpanel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.edit.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.selection.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.grouping.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.columnsresize.js"></script>

<link href='<?php echo base_url();?>assets/fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='<?php echo base_url();?>assets/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='<?php echo base_url();?>assets/fullcalendar/lib/moment.min.js'></script>
<script src='<?php echo base_url();?>assets/fullcalendar/fullcalendar.min.js'></script>
<script src='<?php echo base_url();?>assets/fullcalendar/lang-all.js'></script>

<link rel="stylesheet" href="<?php echo base_url();?>assets/jqyui/themes/base/jquery.ui.all.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/jqyui/themes/redmond/jquery.ui.all.css">
<script src="<?php echo base_url();?>assets/jqyui/ui/jquery.ui.core.js"></script>
<script src="<?php echo base_url();?>assets/jqyui/ui/jquery.ui.widget.js"></script>
<script src="<?php echo base_url();?>assets/jqyui/ui/jquery.ui.accordion.js"></script>

 

<script>
    var tema= "ui-redmond";
    valagendaItems = [];
	$(document).ready(function() {
		
		$('#jqxTabs1').jqxTabs({theme: tema, width: '100%', height: '100%'});
		
        mlistaEmpleados();
        var iemp = $("#listempleado").jqxDropDownList('getSelectedItem');
        load_agenda(iemp.value);
        gridCitas(iemp.value);
        $('#listempleado').on('select', function (event) {
          	        var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
		            load_agenda(iemp.value);
		             gridCitas(iemp.value);
                  });	
		
	});
	
	 function adpempleados(){
        	var datos =
				{
					datatype: "json",
					datafields: [
						{ name: 'id' },
						{ name: 'nombres' },
						{ name: 'apellidos' },
						{ name: 'empleado' }
					],
					url: '<?php echo site_url("emp/empleados/getJerarquia"); ?>',
					async: false
				};
				
		         var dataAdapter = new $.jqx.dataAdapter(datos); 
        	    return dataAdapter;
        }
	
	 function mlistaEmpleados(){
         	 $('#listempleado').jqxDropDownList({
							source: adpempleados(),
							width: 300,
							//height: 20,
							theme: tema,
							selectedIndex: 0,
							displayMember: 'empleado',
							valueMember: 'id'
					}); 
         }
       
	
	 function load_agenda(emp_id){
        
        	valagendaItems.length=0;
        	//clearvalagendaItems();
	    	var url="<?php echo site_url("mar/agenda/agendaempleado"); ?>"+"/"+emp_id;
	    	
	    	$.ajax({
			        type: "POST",
			        url:url,
			        async: true,
			        success: function(datos){
			        				        	
			             valagendaItems=eval(datos);
			             //alert(valagendaItems[0].id);
			               //$('#calendar').fullCalendar('removeEvents');
                           $('#calendar').fullCalendar('addEventSource', valagendaItems);         
                           //$('#calendar').fullCalendar('rerenderEvents' );
			            		             
			        },
			        error: function (obj, error, objError){
			            //avisar que ocurrió un error
			        }
			});
        	
        	
        	
          	var fa= new Date();
	          	$('#calendar').fullCalendar({
				header: {
					left: 'prevYear,prev,next,nextYear, today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
				theme:tema,
				lang: 'es',
				//height: 230,
				//width: 700,
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
				
				eventResize: function(event, delta, revertFunc) {
	               ///alert(event.id + " fin es ahora " + event.end.format());
		           if (confirm("Esta seguro de aplicar el cambio?")) {
		             var id=event.id;
			    	 var index = valgetItemIndex(id);
	                 valagendaItems[index].start = event.start.format();
				     valagendaItems[index].end = event.end.format();
			            
			        }else{
			           revertFunc();
			        }
		
		        },
		        eventDrop: function(event, delta, revertFunc) {
	
		             //alert(event.id + " se ha movido a " + event.start.format());
		
			         if (confirm("Esta seguro de aplicar el cambio?")) {
			         	 var id=event.id;
			    	     var index = valgetItemIndex(id);
	                     valagendaItems[index].start = event.start.format();
				         valagendaItems[index].end = event.end.format();
			           
			         }else{
			         	 revertFunc();
			         }
	
	           },
	           /* eventClick: function(calEvent, jsEvent, view) {

			        //alert('Event: ' + calEvent.id);
			  
			         if (confirm("Desea eliminar el evento?")) {
			         	 var id=calEvent.id;
			         	 $('#calendar').fullCalendar('removeEvents',id);
			    	     var index = valgetItemIndex(id);
	                  	  valagendaItems.splice(index, 1);
	                  	  
			           
			         }else{
			         	 revertFunc();
			         }
			      			
			    },*/
				//events: url,
				
			dayClick: function(date, view) {
					$('#calendar').fullCalendar('changeView', 'agendaDay');
					$('#calendar').fullCalendar('gotoDate', date);
					}
				
			});
          	
          }
          
          
        function adpCitas(emp_id){
		var url = "<?php echo site_url("mar/agenda/agendaempleado"); ?>"+"/"+emp_id;
		var source =
        {
            datatype: "json",
            datafields: [
                { name: 'id', type: 'numeric' },
                { name: 'cita_id', type: 'numeric' },
                { name: 'start', type: 'string' },
				{ name: 'end', type: 'string' },
				{ name: 'campana', type: 'string' },
				{ name: 'con_identificacion', type: 'string' },
				{ name: 'contacto', type: 'string' },
				{ name: 'ruc', type: 'string' },
			    { name: 'razon_social', type: 'string' },
				{ name: 'ciudad', type: 'string' },
				{ name: 'direccion', type: 'string' },
				{ name: 'estado', type: 'string' }
            ],
            id: 'id',
            url: url,
            pagesize: 20,
            async: false
        };
		 var dataAdapter = new $.jqx.dataAdapter(source);
		 return dataAdapter;
		}
          
          function gridCitas(empid){
			$("#jqxgrid").jqxGrid({
            width : '100%',
            height: '100%',
            theme: tema,
            source: adpCitas(empid),
            //groupable: true,
            sortable: true,
            //showfilterrow: true,
            //groupsexpandedbydefault: true,
            filterable: true,
            pageable: true,
            //autoheight: true,
            columnsresize: true,
            //pagermode: 'simple',
            //showtoolbar: true,
             columns: [
                { text: 'Id', datafield: 'id', width: '5%',hidden:true },
               	{ text: 'cita_id', datafield: 'cita_id', width: '5%',hidden:true },
				{ text: 'Inicia', datafield: 'start', width: '10%'},
				{ text: 'Finaliza', datafield: 'end', width: '10%'},
				{ text: 'Campaña', datafield: 'campana', width: '10%'},
				{ text: 'Identificación', datafield: 'con_identificacion', width: '10%' },
				{ text: 'Contacto', datafield: 'contacto', width: '15%' },
				{ text: 'RUC', datafield: 'ruc', width: '10%' },
				{ text: 'Razón Social', datafield: 'razon_social', width: '15%' },
				{ text: 'Ciudad', datafield: 'ciudad', width: '15%' },
				{ text: 'Direccion', datafield: 'direccion', width: '20%'},
				               
              
            ],
             
        });
		}
    

</script>
<style>

	#centracal {
		margin: 40px 0px;
		padding: 0;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		font-size: 14px;
	}

#calendar {
		max-width: 55%;
		margin: 0 auto;
	}
</style>

<div class="main">
 <div class='titnavbg'>
    <div class='titnavtit'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/seg.png">&nbsp;&nbsp;Marketing: Agenda de ventas</div>
    <div class='titnavlog'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/log_titulo.png"></div>
  
 </div>
 <div style='margin-left: 0px; margin-top: 5px;' id='jqxMenu'></div>
 <div style='float: left;' id='listempleado'></div>
 <div style='margin-left: 0px; margin-top: 35px;' id='jqxTabs1'>
				                 <ul>
				                    <li style="margin-left: 30px;">Lista de visitas</li>
				                    <li>Calendario</li>
				                   
				                    
				                 </ul>
				                 
	                    	     <div style='margin-left: 0px; margin-top: 35px;' id="jqxgrid"></div>
	                    	    
				                 <div>
		                              <div id='centracal'>
                                       	<div  id='calendar'></div>
                                     </div>
	                    	     </div>	
	                    	     
	                    	     
	                    	     
 </div>


 
 

