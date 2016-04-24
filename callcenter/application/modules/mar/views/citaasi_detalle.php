<meta charset='utf-8' />

<style>
#asiaccordion{
	font-size: 12px;
	}
#asicalendar {
		max-width: 750px;
		margin: 0 auto;
	}
	
#asibtnConsAgendaVendedor{
		font-size: 12px;
}
td {
	style="font-size: 12px;"
}
</style>

<script type="text/javascript">

 function asiabrirDialogoRegestion(llamada_id,inicio,contacto_id,campana_id,telefono){
 	          asilista_tipo_cliente();  
              //opvalidar(); 
              openfrmAsiCita();
              $('#adidcampana').val(campana_id);
			  $('#adidcontacto').val(contacto_id);
			  //$('#adidcontactocampana').val(contacto_campana_id);
			   asieventoTipoCliente();
			    	
 }
 function asiabrirDialogo(contacto_id,campana_id,contacto_campana_id){
	          asilista_tipo_cliente();  
              //opvalidar(); 
              openfrmAsiCita();
              $('#adidcampana').val(campana_id);
			  $('#adidcontacto').val(contacto_id);
			  $('#adidcontactocampana').val(contacto_campana_id);
			   asieventoTipoCliente();
              
  }

function openfrmAsiCita(){
			 var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                       
                        if (selectedrowindex >= 0 ) {
                           
                            var offset = $("#jqxgrid").offset();
                            // get the clicked row's data and initialize the input fields.
	                        var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex );
	                        document.getElementById("frmAsiCita").reset();
	                        // show the popup window.
	                        createElementsAsiCita();
	                        asicampana_formapago(dataRecord.campana_id, 1);
			                asicampana_preaprobacion(dataRecord.campana_id, 2);
			                asi_perfil();
	                        $('#asicita_id').val(dataRecord.id);
	                        $('#asitipogestion').val(dataRecord.tipo_gestion);
	                        $("#asicliente_tipo_id").val(dataRecord.tipo_cliente_id);
			                $('#asillamada_id').val(dataRecord.llamada_id);
			                $('#asicampana_id').val(dataRecord.campana_id);
			                $('#asifpago').val(dataRecord.forma_pago);
			                $('#asipreaestado').val(dataRecord.estado_preaprobacion);
			                $('#asiidprea').val(dataRecord.codigo_preaprobacion);
			                $('#asiperfil').val(dataRecord.perfil);
			                $('#asilimcredito').val(dataRecord.limite_credito);
			                $('#asifinanciamiento').val(dataRecord.financiamiento);
			                $('#asilimcredito_tc').val(dataRecord.limite_credito_tc);
			                $('#asifinanciamiento_tc').val(dataRecord.financiamiento_tc);
			                $('#asiobservacion').val(dataRecord.observacion);
			                asihabilitaTipoCliente(dataRecord.tipo_cliente_id);
			                asillamada(dataRecord.llamada_id);
							asicontacto(dataRecord.contacto_id);
			                asiempresa(dataRecord.empresa_id);
			                asicmail(dataRecord.contacto_id);
			                asigridProductos(dataRecord.id); 
			                asiagenda(dataRecord.id);
			                $("#eventWindowAsiCita").jqxWindow('open');
						    $('#asicalendar').fullCalendar('render'); 	
							
	                        }else{
	                        	jqxAlert.alert('Seleccione un registro','Asignación de cita');
	                        }
		}
		
function asipreguntas_datos(camp_id,contacto_id,contacto_campana_id){
			$("#asidatosEncuesta").empty(); 
			var url = "<?php echo site_url("mar/preguntas/ajax"); ?>";
		    var soper = 'dataPG';
		    var datos = {
		    	     accion: soper,
			         campana_id: camp_id,
			         contacto_id: contacto_id,
			         contacto_campana_id: contacto_campana_id,
			         };
			var customersPreguntas =
				{
					dataType: "json",
					dataFields: [
						{ name: 'id'},
						{ name: 'campana_id'},
						{ name: 'orden'},
						{ name: 'detalle_pregunta'},
						{ name: 'tipo_pregunta'},
						{ name: 'tipo_pregunta_id'},
						{ name: 'tipo_respuesta_id'},
						{ name: 'tipo_respuesta'},
						{ name: 'multiple_respuesta'},
						{ name: 'opciones'},
						{ name: 'obligatorio'}
					],
				    id: 'id',
                    type: 'POST',
                    url: url,
                    data: datos,
                    async: false
                 };
			
			 var dataAdapterPreg = new $.jqx.dataAdapter(customersPreguntas, {
			 	        autoBind: true,
						loadComplete: function (data) { 
							   
							   var pregunta;
							   var orden;
							   $('#asidatosEncuesta').append("<table>");
								for(i=0;i<data.length;i++){
								 id_pregunta = data[i]['id'];
								 pregunta = data[i]['detalle_pregunta'];
								 orden = data[i]['orden'];
								 var tipo_respuesta = data[i]['tipo_respuesta_id'];
								 var opciones = data[i]['opciones'];
								 if (opciones==''){
								 	$('#asidatosEncuesta').append("<tr><td>"+orden+".- </td><td>"+data[i]['detalle_pregunta']+"</td><tr></tr><td colspan='2'><input id='asiresp_"+id_pregunta+"' value='"+data[i]['respuesta_texto']+"'/><td></tr>");
								 }else{
								 	$('#asidatosEncuesta').append("<tr><td>"+orden+".- </td><td>"+data[i]['detalle_pregunta']+"</td></tr>");
								 }
								 
								 for(j=0;j<opciones.length;j++){
									
								 	if (opciones[j]['respuesta']==opciones[j]['detalle']){var check='checked';}else{var check='';}
										//alert(opciones[j]['respuesta']);
									 $('#asidatosEncuesta').append("<tr><td colspan=2><input type='"+opciones[j]['objeto']+"' id='asi"+opciones[j]['detalle']+"' name='"+id_pregunta+"'  value = '"+opciones[j]['detalle']+"' "+check+">"+opciones[j]['detalle']+"</td></tr>");
									
									 }
								}
								
								$('#asidatosEncuesta').append("</table>");
						},
						
					});
									         
            
            } 

