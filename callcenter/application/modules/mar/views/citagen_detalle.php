<meta charset='utf-8' />
<style>
#genaccordion{
	font-size: 12px;
	}
#gencalendar {
		max-width: 750px;
		margin: 0 auto;
	}
/*	
#valbtnConsAgendaVendedor{
		font-size: 12px;
}*/
td {
	style="font-size: 12px;"
}
</style>

<script type="text/javascript">

function genabrirDialogo(contacto_id,campana_id,contacto_campana_id){
	          genlista_tipo_cliente();  
              //opvalidar(); 
              openfrmGenCita();
              //$('#didllamada').val(llamada_id);
              //$('#dinicio').val(inicio);
              //$('#dtelefono').val(telefono);
			  $('#gendidcampana').val(campana_id);
			  $('#gendidcontacto').val(contacto_id);
			  $('#gendidcontactocampana').val(contacto_campana_id);
			  eventoGesTipoCliente();
              
  }
  
function openfrmGenCita(){
         
        	         var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                       
                        if (selectedrowindex >= 0 ) {
                           
                            var offset = $("#jqxgrid").offset();
                            // get the clicked row's data and initialize the input fields.
	                        var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex );
	                        document.getElementById("frmGesCita").reset();
	                        // show the popup window.
	                        createElementsGesCita();
	                        gencampana_formapago(dataRecord.campana_id, 1);
			                gencampana_preaprobacion(dataRecord.campana_id, 2);
			                gen_perfil();
	                        $('#gescita_id').val(dataRecord.id);
	                        $('#gestipogestion').val(dataRecord.tipo_gestion);
							$("#gencliente_tipo_id").val(dataRecord.tipo_cliente_id);
			                $('#gesllamada_id').val(dataRecord.llamada_id);
			                $('#gescampana_id').val(dataRecord.campana_id);
			                $('#genfpago').val(dataRecord.forma_pago);
			                $('#genpreaestado').val(dataRecord.estado_preaprobacion);
			                $('#genidprea').val(dataRecord.codigo_preaprobacion);
			                $('#genperfil').val(dataRecord.perfil);
			                $('#genlimcredito').val(dataRecord.limite_credito);
			                $('#genfinanciamiento').val(dataRecord.financiamiento);
			                $('#genlimcredito_tc').val(dataRecord.limite_credito);
			                $('#genfinanciamiento_tc').val(dataRecord.financiamiento);
			                $('#genobservacion').val(dataRecord.observacion);
			                genhabilitaTipoCliente(dataRecord.tipo_cliente_id);
			                genllamada(dataRecord.llamada_id);
							gencontacto(dataRecord.contacto_id);
			                genempresa(dataRecord.empresa_id);
			                gencmail(dataRecord.contacto_id);
			                GengridProductos(dataRecord.id); 
			                genagenda(dataRecord.id);
			                $("#eventWindowGesCita").jqxWindow('open');
							$('#gencalendar').fullCalendar('render'); 	
							
	                        }else{
	                        	jqxAlert.alert('Seleccione un registro','Gestión');
	                        }
        	
		}  

