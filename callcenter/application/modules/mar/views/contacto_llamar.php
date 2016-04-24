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
     
     function volverLlamar(conta_id, camp_id,contacto,telefono){
     	document.getElementById("frmLlamar").reset();	
     	createElementsLlamar();
     	$("#eventWindowLlamar").jqxWindow('open');
      	$('#llidcontacto').val(conta_id);
		$('#llidcampana').val(camp_id);
		$('#llcontacto').val(contacto);
		$('#lltelefono').val(telefono);
		
     	reglasLlamar();
     }
 
     function createElementsLlamar() {
     	
            $('#eventWindowLlamar').jqxWindow({
            	resizable: false,
                width: 530,
                Height: 340,
                theme: tema,
                //minHeight: 300,
                isModal: true,
                modalOpacity: 0.01,   
                initContent: function () {
                	
                	$('#llid').jqxInput({theme: tema,disabled: true, width: '100px', height: 20});
                	$('#llidcampana').jqxInput({theme: tema,width: '100px', height: 20});
                	$('#llidcontacto').jqxInput({theme: tema,width: '100px', height: 20});
                	$('#lltelefono').jqxInput({theme: tema,disabled: true, width: '300px', height: 25});
                	$('#llcontacto').jqxInput({theme: tema,disabled: true, width: '405px', height: 25});
                	$('#llfecha').jqxDateTimeInput({theme: tema, culture: 'es-ES', width: '300px', formatString: 'yyyy-MM-dd' });
                    $('#llhora').jqxDateTimeInput({theme: tema, culture: 'es-ES', width: '300px', formatString: 'HH:mm', showCalendarButton: false });
                    $('#llobservacion').jqxInput({theme:tema,width: '405px', height: 50 });
                    $("#llbtnOk").jqxButton({theme: tema,width: '70px', height: 25 });
                    
                     
                
   		           $("#llbtnOk").click(function () {
   		           	  //alert('ok');
   		           	   var contacto_campana_id= $("#vidcontactocampana").jqxInput('val');
   		           	   var contacto_id=$('#didcontacto').jqxInput('val');
   		               var campana_id=$('#didcampana').jqxInput('val');
   		               var telefono=$('#dtelefono').jqxInput('val');
   		               var padre_id=$('#didllamada').jqxInput('val');
   		               var inicio=$('#dinicio').jqxInput('val');
   		               var proceso=$('#vproceso').val();
   		               var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
				       var empleado_id=iemp.value;
   		               var oper='segtel';
   		               var url = "<?php echo site_url("mar/contactos/ajax"); ?>"; 
   		               var validationResult = function (isValid) {
			                if (isValid) {
			                	var fec = $('#llfecha').val();
			                	var hor = $('#llhora').val();
			                	var fec_hor=fec + ' ' + hor;
			                	
			                    var seguimiento = {  
			                        accion: oper,
			                        //$('#llfechahora').jqxDateTimeInput('getDate')
			                        contacto_campana_id: contacto_campana_id,
			                        contacto_id: contacto_id,
									campana_id: campana_id,
									empleado_id: empleado_id,
									telefono: telefono,
									fecha_hora: moment(fec_hor).format('YYYY-MM-DD HH:mm:ss'),
									observacion: $("#llobservacion").val()
									
			                    };		
								
								//alert(seguimiento.contacto_id+' '+seguimiento.campana_id+' '+seguimiento.telefono+' '+seguimiento.observacion+' '+seguimiento.fecha_hora)
								
			                    $.ajax({
			                        type: "POST",
			                        url: url,
			                        data: seguimiento,
			                        success: function (data) {
										if(data=true){
					
			      	                         finalizarConSegTel(contacto_id,empleado_id,campana_id,telefono,padre_id,inicio,proceso)
											 
			                                 //alert("El dato se grab� correctamente.");
			                                //jqxAlert.alert ('El dato se grabó correctamente.');
			                            }else{
			                                //alert("Problemas al guardar.");
			                                jqxAlert.alert ('Problemas al guardar.');
			                            }
			                        },
			                        error: function (msg) {
			                            alert(msg);
			                        }
			                    });	
			                }
			            }
			            $('#eventWindowLlamar').jqxValidator('validate', validationResult); 
   		            });		      				
                }
            });
            $('#eventWindowLlamar').jqxWindow('focus');
            $('#eventWindowLlamar').jqxValidator('hide');
        }
         
         
         
         
         function reglasLlamar(){
         	$('#eventWindowLlamar').jqxValidator({
		            hintType: 'label',
		            animationDuration: 0,
		            rules: [
		                //{ input: '#llfechahora', message: 'Ingrese la fecha y hora de la siguiente llamada!', action: 'keyup, blur', rule: 'length=10,10' },
						//{ input: '#lltelefono', message: 'Teléfono es requerido!', action: 'keyup, blur, select', rule: 'required' },
						{ input: '#llobservacion', message: 'Observación es requerida!', action: 'keyup, blur', rule: 'required' }
												
						
		            ]
		            });	
         }
       
        
	   function finalizarConSegTel(contacto_id,empleado_id,campana_id,telefono,padre_id,inicio,proceso){
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
		                		respuesta: 'Seguimiento telefónico',
								
						    };	
						   
							$.ajax({
		                        type: "POST",
		                        url: url,
		                        data: llamada,
		                        success: function (data) {
		                         	                          
		                           //var llamada_id=data;                   					          
		                           if(data=true){
		                           	       
		                           		    $("#eventWindowLlamar").jqxWindow('hide');
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
 
 <div style="visibility: hidden; display:none;" id="jqxWidgetLlamar">		    
      <div style="display:none;" id="eventWindowLlamar">
            <div>Datos de nueva llamada</div>
            <div>
                <div>
                   <form id="frmLlamar" method="post">
                       <input type="hidden" id="llid"/>
                   	   <input type="hidden" id="llidcampana"/>
                       <input type="hidden" id="llidcontacto"/>
                      
                      <table style="width:100%">
						  <tr>
						  	<td style="width:15%">Contacto: </td>
						  	<td ><input id="llcontacto"></td>
						  </tr>
						  <tr> 
						    <td style="width:15%">Número:</td>
						    <td><input id="lltelefono"></td>
						  </tr>
						  <tr> 
						    <td style="width:15%">Fecha:</td>
						    <td><div id="llfecha"></td>
						   </tr>
						  
						  <tr> 
						    <td style="width:15%">Hora:</td>
						    <td><div id="llhora"></td>
						  </tr>
						 
						  <tr>
						  	<td style="width:15%">Observación:</td>
						    <td align="left"><textarea id="llobservacion"></textarea></td>
						  </tr>
						  <tr><p></p></tr>
						  <tr>
						  	<td style="width:15%"></td>
						  	<td align="center"><input style="margin-right: 5px; margin-top: 10px" type="button" id="llbtnOk" value="Ok" />
									                         
						  </tr>
					  </table>
					  
                    </form>
                </div>
            </div>
      </div>
   </div>   