<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdatetimeinput.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxcalendar.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxtooltip.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/globalization/globalize.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxscrollbar.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxlistbox.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxcombobox.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/globalization/globalize.culture.es-ES.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/fullcalendar/lib/moment.min.js"></script>
<script type="text/javascript">

     function rechazar(conta_id, camp_id){
     	document.getElementById("frmRechaza").reset();	
     	createElementsRechazar();
     	$("#eventWindowRechaza").jqxWindow('open');
     	info_rechazo(camp_id);
     	razones_rechaza(camp_id, 3);
      	
     }
 
     function createElementsRechazar() {
            $('#eventWindowRechaza').jqxWindow({
            	resizable: false,
                width: 500,
                Height: 300,
                theme: tema,
                //minHeight: 300,
                isModal: true,
                modalOpacity: 0.01,   
                initContent: function () {
                	$('#reid').jqxInput({theme: tema,disabled: true, width: '100px', height: 20});
                	$('#reidcampana').jqxInput({theme: tema,width: '100px', height: 20});
                	$('#reidcontacto').jqxInput({theme: tema,width: '100px', height: 20});
                	$('#retexto_rechaza').jqxPanel({theme: tema, width: 470, height: 70});
                    $("#rebtnOk").jqxButton({theme: tema,width: '70px', height: 25 });
                    
                    $("#rebtnOk").click(function () {
   		           	  //alert('ok');
   		           	  var contacto_id=$('#didcontacto').jqxInput('val');
   		              var campana_id=$('#didcampana').jqxInput('val');
   		              var telefono=$('#dtelefono').jqxInput('val');
   		              var padre_id=$('#didllamada').jqxInput('val');
   		              var inicio=$('#dinicio').jqxInput('val');
   		              var razon=$('#rejqxRazon').val();
   		              var proceso=$('#vproceso').val();
   		              var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
				      var empleado_id=iemp.value;	
   		              if (!razon==""){
   		              	finalizarNoInteres(contacto_id,empleado_id,campana_id,telefono,padre_id,inicio,razon,proceso);
   		              }else{
   		              	jqxAlert.alert('Selecione una razón');
   		              }
   		           	  
   		       
   		            });		
   		                 				
                }
            });
            $('#eventWindowRechaza').jqxWindow('focus');
            $('#eventWindowRechaza').jqxValidator('hide');
        }

      
         
        
        function razones_rechaza(camp_id, tabla_id) {
        	
        	   var url="<?php echo site_url("mar/campanas/confparametros"); ?>"+"/"+camp_id+"/"+tabla_id;
               var source ={
						                datatype: "json",
						                datafields: [
                   					      { name: 'id', type: 'number' },
			               		          { name: 'descripcion', type: 'string' },
					                      
					                    ],
						                id: 'id',
						                url: url,
						            };
			             
                   
                 var dataAdapter = new $.jqx.dataAdapter(source, {
						                //loadComplete: function (data) { },
						                //loadError: function (xhr, status, error) { }      
						            });
									         
              
               
                                                  
                                          
                //$("#rejqxRazon").jqxListBox({ theme:tema, source: dataAdapter, displayMember: "descripcion", valueMember: "descripcion", width: 470, height: 130});
               
			    $('#rejqxRazon').jqxDropDownList({theme:tema,
               	                          selectedIndex: 0, autoDropDownHeight: true, promptText: "Ingrese motivo de rechazo:", 
                                          source: dataAdapter, displayMember: "descripcion", valueMember: "descripcion", 
                                          width: 470, height: 22});
            }
            
            function  info_rechazo(camp_id){
          	
          	  $('#retexto_rechaza').jqxPanel('clearcontent');
          	   var url="<?php echo site_url("mar/contactos/campana"); ?>"+"/"+camp_id;
          	   var source ={
						                datatype: "json",
						                datafields: [
													{ name: 'id' },
													{ name: 'nombre' },
													{ name: 'descripcion' },
													{ name: 'texto_rechazo' }
													],
						                id: 'id',
						                url: url,
						            };
				
				 var dataAdapter = new $.jqx.dataAdapter(source, {
						                loadComplete: function (data) { 
						                	  
						                	   var container;
						                	   container = data.texto_rechazo;
						                	 
						                	   $('#retexto_rechaza').jqxPanel('append', container);
						                	 
   		                                 
						                },
						               //loadError: function (xhr, status, error) { }
						            });
									         
             dataAdapter.dataBind(); 
		 	
          }
          
          
        function finalizarNoInteres(contacto_id,empleado_id,campana_id,telefono,padre_id,inicio,razon,proceso){
	     	       var url = "<?php echo site_url("mar/contactos/ajax"); ?>";
	     	       var oper='addllamada';
				      var llamada = {  
		                        accion: oper,
		                        padre_id: padre_id,
		                        contacto_campana_id: $("#vid").val(),
		                        contacto_id: contacto_id,
		                        empleado_id: empleado_id,
		                        campana_id: campana_id,
								telefono: telefono,
								inicio: inicio,
								fin: moment().format('YYYY-MM-DD HH:mm:ss'),
		                		llamada_estado: 'Finalizada',
		                		proceso:proceso,
		                		respuesta: 'No interesado',
		                		observacion: razon
								
						    };	
						   
							$.ajax({
		                        type: "POST",
		                        url: url,
		                        data: llamada,
		                        success: function (data) {
		                         	                          
		                           //var llamada_id=data;                   					          
		                           if(data=true){
		                           	       
		                           		    $("#eventWindowRechaza").jqxWindow('hide');
		                           		    $('#eventWindowDialogo').jqxWindow('hide');
		                                    $("#gtelefonosGrid").jqxGrid('updatebounddata');
		                                    $('#eventWindowVisualizar').jqxWindow('hide');  
		                                    $("#jqxgrid").jqxGrid('updatebounddata');
		                   				 		
										//jqxAlert.alert ('El dato se grabó correctamente.');
		                            }else{
		                                //alert("Problemas al guardar.");
		                                //jqxAlert.alert ('Problemas al guardar.');
		                            }
		                            
		                        },
		                        error: function (msg) {
		                            alert(msg.responseText);
		                        }
		                    });
	     }
 
</script>		
 
 <div style="visibility: hidden; display:none;" id="jqxWidgetRechaza">		    
      <div style="display:none;" id="eventWindowRechaza">
            <div>No acepto venta</div>
            <div>
                <div>
                   <form id="frmRechaza" method="post">
                       <input type="hidden" id="reid"/>
                   	   <input type="hidden" id="reidcampana"/>
                       <input type="hidden" id="reidcontacto"/>
                       <div id="retexto_rechaza"></div>
                       <div style="margin-right: 5px; margin-top: 10px" align="center"  id='rejqxRazon'></div>
                       <input style="margin-right: 5px; margin-top: 10px" type="button" id="rebtnOk" value="Ok" />
                      					  
                    </form>
                </div>
            </div>
      </div>
   </div>   