function createElementsGesCita() {
	
               $('#eventWindowGesCita').jqxWindow({
            	resizable: false,
                width: '100%',
                Height: '100%',
                theme:tema,
                //minHeight: 300, 
                isModal: true,
                modalOpacity: 0.01,  
                cancelButton: $("#genbtnCancel"),
                initContent: function () {
                	
               	var headers = $('#genaccordion .accordion-header');
				//inicia expandido el acordion
				var contentAreas = $('#genaccordion .ui-accordion-content ').show();
				var expandLink = $('#genaccordion-expand-all');
				
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
            	
            	$('#gescita_id').jqxInput({theme:tema, disabled: true,width: '100px', height: 20 });
            	$('#gestipogestion').jqxInput({theme:tema, disabled: true,width: '100px', height: 20 });
            	$('#gescontacto_id').jqxInput({theme:tema, disabled: true,width: '100px', height: 20 });
			    $('#gesllamada_id').jqxInput({theme:tema,disabled: true,width: '100px', height: 20 });
			    $('#gescampana_id').jqxInput({theme:tema,disabled: true,width: '100px', height: 20 });
			    //$("#dtelefono").jqxInput({theme: tema, disabled: true, width: '150px'});
			    //$("#dinicio").jqxInput({theme: tema, disabled: true, width: '150px'});
			    //$("#dtiempo").jqxInput({theme: tema, disabled: true, width: '100px'});
			    $('#gendidcampana').jqxInput({theme: tema, disabled: true,width: '100px', height: 20 });
			    $('#gendidcontacto').jqxInput({theme: tema, disabled: true,width: '100px', height: 20 });
			    $('#gendidcontactocampana').jqxInput({theme: tema, disabled: true,width: '100px', height: 20 });
			    /*$('#didllamada').jqxInput({theme: tema, disabled: true,width: '100px', height: 20 });
			     var myVar = setInterval(function () {myTimer()}, 100);
			    	function myTimer() {
					    var d = new Date();
					    $('#dtiempo').val(d.toLocaleTimeString());
					}*/	
			    $('#gentelefonollamada').jqxInput({theme:tema,disabled: true,width: '100px', height: 20 });
			    $('#genfechallamada').jqxInput({theme:tema,disabled: true,width: '100px', height: 20 });
			    $('#genhorallamada').jqxInput({theme:tema,disabled: true,width: '100px', height: 20 });
			    $("#gencliente_tipo_id").jqxDropDownList({theme: tema, width: 200,height: 20});
			    $('#gencedula').jqxInput({theme:tema,disabled: true,width: '120px', height: 20 });
			    $('#gennombres').jqxInput({theme:tema,width: '280px', height: 20, placeHolder:'ingrese nombres'});
			    $('#genapellidos').jqxInput({theme:tema,width: '280px', height: 20, placeHolder:'ingrese apellidos'});
			    $("#genruc").jqxInput({theme:tema,width: '150px', height: 20});
			    $("#genrazonsocial").jqxInput({theme:tema,width: '570px', height: 20}); 
			    $('#genciudad').jqxInput({theme:tema,width: '570px', height: 20 });
			    genciudades($('#genciudad'));
			    $('#gendireccion').jqxInput({theme:tema,width: '570px', height: 50 });
			    $('#genobservacion').jqxInput({theme:tema,width: '590px', height: 40 });
			    $('#genemail').jqxInput({theme:tema, width: '570px', height: 20 });
			    $('#genidprea').jqxInput({theme:tema, width: '100px', height: 20 });
                //$('#genperfil').jqxInput({theme:tema, width: '100px', height: 20 });
                $('#genlimcredito').jqxInput({theme:tema, width: '200px', height: 20 });
                $('#genfinanciamiento').jqxInput({theme:tema, width: '200px', height: 20 });
                $('#genlimcredito_tc').jqxInput({theme:tema, width: '200px', height: 20 });
                $('#genfinanciamiento_tc').jqxInput({theme:tema, width: '200px', height: 20 });
                gencestadocita();
                genvendedor();
                $('#genbtnListaProducto').jqxButton({theme:tema, width: '70px' });
                //$('#valbtnConsAgendaVendedor').jqxButton({theme:tema, width: '141px', height: 24 });
                $('#genbtnSave').jqxButton({theme:tema, width: '65px' });
   		        $('#genbtnCancel').jqxButton({theme:tema, width: '65px' });
   		        $('#genbtnExpandir').jqxButton({theme:tema, width: '65px' });
   		        $("#genbtnListaProducto").click(function () {
   		        	campid=	 $('#gendidcampana').val();	
   		           	clieid= $("#gencliente_tipo_id").val();
   		            abrirListaProductos('citagen_detalle', campid, clieid);
   		           	   		               		        	 
   		          });   
   		        /*  
   		        $("#valbtnConsAgendaVendedor").click(function () {
   		        	createElementsAgenda();
        	         $("#eventWindowAgenda").jqxWindow('open');
   		        	 var iemp = $("#genvendedor").jqxComboBox('getSelectedItem');
			         borrarAgenda();
        	         load_agenda(iemp.value);
   		           	   		               		        	 
   		          });            
   		        */
   		       
   		         $("#genbtnSave").click(function () {	
   		         	  genmensaje='' 	
   		              if (genvalidaForm()){
   		                 
   		              	   GenSaveCita();
   		        	   }else{
   		        	   	jqxAlert.alert(genmensaje,'Validación');
   		        	   }
   		          });
   		          
   		           $("#genbtnCancel").click(function () {	
   		           	 genencuestaItems.length=0;
   		           	 genagendaItems.length=0;
   		           	 //ValCancelar();
   		           	   		               		        	 
   		          });         		          	
   		          $("#genbtnExpandir").click(function () {	
   		             var contentAreas = $('#genaccordion .ui-accordion-content ').show();
   		          });  			
               }
            });
            $('#eventWindowGesCita').jqxWindow('focus');
            $('#eventWindowGesCita').jqxValidator('hide');
            $('#eventWindowGesCita').on('close', function (event) {
            	genencuestaItems.length=0;
            	genagendaItems.length=0;
			     //location.reload();
			     // $("#eventWindowGesCita").jqxWindow('destroy');
			});
        }
        
        
        function eventoGesTipoCliente(){
        	 $('#gencliente_tipo_id').on('select', function (event) {
                	var args = event.args;
                    var item = $('#gencliente_tipo_id').jqxDropDownList('getItem', args.index);
                    if (item != null) {
                    
                       $('#eventWindowGesCita').jqxValidator('hide');
                       $("#genruc").val('');
			           $("#genrazonsocial").val('');
                       genhabilitaTipoCliente(item.value);
                       cartItemsGen.length=0;
                       $("#gengridproductos").jqxGrid('updatebounddata');
                       
                     }
                 
                });
        }
        
        function genhabilitaTipoCliente(tipo){
         	if (tipo==2){//cliente con ruc
			    $("#genruc").jqxInput({disabled: false});
			    $("#genrazonsocial").jqxInput({disabled: false}); 	
			    }else if (tipo==1){//cliente sin ruc
			    $("#genruc").jqxInput({disabled: true});
			    $("#genrazonsocial").jqxInput({disabled: true}); 	
			    }
			
			    //codigo para validacion de entradas
	            $('#eventWindowGesCita').jqxValidator({
	             	hintType: 'label',
	                animationDuration: 0,
	                rules:  genreglasVisita(tipo) 
	            });	
         }
         
         
         function genreglasVisita(tipo){
         	if (tipo==2){//cliente con ruc
         		return genreglasconRuc;
         	}else if (tipo==1){//cliente sin ruc
         	 return genreglassinRuc;
         	}
         } 
          var genmensaje;
          var genreglassinRuc=[
	                { input: '#gencedula', message: 'Cédula debe tener 10 caracteres!', action: 'keyup, blur', rule: 'length=10,10' },
					{ input: '#gennombres', message: 'Nombres son requeridos!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							// setValSeccion(0);
							 genmensaje='Nombres son requeridos!';	
							 return false;
							 }
							return true;
							
							} },
					{ input: '#genapellidos', message: 'Apellidos son requeridos!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							// setValSeccion(0);
							 genmensaje='Apellidos son requeridos!';	
							 return false;
							 }
							return true;
							
							} },
	               { input: '#genobservacion', message: 'Observación es requerida!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(1);	
							 genmensaje='Observación es requerida!';
							 return false;
							 }
							return true;
							
							}},

	                { input: '#genciudad', message: 'Ciudad es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(0);
							 genmensaje='Ciudad es requerida!';	
							 return false;
							 }
							return true;
							
							}  },
					{ input: '#gendireccion', message: 'Direccion es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(0);
							 genmensaje='Direccion es requerida!';	
							 return false;
							 }
							return true;
							
							} },
	                /*{ input: '#genemail', message: 'email es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setValSeccion(0);	
							 return false;
							 }
							return true;
							
							}  },
	                { input: '#genemail', message: 'e-mail invalido!', action: 'keyup', rule: 'email' },*/
	                { input: '#genfpago', message: 'Forma de pago es requerida!', action: 'keyup, blur, select', rule: function (input) {
                           	if(input.val()==""){
							//setValSeccion(3);
							 genmensaje='Forma de pago es requerida!'; 	
							 return false;
							 }
							return true;
							} 
					},
					{ input: '#genpreaestado', message: 'Estado de preaprobación es requerido!', action: 'keyup, blur, select', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);
							 genmensaje='Estado de preaprobación es requerido!';	
							 return false;
							 }
							return true;
							
							}
					},
					
					{ input: '#genestadocita', message: 'Estado de la cita es requerida!', action: 'keyup, blur, select', rule: function (input) {
                           	if(input.val()==""){
							 //setValSeccion(3);
							 genmensaje='Estado de la cita es requerida!';
							 return false;
							 }
							return true;
							} 
					},
					
					{ input: '#genvendedor', message: 'Vendedor es requerido!', action: 'keyup, blur, select', rule: function (input) {
                           	if(input.val()==""){
							 //setValSeccion(3);
							 genmensaje='Vendedor es requerido!';
							 return false;
							 }
							return true;
							} 
					},
	
	                { input: '#genidprea', message: 'ID de aprobación es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);
							 genmensaje='ID de aprobación es requerido!';	
							 return false;
							 }
							return true;
							
							} },
	                { input: '#genperfil', message: 'Perfil de aprobación es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);
							 genmensaje='Perfil de aprobación es requerido!';	
							 return false;
							 }
							return true;
							
							} },
					{ input: '#genlimcredito', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#genlimcredito', message: 'Limite de credito banco  es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);
							 genmensaje='Limite de credito banco  es requerido!';	
							 return false;
							 }
							return true;
							
							} },
					{ input: '#genfinanciamiento', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#genfinanciamiento', message: 'Financiamiento banco es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);	
							 genmensaje='Financiamiento banco es requerido!';
							 return false;
							 }
							return true;
							
							} },
					{ input: '#genlimcredito_tc', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#genlimcredito_tc', message: 'Limite de credito tarjeta  es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);
							 genmensaje='Limite de credito tarjeta  es requerido!';	
							 return false;
							 }
							return true;
							
							} },
					{ input: '#genfinanciamiento_tc', message: 'Solo Numeros!', action: 'keyup, blur', rule: 'number' },
	                { input: '#genfinanciamiento_tc', message: 'Financiamiento tarjeta es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);
							 genmensaje='Financiamiento tarjeta es requerido!';	
							 return false;
							 }
							return true;
							
							} }
	              
	                ]   
          var genreglasconRuc=[
	                { input: '#gencedula', message: 'Cédula debe tener 10 caracteres!', action: 'keyup, blur', rule: 'length=10,10' },
					{ input: '#gennombres', message: 'Nombres son requeridos!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(0);
							 genmensaje='Nombres son requeridos!';	
							 return false;
							 }
							return true;
							
							} },
					{ input: '#genapellidos', message: 'Apellidos son requeridos!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(0);
							 genmensaje='Apellidos son requeridos!';	
							 return false;
							 }
							return true;
							
							} },
	                { input: '#genruc', message: 'RUC es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(0);
							 genmensaje='RUC es requerido!';	
							 return false;
							 }
							return true;
							
							} },
	                { input: '#genruc', message: 'RUC incorrecto!', action: 'keyup, blur', rule: function (input) {
            				if(!valValidaRuc()){
            				 //setValSeccion(0);
            				 genmensaje='RUC incorrecto!';		
							 return false;
							 }
							return true;
							}
					},
	                { input: '#genruc', message: 'RUC debe tener 13 caracteres!', action: 'keyup, blur', rule: 'length=13,13' },
	                { input: '#genrazonsocial', message: 'Razón social es requerida!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(0);
							 genmensaje='Razón social es requerida!';		
							 return false;
							 }
							return true;
							
							}  },
	                { input: '#genrazonsocial', message: 'Razón social debe contener solo letras!', action: 'keyup', rule: 'notNumber' },
	                { input: '#genrazonsocial', message: 'Razón social debe contener de 3 a 30 caracteres!', action: 'keyup', rule: 'length=3,30' },
	                { input: '#genobservacion', message: 'Observación es requerida!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(1);
							 genmensaje='Observación es requerida!';	
							 return false;
							 }
							return true;
							
							}},
	                //{ input: '#nombrecomercial', message: 'Razón social debe contener solo letras!', action: 'keyup', rule: 'notNumber' },
	                //{ input: '#nombrecomercial', message: 'Razón social debe contener de 3 a 40 caracteres!', action: 'keyup', rule: 'length=3,40' },
	                { input: '#genciudad', message: 'Ciudad es requerida!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(0);
							 genmensaje='Ciudad es requerida!';		
							 return false;
							 }
							return true;
							
							}  },
					{ input: '#gendireccion', message: 'Dirección es requerida!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(0);
							 genmensaje='Dirección es requerida!';	
							 return false;
							 }
							return true;
							
							} },
	               /* { input: '#genemail', message: 'email es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 setValSeccion(0);	
							 return false;
							 }
							return true;
							
							}  },
	                { input: '#genemail', message: 'e-mail invalido!', action: 'keyup', rule: 'email' },*/
	                { input: '#genfpago', message: 'Forma de pago es requerida!', action: 'keyup, blur, select', rule: function (input) {
                           	if(input.val()==""){
							 //setValSeccion(3);
							 genmensaje='Forma de pago es requerida!';
							 return false;
							 }
							return true;
							} 
					},
					
					{ input: '#genestadocita', message: 'Estado de la gestión es requerida!', action: 'keyup, blur, select', rule: function (input) {
                           	if(input.val()==""){
							 //setValSeccion(3);
							 genmensaje='Estado de la gestión es requerida!';
							 return false;
							 }
							return true;
							} 
					},
					
					{ input: '#genvendedor', message: 'Vendedor es requerido!', action: 'keyup, blur, select', rule: function (input) {
                           	if(input.val()==""){
							 //setValSeccion(3);
							 genmensaje='Vendedor es requerido!';
							 return false;
							 }
							return true;
							} 
					},
					
					{ input: '#genpreaestado', message: 'Estado de preaprobación es requerido!', action: 'keyup, blur, select', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);
							 genmensaje='Estado de preaprobación es requerido!';	
							 return false;
							 }
							return true;
							
							}
					},
	                { input: '#genidprea', message: 'ID de aprobación es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);
							 genmensaje='ID de aprobación es requerido!';	
							 return false;
							 }
							return true;
							
							} },
	                { input: '#genperfil', message: 'Perfil de aprobación es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);
							 genmensaje='Perfil de aprobación es requerido!';		
							 return false;
							 }
							return true;
							
							} },
	                { input: '#genlimcredito', message: 'Limite de credito es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);
							 genmensaje='Limite de credito es requerido!';		
							 return false;
							 }
							return true;
							
							} },
	                { input: '#genfinanciamiento', message: 'Financiamiento de producto es requerido!', action: 'keyup, blur', rule: function (input) {
                            if(input.val()==""){
							 //setValSeccion(3);
							 genmensaje='Financiamiento de producto es requerido!';		
							 return false;
							 }
							return true;
							
							} }
	              
	                ]   
		       
		  function setValSeccion(h){
			    	$( "#accordion" ).accordion( "option", "active", h );
			    }  
            
          function valValidaRuc(){
           var rvalida=true;
           if (!validaDoc($("#genruc").val())){
          	  rvalida=false;
           }
           	return rvalida;
          }
          
          function genValidaProductos(){
            var pvalida=true;
          	var rows = $('#gengridproductos').jqxGrid('getrows');
           	if (!rows.length>0){
          		pvalida=false;
          	}
          	return pvalida;
          }
          
           function genValidaAgenda(){
           	var avalida=true;
           	if (!genagendaItems.length>0){
           		avalida=false;
           	}
           	return avalida;
           }
           
           function valvalidaCita(){
           	    var cvalida =$('#eventWindowGesCita').jqxValidator('validate')
           	    if (!cvalida){
           		 cvalida=false;	
           		}
           		return cvalida;	
           }
           
           function setGenEncuesta(){
           	/*Actualiza el arreglo con informacion de la encuesta que se va enviarl al controlador*/
           	var contacto_campana_id=$("#gendidcontactocampana").jqxInput('val');
           	var contacto_id=$('#gendidcontacto').jqxInput('val');
   		    var campana_id=$('#gendidcampana').jqxInput('val');
   		    //armo el arreglo con informacion de encuesta del formulario
   		    actualiza_genencuestaItems(contacto_id,campana_id);
           }
           
           function genvalidaForm(){
           	var fvalida=true
           	setGenEncuesta();
            if (!valvalidaCita()){
                	fvalida=false;
                	//jqxAlert.alert('Ingrese datos de la cita');
             }else if (!genValidaProductos()){
           		   fvalida=false;
           		   setValSeccion(1);
           		  //jqxAlert.alert('Ingrese productos');
             }else if (!genValidaAgenda()){
                 fvalida=false;
                   setValSeccion(2);
                  //jqxAlert.alert('Ingrese agenda');	
              }
                        
              if (fvalida) return true; else return false;
           	}

        
         cartItemsGen = [];
            //, totalPrice = 0;  
              
         function GengridProductos(cita_id) { 
         	
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
									           
									           GenRecuperaItem({producto_id: data[i].producto_id, producto: data[i].producto, cantidad: data[i].cantidad});
									            
									        }
						       
						                },
						           });
									         
               
                 dataAdapter.dataBind();
	        
        	  
                $("#gengridproductos").jqxGrid(
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
                $("#gengridproductos").bind('cellclick', function (event) {
                    var index = event.args.rowindex;
                    if (event.args.datafield == 'remove') {
                        var item = cartItemsGen[index];
                        if (item.cantidad > 1) {
                            item.cantidad -= 1;
                            updateGridRowGen(index, item);
                        }
                        else {
                            cartItemsGen.splice(index, 1);
                            removeGridRowGen(index);
                        }
                       
                    }
                });
              
            };
                     
            
            function GenRecuperaItem(item) {
                var index = getItemIndexnGen(item.producto);
           
                    var id = cartItemsGen.length,
                        item = {
                        	producto_id: item.producto_id,
                            producto: item.producto,
                            cantidad: parseInt(item.cantidad),
                            index: id,
                            remove: '<div style="text-align: center; cursor: pointer; width: 53px;"' +
                         'id="draggable-demo-row-' + id + '">X</div>'
                        };
                    cartItemsGen.push(item);
                    addGridRowGen(item);
                  
               
            };
            
            function addItemGen(item) {
                var index = getItemIndexnGen(item.producto);
                if (index >= 0) {
                    cartItemsGen[index].cantidad += 1;
                    updateGridRowGen(index, cartItemsGen[index]);
                } else {
                    var id = cartItemsGen.length,
                        item = {
                        	producto_id: item.producto_id,
                            producto: item.producto,
                            cantidad: 1,
                            index: id,
                            remove: '<div style="text-align: center; cursor: pointer; width: 53px;"' +
                         'id="draggable-demo-row-' + id + '">X</div>'
                        };
                    cartItemsGen.push(item);
                    addGridRowGen(item);
                  
                }
                //updatePrice(item.price);
            };
            
            function addGridRowGen(row) {
                $("#gengridproductos").jqxGrid('addrow', null, row);
                 
            };
            function updateGridRowGen(id, row) {
                var rowID = $("#gengridproductos").jqxGrid('getrowid', id);
                $("#gengridproductos").jqxGrid('updaterow', rowID, row);
            };
            function removeGridRowGen(id) {
                var rowID = $("#gengridproductos").jqxGrid('getrowid', id);
                $("#gengridproductos").jqxGrid('deleterow', rowID);
            };
             function getItemIndexnGen(name) {
                for (var i = 0; i < cartItemsGen.length; i += 1) {
                    if (cartItemsGen[i].producto === name) {
                        return i;
                    }
                }
                return -1;
            };      
            
            
        function gencontacto(cont_id){
        $("#gendescontacto").empty();
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
						                	    $('#gescontacto_id').val(cont_id);
						                	    $('#gencedula').val(data.identificacion);
						                	    $('#gennombres').val(data.nombres);
						                	    $('#genapellidos').val(data.apellidos);
						                	    $('#genciudad').val(data.ciudad);
						                	    $('#gendireccion').val(data.direccion);
						                	     var container;
						                	     container = 'CITA DE: '+ data.apellidos+' '+data.nombres;
						                	      $('#gendescontacto').append(container);
						       
						                },
						           });
									         
               
         dataAdapter.dataBind();
	   }
	   
	   function genllamada(id){
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
						                    $('#gentelefonollamada').val(data.telefono);
						                    $('#genfechallamada').val(llfecha);
						                    $('#genhorallamada').val(llhora);
						                 },
						           });
									         
               dataAdapter.dataBind();
	   }
	   
	   function gencmail(cont_id){
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
						                	    $('#genemail').val(data.valor);
						                 },
						           });
									         
               dataAdapter.dataBind();
	   }
	   
	   function genempresa(emp_id){
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
						                	    $('#genruc').val(data.ruc);
						                	    $('#genrazonsocial').val(data.razon_social);
						                 },
						           });
									         
               dataAdapter.dataBind();
	   }
        
        function genciudades($ciudad){
       	
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
       
        function genlista_tipo_cliente(){
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
		 		 $("#gencliente_tipo_id").jqxDropDownList({
							source: dataAdapter,
							//width: 400,
							//height: 20,
							//selectedIndex: 0,
							displayMember: 'descripcion',
							valueMember: 'id'
					});  
				 
          	
          } 
      
         /* Generate unique id */
		function genget_uni_id(){
				
					//Generate unique id
					return new Date().getTime() + Math.floor(Math.random()) * 500;
		}
        function gengetItemIndex(id) {
		                for (var i = 0; i < genagendaItems.length; i += 1) {
		                    if (genagendaItems[i].id === id) {
		                        return i;
		                    }
		                }
		                return -1;
		}
		
	    genagendaItems = [];
	    //genagendaItems = new Array();
	    function cleargenagendaItems(){
	    	for(i in genagendaItems){
	    		genagendaItems.pop();
	    	}
	    }
	    
	    function borrargenagendaempleado(){
	        consagendaItems.length=0;
   		    $('#gencalendar').fullCalendar('removeEventSource', consagendaItems);
   		    $('#gencalendar').fullCalendar('rerenderEvents' );
	    }
	    
	    function borrargenagenda(){
        	genagendaItems.length=0;
   		    $('#gencalendar').fullCalendar('removeEvents');
   		    $('#gencalendar').fullCalendar('rerenderEvents' );
        }
        
        function genagenda(cita_id){
            borrargenagenda();
            initGenCalendar();
	    	var url="<?php echo site_url("mar/asicitas/agenda"); ?>"+"/"+cita_id;
	    	$.ajax({
			        type: "POST",
			        url:url,
			        async: true,
			        success: function(datos){
			        				        	
			             genagendaItems=eval(datos);
			             //alert(genagendaItems[0].id);
			             $('#gencalendar').fullCalendar('addEventSource', genagendaItems);         
                          
			            		             
			        },
			        error: function (obj, error, objError){
			            //avisar que ocurrió un error
			        }
			});
        	
        		
          }
          
         consagendaItems = [];
         function agendaGenEmpleado(emp_id){
            borrargenagendaempleado();
            var url="<?php echo site_url("mar/gescitas/agendaempleado"); ?>"+"/"+emp_id;
	    	$.ajax({
			        type: "POST",
			        url:url,
			        async: true,
			        events: url,
			        success: function(datos){
			        	 consagendaItems=eval(datos);
			             $('#gencalendar').fullCalendar('addEventSource',consagendaItems);
                         			            		             
			        },
			        error: function (obj, error, objError){
			            //avisar que ocurrió un error
			        }
			});
        		
          }
          
          function initGenCalendar(){
        	var fa= new Date();
				          	$('#gencalendar').fullCalendar({
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
								var title='Visita a: ' + $("#genapellidos").val()+' ' +$("#gennombres").val();
								var eventData;
								if (title) {
									eventData = {
										id: genget_uni_id(),
										title: title,
										start: start.format(),
										end: end.format()
										
									};
									genagendaItems.push(eventData);
									$('#gencalendar').fullCalendar('renderEvent', eventData, true); // stick? = true
									
								}
								$('#gencalendar').fullCalendar('unselect');
								
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
						    	 var index = gengetItemIndex(id);
				                 genagendaItems[index].start = event.start.format();
							     genagendaItems[index].end = event.end.format();
						            
						        }else{
						           revertFunc();
						        }
					
					        },
					        eventDrop: function(event, delta, revertFunc) {
				
					             //alert(event.id + " se ha movido a " + event.start.format());
					
						         if (confirm("Esta seguro de aplicar el cambio?")) {
						         	 var id=event.id;
						    	     var index = gengetItemIndex(id);
				                     genagendaItems[index].start = event.start.format();
							         genagendaItems[index].end = event.end.format();
						           
						         }else{
						         	 revertFunc();
						         }
				
				           },
				           /*
				            eventClick: function(calEvent, jsEvent, view) {
			
						        //alert('Event: ' + calEvent.id);
						  
						         if (confirm("Desea eliminar el evento?")) {
						         	 var id=calEvent.id;
						         	 $('#gencalendar').fullCalendar('removeEvents',id);
						    	     var index = gengetItemIndex(id);
				                  	  genagendaItems.splice(index, 1);
				                  	  
						           
						         }else{
						         	 revertFunc();
						         }
						      			
						    },
						    */
							//events: url,
							
						dayClick: function(date, view) {
								$('#gencalendar').fullCalendar('changeView', 'agendaDay');
								$('#gencalendar').fullCalendar('gotoDate', date);
								}
							
						});		
        }
	    
          
          function gencampana_formapago(camp_id, tabla_id) {
        	
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
               $('#genfpago').jqxDropDownList({theme:tema,
               	                          selectedIndex: 0, autoDropDownHeight: true, promptText: "Forma de pago:", 
                                          source: formasPago, displayMember: "descripcion", valueMember: "id", 
                                          width: 300, height: 22}); 
			   
            }
            
            
            
            function gencestadocita() {
        	
               $('#genestadocita').jqxDropDownList({theme:tema,
               	                          selectedIndex: 0, autoDropDownHeight: true, promptText: "Estado de la cita:", 
                                          source: adpestadocita(), displayMember: "descripcion", valueMember: "descripcion", 
                                          width: 300, height: 22}); 
			   
            }
            
            function genvendedor() {
        							         
               $('#genvendedor').jqxDropDownList({theme:tema,
               	                          selectedIndex: 0, autoDropDownHeight: true, promptText: "Asigne vendedor:", 
                                          source: adpempleados(), displayMember: "empleado", valueMember: "id", 
                                          width: 500, height: 22}); 
              
            }
            
         
		  function gencampana_preaprobacion(camp_id, tabla_id) {
		 	  
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
               $('#genpreaestado').jqxDropDownList({ theme:tema, selectedIndex: 0, autoDropDownHeight: true, 
               	                                promptText: "Estados de preaprobación:",
               	                                source: preapestados, displayMember: "descripcion", valueMember: "id",
                                                width: 300, height: 22});
               
            }  
            
             function gen_perfil() {
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
						            
		        $('#genperfil').jqxDropDownList({theme:tema,
               	                          /*selectedIndex: 0, autoDropDownHeight: true,*/ promptText: "Perfil de aprobación:", 
                                          source: dataAdapter, displayMember: "descripcion", valueMember: "descripcion", 
                                          width: 200, height: 22}); 
									         
               
               
            }
            
            
            function GenSaveCita(){
            	var contacto_campana_id=$("#gendidcontactocampana").jqxInput('val');
            	var contacto_id=$('#gendidcontacto').jqxInput('val');
   		        var campana_id=$('#gendidcampana').jqxInput('val');
   		        //var telefono=$('#dtelefono').jqxInput('val');
   		        //var llamada_padre_id=$('#didllamada').jqxInput('val');
   		        //var llamada_id=$('#didllamada').jqxInput('val');
   		        //var inicio=$('#dinicio').jqxInput('val');
   		        var proceso=$('#vproceso').val();
   		        /*selecciona del combo id_empleado del usuario autentificado*/
   		        var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
			    var empleado_id=iemp.value;
   		        var respuesta=$("#genestadocita").val();
   		        if (respuesta!='Venta completa'){$('#gestipogestion').val('REGESTION')};
   		        var vendedor=$("#genvendedor").val();
   		        var oper='repcita';
            	var url = "<?php echo site_url("mar/contactos/ajax"); ?>"; 
            	var cita = {  
                        accion: oper,
                        tipo_gestion: $('#gestipogestion').val(),
                        contacto_campana_id: contacto_campana_id,
                        contacto_id: $("#gescontacto_id").val(),
                        tipo_cliente_id: $("#gencliente_tipo_id").val(),
                        nombres: $("#gennombres").val(),
                        apellidos: $("#genapellidos").val(),
                        ciudad: $("#genciudad").val(),
                        direccion: $("#gendireccion").val(),
                        mail: $("#genemail").val(),
                        ruc: $("#genruc").val(),
			            razon_social: $("#genrazonsocial").val(),
                        llamada_id: $("#gesllamada_id").val() ,
                        campana_id: $("#gescampana_id").val(),
                        observacion:$("#genobservacion").val(),
                        forma_pago:$("#genfpago").val(),
                        estado_preaprobacion:$("#genpreaestado").val(),
                        codigo_preaprobacion:$("#genidprea").val(),
                        perfil:$("#genperfil").val(),
                        limite_credito:$("#genlimcredito").val(),
                        financiamiento:$("#genfinanciamiento").val(),
                        limite_credito_tc:$("#genlimcredito_tc").val(),
                        financiamiento_tc:$("#genfinanciamiento_tc").val(),
						productos: $("#gengridproductos").jqxGrid('getrows'),
						agenda: genagendaItems,
						cita_estado: respuesta,
						empleado_id: vendedor,
						padre_id: $("#gescita_id").val(),
						//datos de llamada
						/*
						telefono:telefono,
   		                llamada_padre_id:llamada_padre_id,
   		                inicio:inicio,
						llamada_estado: 'Finalizada',
		                proceso:proceso,
		                respuesta: respuesta,*/
		                //datos de encuesta
		                encuesta: genencuestaItems,
						
                    };		
					
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: cita,
                        success: function (data) {
							if(data=true){
								
								 $("#eventWindowGesCita").jqxWindow('hide');
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
                   
            }  
            
       
          
          genencuestaItems = [];
          function actualiza_genencuestaItems(contacto_id,campana_id,contacto_campana_id){
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
						genencuestaItems.length=0;	 
						for(i=0;i<data.length;i++){
							 id_pregunta = data[i]['id'];
							 multi = data[i]['multiple_respuesta'];
							 var opciones = data[i]['opciones'];
							 if (opciones==''){
								var resp=$("#resp_"+id_pregunta).val();	
								var respuesta = {
									resp: resp,
									contacto: contacto_id,
									preg: id_pregunta,
									multi: multi
								};
								genencuestaItems.push(respuesta);
								
							 }
								 
								 for(j=0;j<opciones.length;j++){
									if (document.getElementById(""+opciones[j]['detalle']+"").checked==true){
										var resp = document.getElementById(""+opciones[j]['detalle']+"").value;
										var respuesta = {
											resp: resp,
											contacto: contacto_id,
											preg: id_pregunta,
											multi: multi
										};
										genencuestaItems.push(respuesta);
									
									}	
																									 
								 }
						}
					}
					});
					
			
          }
          
          
  
       function cerrarDialogo(){
        	 $('#eventWindowGesCita').jqxWindow('hide');
		     $("#gtelefonosGrid").jqxGrid('updatebounddata');
        }


