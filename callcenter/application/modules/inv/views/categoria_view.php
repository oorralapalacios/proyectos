 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.filter.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.sort.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.pager.js"></script> 
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxpanel.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxlistbox.js"></script>	
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdropdownlist.js"></script>	
    <script type="text/javascript">
        var tema= "ui-redmond";
        var oper;
        var url = "<?php echo site_url("inv/categorias/ajax"); ?>";
        
        $(document).ready(function () {
        	
        	//ejecuta funcion que llama a menu CRUD
        	var tid="<?php echo $_GET["tid"]; ?>";
          	menuopciones(tid);
        	//ejecuta funcion que carga grid
        	gridDatos();
        	//ejecuta funcion de validacion
        	validador();
        	
        	$("#btnSave").click(function () {
	           	 grabar();
	        })
         });
         	
          			
		function menuopciones(padre_id){
			var view='categoria_view'
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
                        createElements();
						document.getElementById("form").reset();
						$("#eventWindow").jqxWindow('open');
						$("#id").val('New');
						$("#estado").val('AC');
						
	                    
						
			       
		 }  
		
		
		function opeditar(){
			         oper = 'edit';
			         var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                       
                        if (selectedrowindex >= 0 ) {
                           
                            var offset = $("#jqxgrid").offset();
                            // get the clicked row's data and initialize the input fields.
	                        var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex );
	                        // show the popup window.
	                        createElements();
							document.getElementById("form").reset();
							$("#id").val(dataRecord.id);
							$("#nombre").val(dataRecord.nombre);
		                    $("#estado").val(dataRecord.estado);
							$("#eventWindow").jqxWindow('open');
							
							
	                        }else{
	                        	jqxAlert.alert('Seleccione un registro','Editar');
	                        }
                      
      	}	
		
		function opborrar(){
			             oper = 'del';
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
        function gridDatos(){
        	 var url = "<?php echo site_url("inv/categorias/ajax"); ?>";
            // prepare the data
            var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'id', type: 'number' },
                    { name: 'nombre', type: 'string' },
					 { name: 'fecha_ing', type: 'string' },
                    { name: 'fecha_mod', type: 'string' },
                    { name: 'estado', type: 'string' },
                    
                ],
                id: 'id',
                url: url,
               
               
            };
            var dataAdapter = new $.jqx.dataAdapter(source, {
                loadComplete: function (data) { },
                loadError: function (xhr, status, error) { }      
            });
			 
            //Codigo de operaciones en la Grilla
            $("#jqxgrid").jqxGrid(
            {
                width : '100%',
                height: '100%',
                source: dataAdapter,
				theme: tema,
                sortable: true,
                //showfilterrow: true,
                filterable: true,
                //selectionmode: 'multiplecellsextended',
                //filtermode: 'excel',
                pageable: true,
                //autoheight: true,
                ready: function () {
                    $("#jqxgrid").jqxGrid('sortby', 'id', 'asc');
                },
               
                columns: [
                  { text: 'Id', datafield: 'id', width: '10%' },
                  { text: 'Nombre', datafield: 'nombre', width: '35%' },
				  { text: 'Fecha de creación', datafield: 'fecha_ing', width: '15%' },
                  { text: 'Fecha de modificación', datafield: 'fecha_mod', width: '15%' },
                  { text: 'Estado', datafield: 'estado', width: '35%' },
              ]
                
            });
        	
         }   
         function validador(){
           	//codigo para validacion de entradas
            $('#eventWindow').jqxValidator({
             	hintType: 'label',
                animationDuration: 0,
                rules: [
                { input: '#nombre', message: 'Nombre es requerido!', action: 'keyup, blur', rule: 'required' }
                ]
            });	
          }
            
            //codigo para inicializacion del formulario
            function createElements() {
            $('#eventWindow').jqxWindow({
                resizable: true,
                width: 300,
                height: 200,
			    theme: tema,
                minWidth: 200,
                minHeight: 200,  
                isModal: true,
                modalOpacity: 0.01,
                //okButton: $('#btnSave'),
				cancelButton: $("#btnCancel"),
				initContent: function () {
					$('#id').jqxInput({theme:tema,disabled: true,width: '100px' });
					$('#nombre').jqxInput({theme:tema,width: '200px'});
					$('#estado').jqxInput({theme:tema,disabled: true, width: '20px'  });
                    $('#btnSave').jqxButton({theme:tema,width: '65px' });
                    $('#btnCancel').jqxButton({theme:tema,width: '65px' });
                    $('#btnSave').focus();
                }
            });
            $('#eventWindow').jqxWindow('focus');
            $('#eventWindow').jqxValidator('hide');
            
            }
            
            
          
            // codigo para afectar la base por insert o update.
	         function grabar(){
			    var validationResult = function (isValid) {
                    if (isValid) {
                       
                      var datos = {  
                       	accion: oper,
					   	id: $("#id").val(),
		                nombre: $("#nombre").val(),
		                estado: $("#estado").val()
		               };		
		               //alert(JSON.stringify(producto));
		               $.ajax({
			                type: "POST",
			                url: url,
			                 //data: JSON.stringify(producto),
			                data: datos,
			                //contentType: "application/json; charset=utf-8",
			                //dataType: "json",
			                success: function (data) {
								if(data=true){
									//alert("El dato se grabó correctamente.");
									//jqxAlert.alert ('El dato se grabó correctamente.');
									$("#eventWindow").jqxWindow('hide');
									$("#jqxgrid").jqxGrid('updatebounddata');
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
		
			}
        
           
       
    </script>
	
<div class="main">
	 <div class='titnavbg'>
	    <div class='titnavtit'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/inv.png">&nbsp;&nbsp;Inventario: Categorias</div>
	    <div class='titnavlog'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/log_titulo.png"></div>
	 </div>
      <div style='margin-left: 0px; margin-top: 5px;' id='jqxMenu'></div> 
      <div  style='margin-left: 0px; margin-top: 5px;' id="jqxgrid"></div>
</div>
<div style="visibility: hidden; display:none;" id="jqxWidget">
  
			<div id="eventWindow">
			<div>Categoria</div>
			<div>
				<div>
				<form id="form">
					<table>
                    
                    <tr>
                        <td align="right">Id:</td>
                        <td align="left"><input id="id"/></td>
                    </tr>
                    <tr>
                        <td align="right">Nombre:</td>
                        <td align="left"><input id="nombre" /></td>
                    </tr>
                     <tr>
                        <td align="right">Estado:</td>
                        <td align="left"><input id="estado" /></td>
                    </tr>
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

    