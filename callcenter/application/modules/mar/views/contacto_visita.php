<style>
#accordion{
	font-size: 12px;
	}
</style>
<script type="text/javascript">
             
       
            function createElementsVisita(tipo) {
             $('#eventWindowVisita').jqxWindow({
            	resizable: false,
                width: '100%',
                Height: '100%',
                //theme: "orange-custom",
                theme:tema,
                //minHeight: 300, 
                isModal: true,
                modalOpacity: 0.01,  
                cancelButton: $("#vibtnCancel"),
                initContent: function () {
                	
            	
			    //$('#jqxTabsVisita').jqxTabs({});
			    /*codigo para expandido automatico del acordion*/			
				var headers = $('#accordion .accordion-header');
				//inicia expandido el acordion
				var contentAreas = $('#accordion .ui-accordion-content ').show();
				var expandLink = $('#accordion-expand-all');
				 
				
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
			    $('#vicontacto_id').jqxInput({theme:tema, disabled: true,width: '100px', height: 20 });
			    $('#villamada_id').jqxInput({theme:tema,disabled: true,width: '100px', height: 20 });
			    $('#vicampana_id').jqxInput({theme:tema,disabled: true,width: '100px', height: 20 });
			    $('#vitipo_cliente_id').jqxInput({theme:tema,disabled: true,width: '100px', height: 20 });
			    $('#vicedula').jqxInput({theme:tema,disabled: true,width: '110px', height: 20 });
			    $('#vitelefono').jqxInput({theme:tema,disabled: true,width: '110px', height: 20 });
			    $('#vinombres').jqxInput({theme:tema,width: '280px', height: 20, placeHolder:'ingrese nombres'});
			    $('#viapellidos').jqxInput({theme:tema,width: '280px', height: 20, placeHolder:'ingrese apellidos'});
			    $("#viruc").jqxInput({theme:tema,width: '150px', height: 20});
			    $("#virazonsocial").jqxInput({theme:tema,width: '570px', height: 20}); 
			   		    
			    $('#viciudad').jqxInput({theme:tema,width: '570px', height: 20 });
			    ciudades($('#viciudad'));
			    $('#vidireccion').jqxInput({theme:tema,width: '570px', height: 50 });
			    $('#viobservacion').jqxInput({theme:tema,width: '660px', height: 40 });
			    $('#vifecha').jqxDateTimeInput({theme: tema, culture: 'es-ES', width: '300px', formatString: 'yyyy-MM-dd' });
                $('#vihoraini').jqxDateTimeInput({theme: tema, culture: 'es-ES', disabled: true, width: '300px', formatString: 'HH:mm', showCalendarButton: false });
                $('#vihorafin').jqxDateTimeInput({theme: tema, culture: 'es-ES', disabled: true, width: '300px', formatString: 'HH:mm', showCalendarButton: false });
                  
			   			    
			   
			     $('#viemail').jqxInput({theme:tema, width: '570px', height: 20 });
			    
			     
			    $('#viidprea').jqxInput({theme:tema, width: '150px', height: 20 });
                //$('#viperfil').jqxInput({theme:tema, width: '150px', height: 20 });
                $('#vilimcredito').jqxInput({theme:tema, width: '150px', height: 20 });
                $('#vifinanciamiento').jqxInput({theme:tema, width: '150px', height: 20 });
                $('#vilimcredito_tc').jqxInput({theme:tema, width: '150px', height: 20 });
                $('#vifinanciamiento_tc').jqxInput({theme:tema, width: '150px', height: 20 });
                
                
			    
			    
			    $('#vibtnListaProducto').jqxButton({theme:tema, width: '70px' });
			    $('#vibtnSave').jqxButton({theme:tema, width: '65px' });
   		        $('#vibtnCancel').jqxButton({theme:tema, width: '65px' });
   		        $('#vibtnExpandir').jqxButton({theme:tema, width: '65px' });
   		        
   		        $("#vibtnListaProducto").click(function () {	
   		             //var item = $("#producto_id").jqxDropDownList('getSelectedItem'); 
   		        	 //addItem({ price: 0, name: item.label, producto_id: item.value });
   		        	 campid=$('#didcampana').val();	
   		             clieid= $('#cliente_tipo_id').val();	
   		             abrirListaProductos('contacto_visita',campid,clieid);
   		        	 
   		          });  
   		       
   		         $("#vibtnSave").click(function () {	
   		         	  mensaje=''  		         	
   		              if (validaForm()){
   		              	
   		              	  SaveCita();
						   
   		        	   }else{
   		        	   	jqxAlert.alert(mensaje,'Validación');
   		        	   }
   		          });
   		          
   		           $("#vibtnCancel").click(function () {
   		             encuestaItems.length=0;	
   		          
   		          });  
   		          
   		           $("#vibtnExpandir").click(function () {	
   		             var contentAreas = $('#accordion .ui-accordion-content ').show();
   		          });         		          	
   		            				
               }
            });
            $('#eventWindowVisita').jqxWindow('focus');
            $('#eventWindowVisita').jqxValidator('hide');
            $('#eventWindowVisita').on('close', function (event) {
            	 encuestaItems.length=0;	
			    
			});
			
			
			
        }
        
        
       
       
        encuestaItems = [];
        function actualiza_encuestaItems(contacto_id,campana_id,contacto_campana_id){
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
						encuestaItems.length=0;	 
						for(i=0;i<data.length;i++){
							 id_pregunta = data[i]['id'];
							 multi = data[i]['multiple_respuesta'];
							 var opciones = data[i]['opciones'];
							 if (opciones==''){
								var resp=$("#resp_i"+id_pregunta).val();	
								var respuesta = {
									resp: resp,
									contacto: contacto_id,
									preg: id_pregunta,
									multi: multi
								};
								encuestaItems.push(respuesta);
								
							 }
								 
								 for(j=0;j<opciones.length;j++){
									if (document.getElementById("ri_"+opciones[j]['detalle']+"").checked==true){
										var resp = document.getElementById("ri_"+opciones[j]['detalle']+"").value;
										var respuesta = {
											resp: resp,
											contacto: contacto_id,
											preg: id_pregunta,
											multi: multi
										};
										encuestaItems.push(respuesta);
									
									}	
																									 
								 }
						}
					}
					});
					//dataAdapterPreg.dataBind();	
			
          }
          
        
        function campana_formapago(camp_id, tabla_id) {
        	
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
               $('#vifpago').jqxDropDownList({theme:tema,
               	                          /*selectedIndex: 0, autoDropDownHeight: true,*/ promptText: "Forma de pago:", 
                                          source: formasPago, displayMember: "descripcion", valueMember: "id", 
                                          width: 300, height: 22}); 
			   
            }
            
            function visita_horario() {
            	$('#vihoraini').val('');
            	$('#vihorafin').val('');
            	var datos = {accion: 'dataHC'};//Horarios de cita
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
									         
              
                $('#vihorario').jqxDropDownList({theme:tema,
               	                          /*selectedIndex: 0, autoDropDownHeight: true,*/ promptText: "Horario de visita:", 
                                          source: dataAdapter, displayMember: "descripcion", valueMember: "id", 
                                          width: 300, height: 22}); 
                                          
               
            }
            
            function visita_perfil() {
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
						            
		        $('#viperfil').jqxDropDownList({theme:tema,
               	                          /*selectedIndex: 0, autoDropDownHeight: true,*/ promptText: "Perfil de aprobación:", 
                                          source: dataAdapter, displayMember: "descripcion", valueMember: "descripcion", 
                                          width: 200, height: 22}); 
									         
               
              
                                          
               
            }
            
          
		 //var preapestados;
		 //[{value:"01", label: "Aprobado"}, {value:"02", label:"Solo califica prepago"}, {value:"03", label:"Necesita revisión manual"}];
		 function campana_preaprobacion(camp_id, tabla_id) {
		 	  
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
               $('#vipreaestado').jqxDropDownList({ theme:tema, /*selectedIndex: 0, autoDropDownHeight: true,*/ 
               	                                promptText: "Estados de preaprobación:",
               	                                source: preapestados, displayMember: "descripcion", valueMember: "id",
                                                width: 300, height: 22});
               
            }    
        
         
        	
      
             
         function habilitaTipoCliente(tipo){
         	if (tipo==2){//cliente con ruc
			    $("#viruc").jqxInput({disabled: false});
			    $("#virazonsocial").jqxInput({disabled: false}); 	
			    }else if (tipo==1){//cliente sin ruc
			    $("#viruc").jqxInput({disabled: true});
			    $("#virazonsocial").jqxInput({disabled: true}); 	
			    }
			
			 //codigo para validacion de entradas
	            $('#eventWindowVisita').jqxValidator({
	             	hintType: 'label',
	                animationDuration: 'fade',
	                rules:  reglasVisita(tipo) 
	            });	
         }
         
         
         function reglasVisita(tipo){
         	if (tipo==2){//cliente con ruc
         		return reglasconRuc;
         	}else if (tipo==1){//cliente sin ruc
         	 return reglassinRuc;
         	}
         } 
          var mensaje;
          var reglassinRuc=[
	                { input: '#vicedula', message: 'Cédula debe tener 10 caracteres!', action: 'keyup, blur', rule: 'length=10,10' },
					{ input: '#vinombres', message: 'Nombres es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(0);
							 mensaje='Nombres son requeridos!';	
							 return false;
							 }
							return true;
							
							} },
					{ input: '#viapellidos', message: 'Apellidos es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(0);	
							 mensaje='Apellidos son requeridos!';
							 return false;
							 }
							return true;
							
							} },
	               /*{ input: '#viobservacion', message: 'Observación es requerida!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(1);	
							 return false;
							 }
							return true;
							
							}},*/

	                { input: '#viciudad', message: 'Ciudad es requerida!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							//setSeccion(0);
							 mensaje='Ciudad es requerida!';	
							 return false;
							 }
							return true;
							
							}  },
					{ input: '#vidireccion', message: 'Direccion es requerida!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(0);
							  mensaje='Direccion es requerida!';
							  return false;
							 }
							return true;
							
							} },
					{ input: '#vifecha', message: 'fecha de cita es requerida!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							//setSeccion(0);	
							 mensaje='fecha de cita es requerida!';
							 return false;
							 }
							return true;
							
							}  },
					{ input: '#vihoraini', message: 'hora de inicio de cita es requerida!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							//setSeccion(0);
							 mensaje='hora de inicio de cita es requerida!';	
							 return false;
							 }
							return true;
							
							}  },
					{ input: '#vihorafin', message: 'hora de finalización de cita es requerida!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							//setSeccion(0);	
							 mensaje='hora de finalización de cita es requerida!';
							 return false;
							 }
							return true;
							
							}  },			
	                /*
	                { input: '#viemail', message: 'email es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(0);	
							 return false;
							 }
							return true;
							
							}  },
	                { input: '#viemail', message: 'e-mail invalido!', action: 'keyup', rule: 'email' },
	                */
	               { input: '#vihorario', message: 'Horario de visita es requerido!', action: 'keyup, blur, select', rule: function (input) {
                           	if(input.val()==""){
							 //setSeccion(3);
							 mensaje='Horario de visita es requerido!'; 	
							 return false;
							 }
							return true;
							}
					}, 
	                { input: '#vifpago', message: 'Forma de pago es requerida!', action: 'keyup, blur, select', rule: function (input) {
                           	if(input.val()==""){
							  	//setSeccion(3);
							 mensaje='Forma de pago es requerida!'; 	
							 return false;
							 }
							return true;
							} 
					},
					{ input: '#vipreaestado', message: 'Estado de preaprobación es requerido!', action: 'keyup, blur, select', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(3);
							 mensaje='Estado de preaprobación es requerido!'; 	
							 return false;
							 }
							return true;
							
							}
					},
					{ input: '#viidprea', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#viidprea', message: 'ID de aprobación es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(3);
							 mensaje='ID de aprobación es requerido!'; 	
							 return false;
							 }
							return true;
							
							} },
	                { input: '#viperfil', message: 'Perfil de aprobación es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(3);
							 mensaje='Perfil de aprobación es requerido!'; 		
							 return false;
							 }
							return true;
							
							} },
					{ input: '#vilimcredito', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#vilimcredito', message: 'Limite de credito es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(3);
							 mensaje='Limite de credito es requerido!';	
							 return false;
							 }
							return true;
							
							} },
					{ input: '#vifinanciamiento', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#vifinanciamiento', message: 'Financiamiento es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(3);	
							  mensaje='Financiamiento es requerido!';	
							 return false;
							 }
							return true;
							
							} },
					{ input: '#vilimcredito_tc', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#vilimcredito_tc', message: 'Limite de credito de tarjeta es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(3);
							 mensaje='Limite de credito de tarjeta es requerido!';	
							 return false;
							 }
							return true;
							
							} },
					{ input: '#vifinanciamiento_tc', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#vifinanciamiento_tc', message: 'Financiamiento de tarjeta es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(3);	
							  mensaje='Financiamiento de tarjeta es requerido!';	
							 return false;
							 }
							return true;
							
							} }
	              
	                ]   
          var reglasconRuc=[
	                { input: '#vicedula', message: 'Cédula debe tener 10 caracteres!', action: 'keyup, blur', rule: 'length=10,10' },
					{ input: '#vinombres', message: 'Nombres es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(0);
							 mensaje='Nombres son requerido!';		
							 return false;
							 }
							return true;
							
							} },
					{ input: '#viapellidos', message: 'Apellidos es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(0);	
							 mensaje='Apellidos son requerido!';	
							 return false;
							 }
							return true;
							
							} },
	                { input: '#viruc', message: 'RUC es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(0);
							 mensaje='RUC es requerido!';		
							 return false;
							 }
							return true;
							
							} },
	                { input: '#viruc', message: 'RUC incorrecto!', action: 'keyup, blur', rule: function (input) {
            				if(!ValidaRuc()){
            				 //setSeccion(0);
            				 mensaje='RUC incorrecto!';		
							 return false;
							 }
							return true;
							}
					},
	                { input: '#viruc', message: 'RUC debe tener 13 caracteres!', action: 'keyup, blur', rule: 'length=13,13' },
	                { input: '#virazonsocial', message: 'Razón social es requerida!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(0);
							 mensaje='Razón social es requerida!';	
							 return false;
							 }
							return true;
							
							}  },
	                { input: '#virazonsocial', message: 'Razón social debe contener solo letras!', action: 'keyup', rule: 'notNumber' },
	                { input: '#virazonsocial', message: 'Razón social debe contener de 3 a 100 caracteres!', action: 'keyup', rule: 'length=3,100' },
	                /*{ input: '#viobservacion', message: 'Observación es requerida!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(1);	
							 return false;
							 }
							return true;
							
							}},*/
	                //{ input: '#nombrecomercial', message: 'Razón social debe contener solo letras!', action: 'keyup', rule: 'notNumber' },
	                //{ input: '#nombrecomercial', message: 'Razón social debe contener de 3 a 40 caracteres!', action: 'keyup', rule: 'length=3,40' },
	                { input: '#viciudad', message: 'Ciudad es requerida!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(0);	
							 mensaje='Ciudad es requerida!';
							 return false;
							 }
							return true;
							
							}  },
					{ input: '#vidireccion', message: 'Direccion es requerida!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(0);
							 mensaje='Direccion es requerida!';	
							 return false;
							 }
							return true;
							
							} },
					{ input: '#vifecha', message: 'fecha de cita es requerida!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							//setSeccion(0);
							 mensaje='fecha de cita es requerida!';	
							 return false;
							 }
							return true;
							
							}  },
					{ input: '#vihoraini', message: 'hora de inicio de cita es requerida!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							//setSeccion(0);
							 mensaje='hora de inicio de cita es requerida!';	
							 return false;
							 }
							return true;
							
							}  },
					{ input: '#vihorafin', message: 'hora de finalización de cita es requerida!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							//setSeccion(0);
							 mensaje='hora de finalización de cita es requerida!';	
							 return false;
							 }
							return true;
							
							}  },			
					/*		
	                { input: '#viemail', message: 'email es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(0);	
							 return false;
							 }
							return true;
							
							}  },
	                { input: '#viemail', message: 'e-mail invalido!', action: 'keyup', rule: 'email' },
	                */
	               { input: '#vihorario', message: 'Horario de visita es requerido!', action: 'keyup, blur, select', rule: function (input) {
                           	if(input.val()==""){
							  	//setSeccion(3);
							 mensaje='Horario de visita es requerido!';  	
							 return false;
							 }
							return true;
							}
					}, 
	                { input: '#vifpago', message: 'Forma de pago es requerida!', action: 'keyup, blur, select', rule: function (input) {
                           	if(input.val()==""){
							  	//setSeccion(3);
							 mensaje='Forma de pago es requerida!';
							 return false;
							 }
							return true;
							} 
					},
					{ input: '#vipreaestado', message: 'Estado de preaprobación es requerido!', action: 'keyup, blur, select', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(3);
							 mensaje='Estado de preaprobación es requerida!';	
							 return false;
							 }
							return true;
							
							}
					},
					{ input: '#viidprea', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#viidprea', message: 'ID de aprobación es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(3);
							 mensaje='ID de aprobación es requerido!';		
							 return false;
							 }
							return true;
							
							} },
	                { input: '#viperfil', message: 'Perfil de aprobación es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(3);
							 mensaje='Perfil de aprobación es requerido!';		
							 return false;
							 }
							return true;
							
							} },
				    { input: '#vilimcredito', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#vilimcredito', message: 'Limite de credito es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(3);	
							 mensaje='Limite de credito es requerido!';
							 return false;
							 }
							return true;
							
							} },
					{ input: '#vifinanciamiento', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#vifinanciamiento', message: 'Financiamiento es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(3);
							 mensaje='Financiamiento es requerido!';	
							 return false;
							 }
							return true;
							
							} },
					{ input: '#vilimcredito_tc', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#vilimcredito_tc', message: 'Limite de credito de tarjeta es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(3);
							 mensaje='Limite de credito de tarjeta es requerido!';	
							 return false;
							 }
							return true;
							
							} },
					{ input: '#vifinanciamiento_tc', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#vifinanciamiento_tc', message: 'Financiamiento de tarjeta es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setSeccion(3);	
							  mensaje='Financiamiento de tarjeta es requerido!';	
							 return false;
							 }
							return true;
							
							} }
	              
	                ]   
		       
		 /* function setSeccion(h){
			    	$( "#accordion" ).accordion( "option", "active", h );
			    }  
           */ 
          function ValidaRuc(){
           var rvalida=true;
           if (!validaDoc($("#viruc").val())){
          	  rvalida=false;
           }
           	return rvalida;
          }
          
          function ValidaProductos(){
            var pvalida=true;
          	var rows = $('#vigridproductos').jqxGrid('getrows');
           	if (!rows.length>0){
          		pvalida=false;
          	}
          	return pvalida;
          }
          
           function ValidaAgenda(){
           	var avalida=true;
           
           	return avalida;
           }
           
           function validaCita(){
           	    var cvalida =$('#eventWindowVisita').jqxValidator('validate')
           	    if (!cvalida){
           		 cvalida=false;	
           		}
           		return cvalida;	
           }
           
        function recuperaDatosGestionados(){
        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                  if (selectedrowindex >= 0) {
                       var offset = $("#jqxgrid").offset();
	                   // get the clicked row's data and initialize the input fields.
	                   dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex);
	                   $('#cliente_tipo_id').val(dataRecord.tipo_cliente_id);
                       $('#vifpago').val(dataRecord.forma_pago);
		               $('#vipreaestado').val(dataRecord.estado_preaprobacion);
			           $('#viidprea').val(dataRecord.codigo_preaprobacion);
			           $('#viperfil').val(dataRecord.perfil);
			           $('#vilimcredito').val(dataRecord.limite_credito);
			           $('#vifinanciamiento').val(dataRecord.financiamiento);
			           $('#vilimcredito_tc').val(dataRecord.limite_credito_tc);
			           $('#vifinanciamiento_tc').val(dataRecord.financiamiento_tc);
			           $('#viobservacion').val(dataRecord.observacion);
			      }
      }
           
           function setEncuesta(){
           	/*Actualiza el arreglo con informacion de la encuesta que se va enviarl al controlador*/
           	var contacto_campana_id=$("#vidcontactocampana").jqxInput('val');
           	var contacto_id=$('#didcontacto').jqxInput('val');
   		    var campana_id=$('#didcampana').jqxInput('val');
   		    //armo el arreglo con informacion de encuesta del formulario
   		    
   		    actualiza_encuestaItems(contacto_id,campana_id,contacto_campana_id);
   		    
           }
           
           function validaForm(){
           	var fvalida=true;
          
            setEncuesta();
              	
            if (!validaCita()){
                	fvalida=false;
                	//jqxAlert.alert('Ingrese datos de la cita');
             }else if (!ValidaProductos()){
           		   fvalida=false;
           		   //setSeccion(1);
           		  jqxAlert.alert('Ingrese productos');
             }else if (!ValidaAgenda()){
                 fvalida=false;
                   //setSeccion(2);
                  jqxAlert.alert('Ingrese agenda');	
              }
                        
              if (fvalida) return true; else return false;
           	}
          
        
        
        function gridProductos(data) {
        	    var source={
        	   	localdata: data,
        	   	datatype: "array",
        	   	datafields:
        	   	[
        	   	{name: 'producto_id',type: 'number'},
        	   	{name: 'producto',type:'string'},
        	   	{name: 'cantidad',type:'number'},
        	    {name: 'price',type:'number'},
        	    {name: 'index',type:'number'},
        	    {name: 'remove'}
        	     ]
        	   }
        	   var dataAdapter=new $.jqx.dataAdapter(source);
                $("#vigridproductos").jqxGrid(
                {
                    height: 150,
                    width: 650,
                    source: dataAdapter,
                    keyboardnavigation: false,
                    selectionmode: 'none',
                    theme: tema,
                    columns: [
                      { text: 'Producto_id', dataField: 'producto_id', width: 4, hidden:true },
                      { text: 'Item', dataField: 'producto', width: 560 },
                      { text: 'Cantidad', dataField: 'cantidad', width: 80 },
                      { text: 'Borrar', dataField: 'remove', width: 60 }
                    ]
                });
                 $("#vigridproductos").bind('cellclick', function (event) {
                    var index = event.args.rowindex;
                    if (event.args.datafield == 'remove') {
                        var item = cartItems[index];
                        if (item.cantidad > 1) {
                            item.cantidad -= 1;
                            updateGridRow(index, item);
                            $("#vigridproductos").jqxGrid('updaterow', index, item);
                        }
                        else {
                            cartItems.splice(index, 1);
                            removeGridRow(index);
                            $("#vigridproductos").jqxGrid('deleterow', index);
                        }
                       
                    }
                   
                });
              
            };
            
        
            
        
            
        function contacto(cont_id){
        $("#videscontacto").empty();
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
						                	    $('#vicontacto_id').val(cont_id);
						                	    $('#vicedula').val(data.identificacion);
						                	    $('#vitelefono').val($("#vmovil").val());
						                	    $('#vinombres').val(data.nombres);
						                	    $('#viapellidos').val(data.apellidos);
						                	    $('#viciudad').val(data.ciudad);
						                	    $('#vidireccion').val(data.direccion);
						                	     var container;
						                	     container = 'GESTIÓN DE CITA A: '+ data.apellidos+' '+data.nombres;
						                	      $('#videscontacto').append(container);
						       
						                },
						           });
									         
               
             dataAdapter.dataBind();
	   }
	   
	   
	   function cmail(cont_id){
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
						                	    $('#viemail').val(data.valor);
						                 },
						           });
									         
               dataAdapter.dataBind();
	   }
	   
	   function empresa(cont_id){
		var url = "<?php echo site_url("mar/contactos/empresa"); ?>"+"/"+cont_id;
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
						                	    $('#viruc').val(data.ruc);
						                	    $('#virazonsocial').val(data.razon_social);
						                 },
						           });
									         
               dataAdapter.dataBind();
	   }
	   
	 
         
          
	  
       
                
         function SaveCita(){
         	    var tipo_gestion=$("#vtipogestion").val();
         	    var padre_id=$('#vpadreid').val();
         	    var contacto_campana_id= $("#vidcontactocampana").val();
	     	    var contacto_id=$('#didcontacto').jqxInput('val');
   		        var campana_id=$('#didcampana').jqxInput('val');
   		        var telefono=$('#dtelefono').jqxInput('val');
   		        var llamada_padre_id=$('#didllamada').jqxInput('val');
   		        var inicio=$('#dinicio').jqxInput('val');
   		        var proceso=$('#vproceso').val();
   		        var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
				var empleado_id = iemp.value;
	     		var oper='addcita';
            	var url = "<?php echo site_url("mar/contactos/ajax"); ?>"; 
            	
            	var title='Visita a: ' + $("#viapellidos").val()+' ' +$("#vinombres").val();
            	var fec = $('#vifecha').val();
			    var hori = $('#vihoraini').val();
			    var horf = $('#vihorafin').val();
			    var fec_hori=fec + ' ' + hori;
			    var fec_horf=fec + ' ' + horf;
			    var agendaItem = [];
                var eventData = {
				      	         title: title,
								 start: moment(fec_hori).format('YYYY-MM-DD HH:mm:ss'),
								 end: moment(fec_horf).format('YYYY-MM-DD HH:mm:ss')
								};
								agendaItem.push(eventData);
			                	
			                  
            	
            	var cita = {
            		    //datos de cita  
                        accion: oper,
                        tipo_gestion: tipo_gestion,
                        contacto_campana_id: contacto_campana_id,
                        contacto_id: $("#vicontacto_id").val(),
                        empleado_id: empleado_id,
                        tipo_cliente_id: $("#vitipo_cliente_id").val(),
                        nombres: $("#vinombres").val(),
                        apellidos: $("#viapellidos").val(),
                        ciudad: $("#viciudad").val(),
                        direccion: $("#vidireccion").val(),
                        mail: $("#viemail").val(),
                        ruc: $("#viruc").val(),
			            razon_social: $("#virazonsocial").val(),
                        llamada_id: $("#villamada_id").val(),
                        campana_id: $("#vicampana_id").val(),
                        observacion:$("#viobservacion").val(),
                        forma_pago:$("#vifpago").val(),
                        estado_preaprobacion:$("#vipreaestado").val(),
                        codigo_preaprobacion:$("#viidprea").val(),
                        perfil:$("#viperfil").val(),
                        limite_credito:$("#vilimcredito").val(),
                        financiamiento:$("#vifinanciamiento").val(),
                        limite_credito_tc:$("#vilimcredito_tc").val(),
                        financiamiento_tc:$("#vifinanciamiento_tc").val(),
						productos: $("#vigridproductos").jqxGrid('getrows'),
						//fecha_hora: moment(fec_hori).format('YYYY-MM-DD HH:mm:ss'),
						agenda: agendaItem,
						cita_estado:'Nueva',
						padre_id:padre_id,
						//datos de llamada
						telefono:telefono,
   		                llamada_padre_id:llamada_padre_id,
   		                inicio:inicio,
						llamada_estado: 'Finalizada',
		                proceso:proceso,
		                respuesta: 'Seguimiento insitu',
		                //datos de encuesta
		                encuesta: encuestaItems,
						
						
                    };		
                    
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: cita,
                        success: function (data) {
							if(data=true){
								
                                $("#eventWindowVisita").jqxWindow('hide');
		                        $('#eventWindowDialogo').jqxWindow('hide');
		                        $("#gtelefonosGrid").jqxGrid('updatebounddata'); 
		                        $('#eventWindowVisualizar').jqxWindow('hide'); 
		                        $("#jqxgrid").jqxGrid('updatebounddata');
		                        
                            }else{
                                
                                jqxAlert.alert ('Problemas al guardar.');
                            }
                        },
                        error: function (msg) {
                            alert(msg.responseText);
                            //alert('Error');
                        }
                    });	
					//actualiza_encuesta(contacto_id,campana_id); 
            }
                
          
    function finalizarSegInsitu(contacto_id,empleado_id,campana_id,telefono,padre_id,inicio,proceso){
	     	       var url = "<?php echo site_url("mar/contactos/ajax"); ?>";
	     	       var oper='addllamada';
				      var llamada = {  
		                        accion: oper,
		                        padre_id: padre_id,
		                        contacto_campana_id: $("#vidcontactocampana").val(),
		                        contacto_id: contacto_id,
		                        empleado_id: empleado_id,
		                        campana_id: campana_id,
								telefono: telefono,
								inicio: inicio,
								fin: moment().format('YYYY-MM-DD HH:mm:ss'),
		                		llamada_estado: 'Finalizada',
		                		proceso:proceso,
		                		respuesta: 'Seguimiento insitu',
								
						    };	
						   	$.ajax({
		                        type: "POST",
		                        url: url,
		                        data: llamada,
		                        success: function (data) {
		                         	                          
		                           //var llamada_id=data;                   					          
		                           if(data=true){
		                           	       
		                           		    $("#eventWindowVisita").jqxWindow('hide');
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
             
     
          function preguntas_datos_act(campana_id,contacto_id,contacto_campana_id){
			$("#vidatos_encuesta").empty(); 
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
							   $('#vidatos_encuesta').append("<table>");
								for(i=0;i<data.length;i++){
								 id_pregunta = data[i]['id'];
								 pregunta = data[i]['detalle_pregunta'];
								 orden = data[i]['orden'];
								 var tipo_respuesta = data[i]['tipo_respuesta_id'];
								 var opciones = data[i]['opciones'];
								 if (opciones==''){
								 	$('#vidatos_encuesta').append("<tr><td>"+orden+".- </td><td>"+data[i]['detalle_pregunta']+"</td><tr></tr><td colspan='2'><input id='resp_i"+id_pregunta+"' value='"+data[i]['respuesta_texto']+"'/><td></tr>");
								 }else{
								 	$('#vidatos_encuesta').append("<tr><td>"+orden+".- </td><td>"+data[i]['detalle_pregunta']+"</td></tr>");
								 }
								 
								 for(j=0;j<opciones.length;j++){
									
								 	if (opciones[j]['respuesta']==opciones[j]['detalle']){var check='checked';}else{var check='';}
										//alert(opciones[j]['respuesta']);
									 $('#vidatos_encuesta').append("<tr><td colspan=2><input type='"+opciones[j]['objeto']+"' id='ri_"+opciones[j]['detalle']+"' name='"+id_pregunta+"'  value = '"+opciones[j]['detalle']+"' "+check+">"+opciones[j]['detalle']+"</td></tr>");
									
									 }
								}
								
								$('#vidatos_encuesta').append("</table>");
						},
						
					});
									         
               //return dataAdapter;
             //dataAdapterPreg.dataBind();
			 
			 	 
		} 
		
  
                
    </script>	


<div style="visibility: hidden; display:none;" id="jqxWidgetVisita">	
	 <div>		
		<div style="display:none;" id="eventWindowVisita">
            <div id="videscontacto">Visita insitu</div>
          
                <div>
                    <form id="frmVisita" method="post">
                    	   <input name="vicontacto_id" style="margin-top: 5px;" type="hidden" id="vicontacto_id"/>
                    	   <input name="villamada_id" style="margin-top: 5px;" type="hidden" id="villamada_id"/>
                    	   <input name="vicampana_id" style="margin-top: 5px;" type="hidden" id="vicampana_id"/>
                    	   <input name="vicampana_id" style="margin-top: 5px;" type="hidden" id="vitipo_cliente_id"/>
                                   <!--control oculto para contorlar expandido del acordion-->
                                   <div style="display:none;">
                                    	<p class="accordion-expand-holder">
									    <a id="accordion-expand-all" href="#">Expand all</a>
									  </p>
                                   </div>
		                            
		                            <div id='accordion' class="ui-accordion ui-widget ui-helper-reset">
						                  
						                 <h2 class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all">  <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span>Datos del contacto</h2>
						                 <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
						                 	<table>    
	                    			        <tr>
											  <td align="right">Cédula:</td>
											  <td colspan="5" align="left"> 
											  	 <input name="vicedula" style="margin-top: 1px;" id="vicedula"/>
											     Móvil:<input name="vitelefono" style="margin-top: 1px;" id="vitelefono"/>
											  </td>
											</tr>
											<tr>  
											  <td align="right">Contacto:</td>
											  <td colspan="5" align="left"> <input name="vinombres" style="margin-top: 2px;" id="vinombres"/>
											  <input name="viapellidos" style="margin-top: 1px;" id="viapellidos"/></td>
											 
										    </tr>
				                            <tr>
											  <td align="right">Ruc:</td>
											  <td colspan="5" align="left"> <input name="viruc" style="margin-top: 1px;" id="viruc"/></td>
											</tr> 
											<tr>
											  <td align="right">Razón social:</td>
											  <td colspan="5" align="left"> <input name="virazonsocial" style="margin-top: 1px;" id="virazonsocial"/></td>
	                               		    </tr>
											
											<tr>
												<td align="right">Email personal:</td>
												<td colspan="5" align="left"><input name="viemail" style="margin-top: 1px;" id="viemail"/></td>
											</tr>
											<tr>
												<td align="right">Ciudad:</td>
												<td colspan="5" align="left"> <input name="viciudad" style="margin-top: 1px;" id="viciudad"/></td>
											</tr>
											<tr>
												<td align="right">Direccion:</td>
												<td colspan="5" align="left"><textarea id="vidireccion"></textarea></td>
											</tr>
												
										  </table>
						                 </div>	
						                  <h2 class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span>Encuesta</h2>
			                    	      <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
										    <div style='margin-left: 8px; margin-top: 10px;' id="vidatos_encuesta"></div>
										  </div>
						                 <h2 class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span>Productos de interés</h2>
			                    	     <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
			                    	     	<input style="margin-right: 5px;" type="button" id="vibtnListaProducto" value="Productos" />
			                    	     	<table>
				                    	     	 <tr>
				                    	     	    <td align="left"><div style="padding: 5px; " id="vigridproductos"></div></td>
			                                     </tr> 
			                                     <tr>
			                                    	 <td align="left">Observaciones:</td>
			                                     </tr>
				                    	     	 <tr>
												 
												  <td align="left"><textarea id="viobservacion"></textarea></td>
											     </tr>
											   
										    
		                                     </table>
			                    	     </div>	
						                 
						                 <h2 class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span>Agenda</h2>
						                  <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
							                 <table>
							                   <tr> 
											    <td style="width:15%">Fecha:</td>
											    <td><div id="vifecha"></td>
											    <td align="right">Horario:</td>
											    <td colspan="5" align="left"><div name="vihorario" style="margin-top: 1px;" id="vihorario"></div></td>
											   </tr>
											  
											   <tr> 
											    <td style="width:15%">Inicio:</td>
											    <td><div id="vihoraini"></td>
											    <td style="width:15%">Fin:</td>
											    <td><div id="vihorafin"></td>
											   </tr>						                 
				                    	      </table>
				                    	    </div>
			                    	      <h2 class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span>Preaprobación del crédito</h2>
			                    	      <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
			                    	      	<table>
											    <tr>
												  <td align="right">Forma de pago:</td>
												  <td colspan="5" align="left"><div name="vifpago" style="margin-top: 1px;" id="vifpago"></div></td>
									  	        </tr>
			                    		     	<tr>
													<td align="right">Estado de preaprobación:</td>
													<td colspan="3" align="left"> <div name="vipreaestado" style="margin-top: 1px;" id="vipreaestado"></div></td>
												</tr>
											    <tr> 
											    	<td align="right">ID de preaprobación:</td>
													<td align="left"> <input name="viidprea" style="margin-top: 1px;" id="viidprea"/></td>
											        <td align="right">Perfil:</td>
													<td align="left"> <div name="viperfil" style="margin-top: 2px;" id="viperfil"/></td>
												 </tr>
			                                     <tr>
			                                        <td align="right">Limite de crédito banco:</td>
													<td align="left"> <input name="vilimcredito" style="margin-top: 2px;" id="vilimcredito"/></td>
									                <td align="right">Financiamiento banco:</td>
													<td align="left"><input name="vifinanciamiento" style="margin-top: 2px;" id="vifinanciamiento"/></td>
                                                 </tr>
			                                     <tr>
			                                        <td align="right">Limite de crédito tarjeta:</td>
													<td align="left"> <input name="vilimcredito_tc" style="margin-top: 2px;" id="vilimcredito_tc"/></td>
									                <td align="right">Financiamiento tarjeta:</td>
													<td align="left"><input name="vifinanciamiento_tc" style="margin-top: 2px;" id="vifinanciamiento_tc"/></td>

			                                     </tr>
			                                    </table>
			                    	      </div>	
			                    	    
                                       
							        </div> 
							
                     </form>
                     
                                <table>
							           <tr>
										   <td align="right"> </td>
										   <td colspan="5" style="padding-top: 10px;" align="right"><input style="margin-right: 5px;" type="button" id="vibtnSave" value="Grabar" /><input style="margin-right: 5px;" id="vibtnCancel" type="button" value="Cancelar" /><input style="margin-right: 5px;" id="vibtnExpandir" type="button" value="Expandir" /></td>
                                		</tr>
		                        </table>
		                        
                            
                </div>
            </div>
      </div>
  </div>   
   