<?php echo modules::run('login/menu_rol');?>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.filter.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.sort.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.pager.js"></script> 
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxpanel.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxlistbox.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdropdownlist.js"></script>
	<script type="text/javascript">
        $(document).ready(function () {
            var oper;
            var url = "<?php echo site_url("mar/tipos_clientes/ajax"); ?>";
            function menuopciones(){
			var opc_id=9;
			var view='tipo_cliente_view'
			var url="<?php echo site_url("seg/menus_opciones/menu"); ?>"+"/"+opc_id+"/"+view;
			  
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
			 $("#jqxMenu").jqxMenu({source: records, theme: "ui-start", autoSizeMainItems: true, showTopLevelArrows: true, width: '100%'});
             $("#jqxMenu").css("visibility", "visible");
             $("#jqxMenu").on('itemclick', function (event) {
             	  //alert($(event.args).text());
                    //$("#eventLog").text("Id: " + event.args.id + ", Text: " + $(event.args).text());
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
                        var url = "<?php echo site_url("mar/tipos_clientes/ajax"); ?>";
                        createElements();
						document.getElementById("form").reset();
						$("#eventWindow").jqxWindow('open');
						$("#id").val('New');
						$("#estado").val('AC');
						 
			       
		}  
		
		
		function opeditar(){
			         oper = 'edit';
			         var url = "<?php echo site_url("mar/tipos_clientes/ajax"); ?>"; 
                 	 var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                       
                        if (selectedrowindex >= 0 ) {
                           
                            var offset = $("#jqxgrid").offset();
                            // get the clicked row's data and initialize the input fields.
	                        var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex );
	                        // show the popup window.
	                        createElements();
							document.getElementById("form").reset();
							$("#id").val(dataRecord.id);
							$("#descripcion").val(dataRecord.descripcion);
							$("#estado").val(dataRecord.estado);
							$("#eventWindow").jqxWindow('open');
							
							
	                        }else{
	                        	jqxAlert.alert('Seleccione un registro','Editar');
	                        }
                      
      	}	
		
		function opborrar(){
			             oper = 'del';
			             var url = "<?php echo site_url("mar/tipos_clientes/ajax"); ?>";
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
		
            
            // prepare the data
            var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'id', type: 'string' },
                    { name: 'descripcion', type: 'string' },
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
            
            //crea menus de operaciones
            menuopciones();
      
        //Codigo de operaciones en la Grilla
			$("#jqxgrid").jqxGrid(
			{
            	width : '100%',
                source: dataAdapter,
				theme: "ui-start",
                sortable: true,
                //showfilterrow: true,
                filterable: true,
                //selectionmode: 'multiplecellsextended',
                //filtermode: 'excel',
                pageable: true,
                autoheight: true,
                ready: function () {
                    $("#jqxgrid").jqxGrid('sortby', 'id', 'asc');
                },
            columns: [
                { text: 'Id', datafield: 'id', width: '10%' },
                { text: 'Descripción', datafield: 'descripcion', width: '30%' },
				{ text: 'Fecha de creación', datafield: 'fecha_ing', width: '20%' },
                { text: 'Fecha de modificación', datafield: 'fecha_mod', width: '20%' },
                { text: 'Estado', datafield: 'estado', width: '20%' },
                 ]
                
            });
            
        //codigo para validacion de entradas
        $('#eventWindow').jqxValidator({
            hintType: 'label',
            animationDuration: 0,
            rules: [
                { input: '#descripcion', message: 'Descripción es requerido!', action: 'keyup, blur', rule: 'required' }
            ]
        });	
        
        //codigo para inicializacion del formulario
        function createElements() {
            $('#eventWindow').jqxWindow({
                  resizable: true,
                width: 300,
                height: 250,
                theme: "ui-start",
                minWidth: 200,
                minHeight: 200,
                isModal: true,
                modalOpacity: 0.01,    
                cancelButton: $("#btnCancel"),
                initContent: function () {
                    $('#id').jqxInput({disabled: true,width: '100px' });
					//$('#descripcion').jqxInput({width: '200px'});
                    $('#descripcion').jqxInput({width: '200px',placeHolder: "Ingrese descripcion" });
                    $('#estado').jqxInput({disabled: true, width: '20px'  });
                    $('#btnSave').jqxButton({width: '65px' });
                    $('#btnCancel').jqxButton({ width: '65px' });
                    $('#btnSave').focus();
                }
            });
            $('#eventWindow').jqxWindow('focus');
            $('#eventWindow').jqxValidator('hide');
        }

        // codigo para afectar la base por insert o update.
        $("#btnSave").click(function () {
            var validationResult = function (isValid) {
                if (isValid) {
                    var tipo_cliente = {  
                        accion: oper,
                        id: $("#id").val(),
                        descripcion: $("#descripcion").val(),
                        estado: $("#estado").val()
                    };		

                    $.ajax({
                        type: "POST",
                        url: url,
                        data: tipo_cliente,
                        success: function (data) {
                            if(data=true){
                                $("#eventWindow").jqxWindow('hide');
                                $("#jqxgrid").jqxGrid('updatebounddata');
                                //alert("El dato se grabó correctamente.");
                            }else{
                               // alert("Problemas al guardar.");
                            }
                        },
                        error: function (msg) {
                           // alert(msg.responseText);
                        }
                    });	
                }
            }
            $('#eventWindow').jqxValidator('validate', validationResult);    	
        });
       
    });
</script>
<div class='titnavbg'>
    <div class='titnavtit'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/seg.png">&nbsp;&nbsp;Marketing: Tipo Cliente</div>
    <div class='titnavlog'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/log_titulo.png"></div>
</div>
<div id="main">


      <div style='margin-left: 0px; margin-top: 5px;' id='jqxMenu'></div> 
      <div  style='margin-left: 0px; margin-top: 5px;' id="jqxgrid"></div>
   
      <div style="visibility: hidden; display:none;" id="jqxWidget">
  
        <div id="eventWindow">
            <div>Tipos de clientes</div>
            <div>
                <div>
                    <form id="form">
                        <table>
                            <tr>
                                <td align="right">Id:</td>
                                <td align="left"><input id="id"/></td>
                            </tr>
                            <tr>
                                <td align="right">Descripción:</td>
                                <td align="left"><input id="descripcion" /></td>
                            </tr>
                            <tr>
                                <td align="right">Estado:</td>
                                <td align="left"><input id="estado" /></td>
                            </tr>
                            <tr>
                                <td align="right"></td>
                                <td style="padding-top: 10px;" align="right"><input style="margin-right: 5px;" type="button" id="btnSave" value="Save" /><input id="btnCancel" type="button" value="Cancel" /></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
</div>
</div>