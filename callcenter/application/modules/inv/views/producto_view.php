 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.filter.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.sort.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.pager.js"></script> 
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxpanel.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.edit.js"></script> 
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxlistbox.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdropdownlist.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxcombobox.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxnumberinput.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.aggregates.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdropdownbutton.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxmaskedinput.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxeditor.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxtooltip.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxcolorpicker.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxcheckbox.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxtabs.js"></script> 
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.columnsresize.js"></script>
 <script type="text/javascript">
        var tema= "ui-redmond";
        //variable para acciones CRUD
        var oper;
        //variables de controladores
        var url = "<?php echo site_url("inv/productos/ajax"); ?>";
        $(document).ready(function () {
        	
           //crea menus de operaciones
            var tid="<?php echo $_GET["tid"]; ?>";
          	menuopciones(tid);
            //llena grid   
           	gridMainProductos();
            
          
        });
       	
        function menuopciones(padre_id){
			//var view='producto_view';
			var url="<?php echo site_url("login/login/tool_rol"); ?>"+"/"+padre_id;
			var source =
			{
			datatype: "json",
			datafields: [
			{ name: 'id' },
			{ name: 'padre_id' },
			{ name: 'nombre' },
			{ name: 'valor' }
			],
			id: 'id',
			url: url,
			async: false
			};
			// create data adapter.
			var dataAdapter = new $.jqx.dataAdapter(source);
			// perform Data Binding.
			dataAdapter.dataBind();
			var records = dataAdapter.getRecordsHierarchy('id', 'padre_id', 'items', [{ name: 'nombre', map: 'label'}]);
			 $("#jqxMenu").jqxMenu({source: records, theme: tema, autoSizeMainItems: false, showTopLevelArrows: true, width: '100%'});
             $("#jqxMenu").css("visibility", "visible");
             $("#jqxMenu").on('itemclick', function (event) {
             	    var opt=$(event.args).text();
                    switch (opt) {
					    case 'Nuevo':
					        opnuevo();
					        break;
					    case 'Editar':
					        opeditar();
					        break;
					    case 'Borrar':
					        opborrar();
					        break;
					    case 'Reconsultar':
					        opreconsular();
					        break;
					    default:
					        //default code block
					} 
               	 });
        }
        
        
        function opnuevo(){
			
                        oper='add';
                        var url = "<?php echo site_url("inv/productos/ajax"); ?>";
                        createElements();
						document.getElementById("form").reset();
						comboCategoria();
						comboProveedor();
						comboTipoCliente();
						comboModelo();
						comboMarca();
						$("#tarifasGrid").jqxGrid({ source: detallestarifas()});
                        $("#subproductosGrid").jqxGrid({ source: detallessubproductos()});
						$("#id").val('New');
						$("#nombre").val('');
						$("#descripcion").val('');
					    $("#tipo_cliente").val('');
					    $("#categoria").val('');
					    $("#proveedor").val('');
					    $("#marca").val('');
					    $("#modelo").val('');
					    $("#costo").val('0');
					    $("#iva").val('0');
					    $("#descuento").val('0');
						$("#estado").val('AC');
						$("#eventWindow").jqxWindow('open');
					
								       
		}  
		
		
		function opeditar(){
			         oper = 'edit';
			         var url = "<?php echo site_url("inv/productos/ajax"); ?>";
			         var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                       
                        if (selectedrowindex >= 0 ) {
                           
                            var offset = $("#jqxgrid").offset();
                            // get the clicked row's data and initialize the input fields.
	                        var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex );
	                        // show the popup window.
	                       
	                            
	                            createElements();  
	                            //document.getElementById("form").reset(); 
	                             
							     comboCategoria();
								 comboProveedor();
								 comboTipoCliente();
								 comboModelo();
								 comboMarca();
								 
							     $("#id").val(dataRecord.id);
								 $("#nombre").val(dataRecord.nombre);
								 $("#descripcion").val(dataRecord.descripcion);
								 $("#categoria").val(dataRecord.categoria_id);
								 $("#tipo_cliente").val(dataRecord.cliente_tipo_id);
							     $("#proveedor").val(dataRecord.proveedor_id);
								 $("#marca").val(dataRecord.marca_id);
								 $("#modelo").val(dataRecord.modelo_id);
								 $("#costo").val(dataRecord.costo);
								 $("#iva").val(dataRecord.iva);
								 $("#descuento").val(dataRecord.descuento);
								 $("#estado").val(dataRecord.estado);
								 $("#tarifasGrid").jqxGrid({ source: detallestarifas(dataRecord.id)});
								 $("#subproductosGrid").jqxGrid({ source: detallessubproductos(dataRecord.id)});
								 $("#eventWindow").jqxWindow('open');
								 
					        }else{
	                        	jqxAlert.alert('Seleccione un registro','Editar');
	                        }
                      
      	}	
		
		function opborrar(){
			             oper = 'del';
			             var url = "<?php echo site_url("inv/productos/ajax"); ?>";
			             var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                         if (selectedrowindex >= 0) {
                        	    
		                        //editrow = row;
		                        var offset = $("#jqxgrid").offset();
		                        var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex);
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
		                                    $("#jqxgrid").jqxGrid('updatebounddata');
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
		function opreconsular(){
			 $("#jqxgrid").jqxGrid('updatebounddata');
		}	
		
		
		
		function adpMainProductos(){
			 var url = "<?php echo site_url("inv/productos/ajax"); ?>";
			 var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'id', type: 'number' },
                    { name: 'nombre', type: 'string' },
                    { name: 'descripcion', type: 'string' },
                    { name: 'categoria_id', type: 'string' },
                    { name: 'categoria', type: 'string' },
                    { name: 'proveedor_id', type: 'number' },
                    { name: 'proveedor', type: 'string' },
					{ name: 'cliente_tipo_id', type: 'number' },
					{ name: 'tipo_cliente', type: 'string' },
                    { name: 'marca_id', type: 'number' },
                    { name: 'marca', type: 'string' },
                    { name: 'modelo_id', type: 'number' },
                    { name: 'modelo', type: 'string' },
                    { name: 'costo', type: 'number' },
                    { name: 'iva', type: 'number' },
                    { name: 'descuento', type: 'number' },
                    { name: 'estado', type: 'string' },
                ],
                id: 'id',
                url: url,
                pagesize: 20,
                async: false
                /*filter: function()
			    {
				// update the grid and send a request to the server.
				$("#jqxgrid").jqxGrid('updatebounddata', 'filter');
	     		},
			    cache: false*/
            };
            var dataAdapter = new $.jqx.dataAdapter(source);
            return dataAdapter;
		}
		
		
		function gridMainProductos(){
			//Codigo de operaciones en la Grilla
            $("#jqxgrid").jqxGrid(
            {
                width : '100%',
                height: '100%',
				theme: tema,
                source: adpMainProductos(),
                sortable: true,
                columnsresize: true,
                //showfilterrow: true,
                filterable: true,
                //selectionmode: 'multiplecellsextended',
                //filtermode: 'excel',
                pageable: true,
                //autoheight: true,
                ready: function () {
                    $("#jqxgrid").jqxGrid('sortby', 'id', 'asc');
                },
                //showtoolbar: true,
                //Codigo para la barra de herramientas de la grilla
               
                columns: [
                  { text: 'Id', datafield: 'id', width: '0%' },
				  { text: 'cliente_tipo_id', datafield: 'cliente_tipo_id', width: '5%',hidden:true },
                  { text: 'Categoria_id', datafield: 'categoria_id', width: '0%',hidden:true },
                  { text: 'Proveedor_id', datafield: 'proveedor_id', width: '0%',hidden:true },
                  { text: 'Nombre', datafield: 'nombre', width: '25%'},
                  { text: 'Descripción', datafield: 'descripcion', width: '20%',hidden:true},
				  { text: 'Tipo de cliente', datafield: 'tipo_cliente', width: '8%',hidden:true },
                  { text: 'Categoria', datafield: 'categoria', width: '12%' },
                  { text: 'Proveedor', datafield: 'proveedor', width: '15%' },
                  { text: 'Marca', datafield: 'marca', width: '9%' },
                  { text: 'Modelo', datafield: 'modelo', width: '9%' },
                  { text: 'Costo', datafield: 'costo', width: '8%',cellsformat: 'c2' },
                  { text: 'Iva', datafield: 'iva', width: '8%',cellsformat: 'p2' },
                  { text: 'Descuento', datafield: 'descuento',cellsformat: 'p2', width: '8%' },
                  { text: 'Estado', datafield: 'estado', width: '8%' },
                
                ]
                
            });
            
		}
		
		
		//funcion que carga los datos de detalle de tarifas de los productos en el grid
            function detallestarifas(prod_id) {
               var url="<?php echo site_url("inv/productos/tarifas"); ?>"+"/"+prod_id;
                           //campos del grid de detalle tarifa
               var dataTarifaFields = [
                   					       { name: 'id', type: 'number' },
			               		           { name: 'producto_id', type: 'number' },
					                       { name: 'nombre', type: 'string' },
					                       { name: 'unidad', value: 'unidad_id', values: { source: dataAdapterUnidades().records, value: 'id', name: 'nombre' } },
					                       { name: 'unidad_id', type: 'number' },
					                       { name: 'costo_unitario', type: 'number' },
					                       { name: 'cantidad', type: 'number' },
					                       { name: 'valor', type: 'number' }
					                    ];
               var source ={
						                datatype: "json",
						                datafields: dataTarifaFields,
						                id: 'id',
						                url: url,
						            };
			             
                   
                 var dataAdapter = new $.jqx.dataAdapter(source, {
						                //loadComplete: function (data) { },
						                //loadError: function (xhr, status, error) { }      
						            });
									         
               return dataAdapter;
           
            }
            
            
             //funcion que carga los datos de detalle de tarifas de los productos en el grid
            function detallessubproductos(prod_id) {
               var url="<?php echo site_url("inv/productos/subproductos"); ?>"+"/"+prod_id;
                  //campos del grid de detalle subproductos
              var dataSubproductosFields = [
                   					       { name: 'id', type: 'number' },
			               		           { name: 'producto_id', type: 'number' },
			               		           { name: 'subproducto', value: 'subproducto_id', values: { source: dataAdapterProductos().records, value: 'id', name: 'nombre' } },
			               		           { name: 'subproducto_id', type: 'number' },
			               		           { name: 'cantidad', type: 'number' },
					                       { name: 'costo', type: 'number' },
					                       { name: 'iva', type: 'number' },
					                       { name: 'descuento', type: 'number' }
					                    ]; 
               var source ={
						                datatype: "json",
						                datafields: dataSubproductosFields,
						                id: 'id',
						                url: url,
						            };
			             
                   
                 var dataAdapter = new $.jqx.dataAdapter(source, {
						                //loadComplete: function (data) { },
						                //loadError: function (xhr, status, error) { }      
						            });
									         
               return dataAdapter;
           
            }
		
 </script>
 <div style='margin-left: 0px; margin-top: -23px;' class="main">
  	  <div class='titnavbg'>
  	  	<div class='titnavtit'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/inv.png">&nbsp;&nbsp;Inventario:Productos</div>
	    <div class='titnavlog'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/log_titulo.png"></div>
	  </div>
      <div style='margin-left: 0px; margin-top: 5px;' id='jqxMenu'></div> 
      <div style='margin-left: 0px; margin-top: 5px;' id="jqxgrid"></div>
 </div>	   
 



 
