<?php echo modules::run('login/menu_rol');?>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.filter.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.sort.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.pager.js"></script> 
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxpanel.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.edit.js"></script> 
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.selection.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxlistbox.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdropdownlist.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdropdownbutton.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxcombobox.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxnumberinput.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxmaskedinput.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxtabs.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxradiobutton.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxbuttongroup.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxlistbox.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdropdownlist.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxeditor.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/otwidgets/validadoc.js"></script>
 

<script type="text/javascript">
    $(document).ready(function () {
        var oper;
        var url = "<?php echo site_url("mar/clientes/ajax"); ?>";
		
        var source =
        {
            datatype: "json",
            datafields: [
                { name: 'id', type: 'numeric' },
                //{ name: 'contacto_id', type: 'numeric' },
				{ name: 'descripcion', type: 'numeric' },
				{ name: 'tipo', type: 'numeric' },
                { name: 'genero', type: 'string' },
				{ name: 'ciudad', type: 'string' },
				{ name: 'identificacion', type: 'string' },
				{ name: 'nombres', type: 'string' },
				{ name: 'apellidos', type: 'string' },
				{ name: 'direccion', type: 'string' },
				{ name: 'observaciones', type: 'string' },
				{ name: 'estado', type: 'string' }
            ],
            id: 'id',
            url: url
        };
		
		
        var dataAdapter = new $.jqx.dataAdapter(source, {
            loadComplete: function (data) { },
            loadError: function (xhr, status, error) { }      
        });
		
		
		//Codigo de operaciones en la Grilla
        $("#jqxgrid").jqxGrid({
            width : '100%',
            source: dataAdapter,
			sortable: true,
            showfilterrow: true,
            filterable: true,
            pageable: true,
            showtoolbar: true,
            //Codigo para la barra de herramientas de la grilla
            rendertoolbar: function (toolbar) { 
                var me = this;
                var container = $("<div style='margin: 3px;'></div>");
                toolbar.append(container);
                //Codigo para boton Nuevo
                container.append('<div id="btnNuevo" style="float: left; position:relative; margin:auto;"><img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/iconue.png" />&nbsp;Nuevo</div>');
                $("#btnNuevo").jqxButton();
                $("#btnNuevo").bind('click', function () {
                    // show the popup window.
                    oper = 'add';
                    
                    $('#telefonosGrid').jqxGrid('clear');
                    $('#correosGrid').jqxGrid('clear');
                    createElementsNuevo();
                    gridContact();
					document.getElementById("fmprNuevo").reset();
                    $("#id").val('New');
					$("#direccion").val('');
                    $("#telefonosGrid").jqxGrid({ source: detalles()});
                    $("#correosGrid").jqxGrid({ source: detalles()});
                    $("#eventWindowNuevo").jqxWindow('open');
                    $("#estado").val('AC');
                    $('#label1').html('Identificaci&oacute;n:');
					$('#label2').html('Nombres:');
					$('#label3').html('Apellidos:');
					$('#tipo').val('Natural');
                });
                container.append('<div style="float: left;">&nbsp;</div>');
                //Codigo para boton reconsultar 
                container.append('<div id="btnReconsultar" style="float: left; position:relative; margin:auto;"><img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/icoref.png" />&nbsp;Reconsultar</div>');
                $("#btnReconsultar").jqxButton();
                $("#btnReconsultar").bind('click', function () {
                    // show the popup window.
                    $("#jqxgrid").jqxGrid('updatebounddata');
                });
				
            },
            columns: [
                { text: 'Id', datafield: 'id', width: '5%',hidden:true },
               	/*{ text: 'contacto_id', datafield: 'contacto_id', width: '5%',hidden:true },
				{ text: 'empleado_id', datafield: 'empleado_id', width: '5%',hidden:true },*/
				{ text: 'tipo', datafield: 'tipo', width: '5%',hidden:true },
				{ text: 'Tipo de cliente', datafield: 'descripcion', width: '10%' },
				//{ text: 'Campa&ntilde;a', datafield: 'campana', width: '10%' },
                { text: 'Identificacion', datafield: 'identificacion', width: '10%' },
				{ text: 'Nombres', datafield: 'nombres', width: '15%' },
				{ text: 'Apellidos', datafield: 'apellidos', width: '15%' },
				{ text: 'Genero', datafield: 'genero', width: '15%' },
				{ text: 'Ciudad', datafield: 'ciudad', width: '15%' },
				{ text: 'Direccion', datafield: 'direccion', width: '15%'},
				{ text: 'Observaciones', datafield: 'observaciones', width: '10%',hidden:true  },
				{ text: 'Estado', datafield: 'estado', width: '5%' },
                             
                //Codigo para arreglo de botones editar
                { text: 'Editar', datafield: 'Edit', columntype: 'button', width: '5%', cellsrenderer: function () {
                    return "Editar";
                    }, buttonclick: function (row) {
                        // open the popup window when the user clicks a button.
                        oper = 'edit';
                        editrow = row;
                        var offset = $("#jqxgrid").offset();
                        // get the clicked row's data and initialize the input fields.
                        var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', editrow);
                        // show the popup window.
                        createElementsNuevo();
                        $("#id").val(dataRecord.id);
                        $("#tipo_cliente").val(dataRecord.cliente_tipo_id);
                        /*$("#empleado_idN").val(dataRecord.empleado_id);
						$("#campana_idN").val(dataRecord.campana_id);*/
						$("#identificacion").val(dataRecord.identificacion);
						$("#nombre").val(dataRecord.nombres);
						$("#apellido").val(dataRecord.apellidos);
						$("#direccion").val(dataRecord.direccion);
						$("#telefono").val(dataRecord.telefono);
						$("#email").val(dataRecord.email);
                        $("#estado").val(dataRecord.estado);
                        $("#telefonosGrid").jqxGrid({ source: detalles(dataRecord.contacto_id,'telefono')});
                        $("#correosGrid").jqxGrid({ source: detalles(dataRecord.contacto_id,'email')});
						$("#eventWindowNuevo").jqxWindow('open');
                    }
                },
                //Codigo para arreglo de botones borrar
                { text: 'Borrar', datafield: 'Borrar', columntype: 'button', width: '5%', cellsrenderer: function () {
                    return "Borrar";
                    }, buttonclick: function (row) {
                        oper = 'del';
                        editrow = row;
                        var offset = $("#jqxgrid").offset();
                        var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', editrow);
                        var contacto = {
                            accion: oper,
                            id: dataRecord.id
                        };
						jqxAlert.verify('Esta seguro de Borrar?','Dialogo de confirmacion', function(r) {
					    if(r){
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: contacto,
                            success: function (data) {
                                if(data=true){
                                    $("#eventWindowNuevo").jqxWindow('hide');
                                    $("#jqxgrid").jqxGrid('updatebounddata');
                                    //alert("El dato se Elimin? correctamente.");
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
					}
                } 
            ]
        });
       
     
		
		//codigo para validacion de entradas
        $('#eventWindowNuevo').jqxValidator({
            hintType: 'label',
            animationDuration: 0,
            rules: [
                { input: '#identificacion', message: 'Identificaci?n debe tener 10 caracteres!', action: 'keyup, blur', rule: 'length=10,10' },
				{ input: '#nombre', message: 'Nombres es requerido!', action: 'keyup, blur', rule: 'required' },
				{ input: '#apellido', message: 'Apellidos es requerido!', action: 'keyup, blur', rule: 'required' },
				//{ input: '#telefono', message: 'Telefono es requerido!', action: 'keyup, blur', rule: 'required' },
				{ input: '#direccion', message: 'Direccion es requerido!', action: 'keyup, blur', rule: 'required' }
				//{ input: '#email', message: 'E-mail es requerido!', action: 'keyup, blur', rule: 'email' }
            ]
        });	
        
                
       
			
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
			
			function detalleContac(identificacion) {
               var url="<?php echo site_url("mar/clientes/buscar_contacto"); ?>"+"/"+identificacion;
               var source ={
						                datatype: "json",
						                datafields: [
													{ name: 'id' },
													{ name: 'identificacion' },
													{ name: 'tipo' },
													{ name: 'nombres'},
													{ name: 'apellidos' },
													{ name: 'ciudad' },
													{ name: 'direccion' }
													],
						                id: 'id',
						                url: url,
						            };
			             
                   
                 var dataAdapter = new $.jqx.dataAdapter(source);
									         
               return dataAdapter;
           
            }
			      //funcion que carga los datos de detalle de tarifas de los productos en el grid
            function detalles(conta_id,tipo) {
               var url="<?php echo site_url("mar/contactos/detalle"); ?>"+"/"+conta_id+"/"+tipo;
               var source ={
						                datatype: "json",
						                datafields: [
													{ name: 'id' },
													{ name: 'contacto_id' },
													{ name: 'campo', value: 'campo_id', values: { source: campos(tipo), value: 'id', name: 'campo' } },
													{ name: 'campo_id' },
													{ name: 'valor' },
													{ name: 'estado' }
													],
						                id: 'id',
						                url: url,
						            };
			             
                   
                 var dataAdapter = new $.jqx.dataAdapter(source);
									         
               return dataAdapter;
           
            }
            
            
            function DirectorioContacto(conta_id,identificacion,apellidos,nombres) {
               //$("#frmVisualizar").empty();
               var tipo='Telefono'
               var url="<?php echo site_url("mar/contactos/detalleAll"); ?>"+"/"+conta_id;
               
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
				  					         
               //return dataAdapter;
             //dataAdapter.dataBind();
              // Create jqxListBox
             $("#datosTelefonos").jqxDropDownList({/*selectedIndex: 0,*/ source: dataAdapter, displayMember: "valor", valueMember: "tipo", width: 250, height: 200,
             renderer: function (index, label, value) {
               var item = dataAdapter.records[index];
               var imgurl; 
               imgurl='<?php echo base_url(); ?>assets/img/call.png';
               var img = '<img height="25" width="25" src="' + imgurl + '"/>';
             	var table = '<table style="min-width: 130px;"><tr><td style="width: 80px;">' + img + '</td><td>' + datarecord.tipo + '</td></tr><tr><td>' + datarecord.valor + '</td></tr></table>';
             	return table
             }	
             });
           
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
				  					         
               //return dataAdapter;
             //dataAdapter.dataBind();
              // Create jqxListBox
             $("#datosTelefonos").jqxDropDownList({/*selectedIndex: 0,*/ source: dataAdapter, displayMember: "valor", valueMember: "tipo", width: 250, height: 30,
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
				  					         
               //return dataAdapter;
             //dataAdapter.dataBind();
              // Create jqxListBox
              
             
             $("#datosMails").jqxDropDownList({/*selectedIndex: 0,*/ source: dataAdapter, displayMember: "valor", valueMember: "tipo", width: 250, height: 30,
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
		
		
		var sourcetipo =
					{
						datatype: "json",
						datafields: [
							{ name: 'id' },
							{ name: 'descripcion'}
						 ],
						url: "<?php echo site_url("mar/tipos_clientes/ajax"); ?>",
						async: false
					};
					var dar = new $.jqx.dataAdapter(sourcetipo);
		
		 function createElementsNuevo() {
            $('#eventWindowNuevo').jqxWindow({
                resizable: false,
                width: 650,
                height: 570,
                minHeight: 420,  
                isModal: true,
                modalOpacity: 0.01, 
                cancelButton: $("#btnCancel"),
                initContent: function () {
                $('#jqxTabs1').jqxTabs({ width: '100%',height: "50%"});
				$('#id').jqxInput({disabled: true,width: '30px' });
				
				   $("#tipo_cliente").jqxDropDownList({
						source: dar,
						width: 180,
						selectedIndex: 0,
						displayMember: "descripcion", 
						valueMember: "id"});  
						  
				$('#tipo_cliente').on('select', function (event)
					{
						var args = event.args;
						if (args) {
						// index represents the item's index.                
						var index = args.index;
						var item = args.item;
						// get item's label and value.
						var label = item.label;
						var value = item.value;
						$('#tipo').val(label);
						if (label=='Natural'){
							$('#label1').html('Identificaci&oacute;n:');
							$('#label2').html('Nombres:');
							$('#label3').html('Apellidos:');
						}else{
							$('#label1').html('RUC:');
							$('#label2').html('Raz&oacute;n Social:');
							$('#label3').html('Nombre Comercial:');
						}
					}                        
				});

				$("#femenino").jqxRadioButton({ width: 250, height: 25});
            		$("#masculino").jqxRadioButton({ width: 250, height: 25});
					//$('#genero').jqxInput({width: '20px',hidden:true});
					$("#femenino").on('checked', function () {
							  $("#genero").val('F');
					});
					
					$("#masculino").on('checked', function () {
							   $("#genero").val('M');
					});
				$('#identificacion').jqxInput({width: '150px' });
			    $('#nombre').jqxInput({width: '500px'});
			    $('#apellido').jqxInput({width: '500px'});
			    $('#direccion').jqxEditor({width: '500px',height: '50px', tools: ''});
			    $('#ciudad').jqxInput({width: '500px'});
				$('#estado').jqxInput({disabled: true, width: '20px'  });
				$("#estado").val('AC');
				$('#btnSave').jqxButton({width: '65px' });
				$('#btnCancel').jqxButton({ width: '65px' });
				
				gridTelefonos();
				gridCorreos();
			
                $('#btnSave').focus();
                }
            });
            $('#eventWindowNuevo').jqxWindow('focus');
            $('#eventWindowNuevo').jqxValidator('hide');
        }
        
        
           
        function gridTelefonos(){
        		$("#telefonosGrid").jqxGrid(
		            {
		                width: 500,
		                height: 135,
		                //source: detalles(),
		                editable: true,
		                /*ready: function()
	                    {
	                        $("#telefonosGrid").jqxGrid('selectcell', 0, 'ShipName');
	                        // focus jqxgrid.
	                        $("#telefonosGrid").jqxGrid('focus');
	                    },*/
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
		                   container.append('<div id="addButtont" style="float: left; position:relative; margin:auto;"><img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/iconue.png" />&nbsp;Nuevo</div>');
		                   $("#addButtont").jqxButton();
		                   $("#addButtont").bind('click', function () {
		                       
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
			                  	  
			                              var selectedrowindex = $("#telefonosGrid").jqxGrid('getselectedrowindex');
			                               var rowscount = $("#telefonosGrid").jqxGrid('getdatainformation').rowscount;
			                               if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			                               var id = $("#telefonosGrid").jqxGrid('getrowid', selectedrowindex);
			                               var commit = $("#telefonosGrid").jqxGrid('deleterow', id);
			                               }
								 
			                  }
			                 }  
		                    
		                    
		                ]
		            });
        }
        
        function gridContact(){
        		$("#gridContactos").jqxGrid(
		            {
		                width: 640,
		                height: 120,
		                //source: detalleContac(identificacion),
		                editable: true,
		                showtoolbar: true,
		                rendertoolbar: function (toolbar) { 
		                  var me = this;
		                  var container = $("<div style='overflow: hidden; position: relative; margin: 5px;'></div>");
		                  toolbar.append(container);
		                  //Codigo para boton Nuevo
						   
						   container.append('<div id="btnSearch" style="float: left; margin-left: 5px;"><img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/icover.png" />&nbsp;Buscar</div>&nbsp;');
						   container.append('<input id="identificacionB"/>');
						   
						   $("#identificacionB").jqxInput({placeHolder: "Identificacion",width: '120px',height:'23px', minLength: '10'});
		                   $("#btnSearch").jqxButton({  width: 80, height: 17 });
						   $("#btnSearch").bind('click', function () {
		                       
							  	var identificacion = $("#identificacionB").val();
								detalleContac(identificacion);
								var datos = detalleContac(identificacion);
								$("#gridContactos").jqxGrid({ source: detalleContac(identificacion)});
								
		                    });
		                    
		                },
						//source: resultado,
		                columns: [
		                    { text: 'Id', datafield: 'id', width: 0, hidden:true },
		                    { text: 'Identificacion', datafield: 'identificacion', width: '120px'},
		                    { text: 'Nombres', datafield: 'nombres', width: '35%' },
		                    { text: 'Apellidos', datafield: 'apellidos', width: '35%' },  
		                    { text: 'Tipo', datafield: 'tipo', width: '20%' },
		                    { text: 'Direccion', datafield: 'direccion', width: '35%' },
							 { text: 'Cargar Datos', datafield: 'Cargar', columntype: 'button', width: '10%', cellsrenderer: function () {
								return "Cargar";
								}, buttonclick: function (row) {
									// open the popup window when the user clicks a button.
									//oper = 'edit';
									editrow = row;
									var offset = $("#gridContactos").offset();
									// get the clicked row's data and initialize the input fields.
									var dataRecord = $("#gridContactos").jqxGrid('getrowdata', editrow);
									// show the popup window.
									//createElements();
									//document.getElementById("fmpr").reset();
									$("#id").val(dataRecord.id);
									$("#identificacion").val(dataRecord.identificacion);
									$("#nombre").val(dataRecord.nombres);
									$("#apellido").val(dataRecord.apellidos);
									$("#ciudad").val(dataRecord.ciudad);
									$("#direccion").val(dataRecord.direccion);
									$("#tipo_cliente").val(dataRecord.tipo);
									$("#estado").val(dataRecord.estado);
									//$("#eventWindow").jqxWindow('open');
								}
							}
		                ]
		            });
        }
		
		
		
        function gridCorreos(){
        	$("#correosGrid").jqxGrid(
		            {
		                width: 500,
		                height: 135,
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
		                   container.append('<div id="addButtonc" style="float: left; position:relative; margin:auto;"><img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/iconue.png" />&nbsp;Nuevo</div>');
		                   $("#addButtonc").jqxButton();
		                   $("#addButtonc").bind('click', function () {
		                       
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
			                  	  
			                              var selectedrowindex = $("#correosGrid").jqxGrid('getselectedrowindex');
			                               var rowscount = $("#correosGrid").jqxGrid('getdatainformation').rowscount;
			                               if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			                               var id = $("#correosGrid").jqxGrid('getrowid', selectedrowindex);
			                               var commit = $("#correosGrid").jqxGrid('deleterow', id);
			                               }
								 
			                  }
			                 }  
		                    
		                    
		                ]
		            });
        }
        
        
        
                   
	   // codigo para afectar la base por insert o update.
        $("#btnSave").click(function () {
		
			var validationResult = function (isValid) {
                if (isValid) {
                    var contacto = {  
                        accion: oper,
                        id: $("#id").val(),
                        tipo_cliente: $("#tipo_cliente").val(),
						tipo: $("#tipo").val(),
						identificacion: $("#identificacion").val(),
						nombres: $("#nombre").val(),
						apellidos: $("#apellido").val(),
						genero: $("#genero").val(),
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
							//alert(data);
							if(data=true){
                                $("#eventWindowNuevo").jqxWindow('hide');
                                $("#jqxgrid").jqxGrid('updatebounddata');
                                //alert("El dato se grab? correctamente.");
                                //jqxAlert.alert ('El dato se grab� correctamente.');
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
        
		
        

    });
    
</script>
<div class='titnavbg'>
    <div class='titnavtit'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/seg.png">&nbsp;&nbsp;Marketing: Clientes</div>
    <div class='titnavlog'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/log_titulo.png"></div>
</div>
<div id="main">
	<div id="jqxgrid"></div>
	<div style="visibility: hidden;" id="jqxWidget">
       	<div id="eventWindowNuevo">
            <div>Clientes</div>
            <div>
                <div>
						<div id="gridContactos"></div>
				<div id='jqxTabs1'>
			                <ul>
			                  <li style="margin-left: 30px;">Informacion</li>
							  <li style="margin-left: 30px;">Telefonos</li>
			                  <li>Correos</li>
			                </ul>
					<div>
                    <form id="fmprNuevo" method="post">
                    	<!--<input name="contacto_idN" style="margin-top: 5px;"  type="hidden" id="contacto_idN"/>-->
                        <table>
                            <tr>
							<td align="right">Id:</td>
							<td align="left"> <input name="id" style="margin-top: 5px;" id="id"/></td>
							</tr>
							
                            <tr>
                                <td align="right">Tipo de Cliente:</td>
                                <td align="left" colspan="2"><div id="tipo_cliente"></div><input type="hidden" name="tipo" id="tipo"/></td>
                            </tr>
							<tr>
							<td align="right"><div id="label1"></div></td>
							<td align="left"> <input name="identificacion" style="margin-top: 5px;" id="identificacion"/></td>
							</tr>
							<tr>
								<td align="right"><div id="label2"></div></td>
								<td align="left"> <input name="nombre" style="margin-top: 5px;" id="nombre"/></td>
							</tr>
							<tr>
								<td align="right"><div id="label3"></div></td>
								<td align="left"> <input name="apellido" style="margin-top: 5px;" id="apellido"/></td>
							</tr>
							<tr>
                                <td align="right">Genero:</td>
                                <td align="left"><div style="margin-top: 10px;">
											<div style="margin: 3px;" id="femenino">
												Femenino</div>
											<div style="margin: 3px;" id="masculino">
												Masculino</div>
										</div></td><td align="left"><input id="genero" hidden="true" /></td>
                            </tr>
							<tr>
								<td align="right">Ciudad:</td>
								<td align="left"> <input name="ciudad" style="margin-top: 5px;" id="ciudad"/></td>
							 
							</tr>
							<tr>
								<td align="right">Direccion:</td>
								<td align="left"> <input name="direccion" style="margin-top: 5px;" id="direccion"/></td>
							 
							</tr>
							<tr>
								<td align="right">Estado:</td>
								<td align="left"><input id="estado" /></td>
							</tr>
						
							</table>
							</div>
			                <div>
                        	  <table>
                        	    <tr>
		                        <td align="left"><div id="telefonosGrid"></div></td>
		                        </tr>
                    		  </table>
			                </div>
			                <div>
                        	  <table>
                        	    <tr>
		                        <td align="left"><div id="correosGrid"></div></td>
                    		    </tr>
                    		  </table>
			                </div>
			               </div>
                          
                           <table>
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