<script type="text/javascript">
	//codigo para inicializacion del formulario
            function createElements() {
            $('#eventWindow').jqxWindow({
                resizable: false,
                width: '100%',
                height: '100%',
				theme: tema,
                //minWidth: 600,
                minHeight: 485, 
                isModal: true,
                modalOpacity: 0.01, 
                //autoOpen: false, 
                //okButton: $('#btnSave'),
				cancelButton: $("#btnCancel"),
				initContent: function () {
					$('#jqxTabs').jqxTabs({theme:tema, width: '100%',height: "63%"});
					$('#id').jqxInput({theme:tema, disabled: true,width: '100px' });
					$('#descripcion').jqxEditor({theme:tema, height: "300px",width: '100%'});
					$('#nombre').jqxInput({theme:tema, width: '480px'});
					$("#categoria").jqxComboBox({theme:tema, width: 200, height: 20});
					$("#proveedor").jqxComboBox({theme:tema, width: 200, height: 20});
					$("#tipo_cliente").jqxComboBox({theme:tema, width: 200, height: 20})
					$("#marca").jqxComboBox({theme:tema, width: 200, height: 20});
					$("#modelo").jqxComboBox({theme:tema, width: 200, height: 20});
				    $("#costo").jqxNumberInput({theme:tema, width: '200px', height: '20px', inputMode: 'simple', spinButtons: true, symbol: '$' });
				    $("#iva").jqxNumberInput({theme:tema, width: '200px', height: '20px', inputMode: 'simple', spinButtons: true, symbol: '%' });
				    $("#descuento").jqxNumberInput({theme:tema, width: '200px', height: '20px', inputMode: 'simple', spinButtons: true, symbol: '%' });
         			$('#estado').jqxInput({theme:tema,disabled: true, width: '200px'  });
                    $('#btnSave').jqxButton({theme:tema,width: '65px' });
                    $('#btnCancel').jqxButton({theme:tema, width: '65px' });
                    $("#proveedor").jqxComboBox('clearSelection');
                    $("#categoria").jqxComboBox('clearSelection');
                    $("#marca").jqxComboBox('clearSelection');
                    $("#modelo").jqxComboBox('clearSelection');
                    //$("#costo").jqxInput('clearSelection');
                    //$("#iva").jqxInput('clearSelection');
                    //$("#descuento").jqxInput('clearSelection');
                    // $("#addButton").jqxButton({ width: '65'});
                    // $("#removeButton").jqxButton({ width: '65'});
                    $('#btnSave').focus();
                    /*carga grid tarifas*/
                    gridTarifas();
		            /*carga grid subproductos*/
		            gridSubproductos();
                   
                     //codigo para validacion de entradas
                     $('#eventWindow').jqxValidator({
             	     hintType: 'label',
                     animationDuration: 0,
                     rules: [
                            { input: '#nombre', message: 'Nombre es requerido!', action: 'keyup, blur', rule: 'required' }
                          //{ input: '#categoria', message: 'Categoria es requerida!', action: 'keyup, blur', rule: 'required' },
                          //{ input: '#proveedor', message: 'Proveedor es requerido!', action: 'keyup, blur', rule: 'required' }
                            ]
                     });	
                    
                             // codigo para afectar la base por insert o update.
	        $("#btnSave").click(function () {
                var validationResult = function (isValid) {
                    if (isValid) {
                    
                                             
                      var datos = {  
                       	accion: oper,
					   	id: $("#id").val(),
						cliente_tipo_id: $("#tipo_cliente").val(),
		                nombre: $("#nombre").val(),
		                descripcion: $("#descripcion").val(),
		                categoria_id: $("#categoria").val(),
		                proveedor_id: $("#proveedor").val(),
		                marca_id: $("#marca").val(),
		                modelo_id: $("#modelo").val(),
		                costo: $("#costo").val(),
		                iva: $("#iva").val(),
		                descuento: $("#descuento").val(),
		                estado: $("#estado").val(),
		                detalletarifas: $("#tarifasGrid").jqxGrid('getrows'), 
		                detallesubproductos: $("#subproductosGrid").jqxGrid('getrows') 
		                
		               };
		               //alert($('#categoria').val()+','+$('#proveedor').val());
		               //alert (datos.cliente_tipo_id);
		               $.ajax({
			                type: "POST",
			                url: url,
			                 //data: JSON.stringify(data),
			                data: datos,
			                //contentType: "application/json; charset=utf-8",
			                //dataType: "json",
			                success: function (data) {
								if(data=true){
									//alert("El dato se grabó correctamente.");
									//jqxAlert.alert ('El dato se grabó correctamente.');
									$("#eventWindow").jqxWindow('hide');
									$("#jqxgrid").jqxGrid('updatebounddata');
									//$("#tarifasGrid").jqxGrid('updatebounddata');
								}else{
									//alert("Problemas al guardar.");
									//jqxAlert.alert ('Problemas al guardar.');
									
								}
			                },
			                error: function (msg) {
			                     //alert(msg.responseText);
			                     //alert('Error');
			                }
			            });
                    }
                }
                $('#eventWindow').jqxValidator('validate', validationResult);    	
		
			 });	
			 $('#btnSave').focus();   
                    
             }
            });
            
            
            
            
            $('#eventWindow').jqxWindow('focus');
            $('#eventWindow').jqxValidator('hide');
            $('#tarifasGrid').jqxGrid('showtoolbar'); 
            
            }
            
            
            function gridTarifas() {
            	    //configuracion del grid de detalle
		            $("#tarifasGrid").jqxGrid(
		            {
		                width: 750,
		                height: 300,
		                editable: true,
		                theme:tema,
		                keyboardnavigation: false,
		                columnsresize: true,
		                showstatusbar: false,
		                statusbarheight: 25,
		                showaggregates: true,
		                showtoolbar: true,
		                 rendertoolbar: function (toolbar) { 
		                  var me = this;
		                  var container = $("<div style='margin: 5px;'></div>");
		                  toolbar.append(container);
						  theme: tema,
		                  //Codigo para boton Nuevo
		                  //container.append('<input id="btnNuevo" type="button" value="Agregar" />');
		                   container.append('<div id="addButton" style="float: left; position:relative; margin:auto;"><img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/iconue.png" />&nbsp;Nuevo</div>');
		                   $("#addButton").jqxButton({theme:tema});
		                   $("#addButton").bind('click', function () {
		                       
							  	  var datarow = {
			                  	   id: 'New',
			                       producto_id: $("#id").val(),
			                       nombre:null,
			                       unidad_id:null,
			                       costo_unitario:0,
			                       cantidad:0,
			                       valor:0
			                   };
			                  //jqxAlert.alert ('Nuevo detalle.');
			                  var commit = $("#tarifasGrid").jqxGrid('addrow', null, datarow);
								
		                    });
		                  
		                                      
		                    
		                    
		                },
		                columns: [
		                    { text: 'Id', datafield: 'id', width: 0, hidden:true },
		                    { text: 'Tarifa', datafield: 'nombre', width: 250},
		                    { text: 'Unidad', datafield: 'unidad_id',  displayfield: 'unidad',   columntype: 'dropdownlist', width: 150,
		                        initeditor: function  (row, value, editor) {
		                            editor.jqxDropDownList({ source: dataAdapterUnidades(), displayMember: 'nombre', valueMember: 'id'});
		                           
		                        }                      
		                    },
		                    
		                    //{ text: 'Unidad', datafield: 'unidad', width: 100 },
		                    { text: 'Costo', datafield: 'costo_unitario', width: 90, align: 'right', cellsalign: 'right', cellsformat: 'c5', columntype: 'numberinput' },
		                    { text: 'Cantidad', datafield: 'cantidad', width: 80, align: 'right', cellsalign: 'right',  columntype: 'numberinput'},
		                    //{ text: 'Valor',  editable: false, datafield: 'valor', width: 80, align: 'right', cellsalign: 'right', cellsformat: 'c2', columntype: 'numberinput' }
		                     {
		                     text: 'Valor', editable: false, datafield: 'valor',align: 'right', cellsalign: 'right', cellsformat: 'c2',
		                      cellsrenderer: function (index, datafield, value, defaultvalue, column, rowdata) {
		                          var total = parseFloat(rowdata.costo_unitario) * parseFloat(rowdata.cantidad);
		                          return "<div style='margin: 4px;' class='jqx-right-align'>" + adpMainProductos().formatNumber(total, "c2") + "</div>";
		                      }, 
		                      aggregates: [{ '<b>Total</b>':
		                            function (aggregatedValue, currentValue, column, record) {
		                                var total = parseInt(record['cantidad'])*record['costo_unitario'];
		                                return aggregatedValue + total;
		                            }
		                            }] 
		                      
		                    },
		                    
		        
		           
		                          //Codigo para arreglo de botones borrar
			                { text: 'Borrar', datafield: 'Borrar', width: 80, columntype: 'button',id:'number', cellsrenderer: function () {
			                     return "Borrar";
			                      //return '<div style="width: 100%"><img src="../../../Custom Images/pencil.png" style="margin-left: 25%" /></div>';
			                      //return '<div id="removeButton" style="float: left; position:relative; margin:auto;"><img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/icobor.png" />&nbsp;Borrar</div>';
			                  }, buttonclick: function (row) {
			                  	  /*
			                              var selectedrowindex = $("#tarifasGrid").jqxGrid('getselectedrowindex');
			                               var rowscount = $("#tarifasGrid").jqxGrid('getdatainformation').rowscount;
			                               if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			                               var id = $("#tarifasGrid").jqxGrid('getrowid', selectedrowindex);
			                               var commit = $("#tarifasGrid").jqxGrid('deleterow', id);
			                               }
			                         */     
			                               var selectedrowindex = $("#tarifasGrid").jqxGrid('getselectedrowindex');
			                               var rowscount = $("#tarifasGrid").jqxGrid('getdatainformation').rowscount;
			                               if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			                               var dataRecord = $("#tarifasGrid").jqxGrid('getrowdata', selectedrowindex);
			                               if (dataRecord.id) {
			                                 borrarTarifa(dataRecord.id);
			                               } 
			                               var id = $("#tarifasGrid").jqxGrid('getrowid', selectedrowindex);
			                                var commit = $("#tarifasGrid").jqxGrid('deleterow', id);
			                               
			                               }
								 
			                  }
			                 }  
		                ]
		            });
            }
            
            
            function borrarTarifa (id) {
        	    oper='deltar';
          	    var url = "<?php echo site_url("inv/productos/ajax"); ?>";
				
									var registro = {  
										accion: oper,
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
											    $("#tarifasGrid").jqxGrid('updatebounddata');
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
							        // el usuario ha clicado 'No'
							        
							    }
		                     });
										
									
           };
           
           function borrarSubproducto (id) {
        	    oper='delspro';
          	    var url = "<?php echo site_url("inv/productos/ajax"); ?>";
				
									var registro = {  
										accion: oper,
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
											    $("#subproductosGrid").jqxGrid('updatebounddata');
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
							        // el usuario ha clicado 'No'
							        
							    }
		                     });
										
									
           };
            
            function gridSubproductos(){
            	    //configuracion del grid de detalle
		            $("#subproductosGrid").jqxGrid(
		            {
		                width: 750,
		                height: 300,
		                editable: true,
		                theme:tema,
		                keyboardnavigation: false,
		                showstatusbar: false,
		                statusbarheight: 25,
		                columnsresize: true,
		                showaggregates: true,
		                showtoolbar: true,
		                 rendertoolbar: function (toolbar) { 
		                  var me = this;
		                  var container = $("<div style='margin: 5px;'></div>");
		                  toolbar.append(container);
		                  //Codigo para boton Nuevo
		                  //container.append('<input id="btnNuevo" type="button" value="Agregar" />');
		                   container.append('<div id="addSubproducto" style="float: left; position:relative; margin:auto;"><img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/iconue.png" />&nbsp;Nuevo</div>');
		                   $("#addSubproducto").jqxButton({theme:tema});
		                   $("#addSubproducto").bind('click', function () {
		                       
							  	  var datarow = {
			                  	   id: 'New',
			                       producto_id: $("#id").val(),
			                       subproducto_id:null,
			                       costo:0,
			                       cantidad:0,
			                       iva:0,
			                       descuento:0
			                   };
			                  //jqxAlert.alert ('Nuevo detalle.');
			                  var commit = $("#subproductosGrid").jqxGrid('addrow', null, datarow);
								
		                    });
		                        
		                    
		                    
		                },
		                columns: [
		                    { text: 'Id', datafield: 'id', width: 0,hidden:true },
		                    { text: 'Subproducto', datafield: 'subproducto_id',  displayfield: 'subproducto',  columntype: 'combobox', width: 320,
		                       initeditor: function  (row, value, editor) {
		                            editor.jqxComboBox({ source: dataAdapterProductos(), displayMember: 'nombre', valueMember: 'id'});
		                        }/*,
				                 // update the editor's value before saving it.
		                          cellvaluechanging: function (row, column, columntype, oldvalue, newvalue) {
		                            // return the old value, if the new value is empty.
		                            if (newvalue == "") return oldvalue;
		                        } */                       
		                    },
		                     
		                    { text: 'Cantidad', datafield: 'cantidad', width: 80, align: 'right', cellsalign: 'right',  columntype: 'numberinput'},
		                    { text: 'Costo', datafield: 'costo', width: 90, align: 'right', cellsalign: 'right', cellsformat: 'c2', columntype: 'numberinput' },
		                    { text: 'Iva', datafield: 'iva', width: 90, align: 'right', cellsalign: 'right', cellsformat: 'p2', columntype: 'numberinput' },
		                    { text: 'Descuento', datafield: 'descuento', align: 'right', cellsalign: 'right', cellsformat: 'p2', columntype: 'numberinput' },
		                    
		           
		                          //Codigo para arreglo de botones borrar
			                { text: 'Borrar', datafield: 'Borrar', width: 80, columntype: 'button',id:'number', cellsrenderer: function () {
			                     return "Borrar";
			                    }, buttonclick: function (row) {
			                  	     /*
			                               var selectedrowindex = $("#subproductosGrid").jqxGrid('getselectedrowindex');
			                               var rowscount = $("#subproductosGrid").jqxGrid('getdatainformation').rowscount;
			                               if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			                               var id = $("#subproductosGrid").jqxGrid('getrowid', selectedrowindex);
			                               var commit = $("#subproductosGrid").jqxGrid('deleterow', id);
			                               }
			                           */    
			                               var selectedrowindex = $("#subproductosGrid").jqxGrid('getselectedrowindex');
			                               var rowscount = $("#subproductosGrid").jqxGrid('getdatainformation').rowscount;
			                               if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			                               var dataRecord = $("#subproductosGrid").jqxGrid('getrowdata', selectedrowindex);
			                               if (dataRecord.id) {
			                                 borrarSubproducto(dataRecord.id);
			                               } 
			                               var id = $("#subproductosGrid").jqxGrid('getrowid', selectedrowindex);
			                                var commit = $("#subproductosGrid").jqxGrid('deleterow', id);
			                               
			                               }
								 
			                  }
			                 }  
		                ]
		            });
            }
            
            
            
                       
           function  dataAdapterCategoria(){
            //data para categorias
            var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'id', type: 'string' },
                    { name: 'nombre', type: 'string' }
                 ],
                id: 'id',
                url: "<?php echo site_url("inv/categorias/ajax"); ?>",
                pagesize: 20,
                async: false
            };
            var dataAdapter = new $.jqx.dataAdapter(source, {
                loadComplete: function (data) { },
                loadError: function (xhr, status, error) { }      
            });
            return dataAdapter;
           }
           
           function comboCategoria(){
           	$("#categoria").jqxComboBox({promptText: "Seleccionar categoria:", source: dataAdapterCategoria(), displayMember: "nombre", valueMember: "id"});        
           }
    	  
            function dataAdapterProveedor(){
            //data para proveedores
            var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'id', type: 'string' },
                    { name: 'razon_social', type: 'string' }
                 ],
                id: 'id',
                url: "<?php echo site_url("inv/proveedores/ajax"); ?>",
                pagesize: 20,
                async: false
            };
            var dataAdapter = new $.jqx.dataAdapter(source, {
                loadComplete: function (data) { },
                loadError: function (xhr, status, error) { }      
            });
            return dataAdapter;
            }
            
            function comboProveedor(){
              $("#proveedor").jqxComboBox({promptText: "Seleccionar proveedor:", source: dataAdapterProveedor(), displayMember: "razon_social", valueMember: "id"});
			}
          
            function dataAdapterTipo(){
			 var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'id', type: 'string' },
                    { name: 'descripcion', type: 'string' }
                 ],
                id: 'id',
                url: "<?php echo site_url("mar/tipos_clientes/ajax"); ?>",
                pagesize: 20,
                async: false
            };
            var dataAdapter = new $.jqx.dataAdapter(source, {
                loadComplete: function (data) { },
                loadError: function (xhr, status, error) { }      
            });
            return dataAdapter;
            }
            
            function comboTipoCliente(){
            	$("#tipo_cliente").jqxComboBox({promptText: "Seleccionar tipo:", source: dataAdapterTipo(), displayMember: "descripcion", valueMember: "id"});
           
            }
            
            
       function dataAdapterModelo(){
            var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'id', type: 'string' },
                    { name: 'nombre', type: 'string' }
                 ],
                id: 'id',
                url: "<?php echo site_url("inv/modelos/ajax"); ?>",
                pagesize: 20,
                async: false
            };
            var dataAdapter = new $.jqx.dataAdapter(source, {
                loadComplete: function (data) { },
                loadError: function (xhr, status, error) { }      
            });
            return dataAdapter;
           }
           
           function comboModelo(){
             $("#modelo").jqxComboBox({theme:tema, promptText: "Seleccionar modelo:", source: dataAdapterModelo(), displayMember: "nombre", valueMember: "id"});
           }
            
            function dataAdapterMarcas(){
            var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'id', type: 'string' },
                    { name: 'nombre', type: 'string' }
                 ],
                id: 'id',
                url: "<?php echo site_url("inv/marcas/ajax"); ?>",
                pagesize: 20,
                async: false
            };
            var dataAdapter = new $.jqx.dataAdapter(source, {
                loadComplete: function (data) { },
                loadError: function (xhr, status, error) { }      
             });
             return dataAdapter;
            }
            
            function comboMarca(){
              $("#marca").jqxComboBox({theme:tema, promptText: "Seleccionar marca:", source: dataAdapterMarcas(), displayMember: "nombre", valueMember: "id"});
            }
            
            function dataAdapterUnidades(){
            var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'id', type: 'number' },
                    { name: 'nombre', type: 'string' }
                 ],
                id: 'id',
                url: "<?php echo site_url("inv/unidades/ajax"); ?>",
            };
            var dataAdapter = new $.jqx.dataAdapter(source, {
            	autoBind: true,
                //loadComplete: function (data) { },
                //loadError: function (xhr, status, error) { }      
            });
            return dataAdapter;
            }
            
            function dataAdapterProductos(){
            var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'id', type: 'number' },
                    { name: 'nombre', type: 'string' }
                 ],
                id: 'id',
                url: "<?php echo site_url("inv/productos/ajax"); ?>",
            };
            var dataAdapter= new $.jqx.dataAdapter(source, {
            	autoBind: true,
                //loadComplete: function (data) { },
                //loadError: function (xhr, status, error) { }      
            });
            return dataAdapter;
            }   
            
	
