<script type="text/javascript">
 var tema= "ui-redmond";
 
 //var oper;
 /*$(document).ready(function () { 
 	              
 });
 */ 
      function setFormTitulo(titulo){
		 	$("#frmpartitulo").empty();
    		$('#frmpartitulo').append(titulo);
    		
    	 }
		 
		 function getFormTitulo(){
		 	return $('#frmpartitulo').text();
		 }
 
   function abrirListaProductos(frm, camp_id, cliet_id){
    //contacto_dialog
     limpiar_planes();
     setFormTitulo(frm);
   	 createListaProductos(frm);
	 document.getElementById("formListaProductos").reset();
	 $("#eventListaProductos").jqxWindow('open');
	 prolista_categorias(camp_id, cliet_id);
 	 intprogridProductos();
 	  $('#categoria').on('select', function (event) {
                    var item = event.args.item
                    if (item != null) {
                    	progridProductos(proadpproductos(camp_id, item.value));
                       }
                    });
 	 
   }
        
   function limpiar_planes(){
   	 proadpproductos(null,null);
   	 $("#jqxGridListaProductos").jqxGrid('updatebounddata');
     $("#jqxGridListaProductos").jqxGrid('clearselection');
   }
        
   function createListaProductos(frm) {
   	  
            $('#eventListaProductos').jqxWindow({
                resizable: true,
                width: '100%',
                height: '100%',
			    theme: tema,
                minWidth: 200,
                minHeight: 200,  
                isModal: true,
                modalOpacity: 0.01,
                cancelButton: $("#btnProCancel"),
                autoOpen: false,
				initContent: function () {
					
				  
				    
                    $('#btnProOk').jqxButton({theme: tema,width: '80px' });
                    $("#btnProOk").click(function () {	
                    	
                      	var opt= getFormTitulo();
        	            switch (opt) {
        	            	
        	            case 'contacto_dialog':
        	             //Selección del plan
        	             var getselectedrowindexes = $('#jqxGridListaProductos').jqxGrid('getselectedrowindexes');
                           for (var i = 0; i < getselectedrowindexes.length; i++) {
                           var selectedRowData = $('#jqxGridListaProductos').jqxGrid('getrowdata', getselectedrowindexes[i]);
                     	   addItem({producto_id: selectedRowData.id, producto: selectedRowData.nombre});
                     	   }
                     	   //Selección del equipo
					       var getselectedrowindexes = $('#griddet').jqxGrid('getselectedrowindexes');
                           for (var i = 0; i < getselectedrowindexes.length; i++) {
                           var selectedRowData = $('#griddet').jqxGrid('getrowdata', getselectedrowindexes[i]);
                     	   addItem({producto_id: selectedRowData.id, producto: selectedRowData.nombre});
                     	   }
					       //cierre del formulario
                           $('#eventListaProductos').jqxWindow('hide');
        	            
        	            break;   
        	            
        	            case 'contacto_visita':
        	               //Selección del plan
        	               var getselectedrowindexes = $('#jqxGridListaProductos').jqxGrid('getselectedrowindexes');
                           for (var i = 0; i < getselectedrowindexes.length; i++) {
                           var selectedRowData = $('#jqxGridListaProductos').jqxGrid('getrowdata', getselectedrowindexes[i]);
                     	   addItem({producto_id: selectedRowData.id, producto: selectedRowData.nombre});
                     	    $("#vigridproductos").jqxGrid('updatebounddata');
                     	    
                     	   }
                     	   //Selección del equipo
					       var getselectedrowindexes = $('#griddet').jqxGrid('getselectedrowindexes');
                           for (var i = 0; i < getselectedrowindexes.length; i++) {
                           var selectedRowData = $('#griddet').jqxGrid('getrowdata', getselectedrowindexes[i]);
                     	   addItem({producto_id: selectedRowData.id, producto: selectedRowData.nombre});
                     	   $("#vigridproductos").jqxGrid('updatebounddata');
					       }
					       //cierre del formulario
                     	   $('#eventListaProductos').jqxWindow('hide');
        	            
        	            break;	
        	            case 'citaval_detalle':
        	             //Selección del plan
        	             var getselectedrowindexes = $('#jqxGridListaProductos').jqxGrid('getselectedrowindexes');
                           for (var i = 0; i < getselectedrowindexes.length; i++) {
                           var selectedRowData = $('#jqxGridListaProductos').jqxGrid('getrowdata', getselectedrowindexes[i]);
                     	   valaddItem({producto_id: selectedRowData.id, producto: selectedRowData.nombre});
					       }
					       //Selección del equipo
					       var getselectedrowindexes = $('#griddet').jqxGrid('getselectedrowindexes');
                           for (var i = 0; i < getselectedrowindexes.length; i++) {
                           var selectedRowData = $('#griddet').jqxGrid('getrowdata', getselectedrowindexes[i]);
                     	   valaddItem({producto_id: selectedRowData.id, producto: selectedRowData.nombre});
					       }
					       //cierre del formulario
                           $('#eventListaProductos').jqxWindow('hide');
        	            
        	            break; 
        	            
        	            
        	            case 'citaasi_detalle':
        	             //Selección del plan
        	             var getselectedrowindexes = $('#jqxGridListaProductos').jqxGrid('getselectedrowindexes');
                           for (var i = 0; i < getselectedrowindexes.length; i++) {
                           var selectedRowData = $('#jqxGridListaProductos').jqxGrid('getrowdata', getselectedrowindexes[i]);
                     	   addItemAsi({producto_id: selectedRowData.id, producto: selectedRowData.nombre});
					       }
					       //Selección del equipo
					       var getselectedrowindexes = $('#griddet').jqxGrid('getselectedrowindexes');
                           for (var i = 0; i < getselectedrowindexes.length; i++) {
                           var selectedRowData = $('#griddet').jqxGrid('getrowdata', getselectedrowindexes[i]);
                     	   addItemAsi({producto_id: selectedRowData.id, producto: selectedRowData.nombre});
					       }
					       //cierre del formulario
                           $('#eventListaProductos').jqxWindow('hide');
        	            
        	            break; 
        	            
        	            
        	             case 'citagen_detalle':
        	             //Selección del plan
        	              var getselectedrowindexes = $('#jqxGridListaProductos').jqxGrid('getselectedrowindexes');
                           for (var i = 0; i < getselectedrowindexes.length; i++) {
                           var selectedRowData = $('#jqxGridListaProductos').jqxGrid('getrowdata', getselectedrowindexes[i]);
                     	   addItemGen({producto_id: selectedRowData.id, producto: selectedRowData.nombre});
					       }
					      //Selección del equipo
					       var getselectedrowindexes = $('#griddet').jqxGrid('getselectedrowindexes');
                           for (var i = 0; i < getselectedrowindexes.length; i++) {
                           var selectedRowData = $('#griddet').jqxGrid('getrowdata', getselectedrowindexes[i]);
                     	   addItemGen({producto_id: selectedRowData.id, producto: selectedRowData.nombre});
					       }
					      //cierre del formulario
                          $('#eventListaProductos').jqxWindow('hide');
        	            
        	            break; 
        	               
					    default:
					      
					    } 
                    
									           
					  			            
					  		            	
   		        	 
   		             });  
                    $('#btnProCancel').jqxButton({theme:tema, width: '80px' });
                    $('#btnProOk').focus();
                }
            });
            $('#eventListaProductos').jqxWindow('focus');
            $('#eventListaProductos').jqxValidator('hide');
            
            }
 
         
  
  
		
	function prolista_categorias(camp_id, cliente_tipo_id){
		var url = "<?php echo site_url("mar/campanas/categorias"); ?>"+"/"+camp_id+"/"+cliente_tipo_id;
          	 var datos =
				{
					datatype: "json",
					datafields: [
						{ name: 'id' },
						{ name: 'nombre' }
					],
					id: 'id',
					url: url,
					async: false
				};
				
				 var dataAdapter = new $.jqx.dataAdapter(datos); 
		 		
				 $("#categoria").jqxDropDownList({theme: tema, promptText: "Seleccionar categoria:", source: dataAdapter, displayMember: "nombre", valueMember: "id"});        

				
				
					
				 
				 
          	
          } 
	
		
	function proadpproductos(camp_id,cat_id){
			//variables de controladores
            var url = "<?php echo site_url("mar/campanas/productos"); ?>"+"/"+camp_id+"/"+cat_id;
            
            
                
            // prepare the data
            var source =
            {
                datatype: "json",
                datafields: [
                   //{ name: 'available', type: 'boolean' },
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
               
            };
            var dataAdapter = new $.jqx.dataAdapter(source);
        
           return dataAdapter;
            	
           }
           
           
           	function proadpsubproductos(pro_id){
			//variables de controladores
            var url = "<?php echo site_url("mar/campanas/filtersubproductos"); ?>"+"/"+pro_id;
            
            
                
            // prepare the data
            var source =
            {
                datatype: "json",
                datafields: [
                   //{ name: 'available', type: 'boolean' },
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
               
            };
            var dataAdapter = new $.jqx.dataAdapter(source);
        
           return dataAdapter;
            	
           }
           
           function progridProductos(adp){
           	 $("#jqxGridListaProductos").jqxGrid({source: adp})
           }
           
           var initrowdetails = function (index, parentElement, gridElement, datarecord) {
                var id = datarecord.uid.toString();
                var tabsdiv = null;
                var information = null;
                var detalle = null;
                tabsdiv = $($(parentElement).children()[0]);
                if (tabsdiv != null) {
                    information = tabsdiv.find('.information');
                    detalle = tabsdiv.find('.detalle');
                    var title = tabsdiv.find('.title');
                    title.text('Información del plan');
                    var container = $('<div style="margin: 2px;"></div>')
                    container.appendTo($(information));
                    $(information).append(datarecord.descripcion)
                   
                    var grid = $('<div id="griddet"></div>');
                    
                    //limpia detalles seleccionados
                    grid.jqxGrid('updatebounddata');
		            grid.jqxGrid('clearselection');
                    
                    $(detalle).append(grid.jqxGrid({
                    	width : '100%',
			            height: '100%',
			            theme: tema,
			            source: proadpsubproductos(id),
			            //groupable: true,
			            sortable: true,
			            //showfilterrow: true,
			            //groupsexpandedbydefault: true,
			            filterable: true,
			            selectionmode: 'checkbox',
			            //pageable: true,
			            //autoheight: true,
			            columnsresize: true,
			            //pagermode: 'simple',
			            //pagesize: 20,
			            columns: [
		                  { text: 'Id', datafield: 'id', width: '0%',hidden:true },
						  { text: 'cliente_tipo_id', datafield: 'cliente_tipo_id', width: '5%',hidden:true },
		                  { text: 'Categoria_id', datafield: 'categoria_id', width: '0%',hidden:true },
		                  { text: 'Proveedor_id', datafield: 'proveedor_id', width: '0%',hidden:true },
		                  { text: 'Nombre', datafield: 'nombre', width: '60%'},
		                  { text: 'Descripción', datafield: 'descripcion', width: '20%',hidden:true},
						  //{ text: 'Tipo de cliente', datafield: 'tipo_cliente', width: '8%' },
		                  //{ text: 'Categoria', datafield: 'categoria', width: '12%' },
		                  //{ text: 'Proveedor', datafield: 'proveedor', width: '8%' },
		                  //{ text: 'Marca', datafield: 'marca', width: '9%' },
		                  //{ text: 'Modelo', datafield: 'modelo', width: '9%' },
		                  { text: 'Costo', datafield: 'costo', width: '10%',cellsformat: 'c2' },
		                  { text: 'Iva', datafield: 'iva', width: '10%',cellsformat: 'p2' },
		                  { text: 'Descuento', datafield: 'descuento',cellsformat: 'p2', width: '10%' },
		                  { text: 'Estado', datafield: 'estado', width: '8%' },
		                
		                ]
		                }));
                    $(tabsdiv).jqxTabs({theme:tema, width: '96%', height: '95%'});
                }
            }
           
           function intprogridProductos(){
             $("#jqxGridListaProductos").jqxGrid(
            {
	            width : '100%',
	            height: '100%',
	            theme: tema,
	            //source: adpcontactos(),
	            //groupable: true,
	            sortable: true,
	            //showfilterrow: true,
	            //groupsexpandedbydefault: true,
	            filterable: true,
	            selectionmode: 'checkbox',
	            pageable: true,
	            //autoheight: true,
	            columnsresize: true,
	            pagermode: 'simple',
	            pagesize: 20,
            	rowdetails: true,
                rowdetailstemplate: { rowdetails: "<div style='margin: 5px;'><ul style='margin-left: 30px;'><li class='title'></li><li>Equipos</li></ul><div class='information'></div><div class='detalle'></div></div>", rowdetailsheight: 300 },
                /*ready: function () {
                    //$("#jqxGridListaProductos").jqxGrid('showrowdetails', 0);
                    //$("#jqxGridListaProductos").jqxGrid('showrowdetails', 1);
                },*/
                initrowdetails: initrowdetails,
                columns: [
                  { text: 'Id', datafield: 'id', width: '0%',hidden:true },
				  { text: 'cliente_tipo_id', datafield: 'cliente_tipo_id', width: '5%',hidden:true },
                  { text: 'Categoria_id', datafield: 'categoria_id', width: '0%',hidden:true },
                  { text: 'Proveedor_id', datafield: 'proveedor_id', width: '0%',hidden:true },
                  { text: 'Nombre', datafield: 'nombre', width: '60%'},
                  { text: 'Descripción', datafield: 'descripcion', width: '20%',hidden:true},
				  //{ text: 'Tipo de cliente', datafield: 'tipo_cliente', width: '8%' },
                  //{ text: 'Categoria', datafield: 'categoria', width: '12%' },
                  //{ text: 'Proveedor', datafield: 'proveedor', width: '8%' },
                  //{ text: 'Marca', datafield: 'marca', width: '9%' },
                  //{ text: 'Modelo', datafield: 'modelo', width: '9%' },
                  { text: 'Costo', datafield: 'costo', width: '10%',cellsformat: 'c2' },
                  { text: 'Iva', datafield: 'iva', width: '10%',cellsformat: 'p2' },
                  { text: 'Descuento', datafield: 'descuento',cellsformat: 'p2', width: '10%' },
                  { text: 'Estado', datafield: 'estado', width: '8%' },
                
                ]
                
            });
           }
           

</script>

 <div style="visibility: hidden; display:none;" id="jqxWidgetListaProductos">
  
			<div style="display:none;" id="eventListaProductos">
			<div>Lista de Producto y Servicios</div>
			<div>
				<div>
				<form id="formListaProductos">
				
					<table>
                    
                     <tr>
                        <td align="right">Categoria:</td>
	                    <td align="left"><div id="categoria"></div></td>
	                    <td align="left"><input style="margin-right: 5px;" type="button" id="btnProOk" value="Seleccionar" /></td>
	                    <td align="left"><input id="btnProCancel" type="button" value="Cancel" /></td>
	                    <td><a style='display:none;' id="frmpartitulo"></a></td>
                     </tr>
                     
	               </table>
                     <div id="jqxGridListaProductos"></div>
                     <!--<div id="jqxGridListaSubProductos">-->
                                 
				</form>
				 
				
				</div>
			</div>
	</div>		
 </div>

