<meta charset='utf-8' />
<style>
#valaccordion{
	font-size: 12px;
	}
#valcalendar {
		max-width: 750px;
		margin: 0 auto;
	}
	
td {
	style="font-size: 12px;"
}
</style>

 <script type="text/javascript">

        function valabrirDialogo(llamada_id,inicio,contacto_id,campana_id,telefono){
	
	          vallista_tipo_cliente();  
              //opvalidar(); 
              openfrmValCita();
              $('#valdidllamada').val(llamada_id);
              $('#valdinicio').val(inicio);
              $('#valdtelefono').val(telefono);
			  $('#valdidcampana').val(campana_id);
			  $('#valdidcontacto').val(contacto_id);
			  valeventoTipoCliente();
			                
        }
        
        function openfrmValCita(){
			 var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                        if (selectedrowindex >= 0 ) {
                            var offset = $("#jqxgrid").offset();
                            // get the clicked row's data and initialize the input fields.
	                        var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex );
	                        document.getElementById("frmValCita").reset();
	                        // show the popup window.
	                        createElementsValCita();
	                        val_perfil();
	                        valcampana_formapago(dataRecord.campana_id, 1);
			                valcampana_preaprobacion(dataRecord.campana_id, 2);
	                        $('#valcita_id').val(dataRecord.id);
							$('#valcliente_tipo_id').val(dataRecord.tipo_cliente_id);
			                $('#valllamada_id').val(dataRecord.llamada_id);
			                $('#valcampana_id').val(dataRecord.campana_id);
			                $('#valfpago').val(dataRecord.forma_pago);
			                $('#valpreaestado').val(dataRecord.estado_preaprobacion);
			                $('#validprea').val(dataRecord.codigo_preaprobacion);
			                $('#valperfil').val(dataRecord.perfil);
			                $('#vallimcredito').val(dataRecord.limite_credito);
			                $('#valfinanciamiento').val(dataRecord.financiamiento);
			                $('#vallimcredito_tc').val(dataRecord.limite_credito_tc);
			                $('#valfinanciamiento_tc').val(dataRecord.financiamiento_tc);
			                $('#valobservacion').val(dataRecord.observacion);
			                valhabilitaTipoCliente(dataRecord.tipo_cliente_id);
			                valllamada(dataRecord.llamada_id);
							valcontacto(dataRecord.contacto_id);
			                valempresa(dataRecord.empresa_id);
			                valcmail(dataRecord.contacto_id);
			                valgridProductos(dataRecord.id); 
			                valagenda(dataRecord.id);
			                 	
			                $("#eventWindowValCita").jqxWindow('open');
			                $('#valcalendar').fullCalendar('render');
							
							
	                        }else{
	                        	jqxAlert.alert('Seleccione un registro','Validación de cita');
	                        }
        }

        function valpreguntas_datos(camp_id,contacto_id,contacto_campana_id){
			$("#valdatosEncuesta").empty(); 
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
							   $('#valdatosEncuesta').append("<table>");
								for(i=0;i<data.length;i++){
								 id_pregunta = data[i]['id'];
								 pregunta = data[i]['detalle_pregunta'];
								 orden = data[i]['orden'];
								 var tipo_respuesta = data[i]['tipo_respuesta_id'];
								 var opciones = data[i]['opciones'];
								 if (opciones==''){
								 	 $('#valdatosEncuesta').append("<tr><td>"+orden+".- </td><td>"+data[i]['detalle_pregunta']+"</td><tr></tr><td colspan='2'><input id='valresp_"+id_pregunta+"' value='"+data[i]['respuesta_texto']+"'/><td></tr>");
							 	 	//$('#valdatosEncuesta').append("<tr><td>"+orden+".- </td><td>"+data[i]['detalle_pregunta']+"</td><td><input id='valresp_"+id_pregunta+"' value='"+data[i]['respuesta_texto']+"'/><td></tr>");
								 }else{
								 	$('#valdatosEncuesta').append("<tr><td>"+orden+".- </td><td>"+data[i]['detalle_pregunta']+"</td></tr>");
								 }
								 
								 for(j=0;j<opciones.length;j++){
									
								 	if (opciones[j]['respuesta']==opciones[j]['detalle']){var check='checked';}else{var check='';}
										//alert(opciones[j]['respuesta']);
									 $('#valdatosEncuesta').append("<tr><td colspan=2><input type='"+opciones[j]['objeto']+"' id='val_"+opciones[j]['detalle']+"' name='"+id_pregunta+"'  value = '"+opciones[j]['detalle']+"' "+check+">"+opciones[j]['detalle']+"</td></tr>");
									
									 }
								}
								
								$('#valdatosEncuesta').append("</table>");
						},
						
					});
									         
          			 
			 
		}  

        function createElementsValCita() {
	           
               $('#eventWindowValCita').jqxWindow({
            	resizable: false,
                width: '100%',
                Height: '100%',
                theme:tema,
                //minHeight: 300, 
                isModal: true,
                modalOpacity: 0.01,  
                cancelButton: $("#valbtnCancel"),
                initContent: function () {
               	/*$('#valaccordion').accordion({theme:tema, 
            	                          //heightStyle: "content",
            	                          activate: function( event, ui ) {
            		                                $('#valcalendar').fullCalendar('render');
            	                          }
            	});*/
            	
            	var headers = $('#valaccordion .accordion-header');
				//inicia expandido el acordion
				var contentAreas = $('#valaccordion .ui-accordion-content ').show();
				var expandLink = $('#valaccordion-expand-all');
				
				
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
            	
            	$('#valcita_id').jqxInput({theme:tema, disabled: true,width: '100px', height: 20 });
			    $('#valcontacto_id').jqxInput({theme:tema, disabled: true,width: '100px', height: 20 });
			    $('#valllamada_id').jqxInput({theme:tema,disabled: true,width: '100px', height: 20 });
			    $('#valcampana_id').jqxInput({theme:tema,disabled: true,width: '100px', height: 20 });
			    $('#valdtelefono').jqxInput({theme: tema, disabled: true, width: '150px'});
			    $('#valdinicio').jqxInput({theme: tema, disabled: true, width: '180px'});
			    $('#valdtiempo').jqxInput({theme: tema, disabled: true, width: '80px'});
			    $('#valdidcampana').jqxInput({theme: tema, disabled: true,width: '100px', height: 20 });
			    $('#valdidcontacto').jqxInput({theme: tema, disabled: true,width: '100px', height: 20 });
			    $('#valdidllamada').jqxInput({theme: tema, disabled: true,width: '100px', height: 20 });
			     var myVar = setInterval(function () {myTimer()}, 100);
			    	function myTimer() {
					    var d = new Date();
					    $('#valdtiempo').val(d.toLocaleTimeString());
					}	
			    $('#valtelefonollamada').jqxInput({theme:tema,disabled: true,width: '100px', height: 20 });
			    $('#valfechallamada').jqxInput({theme:tema,disabled: true,width: '100px', height: 20 });
			    $('#valhorallamada').jqxInput({theme:tema,disabled: true,width: '100px', height: 20 });
			    $('#valcliente_tipo_id').jqxDropDownList({theme: tema, width: 200,height: 20});
			    $('#valcedula').jqxInput({theme:tema,disabled: true,width: '200px', height: 20 });
			    $('#valnombres').jqxInput({theme:tema,width: '280px', height: 20, placeHolder:'ingrese nombres'});
			    $('#valapellidos').jqxInput({theme:tema,width: '280px', height: 20, placeHolder:'ingrese apellidos'});
			    $('#valruc').jqxInput({theme:tema,width: '200px', height: 20});
			    $('#valrazonsocial').jqxInput({theme:tema,width: '570px', height: 20}); 
			    $('#valciudad').jqxInput({theme:tema,width: '570px', height: 20 });
			    valciudades($('#valciudad'));
			    $('#valdireccion').jqxInput({theme:tema,width: '570px', height: 50 });
			    $('#valobservacion').jqxInput({theme:tema,width: '660px', height: 40 });
			    $('#valemail').jqxInput({theme:tema, width: '570px', height: 20 });
			    $('#validprea').jqxInput({theme:tema, width: '100px', height: 20 });
                //$('#valperfil').jqxInput({theme:tema, width: '100px', height: 20 });
                $('#vallimcredito').jqxInput({theme:tema, width: '150px', height: 20 });
                $('#valfinanciamiento').jqxInput({theme:tema, width: '150px', height: 20 });
                $('#vallimcredito_tc').jqxInput({theme:tema, width: '150px', height: 20 });
                $('#valfinanciamiento_tc').jqxInput({theme:tema, width: '150px', height: 20 });
                valcestadocita();
                $('#valbtnListaProducto').jqxButton({theme:tema, width: '70px' });
			    $('#valbtnSave').jqxButton({theme:tema, width: '65px' });
   		        $('#valbtnCancel').jqxButton({theme:tema, width: '65px' });
   		        $('#valbtnExpandir').jqxButton({theme:tema, width: '65px' });
   		        $("#valbtnListaProducto").click(function () {
   		        	campid=	 $('#valdidcampana').val();	
   		            clieid= $('#valcliente_tipo_id').val();
   		           	abrirListaProductos('citaval_detalle',campid, clieid);
   		           	   		               		        	 
   		          });         
   		         $("#valbtnSave").click(function () {	
   		         		valmensaje='' 
   		              if (valvalidaForm()){
   		                 
   		              	   ValSaveCita();
   		        	   }else{
   		        	   	jqxAlert.alert(valmensaje,'Validación');
   		        	   }
   		          });
   		          
   		           $("#valbtnCancel").click(function () {
   		           	 valencuestaItems.length=0;
   		           	 valagendaItems.length=0;	
   		           	
   		           	 ValCancelar();
   		           	   		               		        	 
   		          });
   		          
   		           $("#valbtnExpandir").click(function () {	
   		             var contentAreas = $('#valaccordion .ui-accordion-content ').show();
   		          });            		          	
   		            				
               }
            });
            $('#eventWindowValCita').jqxWindow('focus');
            $('#eventWindowValCita').jqxValidator('hide');
            $('#eventWindowValCita').on('close', function (event) {
            	 valencuestaItems.length=0;
   		         valagendaItems.length=0;
			     //location.reload();
			     // $("#eventWindowValCita").jqxWindow('destroy');
			});
			
			
        }
        
        
        function valeventoTipoCliente(){
        	 $('#valcliente_tipo_id').on('select', function (event) {
                	var args = event.args;
                    var item = $('#valcliente_tipo_id').jqxDropDownList('getItem', args.index);
                    if (item != null) {
                    
                       $('#eventWindowValCita').jqxValidator('hide');
                       $("#valruc").val('');
			           $("#valrazonsocial").val('');
                       valhabilitaTipoCliente(item.value);
                       valcartItems.length=0;
                       $("#valgridproductos").jqxGrid('updatebounddata');
                       
                     }
                 
                });
        }
        
        function valhabilitaTipoCliente(tipo){
         	if (tipo==2){//cliente con ruc
			    $("#valruc").jqxInput({disabled: false});
			    $("#valrazonsocial").jqxInput({disabled: false}); 	
			    }else if (tipo==1){//cliente sin ruc
			    $("#valruc").jqxInput({disabled: true});
			    $("#valrazonsocial").jqxInput({disabled: true}); 	
			    }
			
			    //codigo para validacion de entradas
	            $('#eventWindowValCita').jqxValidator({
	             	hintType: 'label',
	                animationDuration: 0,
	                rules:  valreglasVisita(tipo) 
	            });	
         }
         
         
        function valreglasVisita(tipo){
         	if (tipo==2){//cliente con ruc
         		return valreglasconRuc;
         	}else if (tipo==1){//cliente sin ruc
         	 return valreglassinRuc;
         	}
         } 
        var valmensaje;
        var valreglassinRuc=[
	                { input: '#valcedula', message: 'Cédula debe tener 10 caracteres!', action: 'keyup, blur', rule: 'length=10,10' },
					{ input: '#valnombres', message: 'Nombres es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(0);
							 valmensaje='Nombres son requeridos!';	
							 return false;
							 }
							return true;
							
							} },
					{ input: '#valapellidos', message: 'Apellidos es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(0);
							 valmensaje='Apellidos son requeridos!';	
							 return false;
							 }
							return true;
							
							} },
				   /*
	               { input: '#valobservacion', message: 'Observación es requerida!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setValSeccion(1);	
							 return false;
							 }
							return true;
							
							}},
                    */
	                { input: '#valciudad', message: 'Ciudad es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(0);
							 valmensaje='Ciudad es requerida!';	
							 return false;
							 }
							return true;
							
							}  },
					{ input: '#valdireccion', message: 'Direccion es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(0);
							 valmensaje='Direccion es requerida!';	
							 return false;
							 }
							return true;
							
							} },
				   /* 
	                { input: '#valemail', message: 'email es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setValSeccion(0);	
							 return false;
							 }
							return true;
							
							}  },
	                { input: '#valemail', message: 'e-mail invalido!', action: 'keyup', rule: 'email' },
	                */
	                { input: '#valfpago', message: 'Forma de pago es requerida!', action: 'keyup, blur, select', rule: function (input) {
                           	if(input.val()==""){
							  //setValSeccion(3);
							 valmensaje='Forma de pago es requerida!'; 
							 return false;
							 }
							return true;
							} 
					},
					{ input: '#valpreaestado', message: 'Estado de preaprobación es requerido!', action: 'keyup, blur, select', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);
							 valmensaje='Estado de preaprobación es requerido!'; 	
							 return false;
							 }
							return true;
							
							}
					},
					
					{ input: '#valestadocita', message: 'Estado de la cita es requerida!', action: 'keyup, blur, select', rule: function (input) {
                           	if(input.val()==""){
							 //setValSeccion(3);
							 valmensaje='Estado de la cita es requerida!'; 	 	
							 return false;
							 }
							return true;
							} 
					},
					
	                { input: '#validprea', message: 'ID de aprobación es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);	
							 valmensaje='ID de aprobación es requerido!'; 	
							 return false;
							 }
							return true;
							
							} },
	                { input: '#valperfil', message: 'Perfil de aprobación es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);	
							 valmensaje='Perfil de aprobación es requerido!';
							 return false;
							 }
							return true;
							
							} },
					{ input: '#vallimcredito', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#vallimcredito', message: 'Limite de credito  es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);
							 valmensaje='Limite de credito es requerido!';		
							 return false;
							 }
							return true;
							
							} },
					{ input: '#valfinanciamiento', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#valfinanciamiento', message: 'Financiamiento de producto es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);
							 valmensaje='Financiamiento es requerido!';	
							 return false;
							 }
							return true;
							
							} },
					{ input: '#vallimcredito_tc', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#vallimcredito_tc', message: 'Limite de credito  es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);
							 valmensaje='Limite de credito es requerido!';		
							 return false;
							 }
							return true;
							
							} },
					{ input: '#valfinanciamiento_tc', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#valfinanciamiento_tc', message: 'Financiamiento de producto es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);
							 valmensaje='Financiamiento es requerido!';	
							 return false;
							 }
							return true;
							
							} }
	                  
	                ]   
        var valreglasconRuc=[
	                { input: '#valcedula', message: 'Cédula debe tener 10 caracteres!', action: 'keyup, blur', rule: 'length=10,10' },
					{ input: '#valnombres', message: 'Nombres es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(0);
							 valmensaje='Nombres son requerido!';	
							 return false;
							 }
							return true;
							
							} },
					{ input: '#valapellidos', message: 'Apellidos es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(0);
							 valmensaje='Apellidos son requerido!';	
							 return false;
							 }
							return true;
							
							} },
	                { input: '#valruc', message: 'RUC es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(0);
							 valmensaje='RUC es requerido!';		
							 return false;
							 }
							return true;
							
							} },
	                { input: '#valruc', message: 'RUC incorrecto!', action: 'keyup, blur', rule: function (input) {
            				if(!valValidaRuc()){
            				 //setValSeccion(0);
            				 valmensaje='RUC incorrecto!';			
							 return false;
							 }
							return true;
							}
					},
	                { input: '#valruc', message: 'RUC debe tener 13 caracteres!', action: 'keyup, blur', rule: 'length=13,13' },
	                { input: '#valrazonsocial', message: 'Razón social!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(0);
							 valmensaje='Razón social es requerida!';
							 return false;
							 }
							return true;
							
							}  },
	                { input: '#valrazonsocial', message: 'Razón social debe contener solo letras!', action: 'keyup', rule: 'notNumber' },
	                { input: '#valrazonsocial', message: 'Razón social debe contener de 3 a 100 caracteres!', action: 'keyup', rule: 'length=3,100' },
	                /*{ input: '#valobservacion', message: 'Observación es requerida!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setValSeccion(1);	
							 return false;
							 }
							return true;
							
							}},*/
	                //{ input: '#nombrecomercial', message: 'Razón social debe contener solo letras!', action: 'keyup', rule: 'notNumber' },
	                //{ input: '#nombrecomercial', message: 'Razón social debe contener de 3 a 40 caracteres!', action: 'keyup', rule: 'length=3,40' },
	                { input: '#valciudad', message: 'Ciudad es requerida!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(0);
							 valmensaje='Ciudad es requerida!';	
							 return false;
							 }
							return true;
							
							}  },
					{ input: '#valdireccion', message: 'Direccion es requerida!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(0);	
							 valmensaje='Direccion es requerida!';	
							 return false;
							 }
							return true;
							
							} },
				    /*
	                { input: '#valemail', message: 'email es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setValSeccion(0);	
							 return false;
							 }
							return true;
							
							}  },
	                { input: '#valemail', message: 'e-mail invalido!', action: 'keyup', rule: 'email' },
	                */
	                { input: '#valfpago', message: 'Forma de pago es requerida!', action: 'keyup, blur, select', rule: function (input) {
                           	if(input.val()==""){
							 //setValSeccion(3);
							 valmensaje='Forma de pago es requerida!';
							 return false;
							 }
							return true;
							} 
					},
					{ input: '#valpreaestado', message: 'Estado de preaprobación es requerido!', action: 'keyup, blur, select', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);	
							 valmensaje='Estado de preaprobación es requerida!';	
							 return false;
							 }
							return true;
							
							}
					},
					
					{ input: '#valestadocita', message: 'Estado de la cita es requerida!', action: 'keyup, blur, select', rule: function (input) {
                           	if(input.val()==""){
							 //setValSeccion(3);
							 valmensaje='Estado de la cita es requerida!';	
							 return false;
							 }
							return true;
							} 
					},
					
	                { input: '#validprea', message: 'ID de aprobación es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);
							 valmensaje='ID de aprobación es requerido!';		
							 return false;
							 }
							return true;
							
							} },
	                { input: '#valperfil', message: 'Perfil de aprobación es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);	
							 valmensaje='Perfil de aprobación es requerido!';
							 return false;
							 }
							return true;
							
							} },
	                { input: '#vallimcredito', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#vallimcredito', message: 'Limite de credito banco  es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);
							 valmensaje='Limite de credito es requerido!';		
							 return false;
							 }
							return true;
							
							} },
					{ input: '#valfinanciamiento', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#valfinanciamiento', message: 'Financiamiento banco es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);
							 valmensaje='Financiamiento es requerido!';	
							 return false;
							 }
							return true;
							
							} },
					{ input: '#vallimcredito_tc', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#vallimcredito_tc', message: 'Limite de credito tarjeta  es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);
							 valmensaje='Limite de credito es requerido!';		
							 return false;
							 }
							return true;
							
							} },
					{ input: '#valfinanciamiento_tc', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#valfinanciamiento_tc', message: 'Financiamiento de tarjeta es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);
							 valmensaje='Financiamiento es requerido!';	
							 return false;
							 }
							return true;
							
							} }
	                   
	                ]   
		       
		 /* function setValSeccion(h){
			    	$( "#accordion" ).accordion( "option", "active", h );
			    }  
          */  
        function valValidaRuc(){
           var rvalida=true;
           if (!validaDoc($("#valruc").val())){
          	  rvalida=false;
           }
           	return rvalida;
          }
          
        function valValidaProductos(){
            var pvalida=true;
          	var rows = $('#valgridproductos').jqxGrid('getrows');
           	if (!rows.length>0){
          		pvalida=false;
          	}
          	return pvalida;
          }
          
        function valValidaAgenda(){
           	var avalida=true;
           	if (!valagendaItems.length>0){
           		avalida=false;
           	}
           	return avalida;
           }
           
        function valvalidaCita(){
           	    var cvalida =$('#eventWindowValCita').jqxValidator('validate')
           	    if (!cvalida){
           		 cvalida=false;	
           		}
           		return cvalida;	
           }
        function setValEncuesta(){
           	/*Actualiza el arreglo con informacion de la encuesta que se va enviarl al controlador*/
           	var contacto_campana_id=$("#vidcontactocampana").jqxInput('val');
           	var contacto_id=$('#valdidcontacto').jqxInput('val');
   		    var campana_id=$('#valdidcampana').jqxInput('val');
   		    //armo el arreglo con informacion de encuesta del formulario
   		    actualiza_valencuestaItems(contacto_id,campana_id,contacto_campana_id);
           }
        function valvalidaForm(){
           	var fvalida=true;
           	setValEncuesta();
            if (!valvalidaCita()){
                	fvalida=false;
                	//jqxAlert.alert('Ingrese datos de la cita');
             }else if (!valValidaProductos()){
           		   fvalida=false;
           		   //setValSeccion(1);
           		  jqxAlert.alert('Ingrese productos');
             }else if (!valValidaAgenda()){
                 fvalida=false;
                   //setValSeccion(2);
                  jqxAlert.alert('Ingrese agenda');	
              }
                        
              if (fvalida) return true; else return false;
           	}

        
         valcartItems = [];
          
              
         function valgridProductos(cita_id) { 
         	   var url="<?php echo site_url("mar/valcitas/productos"); ?>"+"/"+cita_id;
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
									           
									           valRecuperaItem({producto_id: data[i].producto_id, producto: data[i].producto, cantidad: data[i].cantidad});
									            
									        }
						       
						                },
						           });
									         
               
                 dataAdapter.dataBind();
	        
        	  
                $("#valgridproductos").jqxGrid(
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
                $("#valgridproductos").bind('cellclick', function (event) {
                    var index = event.args.rowindex;
                    if (event.args.datafield == 'remove') {
                        var item = valcartItems[index];
                        if (item.cantidad > 1) {
                            item.cantidad -= 1;
                            valupdateGridRow(index, item);
                        }
                        else {
                            valcartItems.splice(index, 1);
                            valremoveGridRow(index);
                        }
                       
                    }
                });
              
            };
                     
            
         function valRecuperaItem(item) {
                var index = valgetItemIndexn(item.producto);
           
                    var id = valcartItems.length,
                        item = {
                        	producto_id: item.producto_id,
                            producto: item.producto,
                            cantidad: parseInt(item.cantidad),
                            index: id,
                            remove: '<div style="text-align: center; cursor: pointer; width: 53px;"' +
                         'id="draggable-demo-row-' + id + '">X</div>'
                        };
                    valcartItems.push(item);
                    valaddGridRow(item);
                  
               
            };
            
         function valaddItem(item) {
                var index = valgetItemIndexn(item.producto);
                if (index >= 0) {
                    valcartItems[index].cantidad += 1;
                    valupdateGridRow(index, valcartItems[index]);
                } else {
                    var id = valcartItems.length,
                        item = {
                        	producto_id: item.producto_id,
                            producto: item.producto,
                            cantidad: 1,
                            index: id,
                            remove: '<div style="text-align: center; cursor: pointer; width: 53px;"' +
                         'id="draggable-demo-row-' + id + '">X</div>'
                        };
                    valcartItems.push(item);
                    valaddGridRow(item);
                  
                }
                //updatePrice(item.price);
            };
            
         function valaddGridRow(row) {
                $("#valgridproductos").jqxGrid('addrow', null, row);
                 
            };
         function valupdateGridRow(id, row) {
                var rowID = $("#valgridproductos").jqxGrid('getrowid', id);
                $("#valgridproductos").jqxGrid('updaterow', rowID, row);
            };
         function valremoveGridRow(id) {
                var rowID = $("#valgridproductos").jqxGrid('getrowid', id);
                $("#valgridproductos").jqxGrid('deleterow', rowID);
            };
         function valgetItemIndexn(name) {
                for (var i = 0; i < valcartItems.length; i += 1) {
                    if (valcartItems[i].producto === name) {
                        return i;
                    }
                }
                return -1;
            };      
            
            
 function valcontacto(cont_id){
        $("#valdescontacto").empty();
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
						                	    $('#valcontacto_id').val(cont_id);
						                	    $('#valcedula').val(data.identificacion);
						                	    $('#valnombres').val(data.nombres);
						                	    $('#valapellidos').val(data.apellidos);
						                	    $('#valciudad').val(data.ciudad);
						                	    $('#valdireccion').val(data.direccion);
						                	     var container;
						                	     container = 'VALIDACIÓN DE CITA DE: '+ data.apellidos+' '+data.nombres;
						                	      $('#valdescontacto').append(container);
						       
						                },
						           });
									         
               
         dataAdapter.dataBind();
	   }
	   
 function valllamada(id){
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
						                    $('#valtelefonollamada').val(data.telefono);
						                    $('#valfechallamada').val(llfecha);
						                    $('#valhorallamada').val(llhora);
						                 },
						           });
									         
               dataAdapter.dataBind();
	   }
	   
 function valcmail(cont_id){
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
						                	    $('#valemail').val(data.valor);
						                 },
						           });
									         
               dataAdapter.dataBind();
	   }
	   
 function valempresa(emp_id){
		var url = "<?php echo site_url("mar/valcitas/empresa"); ?>"+"/"+emp_id;
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
						                	    $('#valruc').val(data.ruc);
						                	    $('#valrazonsocial').val(data.razon_social);
						                 },
						           });
									         
               dataAdapter.dataBind();
	   }
        
 function valciudades($ciudad){
       	
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
       
 function vallista_tipo_cliente(){
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
		 		 $("#valcliente_tipo_id").jqxDropDownList({
							source: dataAdapter,
							//width: 400,
							//height: 20,
							//selectedIndex: 0,
							displayMember: 'descripcion',
							valueMember: 'id'
					});  
				 
          	
          } 
      
 /* Generate unique id */
 function valget_uni_id(){
				
					//Generate unique id
					return new Date().getTime() + Math.floor(Math.random()) * 500;
		}
		
 function valgetItemIndex(id) {
		                for (var i = 0; i < valagendaItems.length; i += 1) {
		                    if (valagendaItems[i].id === id) {
		                        return i;
		                    }
		                }
		                return -1;
		}
		
 valagendaItems = [];
 //valagendaItems = new Array();
 function clearvalagendaItems(){
	    	for(i in valagendaItems){
	    		valagendaItems.pop();
	    	}
	    }
	      
 function valinitCalendar(){
        	var fa= new Date();
				          	$('#valcalendar').fullCalendar({
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
								if ((end.diff(start, 'days')) ==0){
								if (confirm("Desea agregar fecha hora para la cita?")) {
								var title='Visita a: ' + $("#valapellidos").val()+' ' +$("#valnombres").val();
								var eventData;
								if (title) {
									eventData = {
										id: valget_uni_id(),
										title: title,
										start: start.format(),
										end: end.format()
										
									};
									valagendaItems.push(eventData);
									$('#valcalendar').fullCalendar('renderEvent', eventData, true); // stick? = true
									
								}
								$('#valcalendar').fullCalendar('unselect');
								}
							 }
							},
							*/
							editable: true,
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
						      					  
						         if (confirm("Desea eliminar el evento?")) {
						         	 var id=calEvent.id;
						         	 $('#valcalendar').fullCalendar('removeEvents',id);
						    	     var index = valgetItemIndex(id);
				                  	  valagendaItems.splice(index, 1);
				                  	  
						           
						         }else{
						         	 revertFunc();
						         }
						      			
						    },
							*/
							
						dayClick: function(date, view) {
								$('#valcalendar').fullCalendar('changeView', 'agendaDay');
								$('#valcalendar').fullCalendar('gotoDate', date);
								}
							
						});		
        }
	    
 function borrarvalagenda(){
        	valagendaItems.length=0;
   		    $('#valcalendar').fullCalendar('removeEvents');
   		    $('#valcalendar').fullCalendar('rerenderEvents');
        }
        
 function valagenda(cita_id){
            borrarvalagenda();
            valinitCalendar();
        	var url="<?php echo site_url("mar/valcitas/agenda"); ?>"+"/"+cita_id;
	    	$.ajax({
			        type: "POST",
			        url:url,
			        async: true,
			        success: function(datos){
			        				        	
			               valagendaItems=eval(datos);
			               //alert(valagendaItems[0].id);
			               $('#valcalendar').fullCalendar('addEventSource', valagendaItems);         
                           
			               	             
			        },
			        error: function (obj, error, objError){
			            //avisar que ocurrió un error
			        }
			});
        	
          }
          
 function valcampana_formapago(camp_id, tabla_id) {
        	
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
               $('#valfpago').jqxDropDownList({theme:tema,
               	                          selectedIndex: 0, autoDropDownHeight: true, promptText: "Forma de pago:", 
                                          source: formasPago, displayMember: "descripcion", valueMember: "id", 
                                          width: 300, height: 22}); 
			   
            }
            
 function valcestadocita() {
        	
        	 var tabla_id=4
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
									         
               $('#valestadocita').jqxDropDownList({theme:tema,
               	                          selectedIndex: 0, autoDropDownHeight: true, promptText: "Estado de la cita:", 
                                          source: dataAdapter, displayMember: "descripcion", valueMember: "descripcion", 
                                          width: 300, height: 22}); 
			   
            }
            
         
 function valcampana_preaprobacion(camp_id, tabla_id) {
		 	  
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
               $('#valpreaestado').jqxDropDownList({ theme:tema, selectedIndex: 0, autoDropDownHeight: true, 
               	                                promptText: "Estados de preaprobación:",
               	                                source: preapestados, displayMember: "descripcion", valueMember: "id",
                                                width: 300, height: 22});
               
            }  
            
 function val_perfil() {
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
						            
		        $('#valperfil').jqxDropDownList({theme:tema,
               	                          /*selectedIndex: 0, autoDropDownHeight: true,*/ promptText: "Perfil de aprobación:", 
                                          source: dataAdapter, displayMember: "descripcion", valueMember: "descripcion", 
                                          width: 200, height: 22}); 
									         
               
               
            }
            
            
 function ValSaveCita(){
            	var tipo_gestion=$("#vtipogestion").val();
            	var contacto_campana_id= $("#vidcontactocampana").val();
            	var contacto_id=$('#valdidcontacto').jqxInput('val');
   		        var campana_id=$('#valdidcampana').jqxInput('val');
   		        var telefono=$('#valdtelefono').jqxInput('val');
   		        var llamada_padre_id=$('#valdidllamada').jqxInput('val');
   		        var llamada_id=$('#valdidllamada').jqxInput('val');
   		        var inicio=$('#valdinicio').jqxInput('val');
   		        var proceso=$('#vproceso').val();
   		        var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
			    var empleado_id=iemp.value;
   		        var respuesta=$("#valestadocita").val();
   		        var oper='addcita';
            	var url = "<?php echo site_url("mar/contactos/ajax"); ?>"; 
            	var cita = {  
                        accion: oper,
                        tipo_gestion:tipo_gestion,
                        contacto_campana_id: contacto_campana_id,
                        contacto_id: $("#valcontacto_id").val(),
                        empleado_id: empleado_id,
                        tipo_cliente_id: $("#valcliente_tipo_id").val(),
                        nombres: $("#valnombres").val(),
                        apellidos: $("#valapellidos").val(),
                        ciudad: $("#valciudad").val(),
                        direccion: $("#valdireccion").val(),
                        mail: $("#valemail").val(),
                        ruc: $("#valruc").val(),
			            razon_social: $("#valrazonsocial").val(),
                        llamada_id: llamada_id,
                        campana_id: $("#valcampana_id").val(),
                        observacion:$("#valobservacion").val(),
                        forma_pago:$("#valfpago").val(),
                        estado_preaprobacion:$("#valpreaestado").val(),
                        codigo_preaprobacion:$("#validprea").val(),
                        perfil:$("#valperfil").val(),
                        limite_credito:$("#vallimcredito").val(),
                        financiamiento:$("#valfinanciamiento").val(),
                        limite_credito_tc:$("#vallimcredito_tc").val(),
                        financiamiento_tc:$("#valfinanciamiento_tc").val(),
						productos: $("#valgridproductos").jqxGrid('getrows'),
						agenda: valagendaItems,
						cita_estado: respuesta,
						padre_id: $("#valcita_id").val(),
						//datos de llamada
						telefono:telefono,
   		                llamada_padre_id:llamada_padre_id,
   		                inicio:inicio,
						llamada_estado: 'Finalizada',
		                proceso:proceso,
		                respuesta: respuesta,
		                //datos de encuesta
		                encuesta: valencuestaItems,
						
                    };		
					
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: cita,
                        success: function (data) {
							if(data=true){
								
								 $("#eventWindowValCita").jqxWindow('hide');
		                         $("#gtelefonosGrid").jqxGrid('updatebounddata'); 
		                         $('#eventWindowVisualizar').jqxWindow('hide');
		                         $("#jqxgrid").jqxGrid('updatebounddata');
                                
                                //jqxAlert.alert ('El dato se grabó correctamente.');
                            }else{
                                
                                jqxAlert.alert ('Problemas al guardar.');
                            }
                        },
                        error: function (msg) {
                            alert(msg.responseText);
                        }
                    });	
                    
                    
            }  
            
 function ValCancelar(){
          	var contacto_campana_id= $("#vidcontactocampana").jqxInput('val');
          	var contacto_id=$('#valdidcontacto').jqxInput('val');
   		    var campana_id=$('#valdidcampana').jqxInput('val');
   		    var telefono=$('#valdtelefono').jqxInput('val');
   		    var llamada_padre_id=$('#valdidllamada').jqxInput('val');
   		    var inicio=$('#valdinicio').jqxInput('val');
   		    var proceso=$('#vproceso').val();		
   		    var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
			var empleado_id=iemp.value;
   		    valfinalizar(contacto_campana_id,contacto_id,empleado_id,campana_id,telefono,llamada_padre_id,inicio,proceso)
   }  
          
 valencuestaItems = [];
 function actualiza_valencuestaItems(contacto_id,campana_id,contacto_campana_id){
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
						valencuestaItems.length=0;	 
						for(i=0;i<data.length;i++){
							 id_pregunta = data[i]['id'];
							 multi = data[i]['multiple_respuesta'];
							 var opciones = data[i]['opciones'];
							 if (opciones==''){
								var resp=$("#valresp_"+id_pregunta).val();	
								var respuesta = {
									resp: resp,
									contacto: contacto_id,
									preg: id_pregunta,
									multi: multi
								};
								valencuestaItems.push(respuesta);
								
							 }
								 
								 for(j=0;j<opciones.length;j++){
									if (document.getElementById("val_"+opciones[j]['detalle']+"").checked==true){
										var resp = document.getElementById("val_"+opciones[j]['detalle']+"").value;
										var respuesta = {
											resp: resp,
											contacto: contacto_id,
											preg: id_pregunta,
											multi: multi
										};
										valencuestaItems.push(respuesta);
									
									}	
																									 
								 }
						}
					}
					});
					
			
          }
          
         
 function valfinalizar(contacto_campana_id,contacto_id,empleado_id,campana_id,telefono,padre_id,inicio,proceso){
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
		                           	         valcerrarDialogo();
		                   				 		
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
  
 function valcerrarDialogo(){
        	 $('#eventWindowValCita').jqxWindow('hide');
		     $("#gtelefonosGrid").jqxGrid('updatebounddata');
        }


</script>	

<div style="visibility: hidden; display:none;" id="jqxWidgetValCita">	
	 <div>		
		<div style="display:none;" id="eventWindowValCita">
            <div id="valdescontacto">Validación de la cita</div>
          
                <div>
                    <form id="frmValCita" method="post">
                    	<table>
                    	   <tr> 
						    <td><input type="hidden" id="valdidcampana"></td>
						    <input type="hidden" style="margin-top: 0px;" id="valdidcontacto"/>
						    <input type="hidden" style="margin-top: 0px;" id="valdidllamada"/>
							<!--<td style="width:25%">Cedula/RUC: <div id="lidentificacion"></div></td>-->
						  </tr>
                    	</table>
                    	   <input style="margin-top: 5px;" type="hidden"  id="valcita_id"/>
                    	   <input style="margin-top: 5px;" type="hidden" id="valcontacto_id"/>
                    	   <input style="margin-top: 5px;" type="hidden"  id="valllamada_id"/>
                    	   <input style="margin-top: 5px;" type="hidden"  id="valcampana_id"/>
                    	  
                                    <!--control oculto para contorlar expandido del acordion-->
                                   <div style="display:none;">
                                    	<p class="accordion-expand-holder">
									    <a id="accordion-expand-all" href="#">Expand all</a>
									  </p>
                                   </div>
		                            
		                            <div id="valaccordion" class="ui-accordion ui-widget ui-helper-reset">
						                  
						                 <h2 class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span>Datos del contacto</h2>
						                 <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
						                 	<table>
						                 	<tr>
						                 	 <td align="right">Inicio:</td>
										     <td><input id="valdinicio"/> Tiempo: <input id="valdtiempo"/>
										      Número: <input id="valdtelefono"/></td>
											</tr>    
	                    			        <tr>
	                    			          <td align="right">Tipo ID:</td>
		                                      <td colspan="5" align="left"><div id="valcliente_tipo_id"></div></td>
											</tr> 
											<tr>   
											  <td align="right">Cédula:</td>
											  <td colspan="5" align="left"> <input style="margin-top: 1px;" id="valcedula"/>
											  Ruc: <input style="margin-top: 1px;" id="valruc"/></td>
											</tr> 
											<tr>  
											  <td align="right">Contacto:</td>
											  <td colspan="5" align="left"> <input style="margin-top: 2px;" id="valnombres"/>
											  <input style="margin-top: 1px;" id="valapellidos"/></td>
											</tr>
				                           <tr>
											  <td align="right">Razón social:</td>
											  <td colspan="5" align="left"> <input style="margin-top: 1px;" id="valrazonsocial"/></td>
	                               		    </tr>
											<tr>
												<td align="right">Email personal:</td>
												<td colspan="5" align="left"><input style="margin-top: 1px;" id="valemail"/></td>
											</tr>
											<tr>
												<td align="right">Ciudad:</td>
												<td colspan="5" align="left"> <input style="margin-top: 1px;" id="valciudad"/></td>
											</tr>
											<tr>
												<td align="right">Direccion:</td>
												<td colspan="5" align="left"><textarea id="valdireccion"></textarea></td>
											</tr>
												
										  </table>
						                 </div>	
						                 <h2 class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all">  <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span>Encuesta</h2>
						                 <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" id = "valdatosEncuesta"></div>
						                 <h2 class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all">  <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span>Productos de interés</h2>
			                    	     <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
			                    	      Fecha de llamada : <input style="margin-top: 5px;" id="valfechallamada"/>
                    	                  Hora de llamada : <input style="margin-top: 5px;" id="valhorallamada"/>
                    	                  Número: <input style="margin-top: 5px;" id="valtelefonollamada"/>
                    	                  <input style="margin-right: 5px;" type="button" id="valbtnListaProducto" value="Productos" />
			                    	     	<table>
				                    	     	 <tr>
				                    	     	     <td align="left"><div style="padding: 5px; " id="valgridproductos"></div></td>
			                                     </tr> 
			                                     <tr>
			                                    	 <td align="left">Observaciones:</td>
			                                     </tr>
				                    	     	 <tr>
												     <td align="left"><textarea id="valobservacion"></textarea></td>
											     </tr>
											   
										    
		                                     </table>
			                    	     </div>	
						                 
						                 <h2 class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all">  <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span>Agenda de visitas</h2>
						                 <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" id='valcalendar'></div>
						                 						                 
			                    	     
			                    	      <h2 class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all">  <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span>Preaprobación del crédito y confirmación</h2>
			                    	      <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
			                    	      	<table>
											    <tr>
												  <td align="right">Forma de pago:</td>
												  <td colspan="5" align="left"><div style="margin-top: 1px;" id="valfpago"></div></td>
											     </tr>
			                    	     	
				                    	     	<tr>
													<td align="right">Estado de preaprobación:</td>
													<td colspan="3" align="left"> <div style="margin-top: 1px;" id="valpreaestado"></div></td>
												</tr>
												<tr>
												    <td align="right">ID de preaprobación:</td>
													<td align="left"> <input name="viidprea" style="margin-top: 1px;" id="validprea"/></td>
											     	<td align="right">Perfil:</td>
													<td align="left"> <div style="margin-top: 2px;" id="valperfil"/></td>
												</tr>
												<tr>
												    <td align="right">Limite de crédito:</td>
													<td align="left"> <input style="margin-top: 2px;" id="vallimcredito"/></td>
									                <td align="right">Financiamiento:</td>
													<td align="left"><input style="margin-top: 2px;" id="valfinanciamiento"/></td>
			                                     </tr>
			                                     <tr>
			                                        <td align="right">Limite de crédito tarjeta:</td>
													<td align="left"> <input name="vallimcredito_tc" style="margin-top: 2px;" id="vallimcredito_tc"/></td>
									                <td align="right">Financiamiento tarjeta:</td>
													<td align="left"><input name="valfinanciamiento_tc" style="margin-top: 2px;" id="valfinanciamiento_tc"/></td>
                                                 </tr>
			                                     <tr>
			                                	   	 <td align="right">Estado de la cita:</td>
													 <td colspan="5" align="left"><div style="margin-top: 1px;" id="valestadocita"/></td>
												  </tr>
			                                     
			                                    </table>
			                    	      </div>
			                    	      	
			                    	    
                                       
							        </div> 
							
                     </form>
                     
                                <table>
                                	   
							           <tr>
							           	   
										   <td align="right"><input style="margin-right: 5px;" type="button" id="valbtnSave" value="Grabar"/></td>
										   <td align="right"><input id="valbtnCancel" type="button" value="Cancelar" /></td>
										   <td align="right"><input style="margin-right: 5px;" id="valbtnExpandir" type="button" value="Expandir" /></td>
                                		</tr>
		                        </table>
                </div>
           </div>
      </div>
  </div>
       