</script>	

<div style="visibility: hidden; display:none;" id="jqxWidgetValCita">	
	 <div>		
		<div style="display:none;" id="eventWindowGesCita">
            <div id="gendescontacto">Gestión de cita de:</div>
          
                <div>
                    <form id="frmGesCita" method="post">
                    	<table>
                    	   <tr> 
						    <!--<td style="width:15%">Número:</td>
						    <td><input id="dtelefono"></td>
						    <td>Inicio:</td>
						    <td><input id="dinicio"></td>
						    <td>Tiempo:</td>
						    <td><input id="dtiempo"></td>-->
						    <td><input type="hidden" id="gendidcampana"></td>
						    <input type="hidden" style="margin-top: 0px;" id="gendidcontacto"/>
						    <input type="hidden" style="margin-top: 0px;" id="gendidcontactocampana"/>
						    <input type="hidden" style="margin-top: 0px;" id="gestipogestion"/>
						    <!--<input type="hidden" style="margin-top: 0px;" id="didllamada"/>
							<td style="width:25%">Cedula/RUC: <div id="lidentificacion"></div></td>-->
						  </tr>
                    	</table>
                    	   <input style="margin-top: 5px;" type="hidden"  id="gescita_id"/>
                    	   <input style="margin-top: 5px;" type="hidden" id="gescontacto_id"/>
                    	   <input style="margin-top: 5px;" type="hidden"  id="gesllamada_id"/>
                    	   <input style="margin-top: 5px;" type="hidden"  id="gescampana_id"/>
                    	  
                                   <!--control oculto para contorlar expandido del acordion-->
                                   <div style="display:none;">
                                    	<p class="accordion-expand-holder">
									    <a id="accordion-expand-all" href="#">Expand all</a>
									  </p>
                                   </div>
		                            
		                            <div id='genaccordion' class="ui-accordion ui-widget ui-helper-reset">
						                  
						                 <h2 class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span> Datos del contacto</h2>
						                 <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
						                 	<table>
						                 	<tr>
											 <td align="right">Tipo de cliente:</td>
		                                     <td colspan="5" align="left">
		                                     	<div align="left" id="gencliente_tipo_id"></div>
											 </td>
											</tr>
											<tr>  
											  <td align="right">Contacto:</td>
											  <td colspan="5" align="left"> <input style="margin-top: 2px;" id="gennombres"/>
											  <input style="margin-top: 1px;" id="genapellidos"/></td>
											 
										    </tr>
				                            <tr>
											  <td align="right">Cédula:</td>
											  <td colspan="5" align="left"> 
											  	<input style="margin-top: 1px;" id="gencedula"/>
											  	Ruc: <input style="margin-top: 1px;" id="genruc"/>
											  </td>
											</tr> 
											<tr>
											  <td align="right">Razón social:</td>
											  <td colspan="5" align="left"> <input style="margin-top: 1px;" id="genrazonsocial"/></td>
	                               		    </tr>
											
											<tr>
												<td align="right">Email personal:</td>
												<td colspan="5" align="left"><input style="margin-top: 1px;" id="genemail"/></td>
											</tr>
											<tr>
												<td align="right">Ciudad:</td>
												<td colspan="5" align="left"> <input style="margin-top: 1px;" id="genciudad"/></td>
											</tr>
											<tr>
												<td align="right">Direccion:</td>
												<td colspan="5" align="left"><textarea id="gendireccion"></textarea></td>
											</tr>
												
										  </table>
						                 </div>	
						                  <h2 class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span>Preaprobación del crédito y confirmación</h2>
			                    	      <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
			                    	      	<table>
											    <tr>
												  <td align="right">Forma de pago:</td>
												  <td colspan="5" align="left"><div style="margin-top: 1px;" id="genfpago"></div></td>
											     </tr>
			                    	     	
				                    	     	<tr>
													<td align="right">Estado de preaprobación:</td>
													<td colspan="3" align="left"> <div style="margin-top: 1px;" id="genpreaestado"></div></td>
												    </tr>
											    <tr>
											    	<td align="right">ID de preaprobación:</td>
													<td align="left"> <input name="viidprea" style="margin-top: 1px;" id="genidprea"/></td>
											    	<td align="right">Perfil:</td>
											    	<td align="left"> <div style="margin-top: 2px;" id="genperfil"/></td>
											    </tr>
											    <tr>
													<td align="right">Limite de crédito banco:</td>
													<td align="left"> <input style="margin-top: 2px;" id="genlimcredito"/></td>
									                <td align="right">Financiamiento banco:</td>
													<td align="left"><input style="margin-top: 2px;" id="genfinanciamiento"/></td>
			                                     </tr>
			                                      <tr>
													<td align="right">Limite de crédito tarjeta:</td>
													<td align="left"> <input style="margin-top: 2px;" id="genlimcredito_tc"/></td>
									                <td align="right">Financiamiento tarjeta:</td>
													<td align="left"><input style="margin-top: 2px;" id="genfinanciamiento_tc"/></td>
			                                     </tr>
			                                     
												  
			                                     
			                                    </table>
			                    	      </div>
						                
						                 <h2 class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span>Encuesta</h2>
						                 <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" id = "gendatosEncuesta"></div>
						               
						                 <h2 class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span>Productos de interés</h2>
			                    	     <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
			                    	      Fecha de llamada : <input style="margin-top: 5px;" id="genfechallamada"/>
                    	                  Hora de llamada : <input style="margin-top: 5px;" id="genhorallamada"/>
                    	                  Número: <input style="margin-top: 5px;" id="gentelefonollamada"/>
                    	                  <input style="margin-right: 5px;" type="button" id="genbtnListaProducto" value="Productos" />
			                    	     	<table>
				                    	     	 <tr>
				                    	     	    <td align="left"><div style="padding: 5px; " id="gengridproductos"></div></td>
			                                     </tr> 
			                                     
											   
										    
		                                     </table>
			                    	     </div>	
						                 
						                 <h2 class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span>Reporte de Gestión de Cita</h2>
						                  <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
						                 <table>
						                 	<tr>
			                                	   	 <td align="right">Estado:</td>
													 <td colspan="5" align="left"><div style="margin-top: 1px;" id="genestadocita"></div></td>
											</tr>
						                    <tr>
			                                	   	 <td align="right">Vendedor:</td>
													 <td colspan="5" align="left"><div style="margin-top: 1px;" id="genvendedor"></div></td>
													 <!--<td colspan="5" align="left"><input style="margin-left: 5px;" type="button" id="valbtnConsAgendaVendedor" value="Agenda" /></td>-->
											</tr>
											<tr>
												 <td align="left">Observaciones:</td>
												  <td colspan="5" align="left"><textarea id="genobservacion"></textarea></td>
											</tr>
											
						                 </table>
						                 
						                 <div id='gencalendar'></div>
						                 </div>						                 
			                    	     
			                    	     
			                    	      	
			                    	    
                                       
							        </div> 
							
                           </form>
                     
                           <table>
                                 <tr>
										   <td align="right"><input style="margin-right: 5px;" type="button" id="genbtnSave" value="Grabar"/></td>
										   <td align="right"><input id="genbtnCancel" type="button" value="Cancelar" /></td>
										   <td align="right"><input style="margin-right: 5px;" id="genbtnExpandir" type="button" value="Expandir" /></td>
                                		</tr>
		                   </table>
                            
                </div>
            </div>
      </div>
  </div>   