function createElementsAsiCita() {
	
               $('#eventWindowAsiCita').jqxWindow({
            	resizable: false,
                width: '100%',
                Height: '100%',
                theme:tema,
                //minHeight: 300, 
                isModal: true,
                modalOpacity: 0.01,  
                cancelButton: $("#asibtnCancel"),
                initContent: function () {
                	
                	
               	/*$('#asiaccordion').accordion({theme:tema, 
            	                          //heightStyle: "content",
            	                          activate: function( event, ui ) {
            		                                $('#asicalendar').fullCalendar('render');
            	                          }
            	});*/
            	var headers = $('#asiaccordion .accordion-header');
				//inicia expandido el acordion
				var contentAreas = $('#asiaccordion .ui-accordion-content ').show();
				var expandLink = $('#asiaccordion-expand-all');
				
				// add the accordion functionality
				headers.click(function() {
				    var panel = $(this).next();
				    var isOpen = panel.is(':visible');
				 
				    // open or close as necessary
				    panel[isOpen? 'slideUp': 'slideDown']()
				        // trigger the correct custom event
				        .trigger(isOpen? 'hide': 'show');
				
				    // stop the link from causing a pagescroll
				    return false;
				});
				
				// hook up the expand/collapse all
				expandLink.click(function(){
				    var isAllOpen = $(this).data('isAllOpen');
				    
				    contentAreas[isAllOpen? 'hide': 'show']()
				        .trigger(isAllOpen? 'hide': 'show');
				});
				
				// when panels open or close, check to see if they're all open
				contentAreas.on({
				    // whenever we open a panel, check to see if they're all open
				    // if all open, swap the button to collapser
				    show: function(){
				        var isAllOpen = !contentAreas.is(':hidden');   
				        if(isAllOpen){
				            expandLink.text('Collapse All')
				                .data('isAllOpen', true);
				        }
				    },
				    // whenever we close a panel, check to see if they're all open
				    // if not all open, swap the button to expander
				    hide: function(){
				        var isAllOpen = !contentAreas.is(':hidden');
				        if(!isAllOpen){
				            expandLink.text('Expand all')
				            .data('isAllOpen', false);
				        } 
				    }
				});
            	
            	$('#asicita_id').jqxInput({theme:tema, disabled: true,width: '100px', height: 20 });
            	$('#asitipogestion').jqxInput({theme:tema, disabled: true,width: '100px', height: 20 });
            	$('#asicontacto_id').jqxInput({theme:tema, disabled: true,width: '100px', height: 20 });
			    $('#asillamada_id').jqxInput({theme:tema,disabled: true,width: '100px', height: 20 });
			    $('#asicampana_id').jqxInput({theme:tema,disabled: true,width: '100px', height: 20 });
			    //$("#adtelefono").jqxInput({theme: tema, disabled: true, width: '150px'});
			    //$("#adinicio").jqxInput({theme: tema, disabled: true, width: '150px'});
			    //$("#adtiempo").jqxInput({theme: tema, disabled: true, width: '100px'});
			    $('#adidcampana').jqxInput({theme: tema, disabled: true,width: '100px', height: 20 });
			    $('#adidcontacto').jqxInput({theme: tema, disabled: true,width: '100px', height: 20 });
			    $('#adidcontactocampana').jqxInput({theme: tema, disabled: true,width: '100px', height: 20 });
			     /*$('#adidllamada').jqxInput({theme: tema, disabled: true,width: '100px', height: 20 });
			     var myVar = setInterval(function () {myTimer()}, 100);
			    	function myTimer() {
					    var d = new Date();
					    $('#adtiempo').val(d.toLocaleTimeString());
					}*/	
			    $('#asitelefonollamada').jqxInput({theme:tema,disabled: true,width: '100px', height: 20 });
			    $('#asifechallamada').jqxInput({theme:tema,disabled: true,width: '100px', height: 20 });
			    $('#asihorallamada').jqxInput({theme:tema,disabled: true,width: '100px', height: 20 });
			    $("#asicliente_tipo_id").jqxDropDownList({theme: tema, width: 200,height: 20});
			    $('#asicedula').jqxInput({theme:tema,disabled: true,width: '200px', height: 20 });
			    $('#asitelefono').jqxInput({theme:tema,disabled: true,width: '200px', height: 20 });
			    $('#asinombres').jqxInput({theme:tema,width: '280px', height: 20, placeHolder:'ingrese nombres'});
			    $('#asiapellidos').jqxInput({theme:tema,width: '280px', height: 20, placeHolder:'ingrese apellidos'});
			    $("#asiruc").jqxInput({theme:tema,width: '150px', height: 20});
			    $("#asirazonsocial").jqxInput({theme:tema,width: '570px', height: 20}); 
			    $('#asiciudad').jqxInput({theme:tema,width: '570px', height: 20 });
			    asiciudades($('#asiciudad'));
			    $('#asidireccion').jqxInput({theme:tema,width: '570px', height: 50 });
			    $('#asiobservacion').jqxInput({theme:tema,width: '660px', height: 40 });
			    $('#asiemail').jqxInput({theme:tema, width: '570px', height: 20 });
			    $('#asiidprea').jqxInput({theme:tema, width: '200px', height: 20 });
                //$('#asiperfil').jqxInput({theme:tema, width: '100px', height: 20 });
                $('#asilimcredito').jqxInput({theme:tema, width: '200px', height: 20 });
                $('#asifinanciamiento').jqxInput({theme:tema, width: '200px', height: 20 });
                $('#asilimcredito_tc').jqxInput({theme:tema, width: '200px', height: 20 });
                $('#asifinanciamiento_tc').jqxInput({theme:tema, width: '200px', height: 20 });
                asicestadocita();
                asivendedor();
                $('#asibtnListaProducto').jqxButton({theme:tema, width: '70px' });
                $('#asibtnConsAgendaVendedor').jqxButton({theme:tema, width: '141px', height: 24 });
                
			    $('#asibtnSave').jqxButton({theme:tema, width: '65px' });
   		        $('#asibtnCancel').jqxButton({theme:tema, width: '65px' });
   		        $('#asibtnExpandir').jqxButton({theme:tema, width: '65px' });
   		        //$('#asivendedor').jqxComboBox
   		        /*$('#asivendedor').on('select', function (event) {
			          	       var iemp = $("#asivendedor").jqxComboBox('getSelectedItem');
			          	       agendaEmpleado(iemp.value);
			   			        
			                  });*/	
   		       
   		        $("#asibtnListaProducto").click(function () {
   		        	campid=	 $('#adidcampana').val();	
   		           	clieid= $("#asicliente_tipo_id").val();
   		            abrirListaProductos('citaasi_detalle',campid, clieid);
   		           	   		               		        	 
   		          });   
   		          
   		        $("#asibtnConsAgendaVendedor").click(function () {
   		        	createElementsAgenda();
        	         $("#eventWindowAgenda").jqxWindow('open');
   		        	 var iemp = $("#asivendedor").jqxDropDownList('getSelectedItem');
			         borrarAgenda();
        	         load_agenda(iemp.value);
   		           	   		               		        	 
   		          });            
   		       
   		       
   		         $("#asibtnSave").click(function () {	
   		         		
   		              if (asivalidaForm()){
   		                 
   		              	   AsiSaveCita();
   		        	   }
   		          });
   		          
   		           $("#asibtnCancel").click(function () {	
   		           	 asiencuestaItems.length=0;
   		           	 asiagendaItems.length=0;
   		           	 //AsiCancelar();
   		           	   		               		        	 
   		          });         		          	
   		          $("#asibtnExpandir").click(function () {	
   		             var contentAreas = $('#asiaccordion .ui-accordion-content ').show();
   		          });  			
               }
            });
            $('#eventWindowAsiCita').jqxWindow('focus');
            $('#eventWindowAsiCita').jqxValidator('hide');
            $('#eventWindowAsiCita').on('close', function (event) {
            	asiencuestaItems.length=0;
            	asiagendaItems.length=0;
			     //location.reload();
			     // $("#eventWindowAsiCita").jqxWindow('destroy');
			});
        }
        
        
function asieventoTipoCliente(){
        	 $('#asicliente_tipo_id').on('select', function (event) {
                	var args = event.args;
                    var item = $('#asicliente_tipo_id').jqxDropDownList('getItem', args.index);
                    if (item != null) {
                    
                       $('#eventWindowAsiCita').jqxValidator('hide');
                       $("#asiruc").val('');
			           $("#asirazonsocial").val('');
                       asihabilitaTipoCliente(item.value);
                       asicartItems.length=0;
                       $("#asigridproductos").jqxGrid('updatebounddata');
                       
                     }
                 
                });
        }
        
