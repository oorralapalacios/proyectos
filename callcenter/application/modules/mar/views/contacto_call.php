 <script type="text/javascript">
 
     function createElementsIniciaLlamada() {
            $('#eventWindowLlamada').jqxWindow({
            	resizable: false,
                width: '500px',
                Height: '40%',
                theme: tema,
                //minHeight: 300,
                isModal: true,
                modalOpacity: 0.01,   
                initContent: function () {
                	$('#lid').jqxInput({theme: tema,disabled: true, width: '100px', height: 20});
                	$('#lidcampana').jqxInput({theme: tema,width: '100px', height: 20});
                	$('#lidcontacto').jqxInput({theme: tema,width: '100px', height: 20});
                	//$('#lidempleado').jqxInput({theme: tema,width: '100px', height: 20});
                	$('#ltelefono').jqxInput({theme: tema,disabled: true, width: '150px', height: 25});
                	$('#ltiempo').jqxInput({theme: tema,disabled: true, width: '65px', height: 25});
                	$('#lcontacto').jqxInput({theme: tema,disabled: true, width: '405px', height: 25});
                    $('#lestadollamada').jqxInput({theme: tema,disabled: true, width: '250px', height: 25});
                    var myVar = setInterval(function () {myTimer()}, 100);
					function myTimer() {
					    var d = new Date();
					    $('#ltiempo').val(d.toLocaleTimeString());
					   
					}
                	$("#btnDialogar").jqxButton({theme: tema,width: '70px', height: 25 });
                	$("#btnCancelaLlamada").jqxButton({theme: tema,width: '70px', height: 25 });
                	$("#btnFueraServicio").jqxButton({theme: tema,width: '125px', height: 25 });
                	$("#btnNoContesta").jqxButton({theme: tema,width: '90px', height: 25 });
	        
		       				 
			    
		        $("#btnDialogar").click(function () {
		        	 clearTimeout(myCall);
		        	 var url = "<?php echo site_url("mar/contactos/ajax"); ?>"; 
				    //var tiempo= $('#ltiempo').jqxInput('val');
				     var dtelefono=$('#ltelefono').jqxInput('val');
				     var didcampana=$('#lidcampana').jqxInput('val');
				     var didcontacto=$('#lidcontacto').jqxInput('val');
				     var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
				     var didempleado=iemp.value;
				     var didllamada=$('#lid').jqxInput('val');
				     var proceso=$('#vproceso').val(); 				  
				     finEspera(didllamada,'Marcada', 'Ninguna',proceso);
				      	
				     contestar(didcontacto,didempleado,didcampana,dtelefono,didllamada, proceso);
				     
				     
				 });	
				 
				 
				 
				 $("#btnCancelaLlamada").click(function () {
				 	 clearTimeout(myCall);
				 	var url = "<?php echo site_url("mar/contactos/ajax"); ?>"; 
				    var tiempo= $('#ltiempo').jqxInput('val');
				    var proceso=$('#vproceso').val();
				    oper='editllamada';
				    var llamada = {  
		                        /*accion: oper,
		                        id: $('#lid').val(),
		                       	llamada_estado: 'Cancelada',*/
		                       	accion: oper,
		                        id: $('#lid').val(),
		                        inicio: moment().format('YYYY-MM-DD HH:mm:ss'),
		                        fin: moment().format('YYYY-MM-DD HH:mm:ss'),
		                        llamada_estado: 'Marcada',
		                        proceso: proceso,
		                       	respuesta: 'Cancelada',
								
						    };		
							$.ajax({
		                        type: "POST",
		                        url: url,
		                        data: llamada,
		                        success: function (data) {
		                                               	                      					          
		                           if(data=true){
		                           	 $('#eventWindowLlamada').jqxWindow('hide');
		                           	 $("#gtelefonosGrid").jqxGrid('updatebounddata');
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
		                    //clearTimeout(myCall);   
				 });
				 
				 
				  $("#btnFueraServicio").click(function () {
				  	 clearTimeout(myCall);
				 	var url = "<?php echo site_url("mar/contactos/ajax"); ?>"; 
				    var tiempo= $('#ltiempo').jqxInput('val');
				    var proceso=$('#vproceso').val();
				    oper='editllamada';
				    
				    var llamada = {  
		                        /*accion: oper,
		                        id: $('#lid').val(),
		                       	llamada_estado: 'Fuera de servicio',*/
		                       	
		                       	accion: oper,
		                        id: $('#lid').val(),
		                        inicio: moment().format('YYYY-MM-DD HH:mm:ss'),
		                        fin: moment().format('YYYY-MM-DD HH:mm:ss'),
		                        llamada_estado: 'Marcada',
		                        proceso: proceso,
		                       	respuesta: 'Fuera de servicio',
								
						    };		
							$.ajax({
		                        type: "POST",
		                        url: url,
		                        data: llamada,
		                        success: function (data) {
		                        	
		                                                 	                      					          
		                           if(data=true){
		                           	 $('#eventWindowLlamada').jqxWindow('hide');
		                           	 $("#gtelefonosGrid").jqxGrid('updatebounddata');
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
		                    clearTimeout(myCall);   
				 });
				 
				 $("#btnNoContesta").click(function () {
				 	clearTimeout(myCall);
				 	var url = "<?php echo site_url("mar/contactos/ajax"); ?>"; 
				    var tiempo= $('#ltiempo').jqxInput('val');
				    oper='editllamada';
				    var proceso=$('#vproceso').val();
				    var llamada = {  
		                       /* accion: oper,
		                        id: $('#lid').val(),
		                       	llamada_estado: 'No contestada',*/
								accion: oper,
		                        id: $('#lid').val(),
		                        inicio: moment().format('YYYY-MM-DD HH:mm:ss'),
		                        fin: moment().format('YYYY-MM-DD HH:mm:ss'),
		                        llamada_estado: 'Marcada',
		                        proceso: proceso,
		                       	respuesta: 'No contestada',
						    };		
							$.ajax({
		                        type: "POST",
		                        url: url,
		                        data: llamada,
		                        success: function (data) {
		                        	
		                                                 	                      					          
		                           if(data=true){
		                           	 $('#eventWindowLlamada').jqxWindow('hide');
		                           	 $("#gtelefonosGrid").jqxGrid('updatebounddata');
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
		                    //clearTimeout(myCall);   
				 });
   		        
   		           		      				
                }
            });
            $('#eventWindowLlamada').jqxWindow('focus');
            $('#eventWindowLlamada').jqxValidator('hide');
        }
        
                
	    function contestar(contacto_id,empleado_id,campana_id,telefono,padre_id,proceso){
	     	       var url = "<?php echo site_url("mar/contactos/ajax"); ?>";
	     	       var oper='addllamada';
	     	      
				      var llamada = {  
		                        accion: oper,
		                        contacto_campana_id: $("#vid").val(),
		                        padre_id: padre_id,
		                        contacto_id: contacto_id,
		                        empleado_id: empleado_id,
		                        campana_id: campana_id,
								telefono: telefono,
								inicio: moment().format('YYYY-MM-DD HH:mm:ss'),
								fin: moment().format('YYYY-MM-DD HH:mm:ss'),
		                		llamada_estado: 'Contestada',
		                		proceso: proceso,
		                		respuesta: 'Ninguna',
								
						    };	
						   
							$.ajax({
		                        type: "POST",
		                        url: url,
		                        data: llamada,
		                        success: function (data) {
		                         	                          
		                           var llamada_id=data;                   					          
		                           if(data=true){
		                           	        cerrarEspera();
		                           	        switch (proceso) {
		                           	        case 'Gestión telefónica':
					                           abrirGesDialogo(llamada_id,llamada.inicio,contacto_id,campana_id,telefono,proceso);   
		                           		     break;	
		                           	        case 'Validacion de citas':
					                           abrirValDialogo(llamada_id,llamada.inicio,contacto_id,campana_id,telefono,proceso);   
		                           		     break; 
		                           		    	
		                           	        }
		                           		    
		                   				 		
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
	     
	      
	     function abrirGesDialogo(llamada_id,inicio,contacto_id,campana_id,telefono){
		  	var opt= getTitulo();
		  	//alert(proceso);
        	switch (opt) {
					   case 'Contactos asignados':
					       abrirDialogoInicio(llamada_id,inicio,contacto_id,campana_id,telefono);
					     break;
					   case 'Citas nuevas':
					       abrirDialogoInicio(llamada_id,inicio,contacto_id,campana_id,telefono);
					       break;  
					   case 'Citas confirmadas':
					        abrirDialogoInicio(llamada_id,inicio,contacto_id,campana_id,telefono);
					        break;   
					   case 'Citas no confirmadas':
					        abrirDialogoInicio(llamada_id,inicio,contacto_id,campana_id,telefono);
					       break;      
					   case 'Citas mal canalizadas':
					        abrirDialogoInicio(llamada_id,inicio,contacto_id,campana_id,telefono);
					        break;
					   case 'Citas canceladas':
					        abrirDialogoInicio(llamada_id,inicio,contacto_id,campana_id,telefono);
					        break;   
					   case 'Citas postergadas':
					        abrirDialogoInicio(llamada_id,inicio,contacto_id,campana_id,telefono);
					       break;
					  
					  /*Gestión del teleoperador*/ 
					   case 'Números equivocados':
					        abrirDialogoInicio(llamada_id,inicio,contacto_id,campana_id,telefono);
					       break;
					   case 'No titulares':
					        abrirDialogoInicio(llamada_id,inicio,contacto_id,campana_id,telefono);
					       break;
					   case 'No interesados':
					        abrirDialogoInicio(llamada_id,inicio,contacto_id,campana_id,telefono);
					       break;
					   case 'No interesados':
					        abrirDialogoInicio(llamada_id,inicio,contacto_id,campana_id,telefono);
					       break;
					   case 'Seguimiento telefónico':
					       abrirDialogoInicio(llamada_id,inicio,contacto_id,campana_id,telefono);
					     break;
					   case 'Seguimiento telefónico asignado':
					       abrirDialogoInicio(llamada_id,inicio,contacto_id,campana_id,telefono);
					     break;
					   case 'Seguimiento telefónico gestionado':
					       abrirDialogoInicio(llamada_id,inicio,contacto_id,campana_id,telefono);
					     break;
					   case 'Fuera de cobertura':
					       abrirDialogoInicio(llamada_id,inicio,contacto_id,campana_id,telefono);
					     break;  
					   case 'Pago directo':
					       abrirDialogoInicio(llamada_id,inicio,contacto_id,campana_id,telefono);
					     break; 
					   
					   /*Regestión provinientes del asesor*/
					    case 'Ventas incompletas':
					        abrirDialogoInicio(llamada_id,inicio,contacto_id,campana_id,telefono);
					        break;
					    case 'Interesados/visitados':
					         abrirDialogoInicio(llamada_id,inicio,contacto_id,campana_id,telefono);
					        break;
					    case 'No interesados/visitados':
					          abrirDialogoInicio(llamada_id,inicio,contacto_id,campana_id,telefono);
					        break;
						case 'Visitas Canceladas':
						     abrirDialogoInicio(llamada_id,inicio,contacto_id,campana_id,telefono);
						    break;
						case 'No visitados':
						     abrirDialogoInicio(llamada_id,inicio,contacto_id,campana_id,telefono);
						    break;	
					    
					    default:
					        
					} 
		  }
	     
	     
	     function abrirValDialogo(llamada_id,inicio,contacto_id,campana_id,telefono){
		  	var opt= getTitulo();
		  	//alert(proceso);
        	switch (opt) {
					   case 'Contactos asignados':
					       abrirDialogoInicio(llamada_id,inicio,contacto_id,campana_id,telefono);
					     break;
					   case 'Seguimiento telefónico':
					       abrirDialogoInicio(llamada_id,inicio,contacto_id,campana_id,telefono);
					     break;
					   case 'Citas nuevas':
					        valabrirDialogo(llamada_id,inicio,contacto_id,campana_id,telefono);
					       break;  
					   case 'Citas confirmadas':
					        valabrirDialogo(llamada_id,inicio,contacto_id,campana_id,telefono);
					        break;   
					   case 'Citas no confirmadas':
					        valabrirDialogo(llamada_id,inicio,contacto_id,campana_id,telefono);
					       break;      
					   case 'Citas mal canalizadas':
					        valabrirDialogo(llamada_id,inicio,contacto_id,campana_id,telefono);
					        break;
					   case 'Citas canceladas':
					        valabrirDialogo(llamada_id,inicio,contacto_id,campana_id,telefono);
					        break;   
					   case 'Citas postergadas':
					        valabrirDialogo(llamada_id,inicio,contacto_id,campana_id,telefono);
					       break;
					   
					   /*Regestión*/
					    case 'Ventas incompletas':
					         asiabrirDialogoRegestion(llamada_id,inicio,contacto_id,campana_id,telefono);
					        break;
					    case 'Interesados/visitados':
					         asiabrirDialogoRegestion(llamada_id,inicio,contacto_id,campana_id,telefono);
					        break;
					    case 'No interesados/visitados':
					          asiabrirDialogoRegestion(llamada_id,inicio,contacto_id,campana_id,telefono);
					        break;
						case 'Visitas Canceladas':
						     asiabrirDialogoRegestion(llamada_id,inicio,contacto_id,campana_id,telefono);
						    break;
						case 'No visitados':
						     asiabrirDialogoRegestion(llamada_id,inicio,contacto_id,campana_id,telefono);
						    break;	
					    
					    default:
					        
					} 
		  }
		
		
		  
       
 </script>		
 
 <div style="visibility: hidden; display:none;" id="jqxWidget3">		    
      <div style="display:none;"  id="eventWindowLlamada">
            <div>Llamando...</div>
            <div>
                <div>
                   <form id="frmLlamada" method="post">
                      <table style="width:100%">
						  <tr><td style="width:25%">Id:</td>
                            <!--<td><input type="hidden" id="lid"></td>-->
                            <td><input id="lid"></td>
                            <td><input type="hidden" id="lidcampana"></td>
                            <input type="hidden" name="lidcontacto" style="margin-top: 0px;" id="lidcontacto"/>
                            <!--<input type="hidden" name="lidempleado" style="margin-top: 0px;" id="lidempleado"/>-->
                            
                          </tr>
						  <tr> 
						    <td style="width:15%">Número:</td>
						    <td><input id="ltelefono"> Tiempo: <input id="ltiempo"></td>
							<!--<td style="width:25%">Cedula/RUC: <div id="lidentificacion"></div></td>-->
						  </tr>
						  <tr><td style="width:15%">Contacto: </td>
						  	<td colspan="3"><input id="lcontacto"></td>
								<!--<td style="width:25%">Codigo Teleoperador: <div id="lcodigotel"></div></td>-->
						  </tr>
						  <tr><td style="width:15%">Estado:</td>
						  	<td><input id="lestadollamada"></td>
								<!--<td style="width:25%" valign="middle">Observaciones: <textarea style="width:300px;height:250"></textarea></td>-->
		                  
						  </tr>
						  <tr><p></p></tr>
						  <tr><td colspan="3" align="center"><input style="margin-right: 5px; margin-top: 10px" type="button" id="btnDialogar" value="Dialogar" />
									                         <!--<input id="btnIniciaLlamada" type="button" value="Iniciar" />-->
									                         <input id="btnCancelaLlamada" type="button" value="Cancelar" />
									                         <input id="btnFueraServicio" type="button" value="Fuera de servicio" />
									                         <input id="btnNoContesta" type="button" value="No contesta" /></td>
						  </tr>
					  </table>
					  
                    </form>
                </div>
            </div>
      </div>
   </div>   