</script>

<div style="visibility: hidden; display:none;" id="jqxWidget">
		<div id="eventWindow">
			<div>Producto/Servicio</div>
			<div>
			 <div>
			  	<form id="form">
					<table>
                       <tr>
                           <td align="right">Id:</td>
                           <td align="left"><input id="id"></input></td>
                           <td align="right">Dirigido a:</td>
                           <td align="left"><div id="tipo_cliente"></div></td>
                        </tr>
                        <tr>
                          <td align="right">Producto:</td>
                          <td colspan="3" align="left"><input id="nombre"></input></td>
                        </tr>
                        <tr>
	                        <td align="right">Categoria:</td>
	                        <td align="left"><div name="categoria" style="margin-top: 5px;" id="categoria"></div></td>
	                        <td align="right">Proveedor:</td>
	                        <td align="left"><div name="proveedor" style="margin-top: 5px;" id="proveedor"></div></td>
	                    </tr>
	                    <tr>
	                        <td align="right">Marca:</td>
	                        <td align="left"><div name="marca" style="margin-top: 5px;" id="marca"></div></td>
	                        <td align="right">Modelo:</td>
	                        <td align="left"><div name="modelo" style="margin-top: 5px;" id="modelo"></div></td>
	                    </tr>
	                    <tr>
	                        <td align="right">Costo:</td>
	                        <td align="left"><div id="costo"></div></td>
	                        <td align="right">Iva:</td>
	                        <td align="left"><div id="iva"></div></td>
	                    </tr>
	                    <tr>
	                        <td align="right">Descuento:</td>
	                        <td align="left"><div id="descuento"></div></td>
	                        <td align="right">Estado:</td>
	                        <td align="left"><input id="estado"></input></td>
	                    </tr>
                    </table>
        
                    <div id='jqxTabs'>
		              <ul>
		            	<li style="margin-left: 30px;">Descripción del producto</li>
		                <li>Información de Tarifas</li>
		                <li>Equipos</li>
		              </ul>
		            
		              <div>
	            	    <table>
			            	   <tr>
                                <td align="right"></td>
                                <td align="left"><div id="descripcion"></div></td>
                               </tr>
			            </table>
                      </div>
                    
		               <div>
		            	<table>
	                      <tr>  	
	                         <td align="left"><div id="tarifasGrid"></div></td>
	                      </tr>
	                     </table>
                       </div>
                    
	                   <div>
	                      <table>	
	                       <tr>  	
	                        <td align="left"><div id="subproductosGrid"></div></td>
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
 	