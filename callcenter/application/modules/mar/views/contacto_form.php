<script type="text/javascript">
         
         var createElementsNuevo=function()  {
         	
         	
            $('#eventWindowNuevo').jqxWindow({
                resizable: false,
                width: '100%',
                height: '100%',
                theme: tema,
                minWidth: 550,
                minHeight: 480,  
                isModal: true,
                modalOpacity: 0.01, 
                //autoOpen: false,
                cancelButton: $("#btnCancel"),
                initContent: function () {
                $('#jqxTabs1').jqxTabs({theme: tema, width: '100%',height: "50%"}); 	
                $('#id').jqxInput({theme: tema, disabled: true,width: '0px' });
				$('#contacto_idN').jqxInput({theme: tema, disabled: true, width: '0px' });
				$('#identificacion').jqxInput({theme: tema, width: '150px' });
			    $('#nombre').jqxInput({theme: tema, width: '400px'});
			    $('#apellido').jqxInput({theme: tema, width: '400px'});
			    $('#ciudad').jqxInput({theme: tema, width: '400px'});
			    $('#direccion').jqxInput({theme: tema, width: '400px'});
				$('#estado').jqxInput({theme: tema, disabled: true, width: '20px'  });
				//$("#estado").val('AC');
				$('#btnSave').jqxButton({theme: tema, width: '65px' });
				$('#btnCancel').jqxButton({theme: tema, width: '65px' });
				initgridTelefonos();
		        initgridCorreos();
				ciudades($('#ciudad'));
				//codigo para validacion de entradas
		        $('#eventWindowNuevo').jqxValidator({
		            hintType: 'label',
		            animationDuration: 0,
		            rules: [
		                { input: '#identificacion', message: 'Identificaci�n debe tener 10 caracteres!', action: 'keyup, blur', rule: 'length=10,10' },
						{ input: '#nombre', message: 'Nombres es requerido!', action: 'keyup, blur', rule: 'required' },
						{ input: '#apellido', message: 'Apellidos es requerido!', action: 'keyup, blur', rule: 'required' },
						{ input: '#ciudad', message: 'Ciudad es requerido!', action: 'keyup, blur', rule: 'required' },
						{ input: '#direccion', message: 'Direccion es requerido!', action: 'keyup, blur', rule: 'required' }
						
		            ]
		        });	
		        // codigo para afectar la base por insert o update.
		        $("#btnSave").click(function () {
				   var validationResult = function (isValid) {
		                if (isValid) {
		                	
		                    var contacto = {  
		                        accion: oper,
		                        id: $("#id").val(),
		                        contacto_id: $("#contacto_idN").val(),
								empleado_id: $("#empleado_idN").val(),
		                        campana_id: $("#campana_idN").val(),
								identificacion: $("#identificacion").val(),
								nombre: $("#nombre").val(),
								apellido: $("#apellido").val(),
								ciudad: $("#ciudad").val(),
								direccion: $("#direccion").val(),
								estado: $("#estado").val(),
		                        telefonos: $("#telefonosGrid").jqxGrid('getrows'),
		                        mails: $("#correosGrid").jqxGrid('getrows') 
		                    };		
							
		                    $.ajax({
		                        type: "POST",
		                        url: url,
		                        data: contacto,
		                        success: function (data) {
									if(data=true){
										
										$("#eventWindowNuevo").jqxWindow('hide');
		                                $("#jqxgrid").jqxGrid('updatebounddata');
		                                //alert("El dato se grab� correctamente.");
		                                //jqxAlert.alert ('El dato se grabó correctamente.');
		                            }else{
		                                //alert("Problemas al guardar.");
		                                jqxAlert.alert ('Problemas al guardar.');
		                            }
		                        },
		                        error: function (msg) {
		                            alert(msg.responseText);
		                        }
		                    });	
		                }
		            }
		            $('#eventWindowNuevo').jqxValidator('validate', validationResult);    	
		        });
			
                $('#btnSave').focus();
                }
            });
            $('#eventWindowNuevo').jqxWindow('focus');
            $('#eventWindowNuevo').jqxValidator('hide');
        }
        
        function campos(tipo) {
			var url="<?php echo site_url("mar/contactos/campos"); ?>"+"/"+tipo;
			var source =
						{
							datatype: "json",
							datafields: [
								{ name: 'id' },
								{ name: 'campo' }
							],
							url: url,
							async: false
						};
			var dataAdapter = new $.jqx.dataAdapter(source);
			return dataAdapter;
		} 		
        
        function initgridTelefonos(){
        		$("#telefonosGrid").jqxGrid(
		            {
		                width: 770,
		                height: 230,
		                theme: tema,
		                 //source: detalles(),
		                 editable: true,
		                 keyboardnavigation: false,
		                 showtoolbar: true,
		                 rendertoolbar: function (toolbar) { 
		                  var me = this;
		                  var container = $("<div style='margin: 5px;'></div>");
		                  toolbar.append(container);
		                  //Codigo para boton Nuevo
		                  container.append('<div id="addTelefonos" style="float: left; position:relative; margin:auto;"><img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/iconue.png" />&nbsp;Nuevo</div>');
		                   $("#addTelefonos").jqxButton({theme: tema});
		                   $("#addTelefonos").bind('click', function () {
		                       
							  	  var datarow = {
			                  	   id: 'New'
			                       /*producto_id: $("#id").val(),
			                       nombre:null,
			                       unidad_id:null,
			                       costo_unitario:0,
			                       cantidad:0,
			                       valor:0*/
			                       
			                       
			                   };
			                  //jqxAlert.alert ('Nuevo detalle.');
			                  var commit = $("#telefonosGrid").jqxGrid('addrow', null, datarow);
								
		                    });
		                    
		                    
		                    
		                },
		                columns: [
		                    { text: 'Id', datafield: 'id', width: 0, hidden:true },
		                    { text: 'Campo', datafield: 'campo_id', width: '200px', displayfield: 'campo',  columntype: 'combobox', 
		                        createeditor: function (row, value, editor) {
		                            editor.jqxComboBox({ source: campos('telefono'), displayMember: 'campo', valueMember: 'id' });
		                        }                      
		                   },
		                   { text: 'Valor', datafield: 'valor', width: '35%' },
		                      { text: 'Borrar', datafield: 'Borrar', width: 80, columntype: 'button',id:'number', cellsrenderer: function () {
			                     return "Borrar";
			                      //return '<div style="width: 100%"><img src="../../../Custom Images/pencil.png" style="margin-left: 25%" /></div>';
			                      //return '<div id="removeButton" style="float: left; position:relative; margin:auto;"><img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/icobor.png" />&nbsp;Borrar</div>';
			                  }, buttonclick: function (row) {
			                  	  
			                              /*var selectedrowindex = $("#telefonosGrid").jqxGrid('getselectedrowindex');
			                               var rowscount = $("#telefonosGrid").jqxGrid('getdatainformation').rowscount;
			                               if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			                               var id = $("#telefonosGrid").jqxGrid('getrowid', selectedrowindex);
			                               var commit = $("#telefonosGrid").jqxGrid('deleterow', id);
			                               }*/
			                               var selectedrowindex = $("#telefonosGrid").jqxGrid('getselectedrowindex');
			                               var rowscount = $("#telefonosGrid").jqxGrid('getdatainformation').rowscount;
			                               if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			                               var dataRecord = $("#telefonosGrid").jqxGrid('getrowdata', selectedrowindex);
			                               if (dataRecord.id) {
			                                 borrarTelefono(dataRecord.id);
			                               } 
			                               var id = $("#telefonosGrid").jqxGrid('getrowid', selectedrowindex);
			                                var commit = $("#telefonosGrid").jqxGrid('deleterow', id);
			                               
			                               }
								 
			                  }
			                 }  
		                    
		                    
		                ]
		            });
        }
        
        function borrarTelefono (id) {
        	   
          	    var url = "<?php echo site_url("mar/contactos/ajax"); ?>";
				
									var registro = {  
										accion: 'delcampo',
										id: id
										
									};	
									
								jqxAlert.verify('Esta seguro de ejecutar la acción?','Confirmar', function(r) {
							    if(r){
		                        $.ajax({
										type: "POST",
										url: url,
										data: registro,
										success: function (data) {
											if(data=true){
											    $("#telefonosGrid").jqxGrid('updatebounddata');
											   //jqxAlert.alert("El dato se grabó correctamente.");
											}else{
												jqxAlert.alert("Problemas al borrar.");
											}
										},
										error: function (msg) {
											alert(msg.responseText);
										}
									});	
								}else{
								$("#telefonosGrid").jqxGrid('updatebounddata');
							        // el usuario ha clicado 'No'
							        
							    }
		                     });
										
									
           };
        
        function initgridCorreos(){
        	$("#correosGrid").jqxGrid(
		            {
		                width: 770,
		                height: 230,
		                theme: tema,
		                //source: detalles(),
		                editable: true,
		                //keyboardnavigation: false,
		                //selectionmode: 'multiplecellsadvanced',
		                //showstatusbar: true,
		                //statusbarheight: 25,
		                //showaggregates: true,
		                 showtoolbar: true,
		                 rendertoolbar: function (toolbar) { 
		                  var me = this;
		                  var container = $("<div style='margin: 5px;'></div>");
		                  toolbar.append(container);
		                  //Codigo para boton Nuevo
		                   container.append('<div id="addCorreo" style="float: left; position:relative; margin:auto;"><img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/iconue.png" />&nbsp;Nuevo</div>');
		                   $("#addCorreo").jqxButton({theme: tema});
		                   $("#addCorreo").bind('click', function () {
		                       
							  	  var datarow = {
			                  	   id: 'New'
			                       /*producto_id: $("#id").val(),
			                       nombre:null,
			                       unidad_id:null,
			                       costo_unitario:0,
			                       cantidad:0,
			                       valor:0*/
			                       
			                       
			                   };
			                  //jqxAlert.alert ('Nuevo detalle.');
			                  var commit = $("#correosGrid").jqxGrid('addrow', null, datarow);
								
		                    });
		                    
		                    
		                    
		                },
		                columns: [
		                    { text: 'Id', datafield: 'id', width: 0, hidden:true },
		                    { text: 'Campo', datafield: 'campo_id', width: '200px',  displayfield: 'campo',  columntype: 'combobox', 
		                        createeditor: function (row, value, editor) {
		                            editor.jqxComboBox({ source: campos('email'), displayMember: 'campo', valueMember: 'id' });
		                        }                      
		                   },
		                   { text: 'Valor', datafield: 'valor', width: '40%' },
		                      { text: 'Borrar', datafield: 'Borrar', width: 80, columntype: 'button',id:'number', cellsrenderer: function () {
			                     return "Borrar";
			                      //return '<div style="width: 100%"><img src="../../../Custom Images/pencil.png" style="margin-left: 25%" /></div>';
			                      //return '<div id="removeButton" style="float: left; position:relative; margin:auto;"><img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/icobor.png" />&nbsp;Borrar</div>';
			                  }, buttonclick: function (row) {
			                  	  /*
			                              var selectedrowindex = $("#correosGrid").jqxGrid('getselectedrowindex');
			                               var rowscount = $("#correosGrid").jqxGrid('getdatainformation').rowscount;
			                               if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			                               var id = $("#correosGrid").jqxGrid('getrowid', selectedrowindex);
			                               var commit = $("#correosGrid").jqxGrid('deleterow', id);
			                               }
								 */
								           var selectedrowindex = $("#correosGrid").jqxGrid('getselectedrowindex');
			                               var rowscount = $("#correosGrid").jqxGrid('getdatainformation').rowscount;
			                               if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			                               var dataRecord = $("#correosGrid").jqxGrid('getrowdata', selectedrowindex);
			                               if (dataRecord.id) {
			                                 borrarmail(dataRecord.id);
			                               } 
			                               var id = $("#correosGrid").jqxGrid('getrowid', selectedrowindex);
			                                var commit = $("#correosGrid").jqxGrid('deleterow', id);
			                               
			                               }
								
			                  }
			                 }  
		                    
		                    
		                ]
		            });
        }
        
         function borrarmail (id) {
        	    
          	    var url = "<?php echo site_url("mar/contactos/ajax"); ?>";
				
									var registro = {  
										accion: 'delcampo',
										id: id
										
									};	
									
								jqxAlert.verify('Esta seguro de ejecutar la acción?','Confirmar', function(r) {
							    if(r){
		                        $.ajax({
										type: "POST",
										url: url,
										data: registro,
										success: function (data) {
											if(data=true){
											    $("#correosGrid").jqxGrid('updatebounddata');
											   //jqxAlert.alert("El dato se grabó correctamente.");
											}else{
												jqxAlert.alert("Problemas al borrar.");
											}
										},
										error: function (msg) {
											alert(msg.responseText);
										}
									});	
								}else{
								$("#correosGrid").jqxGrid('updatebounddata');
							        // el usuario ha clicado 'No'
							        
							    }
		                     });
										
									
           };
        
        
        function nlistaEmpleados(){
        	 $("#empleado_idN").jqxDropDownList({
							source: adpempleados(),
							width: 400,
							height: 20,
							theme: tema,
							selectedIndex: 0,
							displayMember: 'empleado',
							valueMember: 'id'
					});  
        }
       
		function nlistaCampanas(){
			$("#campana_idN").jqxDropDownList({
							source: adpcampana(),
							width: 400,
							height: 20,
							theme: tema,
							selectedIndex: 0,
							displayMember: 'nombre',
							valueMember: 'id'
		 });
		}		
				
		 
        
      
       function ciudades($ciudad){
       	
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
      
        
 
</script>		
<div style="visibility: hidden; display:none;" id="jqxWidget2">			
		<div id="eventWindowNuevo">
            <div>Gestion de Contactos</div>
            <div>
                <div>
                    <form id="fmprNuevo" method="post">
                    	<input name="id" style="margin-top: 5px;"  type="hidden" id="id"/>
                        <input name="contacto_idN" style="margin-top: 5px;"  type="hidden" id="contacto_idN"/>
                       
                          <table>
                            <tr>
                                <td align="right">Empleado:</td>
                                <td align="left" colspan="2"><div id="empleado_idN"></div></td>
                            </tr>
                            <tr>
                                <td align="right">Campa&ntilde;a:</td>
                                <td align="left" colspan="2"><div id="campana_idN"></div></td>
                            </tr>
							<tr>
							<td align="right">Identificacion:</td>
							<td align="left"> <input name="identificacion" style="margin-top: 5px;" id="identificacion"/></td>
							</tr>
							<tr>
								<td align="right">Nombres:</td>
								<td align="left"> <input name="nombre" style="margin-top: 5px;" id="nombre"/></td>
							</tr>
							<tr>
								<td align="right">Apellidos:</td>
								<td align="left"> <input name="apellido" style="margin-top: 5px;" id="apellido"/></td>
							</tr>
						    <tr>
						    	<td align="right">Ciudad:</td>
								<td align="left"> <input name="ciudad" style="margin-top: 5px;" id="ciudad"/></td>
							</tr>
							<tr>
								<td align="right">Direccion:</td>
								<td align="left"><textarea id="direccion"></textarea></td></td>
							</tr>
							
							<tr>
								<td><input type="hidden" id="estado"></td>
							</tr>
							
						
							</table>
							<div id='jqxTabs1'>
			                <ul>
			                  <li style="margin-left: 30px;">Telefonos</li>
			                  <li>Correos</li>
			                </ul>
			                <div>
                        	  <table>
                        	    <tr>
		                        <td align="left"><div style='margin-left: 5px; margin-top: 5px;' id="telefonosGrid"></div></td>
		                        </tr>
                    		  </table>
			                </div>
			                <div>
                        	  <table>
                        	    <tr>
		                        <td align="left"><div style='margin-left: 5px; margin-top: 5px;' id="correosGrid"></div></td>
                    		    </tr>
                    		  </table>
			                </div>
			               </div>
                          
                           <table>
			                <tr>
                                <td align="right"></td>
                                <td style="padding-top: 10px;" align="right"><input style="margin-right: 5px;" type="button" id="btnSave" value="Grabar" /><input id="btnCancel" type="button" value="Cancelar" /></td>
                            </tr>
                         </table>   
                        
                    </form>
                </div>
            </div>
      </div>
  </div>   
   
   