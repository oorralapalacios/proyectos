
<script type="text/javascript">
     var myCall;
	 function createElementsVisualizar() {
	 	
            $('#eventWindowVisualizar').jqxWindow({
            	resizable: false,
                width: '100%',
                Height: '100%',
                theme: tema,
                //minHeight: 300,
                isModal: true,
                modalOpacity: 0.01,   
                initContent: function () {
                $('#jqxTabs2').jqxTabs({theme: tema, width: '100%',height: "68%"});
				$('#vid').jqxInput({theme: tema, disabled: true,width: '100px', height: 20 });
				$('#vtipogestion').jqxInput({theme: tema, disabled: true,width: '100px', height: 20 });
				$('#vpadreid').jqxInput({theme: tema, disabled: true,width: '100px', height: 20 });
				$('#vidcontactocampana').jqxInput({theme: tema, disabled: true,width: '100px', height: 20 });
				$('#vproceso').jqxInput({theme: tema, disabled: true,width: '100px', height: 20 });
				$('#vidcampana').jqxInput({theme: tema, disabled: true,width: '100px', height: 20 });
				$('#vidcontacto').jqxInput({theme: tema, disabled: true,width: '100px', height: 20 });
				$('#videntificacion').jqxInput({theme: tema,disabled: true, width: '150px', height: 20 });
				$('#vnombre').jqxInput({theme: tema,disabled: true, width: '286px', height: 20});
			    $('#vapellido').jqxInput({theme: tema,disabled: true, width: '290px', height: 20});
			    $('#vciudad').jqxInput({theme: tema,disabled: true, width: '650px', height: 20});
			    $('#vmovil').jqxInput({theme: tema,disabled: true, width: '100px', height: 25});
			    $('#vdireccion').jqxInput({theme: tema,disabled: true, width: '650px', height: 40});
			    $('#btnLlamar').jqxButton({theme: tema,width: '75px', height: 20 });
   		        //$('#btnEnviar').jqxButton({theme: tema,width: '25px', height: 25 });
   		        eventoLlamar();
   		           		      				
                }
            });
            $('#eventWindowVisualizar').jqxWindow('focus');
            //$('#eventWindowVisualizar').jqxValidator('hide');
        }
        
        function eventoLlamar(){
        	$("#btnLlamar").click(function () {
            var oper;
            var url = "<?php echo site_url("mar/contactos/ajax"); ?>";  
        	var sidcontacto=$("#vidcontacto").jqxInput('val');
            var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
			var sidempleado=iemp.value;
        	//var stelefono = $("#datosTelefonos").jqxDropDownList('getSelectedItem'); 
        	var stelefono = $("#vmovil").jqxInput('val');
        	
        	//var d = new Date();
		    //var sinicio= d.toLocaleTimeString();
		    //var sfin= d.toLocaleTimeString();
        	var snombres=$("#vnombre").jqxInput('val');
        	var sapellidos=$("#vapellido").jqxInput('val');
        	var scampana=$("#vidcampana").jqxInput('val');
            var proceso=$('#vproceso').val();
        	var scontacto=sapellidos+' '+snombres;
        	//alert(sinicio);
        	//alert(stelefono.value);
        	if (stelefono){
        	
		    document.getElementById("frmLlamada").reset();
		    createElementsIniciaLlamada();
		    $("#eventWindowLlamada").jqxWindow('open');
		    $('#ltelefono').val(stelefono);
		    $('#lcontacto').val(scontacto);
		    $('#lidcampana').val(scampana);
		    $('#lidcontacto').val(sidcontacto);
		    $('#lestadollamada').val('Marcada');
		    
		    oper='addllamada';
		    var llamada = {  
                        accion: oper,
                        //id: $('#lid').val(),
                        contacto_campana_id: $("#vid").val(),
                        contacto_id: sidcontacto,
                        empleado_id: sidempleado,
                        campana_id: scampana,
						telefono:  $('#ltelefono').val(),
						inicio: moment().format('YYYY-MM-DD HH:mm:ss'),
						fin: moment().format('YYYY-MM-DD HH:mm:ss'),
                		llamada_estado: $('#lestadollamada').val(),
                		proceso:proceso,
                		respuesta: 'Ninguna',
						
				    };	
				   
					$.ajax({
                        type: "POST",
                        url: url,
                        data: llamada,
                        success: function (data) {
                        	
                          $('#lid').val(data);	
                                                					          
                           if(data=true){
                           	   
                           		    myCall = setTimeout(function(){
                           			var id=$('#lid').val();
		                            finEspera(id,'Marcada', 'Ninguna');
		                            cerrarEspera();
                           			},45000);
                           		
									 		
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
                  
		       
            
		    }else jqxAlert.alert('Seleccione un número telefónico','Validación de teléfono');
		 });
        }
        
        function finEspera(id, estado ,respuesta,proceso){
		 	
		 	var url = "<?php echo site_url("mar/contactos/ajax"); ?>"; 
				    //var tiempo= $('#ltiempo').jqxInput('val');
				    oper='editllamada';
				    var llamada = {  
		                        accion: oper,
		                        id: id,
		                        fin: moment().format('YYYY-MM-DD HH:mm:ss'),
		                        llamada_estado: estado,
		                        proceso:proceso,
		                       	respuesta: respuesta,
								
						    };		
							$.ajax({
		                        type: "POST",
		                        url: url,
		                        data: llamada,
		                        success: function (data) {
		                        	
		                                                 	                      					          
		                           if(data=true){
		                           	
		                            			
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
		 
		 function cerrarEspera() {
		   clearTimeout(myCall);
		   $('#eventWindowLlamada').jqxWindow('hide');
           $("#gtelefonosGrid").jqxGrid('updatebounddata');
          
         }
        
        function detallesTelefonos(conta_id,identificacion,apellidos,nombres) {
               //$("#frmVisualizar").empty();
               var tipo='Telefono'
               var url="<?php echo site_url("mar/contactos/detalle"); ?>"+"/"+conta_id+"/"+tipo;
               
               var source ={
						                datatype: "json",
						                datafields: [
													{ name: 'id' },
													//{ name: 'contacto_id' },
													//{ name: 'campo', value: 'campo_id', values: { source: campos(tipo), value: 'id', name: 'campo' } },
													//{ name: 'campo_id' },
													{ name: 'campo' },
													{ name: 'tipo' },
													{ name: 'valor' },
													//{ name: 'estado' }
													],
						                id: 'id',
						                url: url,
						            };
			                        var dataAdapter = new $.jqx.dataAdapter(source);
				  					         
             
             
             
              
             // Create jqxListBox
             $("#datosTelefonos").jqxDropDownList({theme: tema, source: dataAdapter, displayMember: "valor", valueMember: "valor", width: 170, height: 30,
             selectedIndex: 0,
             renderer: function (index, label, value) {
               var item = dataAdapter.records[index];
               var imgurl; 
               imgurl='<?php echo base_url(); ?>assets/img/call.png';
               var img = '<img height="20" width="20" src="' + imgurl + '"/>';
             	//var table = '<table style="min-width: 130px;"><tr><td style="width: 30px;">' + img + '</td><td>' + label + '</td></tr></table>';
             	var table = '<table style="min-width: 130px;"><tr><td style="width: 30px;" rowspan="2">' + img + '</td><td>' + item.campo + '</td></tr><tr><td>' + item.valor + '</td></tr></table>';

             	return table
             }	
             });
        }

        function detallesMails(conta_id,identificacion,apellidos,nombres) {
               //$("#frmVisualizar").empty();
               var tipo='Email'
               var url="<?php echo site_url("mar/contactos/detalle"); ?>"+"/"+conta_id+"/"+tipo;
               
               var source ={
						                datatype: "json",
						                datafields: [
													{ name: 'id' },
													{ name: 'campo' },
													{ name: 'tipo' },
													{ name: 'valor' },
													],
						                id: 'id',
						                url: url,
						            };
			                        var dataAdapter = new $.jqx.dataAdapter(source);
			 
             $("#datosMails").jqxDropDownList({theme: tema, source: dataAdapter, displayMember: "valor", valueMember: "valor", width: 355, height: 30,
             selectedIndex: 0,
             renderer: function (index, label, value) {
               var item = dataAdapter.records[index];
               var imgurl; 
               imgurl='<?php echo base_url(); ?>assets/img/mail.png';
             	var img = '<img height="20" width="20" src="' + imgurl + '"/>';
             	//var table = '<table style="min-width: 130px;"><tr><td style="width: 30px;">' + img + '</td><td>' + label + '</td></tr></table>';
             	var table = '<table style="min-width: 130px;"><tr><td style="width: 30px;" rowspan="2">' + img + '</td><td>' + item.campo + '</td></tr><tr><td>' + item.valor + '</td></tr></table>';
             	return table
             }	
             });
        }    
       
        
        function detalleLlamadas(conta_id) {
            
                var url = "<?php echo site_url("mar/contactos/llamadasfiltradaspaginadas"); ?>"+"/"+conta_id;
		
                var source = {  
                    datatype: "json",
                    datafields: [
								{ name: 'rownum' },
								{ name: 'id' },
								{ name: 'contacto_id' },
								{ name: 'telefono' },
								{ name: 'inicio' },
								{ name: 'fin' },
				    			{ name: 'llamada_estado' },
								{ name: 'campana' },
								{ name: 'proceso' },
								{ name: 'respuesta_recibida'}
								],
					id: 'id',
					url: url,
					root:'Rows',
					filter: function(){
							 	      $("#gtelefonosGrid").jqxGrid('updatebounddata', 'filter');
								        },
								        /*sort: function(){
									      $("#gtelefonosGrid").jqxGrid('updatebounddata', 'sort');
								        },*/
					beforeprocessing: function(data)
											{		
												source.totalrecords = data[0].TotalRows;
											}
                };		
                var dataAdapter = new $.jqx.dataAdapter(source);
			    return dataAdapter;
                  
		}
		
		 
		 function initgridLlamadasTelefonicas(adp){
			$("#gtelefonosGrid").jqxGrid({
            width: 770,
		    height: 330,
            theme: tema,
            source: adp,
            //sortable: true,
            filterable: true,
            pageable: true,
            columnsresize: true,
            pagermode: 'simple',
            pagesize: 50,
            virtualmode: true,
			rendergridrows: function()
				{
					  return adp.records;     
				},
			 /*rendered:function (row, column, value) {
                            return '<div style="text-align: center; margin-top: 5px;">' + (1 + value) + '</div>';
                        },*/
            //Codigo para la barra de herramientas de la grilla
            columns: [
		                    { text: '', datafield: 'rownum'},
		                    { text: 'Id', datafield: 'id', width: 0, hidden:true },
		                    { text: 'Contacto_id', datafield: 'contacto_id', width: 0 , hidden:true},
		                    { text: 'Número', datafield: 'telefono', width: '15%' },
		                    { text: 'Inicio', datafield: 'inicio', width: '20%' },
		                    { text: 'Fin', datafield: 'fin', width: '20%' },
		                    { text: 'Estado', datafield: 'llamada_estado', width: '12%' },
		                    { text: 'Campaña', datafield: 'campana', width: '20%' },
		                    { text: 'Proceso', datafield: 'proceso', width: '20%' },
		                    { text: 'Respuesta', datafield: 'respuesta_recibida', width: '25%' },
		                    /*{ text: 'Borrar', datafield: 'Borrar', width: 80, columntype: 'button',id:'number', cellsrenderer: function () {
			                     return "Borrar";
			                     }, buttonclick: function (row) {
			                  	          opborrarLlamada();
			                              							 
			                  }
			                 }, */ 
		                    
		                ]
          
            
        });
       }
        
        
        function opborrarLlamada(){
			             oper = 'delllamada';
			             var url = "<?php echo site_url("mar/contactos/ajax"); ?>" 
                 	     var selectedrowindex = $("#gtelefonosGrid").jqxGrid('getselectedrowindex');
                         if (selectedrowindex >= 0) {
                        	    
		                        //editrow = row;
		                        var offset = $("#gtelefonosGrid").offset();
		                        var dataRecord = $("#gtelefonosGrid").jqxGrid('getrowdata', selectedrowindex);
		                        var contacto = {
		                            accion: oper,
		                            id: dataRecord.id
		                        };
								jqxAlert.verify('Esta seguro de Borrar?','Confirma borrar', function(r) {
							    if(r){
		                        $.ajax({
		                            type: "POST",
		                            url: url,
		                            data: contacto,
		                            success: function (data) {
		                                if(data=true){
		                                    //$("#eventWindowNuevo").jqxWindow('hide');
		                                    $("#gtelefonosGrid").jqxGrid('updatebounddata');
		                                    //alert("El dato se Elimin� correctamente.");
		                                }else{
		                                    jqxAlert.alert("Problemas al Eliminar.");
		                                }
		                            },
		                            error: function (msg) {
		                                jqxAlert.alert(msg.responseText);
		                            }
		                        });	
								}else{
							        // el usuario ha clicado 'No'
							        
							    }
		                     });
                         
	                        }else{
	                        	jqxAlert.alert('Seleccione un registro','Borrar');
	                        }
                      
		}	
        
      
</script>

<div style="visibility: hidden; display:none;" id="jqxWidget4">   	
		<div id="eventWindowVisualizar">
            <div id="tituloVisualizar">Contacto</div>
            <div>
                <div>
                	<form id="frmVisualizar">
                		     <input type="hidden" name="vid" style="margin-top: 0px;" id="vid"/>
                		     <input type="hidden" name="vtipogestion" style="margin-top: 0px;" id="vtipogestion"/>
                		     <input type="hidden" name="vpadreid" style="margin-top: 0px;" id="vpadreid"/>
                		     <input type="hidden" name="vidcontactocampana" style="margin-top: 0px;" id="vidcontactocampana"/>
							 <input type="hidden" name="vidcontacto" style="margin-top: 0px;" id="vidcontacto"/>
							 <input type="hidden" id="vidcampana">
							 <input type="hidden" id="vproceso">
	                         <table id="datosContacto">
	                            
								<tr>
								<td align="right">Cédula:</td>
								<td align="left"> <input name="videntificacion" style="margin-top: 0px;" id="videntificacion"/></td>
								</tr>
								<tr>
									<td align="right">Nombres:</td>
									<td align="left"> <input name="vnombre" style="margin-top: 0px;" id="vnombre"/></td>
								    <td align="right">Apellidos:</td>
									<td align="left"> <input name="vapellido" style="margin-top: 0px;" id="vapellido"/></td>

								</tr>
								<tr>
									<td align="right">Ciudad:</td>
									<td colspan="3" align="left"> <input id="vciudad"/></td>
									  
								</tr>
							
								<tr>
									<td align="right">Direccion:</td>
									<td colspan="3" align="left"> <textarea id="vdireccion"></textarea></td>
									  
								</tr>
								<tr>
									<td align="right">Movil:</td>
									<td colspan="3" align="left"> <div style="float: left;"><input id="vmovil"/></div>
							        <div type="button" id="btnLlamar"  value="Llamar" style="float: left;"><img style="vertical-align: middle; margin-top: 2px; margin-left: 1.5px;" src="<?php echo base_url(); ?>assets/img/call.png" />&nbsp;Llamar</div>
							        </td>
								
								</tr>
								</table>
								
	                    </form>
                	 <div id='jqxTabs2'>
			            <ul>
			                <li style="margin-left: 30px;">Gestión de LLamadas</li>
			                <!--<li>Gestión de mails</li>-->
			            </ul>
			           <div>
	                    <table>
                        	    <tr>
                        	      <td align="left"><div style='margin-left: 5px; margin-top: 5px;' id="gtelefonosGrid"></div></td>
                        	    </tr>
                    	</table>
                       </div> 
                        <!--<table>
                        	    <tr>
		                        <td align="left"><div style='margin-left: 5px; margin-top: 5px;' id="gcorreosGrid"></div></td>
                    		    </tr>
                    	</table>
                     <div>-->
                    	
                     </div>	
                  </div>
            </div>
      </div>
  </div>  