function asihabilitaTipoCliente(tipo){
         	if (tipo==2){//cliente con ruc
			    $("#asiruc").jqxInput({disabled: false});
			    $("#asirazonsocial").jqxInput({disabled: false}); 	
			    }else if (tipo==1){//cliente sin ruc
			    $("#asiruc").jqxInput({disabled: true});
			    $("#asirazonsocial").jqxInput({disabled: true}); 	
			    }
			
			    //codigo para validacion de entradas
	            $('#eventWindowAsiCita').jqxValidator({
	             	hintType: 'label',
	                animationDuration: 0,
	                rules:  asireglasVisita(tipo) 
	            });	
         }
         
         
function asireglasVisita(tipo){
         	if (tipo==2){//cliente con ruc
         		return asireglasconRuc;
         	}else if (tipo==1){//cliente sin ruc
         	 return asireglassinRuc;
         	}
         } 
var asireglassinRuc=[
	                { input: '#asicedula', message: 'Cédula debe tener 10 caracteres!', action: 'keyup, blur', rule: 'length=10,10' },
					{ input: '#asinombres', message: 'Nombres es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(0);	
							 return false;
							 }
							return true;
							
							} },
					{ input: '#asiapellidos', message: 'Apellidos es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(0);	
							 return false;
							 }
							return true;
							
							} },
	               /*{ input: '#asiobservacion', message: 'Observación es requerida!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(1);	
							 return false;
							 }
							return true;
							
							}},*/

	                { input: '#asiciudad', message: 'Ciudad es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(0);	
							 return false;
							 }
							return true;
							
							}  },
					{ input: '#asidireccion', message: 'Direccion es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(0);	
							 return false;
							 }
							return true;
							
							} },
	               /*{ input: '#asiemail', message: 'email es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(0);	
							 return false;
							 }
							return true;
							
							}  },
	                { input: '#asiemail', message: 'e-mail invalido!', action: 'keyup', rule: 'email' },*/
	                { input: '#asifpago', message: 'Forma de pago es requerida!', action: 'keyup, blur, select', rule: function (input) {
                           	if(input.val()==""){
							  	setAsiSeccion(3);
							 return false;
							 }
							return true;
							} 
					},
					{ input: '#asipreaestado', message: 'Estado de preaprobación es requerido!', action: 'keyup, blur, select', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(3);	
							 return false;
							 }
							return true;
							
							}
					},
					
					{ input: '#asiestadocita', message: 'Estado de la cita es requerida!', action: 'keyup, blur, select', rule: function (input) {
                           	if(input.val()==""){
							  	setAsiSeccion(3);
							 return false;
							 }
							return true;
							} 
					},
					
					{ input: '#asivendedor', message: 'Vendedor es requerido!', action: 'keyup, blur, select', rule: function (input) {
                           	if(input.val()==""){
							  	setAsiSeccion(3);
							 return false;
							 }
							return true;
							} 
					},
	
	                { input: '#asiidprea', message: 'ID de aprobación es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(3);	
							 return false;
							 }
							return true;
							
							} },
	                { input: '#asiperfil', message: 'Perfil de aprobación es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(3);	
							 return false;
							 }
							return true;
							
							} },
				    { input: '#asilimcredito', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#asilimcredito', message: 'Limite de credito banco  es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(3);	
							 return false;
							 }
							return true;
							
							} },
					{ input: '#asifinanciamiento', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#asifinanciamiento', message: 'Financiamiento de banco es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(3);	
							 return false;
							 }
							return true;
							
							} },
					{ input: '#asilimcredito_tc', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#asilimcredito_tc', message: 'Limite de credito de tarjeta es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(3);	
							 return false;
							 }
							return true;
							
							} },
	                { input: '#asifinanciamiento_tc', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#asifinanciamiento_tc', message: 'Financiamiento de tarjeta es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(3);	
							 return false;
							 }
							return true;
							
							} }
	              
	                ]   
var asireglasconRuc=[
	                { input: '#asicedula', message: 'Cédula debe tener 10 caracteres!', action: 'keyup, blur', rule: 'length=10,10' },
					{ input: '#asinombres', message: 'Nombres es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(0);	
							 return false;
							 }
							return true;
							
							} },
					{ input: '#asiapellidos', message: 'Apellidos es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(0);	
							 return false;
							 }
							return true;
							
							} },
	                { input: '#asiruc', message: 'RUC es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(0);	
							 return false;
							 }
							return true;
							
							} },
	                { input: '#asiruc', message: 'RUC incorrecto!', action: 'keyup, blur', rule: function (input) {
            				if(!asiValidaRuc()){
            				 setAsiSeccion(0);		
							 return false;
							 }
							return true;
							}
					},
	                { input: '#asiruc', message: 'RUC debe tener 13 caracteres!', action: 'keyup, blur', rule: 'length=13,13' },
	                { input: '#asirazonsocial', message: 'Razón social!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(0);	
							 return false;
							 }
							return true;
							
							}  },
	                { input: '#asirazonsocial', message: 'Razón social debe contener solo letras!', action: 'keyup', rule: 'notNumber' },
	                { input: '#asirazonsocial', message: 'Razón social debe contener de 3 a 30 caracteres!', action: 'keyup', rule: 'length=3,30' },
	               /*{ input: '#asiobservacion', message: 'Observación es requerida!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(1);	
							 return false;
							 }
							return true;
							
							}},*/
	                //{ input: '#nombrecomercial', message: 'Razón social debe contener solo letras!', action: 'keyup', rule: 'notNumber' },
	                //{ input: '#nombrecomercial', message: 'Razón social debe contener de 3 a 40 caracteres!', action: 'keyup', rule: 'length=3,40' },
	                { input: '#asiciudad', message: 'Ciudad es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(0);	
							 return false;
							 }
							return true;
							
							}  },
					{ input: '#asidireccion', message: 'Direccion es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(0);	
							 return false;
							 }
							return true;
							
							} },
	                /*{ input: '#asiemail', message: 'email es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(0);	
							 return false;
							 }
							return true;
							
							}  },
	                { input: '#asiemail', message: 'e-mail invalido!', action: 'keyup', rule: 'email' },*/
	                { input: '#asifpago', message: 'Forma de pago es requerida!', action: 'keyup, blur, select', rule: function (input) {
                           	if(input.val()==""){
							  	setAsiSeccion(3);
							 return false;
							 }
							return true;
							} 
					},
					
					{ input: '#asiestadocita', message: 'Estado de la cita es requerida!', action: 'keyup, blur, select', rule: function (input) {
                           	if(input.val()==""){
							  	setAsiSeccion(3);
							 return false;
							 }
							return true;
							} 
					},
					
					{ input: '#asivendedor', message: 'Vendedor es requerido!', action: 'keyup, blur, select', rule: function (input) {
                           	if(input.val()==""){
							  	setAsiSeccion(3);
							 return false;
							 }
							return true;
							} 
					},
					
					{ input: '#asipreaestado', message: 'Estado de preaprobación es requerido!', action: 'keyup, blur, select', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(3);	
							 return false;
							 }
							return true;
							
							}
					},
	                { input: '#asiidprea', message: 'ID de aprobación es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(3);	
							 return false;
							 }
							return true;
							
							} },
	                { input: '#asiperfil', message: 'Perfil de aprobación es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(3);	
							 return false;
							 }
							return true;
							
							} },
	                { input: '#asilimcredito', message: 'Limite de credito  es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(3);	
							 return false;
							 }
							return true;
							
							} },
	                { input: '#asifinanciamiento', message: 'Financiamiento de producto es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setAsiSeccion(3);	
							 return false;
							 }
							return true;
							
							} }
	              
	                ]   
		       
