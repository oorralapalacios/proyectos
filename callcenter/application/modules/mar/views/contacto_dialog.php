 
    <script type="text/javascript">
    
    
            function abrirDialogoInicio(llamada_id,inicio,contacto_id,campana_id,telefono){
            	$('#eventWindowDialogo').jqxWindow({autoOpen: false})
                document.getElementById("frmDialogo").reset();
                createElementsDialogo();
				$("#eventWindowDialogo").jqxWindow('open');
				$('#didllamada').val(llamada_id);
                $('#dinicio').val(inicio);
                $('#dtelefono').val(telefono);
				$('#didcampana').val(campana_id);
				$('#didcontacto').val(contacto_id);
			    recuperaProductos();
				
		        
            }
            
           cartItems = []; 
           function recuperaProductos(){
           	$("#dgridproductos").jqxGrid('updatebounddata');
           	cartItems.length=0;
           	 var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                  if (selectedrowindex >= 0) {
                       var offset = $("#jqxgrid").offset();
	                   // get the clicked row's data and initialize the input fields.
	                   dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex);
	                   getgridProductos(dataRecord.cita_id);
                     
			      }
           }    
                   
           function recuperaTipoCliente(){
             var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                  if (selectedrowindex >= 0) {
                       var offset = $("#jqxgrid").offset();
	                   // get the clicked row's data and initialize the input fields.
	                   dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex);
	                   $('#cliente_tipo_id').val(dataRecord.tipo_cliente_id);
                     
			      }
            }
            
         
            function createElementsDialogo() {
	            $('#btnAgregarListaInteres').jqxButton({theme: tema, width: '400px' });
	            $('#btnEquivocado').jqxButton({theme: tema, width: '200px' });	
	            $('#btnNoTitular').jqxButton({theme: tema, width: '200px' });	
	            $('#btnNoInteresado').jqxButton({theme: tema, width: '200px' });	
	   			$('#btnSeguimientoTelefonico').jqxButton({theme: tema, width: '200px' });	
	    		$('#btnFueraCobertura').jqxButton({theme: tema, width: '200px' });
	    	    $('#btnPagoDirecto').jqxButton({theme: tema, width: '200px' });		
	            $('#btnSeguimientoSitu').jqxButton({theme: tema, width: '200px' });	
	   		    $('#btnFinalizaLlamada').jqxButton({theme: tema, width: '200px' });
	   		    $('#btnGuardaEncuesta').jqxButton({theme: tema, width: '200px' });
	            $('#eventWindowDialogo').jqxWindow({
            	resizable: false,
                width: '100%',
                Height: '100%',
                theme: tema,
                //minHeight: 300,
                position: 'top, center', 
                isModal: true,
                modalOpacity: 0.01,  
                initContent: function () {
              	$('#DialogSplitter').jqxSplitter({theme: tema, width: '100%', height: 524, panels: [{ size: 540 },{ size: 510 }] });
				$('#jqxTabs3').jqxTabs({theme: tema, width: 540, height: 525});
			    $("#dtelefono").jqxInput({theme: tema, disabled: true, width: '150px'});
			    $("#dinicio").jqxInput({theme: tema, disabled: true, width: '150px'});
			    $("#dtiempo").jqxInput({theme: tema, disabled: true, width: '100px'}); 
			    $('#didcampana').jqxInput({theme: tema, disabled: true,width: '100px', height: 20 });
			    $('#didcontacto').jqxInput({theme: tema, disabled: true,width: '100px', height: 20 });
			    $('#didllamada').jqxInput({theme: tema, disabled: true,width: '100px', height: 20 });
			    $('#campDialogo').jqxPanel({theme: tema, width: 520, height: 470});
			    //$('#datosEncuesta').jqxPanel({theme: tema, width: 490, height: 470});
			    $('#info_producto').jqxPanel({theme: tema, width: 490, height: 100});
			    //$('#didentificacion').jqxInput({width: '150px' });
			     var myVar = setInterval(function () {myTimer()}, 100);
			    	function myTimer() {
					    var d = new Date();
					    $('#dtiempo').val(d.toLocaleTimeString());
					}	
                $("#cliente_tipo_id").jqxDropDownList({theme: tema, width: 400,height: 20});
		        //$("#categoria_id").jqxDropDownList({theme: tema, width: 400,height: 20});
                //$("#producto_id").jqxDropDownList({theme: tema, width: 400,height: 20});  
                lista_tipo_cliente();
                recuperaTipoCliente();
                //lista_categorias($('#didcampana').val(), $('#cliente_tipo_id').val());
                $('#cliente_tipo_id').on('select', function (event) {
                	var scamid=$('#didcampana').jqxInput('val');
                    var args = event.args;
                    var item = $('#cliente_tipo_id').jqxDropDownList('getItem', args.index);
                    if (item != null) {
                       
                        //lista_categorias(scamid, item.value);
                        cartItems.length = 0;
                        $("#dgridproductos").jqxGrid('updatebounddata');
                        $('#info_producto').jqxPanel('clearcontent');
                     }
                 
                });
                  
                             
                
                //gridRendering();
               
   		        
   		        
   		        	
   		          $("#btnAgregarListaInteres").click(function () {	
   		          	 campid=$('#didcampana').val();	
   		             clieid= $('#cliente_tipo_id').val();
   		             if (clieid){	
   		              abrirListaProductos('contacto_dialog',campid,clieid);
   		        	 }else{
   		        	 	jqxAlert.alert('Seleccione tipo de cliente','Validación');
   		        	 }
   		          });  
   		          
   		           $("#btnSeguimientoSitu").click(function () {	
   		           	
   		          
   		           	
   		           	if (ValidaSelProductos()){
   		           	   
   		               document.getElementById("frmVisita").reset();
   		               var tipocliente=$('#cliente_tipo_id').val();
   		               var vidcontactocampana=$('#vidcontactocampana').jqxInput('val');
   		               var vidcontacto=$('#didcontacto').jqxInput('val');
		               var vidllamada=$('#didllamada').jqxInput('val');
		               var vidcampana=$('#didcampana').jqxInput('val');
		               createElementsVisita();
   		               
   		               habilitaTipoCliente(tipocliente);
   		               $('#vicampana_id').val(vidcampana),
		               $('#villamada_id').val(vidllamada),
		               $('#vitipo_cliente_id').val(tipocliente),
		               
		               contacto(vidcontacto);
		               empresa(vidcontacto);
		               cmail(vidcontacto);
		               gridProductos(cartItems);
		               visita_perfil();
		               visita_horario();
		               
		              /*Espacio para recuperar datos de financiamiento*/
		               
		               $('#vihorario').on('select', function (event) {
                       var args = event.args;
		                    var item = $('#vihorario').jqxDropDownList('getItem', args.index);
		                    if (item != null) {
		                    	var horario=item.label
		                    	var horas = horario.split("-");
		                    	$('#vihoraini').val(horas[0]);
		                    	$('#vihorafin').val(horas[1]);
		                      }
		                
		                });
		               campana_formapago(vidcampana, 1);
		               campana_preaprobacion(vidcampana, 2);
		               preguntas_datos_act(vidcampana,vidcontacto,vidcontactocampana);
		               recuperaDatosGestionados();
		                	
		               $("#eventWindowVisita").jqxWindow('open');
		               
   		             }else{
   		             	jqxAlert.alert('Seleccione productos o servicios de interés');
   		             }
   		           });  
   		          
   		          
   		          $('#btnEquivocado').click(function(){
   		         	var contacto_id=$('#didcontacto').jqxInput('val');
   		            var campana_id=$('#didcampana').jqxInput('val');
   		            var telefono=$('#dtelefono').jqxInput('val');
   		            var padre_id=$('#didllamada').jqxInput('val');
   		            var inicio=$('#dinicio').jqxInput('val');	
   		            var proceso=$('#vproceso').val();
   		            var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
				    var empleado_id=iemp.value;
   		          	finalizarEquivocado(contacto_id,empleado_id,campana_id,telefono,padre_id,inicio,proceso)
   		          });	
			      $('#btnNoTitular').click(function(){
			      	//alert('No titular');
			      	var contacto_id=$('#didcontacto').jqxInput('val');
   		            var campana_id=$('#didcampana').jqxInput('val');
   		            var telefono=$('#dtelefono').jqxInput('val');
   		            var padre_id=$('#didllamada').jqxInput('val');
   		            var inicio=$('#dinicio').jqxInput('val');
   		            var proceso=$('#vproceso').val();
   		            var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
				    var empleado_id=iemp.value;
			      	finalizarNoTitular(contacto_id,empleado_id,campana_id,telefono,padre_id,inicio,proceso)
			       });		
			      $('#btnNoInteresado').click(function(){ 
			      	var vidcontacto=$('#didcontacto').jqxInput('val');
   		            var vidcampana=$('#didcampana').jqxInput('val');
   		            rechazar(vidcontacto,vidcampana);
			      });	
			   	 
			      $('#btnFueraCobertura').click(function(){
			      	var vidcontacto=$('#didcontacto').jqxInput('val');
   		            var vidcampana=$('#didcampana').jqxInput('val');	
			        cobertura(vidcontacto,vidcampana);
			       });	
			      $('#btnPagoDirecto').click(function(){
			      	var contacto_id=$('#didcontacto').jqxInput('val');
   		            var campana_id=$('#didcampana').jqxInput('val');
   		            var telefono=$('#dtelefono').jqxInput('val');
   		            var padre_id=$('#didllamada').jqxInput('val');
   		            var inicio=$('#dinicio').jqxInput('val');
   		            var proceso=$('#vproceso').val();
   		            var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
				    var empleado_id=iemp.value;
			      	finalizarPagoDirecto(contacto_id,empleado_id,campana_id,telefono,padre_id,inicio,proceso)
			       });			
			       	
   		          $("#btnSeguimientoTelefonico").click(function () {
   		          	   var vidcontacto=$('#didcontacto').jqxInput('val');
   		               var vidcampana=$('#didcampana').jqxInput('val');	
   		               var vcontacto=$("#vapellido").jqxInput('val')+' '+$("#vnombre").jqxInput('val');	
   		               var vtelefono=$('#vmovil').jqxInput('val');	
   		               
   		               volverLlamar(vidcontacto,vidcampana,vcontacto,vtelefono);
   		              
   		            });  
   		           $("#btnFinalizaLlamada").click(function () {
   		           	 var contacto_id=$('#didcontacto').jqxInput('val');
   		             var campana_id=$('#didcampana').jqxInput('val');
   		             var telefono=$('#dtelefono').jqxInput('val');
   		             var padre_id=$('#didllamada').jqxInput('val');
   		             var inicio=$('#dinicio').jqxInput('val');
   		             var proceso=$('#vproceso').val();		
   		             var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
				    var empleado_id=iemp.value;
   		             finalizar(contacto_id,empleado_id,campana_id,telefono,padre_id,inicio,proceso)
				            
				 	});
   		              				
                }
            });
            $('#eventWindowDialogo').jqxWindow('focus');
            $('#eventWindowDialogo').jqxValidator('hide');
        }
        
          function finalizar(contacto_id,empleado_id,campana_id,telefono,padre_id,inicio,proceso){
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
		                		respuesta: 'Ninguna',
								
						    };	
						   
							$.ajax({
		                        type: "POST",
		                        url: url,
		                        data: llamada,
		                        success: function (data) {
		                         	                          
		                           //var llamada_id=data;                   					          
		                           if(data=true){
		                           	        //cerrarEspera();
		                           		    //abrirDialogo(llamada_id);
		                           		    cerrarDialogo();  
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
	     
	    function finalizarEquivocado(contacto_id, empleado_id,campana_id,telefono,padre_id,inicio,proceso){
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
		                		proceso: proceso,
		                		respuesta: 'Número equivocado',
								
						    };	
						   
							$.ajax({
		                        type: "POST",
		                        url: url,
		                        data: llamada,
		                        success: function (data) {
		                         	                          
		                           //var llamada_id=data;                   					          
		                           if(data=true){
		                           	        //cerrarEspera();
		                           		    //abrirDialogo(llamada_id);
		                           		    cerrarDialogo();
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
	     
	    function finalizarNoTitular(contacto_id, empleado_id,campana_id,telefono,padre_id,inicio,proceso){
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
		                		respuesta: 'No es titular',
								
						    };	
						   
							$.ajax({
		                        type: "POST",
		                        url: url,
		                        data: llamada,
		                        success: function (data) {
		                         	                          
		                           //var llamada_id=data;                   					          
		                           if(data=true){
		                           	        //cerrarEspera();
		                           		    //abrirDialogo(llamada_id);
		                           		    cerrarDialogo();  
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
	     
	    function finalizarPagoDirecto(contacto_id,empleado_id,campana_id,telefono,padre_id,inicio,proceso){
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
		                		respuesta: 'Pago Directo',
								
						    };	
						   
							$.ajax({
		                        type: "POST",
		                        url: url,
		                        data: llamada,
		                        success: function (data) {
		                         	                          
		                           //var llamada_id=data;                   					          
		                           if(data=true){
		                           	        //cerrarEspera();
		                           		    //abrirDialogo(llamada_id);
		                           		    cerrarDialogo(); 
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
        
        function cerrarDialogo(){
        	 $('#eventWindowDialogo').jqxWindow('hide');
		     $("#gtelefonosGrid").jqxGrid('updatebounddata');
        }
        
          function ValidaSelProductos(){
          	var rows = $('#dgridproductos').jqxGrid('getrows');
          	esValido=false;
          	if (rows.length>0){
          		
          		esValido=true;
          	}else{
          		
          		esValido=false;
          	}
          	return esValido;
          }
        
         function lista_tipo_cliente(){
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
		 		 $("#cliente_tipo_id").jqxDropDownList({
							source: dataAdapter,
							//width: 400,
							//height: 20,
							//selectedIndex: 0,
							displayMember: 'descripcion',
							valueMember: 'id'
					});  
				 
          	
          } 
        
        function lista_categorias(camp_id, cliente_tipo_id){
          	 var datos =
				{
					datatype: "json",
					datafields: [
						{ name: 'id' },
						{ name: 'nombre' }
					],
					url: '<?php echo site_url("mar/campanas/categorias"); ?>'+"/"+camp_id+"/"+cliente_tipo_id,
					async: false
				};
				
				 var dataAdapter = new $.jqx.dataAdapter(datos); 
		 		 $("#categoria_id").jqxDropDownList({
							source: dataAdapter,
							//width: 400,
							//height: 20,
							//selectedIndex: 0,
							displayMember: 'nombre',
							valueMember: 'id'
					});  
				 
          	
          } 
          
         
          
          function lista_productos(camp_id, cat_id){
          	 var datos =
				{
					datatype: "json",
					datafields: [
						{ name: 'id' },
						{ name: 'nombre' }
					],
					url: '<?php echo site_url("mar/campanas/productos"); ?>'+"/"+camp_id+"/"+cat_id,
					async: false
				};
				
				 var dataAdapter = new $.jqx.dataAdapter(datos); 
		 		 $("#producto_id").jqxDropDownList({
							source: dataAdapter,
							//width: 400,
							//height: 20,
							//selectedIndex: 0,
							displayMember: 'nombre',
							valueMember: 'id'
					});  
				//$("#info_producto").empty();
				  $('#info_producto').jqxPanel('clearcontent');
          	
          } 
          
          function  info_producto(prod_id){
          	
          	  $('#info_producto').jqxPanel('clearcontent');
          	 var url="<?php echo site_url("inv/productos/infoproducto"); ?>"+"/"+prod_id;
          	 var source=
				{
					datatype: "json",
					datafields: [
						{ name: 'id' },
						{ name: 'nombre' },
						{ name: 'descripcion' }
					],
					id: 'id',
					url: url,
					
				};
				
				 var dataAdapter = new $.jqx.dataAdapter(source, {
						                loadComplete: function (data) { 
						                	//alert(data[0].nombre);
						                	   var container;
						                	   container = data[0].descripcion;
						                	 
						                	   $('#info_producto').jqxPanel('append', container);
						                	 
   		                                 
						                },
						               //loadError: function (xhr, status, error) { }
						            });
									         
             dataAdapter.dataBind(); 
		 	
          }
          
          
           function getgridProductos(cita_id) { 
           	   //$("#dgridproductos").jqxGrid('updatebounddata');
           	   //cartItems.length=0;
			   //clearcartItems();
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
        	    	                    autoBind: true,
						                loadComplete: function (data) { 
						                   for (var i = 0; i < data.length; i++) {
									           
									           RecuperaItem({producto_id: data[i].producto_id, producto: data[i].producto, cantidad: data[i].cantidad});
									            
									        }
						       
						                },
						           });
									         
               
                 //dataAdapter.dataBind();
	        
        	  
                $("#dgridproductos").jqxGrid(
                {
                    height: 200,
                    width: 650,
                    //source: dataAdapter,
                    keyboardnavigation: false,
                    selectionmode: 'single',
                    //rowdetails: true,
                    theme: tema,
                    columns: [
                      { text: 'Producto_id', dataField: 'producto_id', width: 4, hidden:true },
                      { text: 'Item', dataField: 'producto', width: 360 },
                      { text: 'Cantidad', dataField: 'cantidad', width: 80 },
                      { text: 'Borrar', dataField: 'remove', width: 60 }
                    ]
                });
                $("#dgridproductos").bind('cellclick', function (event) {
                    var index = event.args.rowindex;
                    if (event.args.datafield == 'remove') {
                        var item = cartItems[index];
                        if (item.cantidad > 1) {
                            item.cantidad -= 1;
                            updateGridRow(index, item);
                        }
                        else {
                            cartItems.splice(index, 1);
                            removeGridRow(index);
                        }
                       
                    }
                    if (event.args.datafield == 'producto') {
                        var item = cartItems[index];
                        info_producto(item.producto_id);
                       
                    }
                });
               
          }
   
            
          
          /*  
           function clearcartItems(){
	    	for(i in cartItems){
	    		cartItems.pop();
	    	 }
	        }
            */
            
            function RecuperaItem(item) {
            	
                var index = vigetItemIndexn(item.producto);
           
                    var id = cartItems.length,
                        item = {
                        	producto_id: item.producto_id,
                            producto: item.producto,
                            cantidad: parseInt(item.cantidad),
                            index: id,
                            remove: '<div style="text-align: center; cursor: pointer; width: 53px;"' +
                         'id="draggable-demo-row-' + id + '">X</div>'
                        };
                    cartItems.push(item);
                    addGridRow(item);
                    //info_producto(item.producto_id);
                  
               
            };
            
            function addItem(item) {
                var index = vigetItemIndexn(item.producto);
                if (index >= 0) {
                    cartItems[index].cantidad += 1;
                    updateGridRow(index, cartItems[index]);
                } else {
                    var id = cartItems.length,
                        item = {
                        	producto_id: item.producto_id,
                            producto: item.producto,
                            cantidad: 1,
                            index: id,
                            remove: '<div style="text-align: center; cursor: pointer; width: 53px;"' +
                         'id="draggable-demo-row-' + id + '">X</div>'
                        };
                    cartItems.push(item);
                    addGridRow(item);
                    
                  
                }
                //updatePrice(item.price);
               
            };
           
          
            function addGridRow(row) {
                $("#dgridproductos").jqxGrid('addrow', null, row);
                 
            };
            function updateGridRow(id, row) {
                var rowID = $("#dgridproductos").jqxGrid('getrowid', id);
                $("#dgridproductos").jqxGrid('updaterow', rowID, row);
            };
            function removeGridRow(id) {
                var rowID = $("#dgridproductos").jqxGrid('getrowid', id);
                $("#dgridproductos").jqxGrid('deleterow', rowID);
            };
            function vigetItemIndexn(name) {
                for (var i = 0; i < cartItems.length; i += 1) {
                    if (cartItems[i].producto === name) {
                        return i;
                    }
                }
                return -1;
            };
            
           
        
    </script>	
   
   <div style="visibility: hidden; display:none;" id="jqxWidget3">		
      <!--Formulario para el dialogo   -->
      <div id="eventWindowDialogo">
            <div>Dialogando...</div>
            <div>
                <div>
                	<form id="frmDialogo" method="post"></form>
                	<table>
                     	<tr> 
						    <td style="width:15%">Número:</td>
						    <td><input id="dtelefono"></td>
						    <td>Inicio:</td>
						    <td><input id="dinicio"></td>
						    <td>Tiempo:</td>
						    <td><input id="dtiempo"></td>
						    <td><input type="hidden" id="didcampana"></td>
						    <input style="margin-top: 0px;" type="hidden" id="didcontacto"/>
						    <input style="margin-top: 0px;" type="hidden" id="didllamada"/>
							<!--<td style="width:25%">Cedula/RUC: <div id="lidentificacion"></div></td>-->
						  </tr>
                      </table>  
			         <div id="DialogSplitter">
			         	<div class="splitter-panel">
			         		 <div id='jqxTabs3'>
				                 <ul>
				                    <li style="margin-left: 30px;">Información de Campaña</li>
				                    <li>Encuesta</li>
				                    <li>Información de productos</li>
				                    
				                 </ul>
				                 <div>
		                            <div style='margin-left: 8px; margin-top: 10px;' id="campDialogo"></div>
	                    	     </div>	
	                    	     <div style='margin-left: 8px; margin-top: 10px;' id="datosEncuesta"></div>
	                    	     <div>
	                    	      
	                    	      	
	                    	      		   <div style='margin-left: 8px; margin-top: 10px;'>Seleccione Tipo de cliente:</div>
		                                   <div style='margin-left: 8px; margin-top: 0px;' id="cliente_tipo_id"></div>
	                    	      	       <input style='margin-left: 8px; margin-top: 10px;' type="button" id="btnAgregarListaInteres" value="Lista de productos de interés" />	
	                    	      	 	   <div style='margin-left: 8px; margin-top: 10px;'>Información del Producto:</div>
		                                   <div style='margin-left: 8px; margin-top: 0px;' id="info_producto"></div>
		                                   <div style="padding: 5px; width: 232px; margin-left: 8px; margin-top: 10px; " id="dgridproductos"></div>
	                    	      	
		                            
	                    	     </div>	
	                    	     
	                    	     
                             </div>
                             
			                
			            </div>
			            <div class="splitter-panel">
			            	 <div>
							   <input style='margin-left: 8px; margin-top: 10px;' type="button" id="btnEquivocado"  value="Equivocado" />
							 </div>
							 <div>
							   <input style='margin-left: 8px; margin-top: 10px;' type="button" id="btnNoTitular"  value="No es titular" />
							 </div>
			                  <div> 	
		                       <input style='margin-left: 8px; margin-top: 10px;' type="button" id="btnNoInteresado" value="No interesado" />
		                      </div>
		                      <div> 
		                        <input style='margin-left: 8px; margin-top: 10px;' type="button" id="btnSeguimientoTelefonico" value="Seguimiento telefónico" />
		                      </div>
		                      <div>  
		                         <input style='margin-left: 8px; margin-top: 10px;' type="button" id="btnFueraCobertura" value="Fuera de cobertura" />
							  </div> 
							  <div> 
							  	  <input style='margin-left: 8px; margin-top: 10px;' type="button" id="btnPagoDirecto" value="Aplica pago directo" />
							  </div> 
							  <div> 
                                  <input style='margin-left: 8px; margin-top: 10px;' type="button" id="btnSeguimientoSitu" type="button" value="Seguimiento Insitu" />
                              </div> 
                              <div> 
                                 <input style='margin-left: 8px; margin-top: 10px;' type="button" id="btnFinalizaLlamada" type="button" value="Finalizar Llamada" />
					 	      </div> 
					 	      <div> 
                                 <input style='margin-left: 8px; margin-top: 10px;' type="button" id="btnGuardaEncuesta" type="button" value="Guardar Encuesta" />
					 	      </div>
			            </div>
			        </div>
			      
                </div>
            </div>
      </div>
   </div>  