function setAsiSeccion(h){
			    	$( "#accordion" ).accordion( "option", "active", h );
}  
            
function asiValidaRuc(){
           var rvalida=true;
           if (!validaDoc($("#asiruc").val())){
          	  rvalida=false;
           }
           	return rvalida;
          }
          
function asiValidaProductos(){
            var pvalida=true;
          	var rows = $('#asigridproductos').jqxGrid('getrows');
           	if (!rows.length>0){
          		pvalida=false;
          	}
          	return pvalida;
          }
          
function asiValidaAgenda(){
           	var avalida=true;
           	if (!asiagendaItems.length>0){
           		avalida=false;
           	}
           	return avalida;
           }
           
function asivalidaCita(){
           	    var cvalida =$('#eventWindowAsiCita').jqxValidator('validate')
           	    if (!cvalida){
           		 cvalida=false;	
           		}
           		return cvalida;	
           }
           
function setAsiEncuesta(){
           	/*Actualiza el arreglo con informacion de la encuesta que se va enviarl al controlador*/
           	var contacto_campana_id=$("#adidcontactocampana").jqxInput('val');
           	var contacto_id=$('#adidcontacto').jqxInput('val');
   		    var campana_id=$('#adidcampana').jqxInput('val');
   		    //armo el arreglo con informacion de encuesta del formulario
   		    actualiza_asiencuestaItems(contacto_id,campana_id,contacto_campana_id);
           }
           
function asivalidaForm(){
           	var fvalida=true
           	setAsiEncuesta();
            if (!asivalidaCita()){
                	fvalida=false;
                	//jqxAlert.alert('Ingrese datos de la cita');
             }else if (!asiValidaProductos()){
           		   fvalida=false;
           		   setAsiSeccion(1);
           		  //jqxAlert.alert('Ingrese productos');
             }else if (!asiValidaAgenda()){
                 fvalida=false;
                   setAsiSeccion(2);
                  jqxAlert.alert('Ingrese agenda');	
              }
                        
              if (fvalida) return true; else return false;
           	}

        
asicartItems = [];
            //, totalPrice = 0;  
              
function asigridProductos(cita_id) { 
         	
         	   var url="<?php echo site_url("mar/asicitas/productos"); ?>"+"/"+cita_id;
               var source ={
						                datatype: "json",
						                datafields: [
                   					       { name: 'id', type: 'number' },
			               		           { name: 'producto_id', type: 'number' },
					                       { name: 'producto', type: 'string' },
					                       { name: 'cantidad', type: 'number' }
					                      					                       
					                    ],
						                id: 'id',
						                url: url,
						            };
			             
                     	   
        	    var dataAdapter = new $.jqx.dataAdapter(source, {
						                loadComplete: function (data) { 
						                   for (var i = 0; i < data.length; i++) {
									           
									           asiRecuperaItem({producto_id: data[i].producto_id, producto: data[i].producto, cantidad: data[i].cantidad});
									            
									        }
						       
						                },
						           });
									         
               
                 dataAdapter.dataBind();
	        
        	  
                $("#asigridproductos").jqxGrid(
                {
                    height: 150,
                    width: 650,
                    //source: dataAdapter,
                    keyboardnavigation: false,
                    selectionmode: 'none',
                    theme: tema,
                    columns: [
                      { text: 'Producto_id', dataField: 'producto_id', width: 4, hidden:true },
                      { text: 'Item', dataField: 'producto', width: 460 },
                      { text: 'Cantidad', dataField: 'cantidad', width: 80 },
                      { text: 'Borrar', dataField: 'remove', width: 60 }
                    ]
                });
                $("#asigridproductos").bind('cellclick', function (event) {
                    var index = event.args.rowindex;
                    if (event.args.datafield == 'remove') {
                        var item = asicartItems[index];
                        if (item.cantidad > 1) {
                            item.cantidad -= 1;
                            asiupdateGridRow(index, item);
                        }
                        else {
                            asicartItems.splice(index, 1);
                            asiremoveGridRow(index);
                        }
                       
                    }
                });
              
            };
                     
            
function asiRecuperaItem(item) {
                var index = asigetItemIndexn(item.producto);
           
                    var id = asicartItems.length,
                        item = {
                        	producto_id: item.producto_id,
                            producto: item.producto,
                            cantidad: parseInt(item.cantidad),
                            index: id,
                            remove: '<div style="text-align: center; cursor: pointer; width: 53px;"' +
                         'id="draggable-demo-row-' + id + '">X</div>'
                        };
                    asicartItems.push(item);
                    asiaddGridRow(item);
                  
               
            };
                        
function addItemAsi(item) {
                var index = asigetItemIndexn(item.producto);
                if (index >= 0) {
                    asicartItems[index].cantidad += 1;
                    asiupdateGridRow(index, asicartItems[index]);
                } else {
                    var id = asicartItems.length,
                        item = {
                        	producto_id: item.producto_id,
                            producto: item.producto,
                            cantidad: 1,
                            index: id,
                            remove: '<div style="text-align: center; cursor: pointer; width: 53px;"' +
                         'id="draggable-demo-row-' + id + '">X</div>'
                        };
                    asicartItems.push(item);
                    asiaddGridRow(item);
                  
                }
                //updatePrice(item.price);
            };
            
function asiaddGridRow(row) {
                $("#asigridproductos").jqxGrid('addrow', null, row);
                 
            };
function asiupdateGridRow(id, row) {
                var rowID = $("#asigridproductos").jqxGrid('getrowid', id);
                $("#asigridproductos").jqxGrid('updaterow', rowID, row);
            };
function asiremoveGridRow(id) {
                var rowID = $("#asigridproductos").jqxGrid('getrowid', id);
                $("#asigridproductos").jqxGrid('deleterow', rowID);
            };
function asigetItemIndexn(name) {
                for (var i = 0; i < asicartItems.length; i += 1) {
                    if (asicartItems[i].producto === name) {
                        return i;
                    }
                }
                return -1;
            };      
            
            
        function asicontacto(cont_id){
        $("#asidescontacto").empty();
		var url = "<?php echo site_url("mar/contactos/registro"); ?>"+"/"+cont_id;
		var source =
        {
            datatype: "json",
            datafields: [
                { name: 'id', type: 'numeric' },
                { name: 'contacto_id', type: 'numeric' },
				{ name: 'identificacion', type: 'string' },
				{ name: 'nombres', type: 'string' },
				{ name: 'apellidos', type: 'string' },
				{ name: 'ciudad', type: 'string' },
				{ name: 'direccion', type: 'string' },
				{ name: 'fecha_ing', type: 'string' },
				{ name: 'fecha_mod', type: 'string' },
				{ name: 'estado', type: 'string' }
            ],
            id: 'id',
            url: url,
            pagesize: 20,
            async: false
        }; 
         var dataAdapter = new $.jqx.dataAdapter(source, {
						                loadComplete: function (data) { 
						                	    $('#asicontacto_id').val(cont_id);
						                	    $('#asicedula').val(data.identificacion);
						                	    //$('#asitelefono').val(data.telefono);
						                	    $('#asinombres').val(data.nombres);
						                	    $('#asiapellidos').val(data.apellidos);
						                	    $('#asiciudad').val(data.ciudad);
						                	    $('#asidireccion').val(data.direccion);
						                	     var container;
						                	     container = 'ASIGNACIÓN DE CITA DE: '+ data.apellidos+' '+data.nombres;
						                	      $('#asidescontacto').append(container);
						       
						                },
						           });
									         
               
         dataAdapter.dataBind();
	   }
	   
	   function asillamada(id){
		var url = "<?php echo site_url("mar/contactos/llamada"); ?>"+"/"+id;
		var source =
        {
            datatype: "json",
            datafields: [
                { name: 'id', type: 'numeric' },
                { name: 'telefono', type: 'string' },
                { name: 'inicio', type: 'string' }
                
				
            ],
            id: 'id',
            url: url,
            pagesize: 20,
            async: false
        }; 
         var dataAdapter = new $.jqx.dataAdapter(source, {
						                loadComplete: function (data) { 
						                	var f=data.inicio;
						                	var h=data.inicio;
						                	var llfecha=moment(f).format("DD/MM/YYYY");
						                	var llhora=moment(h).format("h:mm:ss a");
						                    $('#asitelefonollamada').val(data.telefono);
						                    $('#asitelefono').val(data.telefono);
						                    $('#asifechallamada').val(llfecha);
						                    $('#asihorallamada').val(llhora);
						                 },
						           });
									         
               dataAdapter.dataBind();
	   }
	   
	   function asicmail(cont_id){
		var url = "<?php echo site_url("mar/contactos/email"); ?>"+"/"+cont_id;
		var source =
        {
            datatype: "json",
            datafields: [
                { name: 'id', type: 'numeric' },
                { name: 'valor', type: 'string' }
				
            ],
            id: 'id',
            url: url,
            pagesize: 20,
            async: false
        }; 
         var dataAdapter = new $.jqx.dataAdapter(source, {
						                loadComplete: function (data) { 
						                	    $('#asiemail').val(data.valor);
						                 },
						           });
									         
               dataAdapter.dataBind();
	   }
	   
	   function asiempresa(emp_id){
		var url = "<?php echo site_url("mar/asicitas/empresa"); ?>"+"/"+emp_id;
		var source =
        {
            datatype: "json",
            datafields: [
                { name: 'id', type: 'numeric' },
                { name: 'ruc', type: 'string' },
                { name: 'razon_social', type: 'string' },
				
            ],
            id: 'id',
            url: url,
            pagesize: 20,
            async: false
        }; 
         var dataAdapter = new $.jqx.dataAdapter(source, {
						                loadComplete: function (data) { 
						                	    $('#asiruc').val(data.ruc);
						                	    $('#asirazonsocial').val(data.razon_social);
						                 },
						           });
									         
               dataAdapter.dataBind();
	   }
        
        function asiciudades($ciudad){
       	
       	        var timer;
                $ciudad.jqxInput({
                	
                    source: function (query, response) {
                        var dataAdapter = new $.jqx.dataAdapter
                        (
                            {
                                datatype: "jsonp",
                                datafields:
                                [
                                    { name: 'countryName' }, { name: 'name' },
                                    { name: 'population', type: 'float' },
                                    { name: 'continentCode' },
                                    { name: 'adminName1' }
                                ],
                                url: "http://api.geonames.org/searchJSON",
                                data:
                                {
                                    country:"EC",
                                    featureClass: "P",
                                    continent:"SA",
                                    style: "full",
                                    maxRows: 12,
                                    username: "jqwidgets"
                                }
                            },
                            {
                                autoBind: true,
                                formatData: function (data) {
                                    data.name_startsWith = query;
                                    return data;
                                },
                                loadComplete: function (data) {
                                    if (data.geonames.length > 0) {
                                        response($.map(data.geonames, function (item) {
                                            return {
                                                label: item.name + (item.adminName1 ? ", " + item.adminName1 : "") + ", " + item.countryName,
                                                value: item.name
                                            }
                                        }));
                                    }
                                }
                            }
                        );
                    }
                });
                    
       }
       
        function asilista_tipo_cliente(){
          	 var datos =
				{
					datatype: "json",
					datafields: [
						{ name: 'id' },
						{ name: 'descripcion' }
					],
					url: '<?php echo site_url("mar/tipos_clientes/ajax"); ?>',
					async: false
				};
				
				 var dataAdapter = new $.jqx.dataAdapter(datos); 
		 		 $("#asicliente_tipo_id").jqxDropDownList({
							source: dataAdapter,
							//width: 400,
							//height: 20,
							//selectedIndex: 0,
							displayMember: 'descripcion',
							valueMember: 'id'
					});  
				 
          	
          } 
      
         /* Generate unique id */
		function asiget_uni_id(){
				
					//Generate unique id
					return new Date().getTime() + Math.floor(Math.random()) * 500;
		}
        function asigetItemIndex(id) {
		                for (var i = 0; i < asiagendaItems.length; i += 1) {
		                    if (asiagendaItems[i].id === id) {
		                        return i;
		                    }
		                }
		                return -1;
		}
		
	    asiagendaItems = [];
	    //asiagendaItems = new Array();
	    function clearasiagendaItems(){
	    	for(i in asiagendaItems){
	    		asiagendaItems.pop();
	    	}
	    }
	    
	    function borrarasiagendaempleado(){
	        consagendaItems.length=0;
   		    $('#asicalendar').fullCalendar('removeEventSource', consagendaItems);
   		    $('#asicalendar').fullCalendar('rerenderEvents' );
	    }
	    
	    function borrarasiagenda(){
        	asiagendaItems.length=0;
   		    $('#asicalendar').fullCalendar('removeEvents');
   		    $('#asicalendar').fullCalendar('rerenderEvents' );
        }
        
        function asiagenda(cita_id){
            borrarasiagenda();
            initAsiCalendar();
	    	var url="<?php echo site_url("mar/asicitas/agenda"); ?>"+"/"+cita_id;
	    	$.ajax({
			        type: "POST",
			        url:url,
			        async: true,
			        success: function(datos){
			        				        	
			             asiagendaItems=eval(datos);
			             //alert(asiagendaItems[0].id);
			             $('#asicalendar').fullCalendar('addEventSource', asiagendaItems);         
                          
			            		             
			        },
			        error: function (obj, error, objError){
			            //avisar que ocurrió un error
			        }
			});
        	
        		
          }
          
         consagendaItems = [];
         function agendaEmpleado(emp_id){
            borrarasiagendaempleado();
            var url="<?php echo site_url("mar/gescitas/agendaempleado"); ?>"+"/"+emp_id;
	    	$.ajax({
			        type: "POST",
			        url:url,
			        async: true,
			        events: url,
			        success: function(datos){
			        	 consagendaItems=eval(datos);
			             $('#asicalendar').fullCalendar('addEventSource',consagendaItems);
                         			            		             
			        },
			        error: function (obj, error, objError){
			            //avisar que ocurrió un error
			        }
			});
        		
          }
          
          function initAsiCalendar(){
        	var fa= new Date();
				          	$('#asicalendar').fullCalendar({
				          	header: {
								left: 'prevYear,prev,next,nextYear, today',
								center: 'title',
								right: 'month,agendaWeek,agendaDay'
							},
							theme:tema,
							lang: 'es',
							height: 230,
							width: 700,
							defaultView: 'month',
							allDaySlot: false,
							defaultDate: fa,
							//defaultDate:'2014-09-12',
							//selectable: true,
							//selectHelper: true,
							//timezone: 'UTC',
							//timeFormat:'YYYY-MM-DD HH:mm',
							/*
							select: function(start, end) {
								//alert(start);
								//alert(end);
								if ((end.diff(start, 'days')) ==0){
			
			
								//if (allDay='false'){//no aplica para eventos de todo el dia
								//var title = prompt('Event Title:');
								if (confirm("Desea agregar fecha hora para la cita?")) {
								var title='Visita a: ' + $("#asiapellidos").val()+' ' +$("#asinombres").val();
								var eventData;
								if (title) {
									eventData = {
										id: asiget_uni_id(),
										title: title,
										start: start.format(),
										end: end.format()
										
									};
									asiagendaItems.push(eventData);
									$('#asicalendar').fullCalendar('renderEvent', eventData, true); // stick? = true
									
								}
								$('#asicalendar').fullCalendar('unselect');
								
								}
							 }//else{alert('Selecione vista de semana o dia');}
							},
							*/
							editable: true,
							eventLimit: true, // allow "more" link when too many events
							
							eventResize: function(event, delta, revertFunc) {
				               ///alert(event.id + " fin es ahora " + event.end.format());
					           if (confirm("Esta seguro de aplicar el cambio?")) {
					             var id=event.id;
						    	 var index = asigetItemIndex(id);
				                 asiagendaItems[index].start = event.start.format();
							     asiagendaItems[index].end = event.end.format();
						            
						        }else{
						           revertFunc();
						        }
					
					        },
					        eventDrop: function(event, delta, revertFunc) {
				
					             //alert(event.id + " se ha movido a " + event.start.format());
					
						         if (confirm("Esta seguro de aplicar el cambio?")) {
						         	 var id=event.id;
						    	     var index = asigetItemIndex(id);
				                     asiagendaItems[index].start = event.start.format();
							         asiagendaItems[index].end = event.end.format();
						           
						         }else{
						         	 revertFunc();
						         }
				
				           },
				           /*
				            eventClick: function(calEvent, jsEvent, view) {
			
						        //alert('Event: ' + calEvent.id);
						  
						         if (confirm("Desea eliminar el evento?")) {
						         	 var id=calEvent.id;
						         	 $('#asicalendar').fullCalendar('removeEvents',id);
						    	     var index = asigetItemIndex(id);
				                  	  asiagendaItems.splice(index, 1);
				                  	  
						           
						         }else{
						         	 revertFunc();
						         }
						      			
						    },
						    */
							//events: url,
							
						dayClick: function(date, view) {
								$('#asicalendar').fullCalendar('changeView', 'agendaDay');
								$('#asicalendar').fullCalendar('gotoDate', date);
								}
							
						});		
        }
	    
          
          function asicampana_formapago(camp_id, tabla_id) {
        	
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
									         
               //return this.dataAdapter;
               var formasPago=dataAdapter;
               // $('#vifpago').jqxComboBox({source: formasPago, displayMember: "descripcion", valueMember: "id"});
               $('#asifpago').jqxDropDownList({theme:tema,
               	                          selectedIndex: 0, autoDropDownHeight: true, promptText: "Forma de pago:", 
                                          source: formasPago, displayMember: "descripcion", valueMember: "id", 
                                          width: 300, height: 22}); 
			   
            }
            
            function asicestadocita() {
        	
        	 var tabla_id=7
        	 var url = "<?php echo site_url("mar/campanas/datostablas"); ?>"+"/"+tabla_id;
               var source ={
						                datatype: "json",
						                datafields: [
                   					      { name: 'id', type: 'number' },
			               		          { name: 'descripcion', type: 'string' },
					                      
					                    ],
						                id: 'id',
						                url: url,
						            };
			             
                   
                 var dataAdapter = new $.jqx.dataAdapter(source);
									         
               $('#asiestadocita').jqxDropDownList({theme:tema,
               	                          selectedIndex: 0, autoDropDownHeight: true, promptText: "Estado de la cita:", 
                                          source: dataAdapter, displayMember: "descripcion", valueMember: "descripcion", 
                                          width: 300, height: 22}); 
			   
            }
            
            function asivendedor() {
        	
        	 var source =
				{
					datatype: "json",
					datafields: [
						{ name: 'id' },
						{ name: 'nombres' },
						{ name: 'apellidos' },
						{ name: 'empleado' }
					],
					id: 'id',
					url: '<?php echo site_url("emp/empleados/getVendedores"); ?>',
				};
			             
                   
                 var dataAdapter = new $.jqx.dataAdapter(source);
									         
               $('#asivendedor').jqxDropDownList({theme:tema,
               	                          selectedIndex: 0, autoDropDownHeight: true, promptText: "Asigne vendedor:", 
                                          source: dataAdapter, displayMember: "empleado", valueMember: "id", 
                                          width: 480, height: 22}); 
			   
            }
            
         
		  function asicampana_preaprobacion(camp_id, tabla_id) {
		 	  
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
									         
               //return this.dataAdapter;
               var preapestados=dataAdapter;
              //$('#vipreaestado').jqxComboBox({ source: preapestados, displayMember: "descripcion", valueMember: "id"});
               $('#asipreaestado').jqxDropDownList({ theme:tema, selectedIndex: 0, autoDropDownHeight: true, 
               	                                promptText: "Estados de preaprobación:",
               	                                source: preapestados, displayMember: "descripcion", valueMember: "id",
                                                width: 300, height: 22});
               
            } 
            
              function asi_perfil() {
            	var datos = {accion: 'dataPE'};//Perfil
           	    var url = "<?php echo site_url("man/parametros/ajax"); ?>";
           	    	 
        	    var source ={
						                datatype: "json",
						                datafields: [
                   					      { name: 'id', type: 'number' },
			               		          { name: 'descripcion', type: 'string' },
					                      
					                    ],
						                id: 'id',
						                url: url,
						                type: 'POST',
									    url:url,
									    data:datos,
									    async: false
						            };
			             
                   
                 var dataAdapter = new $.jqx.dataAdapter(source, {
						                //loadComplete: function (data) { },
						                //loadError: function (xhr, status, error) { }      
						            });
						            
		        $('#asiperfil').jqxDropDownList({theme:tema,
               	                          /*selectedIndex: 0, autoDropDownHeight: true,*/ promptText: "Perfil de aprobación:", 
                                          source: dataAdapter, displayMember: "descripcion", valueMember: "descripcion", 
                                          width: 200, height: 22}); 
									         
               
               
            } 
            
            
            function AsiSaveCita(){
            	var contacto_campana_id=$("#adidcontactocampana").jqxInput('val');
           	    var contacto_id=$('#adidcontacto').jqxInput('val');
   		        var campana_id=$('#adidcampana').jqxInput('val');
   		        //var telefono=$('#adtelefono').jqxInput('val');
   		        //var llamada_padre_id=$('#adidllamada').jqxInput('val');
   		        //var llamada_id=$('#adidllamada').jqxInput('val');
   		        //var inicio=$('#adinicio').jqxInput('val');
   		        var proceso=$('#vproceso').val();
   		        /*selecciona del combo id_empleado del usuario autentificado*/
   		        var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
			    var empleado_id=iemp.value;
   		        var respuesta=$("#asiestadocita").val();
   		        var vendedor=$("#asivendedor").val();
   		        var oper='asigcita';
            	var url = "<?php echo site_url("mar/contactos/ajax"); ?>"; 
            	var cita = {  
                        accion: oper,
                        tipo_gestion: $("#asitipogestion").val(), 
                        contacto_campana_id: $("#adidcontactocampana").val(),
                        contacto_id: $("#asicontacto_id").val(),
                        tipo_cliente_id: $("#asicliente_tipo_id").val(),
                        nombres: $("#asinombres").val(),
                        apellidos: $("#asiapellidos").val(),
                        ciudad: $("#asiciudad").val(),
                        direccion: $("#asidireccion").val(),
                        mail: $("#asiemail").val(),
                        ruc: $("#asiruc").val(),
			            razon_social: $("#asirazonsocial").val(),
                        llamada_id: $("#asillamada_id").val(),
                        campana_id: $("#asicampana_id").val(),
                        observacion:$("#asiobservacion").val(),
                        forma_pago:$("#asifpago").val(),
                        estado_preaprobacion:$("#asipreaestado").val(),
                        codigo_preaprobacion:$("#asiidprea").val(),
                        perfil:$("#asiperfil").val(),
                        limite_credito:$("#asilimcredito").val(),
                        financiamiento:$("#asifinanciamiento").val(),
                        limite_credito_tc:$("#asilimcredito_tc").val(),
                        financiamiento_tc:$("#asifinanciamiento_tc").val(),
						productos: $("#asigridproductos").jqxGrid('getrows'),
						agenda: asiagendaItems,
						cita_estado: respuesta,
						empleado_id: vendedor,
						padre_id: $("#asicita_id").val(),
						//datos de llamada
						/*
						telefono:telefono,
   		                llamada_padre_id:llamada_padre_id,
   		                inicio:inicio,
						llamada_estado: 'Finalizada',
		                proceso:proceso,
		                respuesta: respuesta,
		                */
		                //datos de encuesta
		                encuesta: asiencuestaItems,
						
                    };		
					//alert (asiencuestaItems.length)
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: cita,
                        success: function (data) {
							if(data=true){
								
								//finalizarAsignacionCita(contacto_id,empleado_id,campana_id,telefono,llamada_padre_id,inicio,respuesta,proceso);
							    $("#eventWindowAsiCita").jqxWindow('hide');
		                        //$("#gtelefonosGrid").jqxGrid('updatebounddata'); 
		                        //$('#eventWindowVisualizar').jqxWindow('hide');
		                        $("#jqxgrid").jqxGrid('updatebounddata');
                                
                                //jqxAlert.alert ('El dato se grabó correctamente.')
                            }else{
                                
                                jqxAlert.alert ('Problemas al guardar.');
                            }
                        },
                        error: function (msg) {
                            alert(msg.responseText);
                        }
                    });	
                    //actializa_encuesta(contacto_id,campana_id);
            }  
            
          /*function AsiCancelar(){
          	var contacto_campana_id=$('#adidcontactocampana').jqxInput('val');
          	var contacto_id=$('#adidcontacto').jqxInput('val');
   		    var campana_id=$('#adidcampana').jqxInput('val');
   		    var telefono=$('#adtelefono').jqxInput('val');
   		    var llamada_padre_id=$('#adidllamada').jqxInput('val');
   		    var inicio=$('#adinicio').jqxInput('val');
   		    var proceso=$('#vproceso').val();
   		    var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
			var empleado_id=iemp.value;		
   		    asifinalizar(contacto_campana_id,contacto_id,empleado_id,campana_id,telefono,llamada_padre_id,inicio,proceso)
          }*/ 
          
          asiencuestaItems = [];
          function actualiza_asiencuestaItems(contacto_id,campana_id,contacto_campana_id){
        	   var url = "<?php echo site_url("mar/preguntas/ajax"); ?>";
		       var soper = 'dataPG';
		       var datos = {
		    	     accion: soper,
			         campana_id: campana_id,
			         contacto_id: contacto_id,
			         contacto_campana_id: contacto_campana_id,
			         };
          		var customersPreguntas =
				{
					dataType: "json",
					dataFields: [
						{ name: 'id'},
						{ name: 'campana_id'},
						{ name: 'orden'},
						{ name: 'detalle_pregunta'},
						{ name: 'tipo_pregunta'},
						{ name: 'tipo_pregunta_id'},
						{ name: 'tipo_respuesta_id'},
						{ name: 'tipo_respuesta'},
						{ name: 'multiple_respuesta'},
						{ name: 'opciones'},
						{ name: 'obligatorio'}
					],
					id: 'id',
					type: 'POST',
                    url: url,
                    data: datos,
                    async: false
				};
			 		var dataAdapterPreg = new $.jqx.dataAdapter(customersPreguntas, {
			 			autoBind: true,
						beforeLoadComplete: function (data) {
						asiencuestaItems.length=0;	 
						for(i=0;i<data.length;i++){
							 id_pregunta = data[i]['id'];
							 multi = data[i]['multiple_respuesta'];
							 var opciones = data[i]['opciones'];
							 if (opciones==''){
								var resp=$("#asiresp_"+id_pregunta).val();	
								var respuesta = {
									resp: resp,
									contacto: contacto_id,
									preg: id_pregunta,
									multi: multi
								};
								asiencuestaItems.push(respuesta);
								
							 }
								 
								 for(j=0;j<opciones.length;j++){
									if (document.getElementById("asi"+opciones[j]['detalle']+"").checked==true){
										var resp = document.getElementById("asi"+opciones[j]['detalle']+"").value;
										var respuesta = {
											resp: resp,
											contacto: contacto_id,
											preg: id_pregunta,
											multi: multi
										};
										asiencuestaItems.push(respuesta);
									
									}	
																									 
								 }
						}
					}
					});
					//dataAdapterPreg.dataBind();	
			
          }
          
          
		
          function finalizarAsignacionCita(contacto_id,empleado_id,campana_id,telefono,padre_id,inicio,respuesta,proceso){
	     	       var url = "<?php echo site_url("mar/contactos/ajax"); ?>";
	     	       var oper='addllamada';
				      var llamada = {  
		                        accion: oper,
		                        padre_id: padre_id,
		                        contacto_id: contacto_id,
		                        empleado_id: empleado_id,
		                        campana_id: campana_id,
								telefono: telefono,
								inicio: inicio,
								fin: moment().format('YYYY-MM-DD HH:mm:ss'),
		                		llamada_estado: 'Finalizada',
		                		proceso:proceso,
		                		respuesta: respuesta,
								
						    };	
						   	$.ajax({
		                        type: "POST",
		                        url: url,
		                        data: llamada,
		                        success: function (data) {
		                         	                          
		                           //var llamada_id=data;                   					          
		                           if(data=true){
		                           	       
		                           		     
		                                     $("#eventWindowAsiCita").jqxWindow('hide');
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
          
          function asifinalizar(contacto_campana_id,contacto_id,empleado_id,campana_id,telefono,padre_id,inicio,proceso){
	     	       var url = "<?php echo site_url("mar/contactos/ajax"); ?>";
	     	       var oper='addllamada';
				      var llamada = {  
		                        accion: oper,
		                        padre_id: padre_id,
		                        contacto_campana_id:contacto_campana_id,
		                        contacto_id: contacto_id,
		                        empleado_id: empleado_id,
		                        campana_id: campana_id,
								telefono: telefono,
								inicio: inicio,
								fin: moment().format('YYYY-MM-DD HH:mm:ss'),
		                		llamada_estado: 'Finalizada',
		                		proceso:proceso,
		                		respuesta: 'Ninguna',
								
						    };	
						   
							$.ajax({
		                        type: "POST",
		                        url: url,
		                        data: llamada,
		                        success: function (data) {
		                         	                          
		                           //var llamada_id=data;                   					          
		                           if(data=true){
		                           	         asicerrarDialogo();
		                   				 		
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
  
       function asicerrarDialogo(){
        	 $('#eventWindowAsiCita').jqxWindow('hide');
		     $("#gtelefonosGrid").jqxGrid('updatebounddata');
        }


</script>	

<div style="visibility: hidden; display:none;" id="jqxWidgetAsiCita">	
	 <div>		
		<div style="display:none;" id="eventWindowAsiCita">
            <div id="asidescontacto">Asignación de la cita</div>
          
                <div>
                    <form id="frmAsiCita" method="post">
                    	<table>
                    	   <tr> 
						    <!--<td style="width:15%">Número:</td>
						    <td><input id="adtelefono"></td>
						    <td>Inicio:</td>
						    <td><input id="adinicio"></td>
						    <td>Tiempo:</td>
						    <td><input id="adtiempo"></td>-->
						    <td><input type="hidden" id="adidcampana"/></td>
						    <input type="hidden" style="margin-top: 0px;" id="adidcontacto"/>
						    <input type="hidden" style="margin-top: 0px;" id="adidcontactocampana"/>
						    <input type="hidden" style="margin-top: 0px;" id="asitipogestion"/>
                		    
						    <!--<input type="hidden" style="margin-top: 0px;" id="adidllamada"/>-->
							<!--<td style="width:25%">Cedula/RUC: <div id="lidentificacion"></div></td>-->
						  </tr>
                    	</table>
                    	   <input style="margin-top: 5px;" type="hidden"  id="asicita_id"/>
                    	   <input style="margin-top: 5px;" type="hidden" id="asicontacto_id"/>
                    	   <input style="margin-top: 5px;" type="hidden"  id="asillamada_id"/>
                    	   <input style="margin-top: 5px;" type="hidden"  id="asicampana_id"/>
                    	  
                                   <!--control oculto para contorlar expandido del acordion-->
                                   <div style="display:none;">
                                    	<p class="accordion-expand-holder">
									    <a id="accordion-expand-all" href="#">Expand all</a>
									    
									  </p>
                                   </div>
		                            
		                            <div id='asiaccordion' class="ui-accordion ui-widget ui-helper-reset">
						                  
						                 <h2 class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span> Datos del contacto</h2>
						                 <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
						                 	<table>
						                 	<tr>
											 <td align="right">Tipo ID:</td>
		                                     <td colspan="5" align="left"><div id="asicliente_tipo_id"></div></td>
											</tr>    
	                    			        <tr>
											  <td align="right">Cédula:</td>
											  <td colspan="5" align="left"> <input style="margin-top: 1px;" id="asicedula"/>
											  Teléfono: <input name="asitelefono" style="margin-top: 1px;" id="asitelefono"/></td>
											</tr>
											<tr>  
											  <td align="right">Contacto:</td>
											  <td colspan="5" align="left"> <input style="margin-top: 2px;" id="asinombres"/>
											  <input style="margin-top: 1px;" id="asiapellidos"/></td>
											 
										    </tr>
				                            <tr>
											  <td align="right">Ruc:</td>
											  <td colspan="5" align="left"> <input style="margin-top: 1px;" id="asiruc"/></td>
											</tr> 
											<tr>
											  <td align="right">Razón social:</td>
											  <td colspan="5" align="left"> <input style="margin-top: 1px;" id="asirazonsocial"/></td>
	                               		    </tr>
											
											<tr>
												<td align="right">Email personal:</td>
												<td colspan="5" align="left"><input style="margin-top: 1px;" id="asiemail"/></td>
											</tr>
											<tr>
												<td align="right">Ciudad:</td>
												<td colspan="5" align="left"> <input style="margin-top: 1px;" id="asiciudad"/></td>
											</tr>
											<tr>
												<td align="right">Direccion:</td>
												<td colspan="5" align="left"><textarea id="asidireccion"></textarea></td>
											</tr>
												
										  </table>
						                 </div>	
						                 <h2 class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span>Encuesta</h2>
						                 <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" id = "asidatosEncuesta"></div>
						                 <h2 class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span>Productos de interés</h2>
			                    	     <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
			                    	      Fecha de llamada : <input style="margin-top: 5px;" id="asifechallamada"/>
                    	                  Hora de llamada : <input style="margin-top: 5px;" id="asihorallamada"/>
                    	                  Número: <input style="margin-top: 5px;" id="asitelefonollamada"/>
                    	                  <input style="margin-right: 5px;" type="button" id="asibtnListaProducto" value="Productos" />
			                    	     	<table>
				                    	     	 <tr>
				                    	     	    <td align="left"><div style="padding: 5px; " id="asigridproductos"></div></td>
			                                     </tr> 
			                                     <tr>
			                                    	 <td align="left">Observaciones:</td>
			                                     </tr>
				                    	     	 <tr>
												 
												  <td align="left"><textarea id="asiobservacion"></textarea></td>
											     </tr>
											   
										    
		                                     </table>
			                    	     </div>	
						                 
						                 <h2 class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span>Agenda de visitas</h2>
						                  <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
						                 <table>
						                    <tr>
			                                	   	 <td align="right">Vendedor:</td>
													 <td colspan="5" align="left"><div style="margin-top: 1px;" id="asivendedor"></div></td>
													 <td colspan="5" align="left"><input style="margin-left: 5px;" type="button" id="asibtnConsAgendaVendedor" value="Agenda" /></td>
											</tr>
						                 </table>
						                 
						                 <div id='asicalendar'></div>
						                 </div>						                 
			                    	     
			                    	      <h2 class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span>Preaprobación del crédito y confirmación</h2>
			                    	      <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
			                    	      	<table>
											    <tr>
												  <td align="right">Forma de pago:</td>
												  <td colspan="5" align="left"><div style="margin-top: 1px;" id="asifpago"></div></td>
											     </tr>
			                    	     	
				                    	     	<tr>
													<td align="right">Estado de preaprobación:</td>
													<td colspan="3" align="left"> <div style="margin-top: 1px;" id="asipreaestado"></div></td>
												</tr>
												<tr>
												    <td align="right">ID de preaprobación:</td>
													<td align="left"> <input name="viidprea" style="margin-top: 1px;" id="asiidprea"/></td>
											        <td align="right">Perfil:</td>
													<td align="left"> <div style="margin-top: 2px;" id="asiperfil"/></td>
												 </tr>
												 <tr> 
												    <td align="right">Limite de crédito banco:</td>
													<td align="left"> <input style="margin-top: 2px;" id="asilimcredito"/></td>
									                <td align="right">Financiamiento banco:</td>
													<td align="left"><input style="margin-top: 2px;" id="asifinanciamiento"/></td>
												 </tr>
												 <tr> 	
													<td align="right">Limite de crédito tarjeta:</td>
													<td align="left"> <input style="margin-top: 2px;" id="asilimcredito_tc"/></td>
									                <td align="right">Financiamiento tarjeta:</td>
													<td align="left"><input style="margin-top: 2px;" id="asifinanciamiento_tc"/></td>
			                                     </tr>
			                                     <tr>
			                                	   	 <td align="right">Estado de la cita:</td>
													 <td colspan="5" align="left"><div style="margin-top: 1px;" id="asiestadocita"></div></td>
												  </tr>
												  
			                                     
			                                    </table>
			                    	      </div>
			                    	      	
			                    	    
                                       
							        </div> 
							
                           </form>
                     
                           <table>
                                 <tr>
										   <td align="right"><input style="margin-right: 5px;" type="button" id="asibtnSave" value="Grabar"/></td>
										   <td align="right"><input id="asibtnCancel" type="button" value="Cancelar" /></td>
										   <td align="right"><input style="margin-right: 5px;" id="asibtnExpandir" type="button" value="Expandir" /></td>
                                		</tr>
		                   </table>
                            
                </div>
            </div>
      </div>
  </div>   