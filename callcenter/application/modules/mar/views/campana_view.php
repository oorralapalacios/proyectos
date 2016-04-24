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
<script type="text/javascript" src="<?php echo base_url();?>assets/otwidgets/validadoc.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.columnsresize.js"></script>
<script type="text/javascript">
   var tema= "ui-redmond";
   var oper;
   var operEsc;
   var operRes;
   var url = "<?php echo site_url("mar/campanas/ajax"); ?>";
   var urlpreg = "<?php echo site_url("mar/preguntas/ajax"); ?>";
    $(document).ready(function () {
       
        var tid="<?php echo $_GET["tid"]; ?>";
       	menuopciones(tid);
        gridMainCampanas();
        createElements();
        
	  
        
        //codigo para validacion de entradas
       
        
        
        $('#eventWindowEscala').jqxValidator({
            hintType: 'label',
            animationDuration: 0,
            rules: [
                { input: '#inpescala', message: 'Nombre es requerido!', action: 'keyup, blur', rule: 'required' },
                //{ input: '#cboipopregunta', message: 'Tipo es requerido!', action: 'keyup, blur', rule: 'required' }
                 
            ]
        });	
        
        $('#eventWindowRespuesta').jqxValidator({
            hintType: 'label',
            animationDuration: 0,
            rules: [
                { input: '#inrordenrespuesta', message: 'Orden es requerido!', action: 'keyup, blur', rule: 'required' },
                { input: '#inropcion', message: 'Opcion es requerido!', action: 'keyup, blur', rule: 'required' }
                
            ]
        });	
        
        
        $("#removeButton").click( function () {
                        var selectedrowindex = $("#productosGrid").jqxGrid('getselectedrowindex');
                        var rowscount = $("#productosGrid").jqxGrid('getdatainformation').rowscount;
                        if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
                            var id = $("#productosGrid").jqxGrid('getrowid', selectedrowindex);
                            var commit = $("#productosGrid").jqxGrid('deleterow', id);
                        }
                   //jqxAlert.alert ('Borrar detalle.');
                 
       }); 

       $("#btnAddPar").click(function (){
       		var objGrid= $("#parametrosGrid").jqxGrid();
		   //alert('Nuevo');                
		                       
						 	  	  var datarow = {
			                	   id: 'New'
			                     		                       
			                       
			                   };
			                  //jqxAlert.alert ('Nuevo detalle.');
			                  var commit = objGrid.jqxGrid('addrow', null, datarow);
								
		 });
        
        // codigo para afectar la base por insert o update.
        $("#btnSave").click(function () {
            var validationResult = function (isValid) {
                if (isValid) {
                    var campana = {  
                        accion: oper,
                        id: $("#id").val(),
                        nombre: $("#nombre").val(),
                        descripcion: $("#descripcion").val(),
                        dialogo_llamada: $("#dialogo_llamada").val(),
                        texto_mail: $("#texto_mail").val(),
                        estado: $("#estado").val(),
                        productos: $("#productosGrid").jqxGrid('getrows'),
                        formapago: $("#formaPagoGrid").jqxGrid('getrows'),
                        preaprobacion: $("#preaprobacionGrid").jqxGrid('getrows'),
                        texto_rechazo: $("#texto_rechazo").val(),
                        texto_cobertura: $("#texto_cobertura").val(),
                        nointeres: $("#noInteresGrid").jqxGrid('getrows'),
                        preguntas: $("#preguntasGrid").jqxGrid('getrows'),
                          
                    };		

                    $.ajax({
                        type: "POST",
                        url: url,
                        data: campana,
                        success: function (data) {
                            if(data=true){
                                $("#eventWindow").jqxWindow('hide');
                                $("#jqxgrid").jqxGrid('updatebounddata');
                                //jqxAlert.alert("El dato se grabó correctamente.");
                            }else{
                                jqxAlert.alert("Problemas al guardar.");
                            }
                        },
                        error: function (msg) {
                            alert(msg.responseText);
                        }
                    });	
                }
            }
            $('#eventWindow').jqxValidator('validate', validationResult);    	
        });
        
        
        
      
       
		
		
		$("#cboipopregunta").jqxComboBox({promptText: "Seleccionar Escala:", source: customersAdapter(), displayMember: "tipo", valueMember: "id"});        
        $("#cborescala").jqxComboBox({promptText: "Seleccionar Escala:", source: datos_escalas(2), displayMember: "nombre", valueMember: "id"});        
        //cborescala.jqxComboBox({ source: datos_escalas(valuet), displayMember: 'nombre', valueMember: 'id' });
		 
	  
		// codigo para afectar la base por insert o update.
        $("#btnSavePregunta").click(function () {
            
				    var pregunta = {  
                        accion: oper,
                        //id: $("#id").val(),
                        orden: $("#orden").val(),
                        detalle_pregunta: $("#detalle_pregunta").val(),
						tipo_respuesta_id: $("#tipo_respuesta_id").val(),
                        obligatorio: $("#obligatorio").val()
                    };		

                    $.ajax({
                        type: "POST",
                        url: urlpreg,
                        data: pregunta,
                        success: function (data) {
                            if(data=true){
                                $("#eventWindowNuevo").jqxWindow('hide');
                                $("#preguntasGrid").jqxGrid('updatebounddata');
                                //jqxAlert.alert("El dato se grabó correctamente.");
                            }else{
                                jqxAlert.alert("Problemas al guardar.");
                            }
                        },
                        error: function (msg) {
                            alert(msg.responseText);
                        }
                    });	
             //   }
           // }
           // $('#eventWindow').jqxValidator('validate', validationResult);    	
        });
        
        
            $("#btnSaveEscala").click(function () {
          	    var url = "<?php echo site_url("mar/campanas/saveEscala"); ?>";
				var validationResult = function (isValid) {
                if (isValid) {
									var escala = {  
										accion: operEsc,
										id: $("#idescala").val(),
										tipo_pregunta_id: $("#cboipopregunta").val(),
										nombre_escala: $("#inpescala").val(),
										opcion_otro: $("#chkoptotro").val(),
										multiple_respuesta: $("#chkmultresp").val()  
										
									};		
									$.ajax({
										type: "POST",
										url: url,
										data: escala,
										success: function (data) {
											if(data=true){
											    $("#escalasGrid").jqxGrid('updatebounddata');
												$("#opcionesGrid").jqxGrid('updatebounddata');
												$("#eventWindowEscala").jqxWindow('hide');
                              				   //jqxAlert.alert("El dato se grabó correctamente.");
											}else{
												jqxAlert.alert("Problemas al guardar.");
											}
										},
										error: function (msg) {
											alert(msg.responseText);
										}
									});	
                }
            }
            $('#eventWindowEscala').jqxValidator('validate', validationResult);    	
        });
        
       
        
        
          $("#btnSaveRespuesta").click(function () {
          	       //alert('graba');
                   var url = "<?php echo site_url("mar/campanas/saveOpcion"); ?>";
				   var validationResult = function (isValid) {
                   if (isValid) {
									var escala = {  
										accion: operRes,
										id: $("#idrespuesta").val(),
										orden: $("#inrordenrespuesta").val(),
										escalas_id: $("#cborescala").val(),
										detalle: $("#inropcion").val()
														
									};		
									$.ajax({
										type: "POST",
										url: url,
										data: escala,
										success: function (data) {
											if(data=true){
											 	$("#opcionesGrid").jqxGrid('updatebounddata');
											 	$("#eventWindowRespuesta").jqxWindow('hide');
											}else{
												jqxAlert.alert("Problemas al guardar.");
											}
										},
										error: function (msg) {
											alert(msg.responseText);
										}
									});	
                }
            }
            $('#eventWindowRespuesta').jqxValidator('validate', validationResult);    	
        });
       
    });
    
    
    var createElements=function() {
            $('#jqxTabs').jqxTabs({ width: '100%',height: "70%",theme: tema});
            
            initProductosGrid();
		    initFormaPagoGrid();
		    initPreaprobacionGrid();
		    initNoInteresGrid();
		    initPreguntasGrid();
		    
		   
        	$('#eventWindow').jqxWindow({
        		//resizable: false,
                width: '100%',
                height: '100%',
				theme: tema,
                minWidth: 550,
                isModal: true,
                modalOpacity: 0.01, 
                minHeight: 400,  
                autoOpen: false,
				cancelButton: $("#btnCancel"),
                initContent: function () {
                    $('#id').jqxInput({disabled: true,width: '100px',theme: tema });
                	$('#nombre').jqxInput({width: '500px',theme: tema,placeHolder: "Ingrese nombre" });
                    $('#descripcion').jqxInput({width: '100%',height: '40px',theme: tema});
                    $('#dialogo_llamada').jqxEditor({width:'100%',height: '350px',theme: tema});
                    $('#texto_mail').jqxEditor({width:'100%',height: '350px',theme: tema});
                    $('#texto_rechazo').jqxInput({width:'100%',height: '50px',theme: tema});
                    $('#texto_cobertura').jqxInput({width:'770px',height: '330px',theme: tema});
                    $('#estado').jqxInput({disabled: true, width: '20px',theme: tema});
                    $('#btnSave').jqxButton({width: '65px',theme: tema });
                    $('#btnCancel').jqxButton({ width: '65px',theme: tema });
                                   
                    //configuracion del grid de detalle
                    //$('#dialogo_llamada').val('');
                    //$('#texto_mail').val('');
                    
                     $('#eventWindow').jqxValidator({
			            hintType: 'label',
			            animationDuration: 0,
			            rules: [
			                { input: '#nombre', message: 'Nombre es requerido!', action: 'keyup, blur', rule: 'required' },
			                //{ input: '#descripcion', message: 'Descripción es requerido!', action: 'keyup, blur', rule: 'required' }
			            ]
			        });	
		           
                    $('#btnSave').focus();
                }
            });
            $('#eventWindow').jqxWindow('focus');
            $('#eventWindow').jqxValidator('hide');
        }
        
        	function menuopciones(padre_id){
			
			//var view='campana_view';
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
        
        
        var opnuevo=function(){
			
                        oper='add';
                        var url = "<?php echo site_url("mar/campanas/ajax"); ?>";
                     
						//createElements();
						//document.getElementById("frmCampana").reset();
						$("#id").val('New');
                        $("#nombre").val('');
                        $("#descripcion").val('');
                        $("#dialogo_llamada").val('');
                        $("#texto_mail").val('');
                        $("#texto_rechazo").val('');
                        $("#texto_cobertura").val('');
                        $("#estado").val('AC');
                        $("#productosGrid").jqxGrid({ source: detalles()});
						$("#formaPagoGrid").jqxGrid({ source: campana_formapago()});
						$("#preaprobacionGrid").jqxGrid({ source: campana_preaprobacion()});
						$("#noInteresGrid").jqxGrid({ source: campana_nointeres()});
						$("#preguntasGrid").jqxGrid({ source: preguntas_datos()});
                        $("#eventWindow").jqxWindow('open');
			       
		}  
		
			var opeditar = function(){
			         oper = 'edit';
			         var url = "<?php echo site_url("mar/campanas/ajax"); ?>"; 
                 	 var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                       
                        if (selectedrowindex >= 0 ) {
                           
                            var offset = $("#jqxgrid").offset();
                            // get the clicked row's data and initialize the input fields.
	                        var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex );
	                        // show the popup window.
	                       	//createElements();
							//document.getElementById("frmCampana").reset();
						   	$("#id").val(dataRecord.id);
							$("#nombre").val(dataRecord.nombre);
							$("#descripcion").val(dataRecord.descripcion);
							document.getElementById("dialogo_llamada").defaultValue =dataRecord.dialogo_llamada;
							$("#dialogo_llamada").val(dataRecord.dialogo_llamada);
							document.getElementById("texto_mail").defaultValue =dataRecord.texto_mail;
							$("#texto_mail").val(dataRecord.texto_mail);
							$("#texto_rechazo").val(dataRecord.texto_rechazo);
						    $("#texto_cobertura").val(dataRecord.texto_cobertura);
							$("#estado").val(dataRecord.estado);
							$("#productosGrid").jqxGrid({ source: detalles(dataRecord.id)});
							$("#formaPagoGrid").jqxGrid({ source: campana_formapago(dataRecord.id,1)});
							$("#preaprobacionGrid").jqxGrid({ source: campana_preaprobacion(dataRecord.id,2)});
							$("#noInteresGrid").jqxGrid({ source: campana_nointeres(dataRecord.id,3)});
							$("#preguntasGrid").jqxGrid({ source: preguntas_datos(dataRecord.id)});
							$("#eventWindow").jqxWindow('open');
							
														
	                        }else{
	                        	jqxAlert.alert('Seleccione un registro','Editar');
	                        }
                      
      	}	
      	
      	function opborrar(){
			             oper = 'del';
			             var url = "<?php echo site_url("mar/campanas/ajax"); ?>";
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
		
		
		function initProductosGrid(){
       	 $("#productosGrid").jqxGrid(
		            {
		                width: 770,
		                height: 350,
		                theme: tema,
		                //source: detalles(),
		                editable: true,
		                keyboardnavigation: false,
		                //showstatusbar: true,
		                //statusbarheight: 25,
		                //showaggregates: true,
		                 showtoolbar: true,
		                 rendertoolbar: function (toolbar) { 
		                  var me = this;
		                  var container = $("<div style='margin: 5px;'></div>");
		                  toolbar.append(container);
		                  //Codigo para boton Nuevo
		                   container.append('<div id="addButton" style="float: left; position:relative; margin:auto;"><img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/iconue.png" />&nbsp;Nuevo</div>');
		                   $("#addButton").jqxButton({theme: tema});
		                   $("#addButton").bind('click', function () {
		                       
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
			                  var commit = $("#productosGrid").jqxGrid('addrow', null, datarow);
								
		                    });
		                    
		                    
		                    
		                },
		                columns: [
		                    { text: 'Id', datafield: 'id', width: 0, hidden: true},
		                    { text: 'Producto/Servicio', datafield: 'producto_id',  displayfield: 'producto',  columntype: 'combobox', 
		                        initeditor: function (row, value, editor) {
		                            editor.jqxComboBox({ source: dataAdapterProductos(), displayMember: 'nombre', valueMember: 'id' });
		                        }                      
		                   },
		                      { text: 'Borrar', datafield: 'Borrar', width: 80, columntype: 'button',id:'number', cellsrenderer: function () {
			                     return "Borrar";
			                      //return '<div style="width: 100%"><img src="../../../Custom Images/pencil.png" style="margin-left: 25%" /></div>';
			                      //return '<div id="removeButton" style="float: left; position:relative; margin:auto;"><img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/icobor.png" />&nbsp;Borrar</div>';
			                  }, buttonclick: function (row) {
			                  	          /*
			                              var selectedrowindex = $("#productosGrid").jqxGrid('getselectedrowindex');
			                               var rowscount = $("#productosGrid").jqxGrid('getdatainformation').rowscount;
			                               if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			                               var id = $("#productosGrid").jqxGrid('getrowid', selectedrowindex);
			                               var commit = $("#productosGrid").jqxGrid('deleterow', id);
			                               }*/
			                               
			                               var selectedrowindex = $("#productosGrid").jqxGrid('getselectedrowindex');
			                               var rowscount = $("#productosGrid").jqxGrid('getdatainformation').rowscount;
			                               if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			                               var dataRecord = $("#productosGrid").jqxGrid('getrowdata', selectedrowindex);
			                               if (dataRecord.id) {
			                                 borrarItemsProductos(dataRecord.id);
			                               } 
			                               var id = $("#productosGrid").jqxGrid('getrowid', selectedrowindex);
			                               //alert(dataRecord.id);
			                                var commit = $("#productosGrid").jqxGrid('deleterow', id);
			                               
			                               }
								 
			                  }
			                 }  
		                    
		                    
		                ]
		            });
       }
       
       function borrarItemsProductos(id) {
        	    oper='delpro';
          	    var url = "<?php echo site_url("mar/campanas/ajax"); ?>";
				
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
											    $("#productosGrid").jqxGrid('updatebounddata');
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
	
	   function initFormaPagoGrid(){
             
            
         $("#formaPagoGrid").jqxGrid(
		            {
		                width: 770,
		                height: 350,
		                //source: detalles(),
		                editable: true,
		                theme: tema,
		                keyboardnavigation: false,
		                //showstatusbar: true,
		                //statusbarheight: 25,
		                //showaggregates: true,
		                 showtoolbar: true,
		                 rendertoolbar: function (toolbar) { 
		                  var me = this;
		                  var container = $("<div style='margin: 5px;'></div>");
		                  toolbar.append(container);
		                  //Codigo para boton Nuevo
		                   container.append('<div id="addFormaPago" style="float: left; position:relative; margin:auto;"><img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/iconue.png" />&nbsp;Nuevo</div>');
		                   $("#addFormaPago").jqxButton({theme: tema});
		                   $("#addFormaPago").bind('click', function () {
		                       
							  	  var datarow = {
			                  	   id: 'New'
			                     
			                       
			                       
			                   };
			                  //jqxAlert.alert ('Nuevo detalle.');
			                  var commit = $("#formaPagoGrid").jqxGrid('addrow', null, datarow);
								
		                    });
		                    
		                    
		                    
		                },
		                columns: [
		                    { text: 'Id', datafield: 'id', width: 0, hidden: true},
		                    { text: 'Parametro', datafield: 'parametro_id',  displayfield: 'descripcion',  columntype: 'combobox', 
		                        initeditor: function (row, value, editor) {
		                        	
		                        	 editor.jqxComboBox({ source: adpformasPago(), displayMember: 'descripcion', valueMember: 'id' });
		                        }                      
		                   },
		                      { text: 'Borrar', datafield: 'Borrar', width: 80, columntype: 'button',id:'number', cellsrenderer: function () {
			                     return "Borrar";
			                     }, buttonclick: function (row) {
			                  	          /*
			                              var selectedrowindex = $("#formaPagoGrid").jqxGrid('getselectedrowindex');
			                               var rowscount = $("#formaPagoGrid").jqxGrid('getdatainformation').rowscount;
			                               if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			                               var id = $("#formaPagoGrid").jqxGrid('getrowid', selectedrowindex);
			                               var commit = $("#formaPagoGrid").jqxGrid('deleterow', id);
			                               }
			                               */
			                               var selectedrowindex = $("#formaPagoGrid").jqxGrid('getselectedrowindex');
			                               var rowscount = $("#formaPagoGrid").jqxGrid('getdatainformation').rowscount;
			                               if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			                               var dataRecord = $("#formaPagoGrid").jqxGrid('getrowdata', selectedrowindex);
			                               if (dataRecord.id) {
			                                 borrarItemsFormaPago(dataRecord.id);
			                               } 
			                               var id = $("#formaPagoGrid").jqxGrid('getrowid', selectedrowindex);
			                               //alert(dataRecord.id);
			                                var commit = $("#formaPagoGrid").jqxGrid('deleterow', id);
			                               
			                               }
								 
			                  }
			                 }  
		                    
		                    
		                ]
		            });
		            
		         // objGrid.jqxGrid('updatebounddata');
       }
       
       
       function borrarItemsFormaPago(id) {
        	    oper='delpar';
          	    var url = "<?php echo site_url("mar/campanas/ajax"); ?>";
				
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
											    $("#formaPagoGrid").jqxGrid('updatebounddata');
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
       
        function initPreaprobacionGrid(){
             
       	        
         $("#preaprobacionGrid").jqxGrid(
		            {
		                width: 770,
		                height: 350,
		                //source: detalles(),
		                editable: true,
		                theme: tema,
		                keyboardnavigation: false,
		                //showstatusbar: true,
		                //statusbarheight: 25,
		                //showaggregates: true,
		                      showtoolbar: true,
		                 rendertoolbar: function (toolbar) { 
		                  var me = this;
		                  var container = $("<div style='margin: 5px;'></div>");
		                  toolbar.append(container);
		                  //Codigo para boton Nuevo
		                   container.append('<div id="addPreaprobaciones" style="float: left; position:relative; margin:auto;"><img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/iconue.png" />&nbsp;Nuevo</div>');
		                   $("#addPreaprobaciones").jqxButton({theme: tema});
		                   $("#addPreaprobaciones").bind('click', function () {
		                       
							  	  var datarow = {
			                  	   id: 'New'
			                     
			                       
			                       
			                   };
			                  //jqxAlert.alert ('Nuevo detalle.');
			                  var commit = $("#preaprobacionGrid").jqxGrid('addrow', null, datarow);
								
		                    });
		                    
		                    
		                    
		                },
		                columns: [
		                    { text: 'Id', datafield: 'id', width: 0, hidden: true},
		                    { text: 'Parametro', datafield: 'parametro_id',  displayfield: 'descripcion',  columntype: 'combobox', 
		                        initeditor: function (row, value, editor) {
		                        	
		                        	 editor.jqxComboBox({ source: adpEstadosPreaprobacion(), displayMember: 'descripcion', valueMember: 'id' });
		                        }                      
		                   },
		                      { text: 'Borrar', datafield: 'Borrar', width: 80, columntype: 'button',id:'number', cellsrenderer: function () {
			                     return "Borrar";
			                     }, buttonclick: function (row) {
			                  	          /*
			                              var selectedrowindex = $("#preaprobacionGrid").jqxGrid('getselectedrowindex');
			                               var rowscount = $("#preaprobacionGrid").jqxGrid('getdatainformation').rowscount;
			                               if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			                               var id = $("#preaprobacionGrid").jqxGrid('getrowid', selectedrowindex);
			                               var commit = $("#preaprobacionGrid").jqxGrid('deleterow', id);
			                               }
			                               */
			                               var selectedrowindex = $("#preaprobacionGrid").jqxGrid('getselectedrowindex');
			                               var rowscount = $("#preaprobacionGrid").jqxGrid('getdatainformation').rowscount;
			                               if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			                               var dataRecord = $("#preaprobacionGrid").jqxGrid('getrowdata', selectedrowindex);
			                               if (dataRecord.id) {
			                                 borrarItemsPreaprobacion(dataRecord.id);
			                               } 
			                               var id = $("#preaprobacionGrid").jqxGrid('getrowid', selectedrowindex);
			                               //alert(dataRecord.id);
			                                var commit = $("#preaprobacionGrid").jqxGrid('deleterow', id);
			                               
			                               }
								 
			                  }
			                 }  
		                    
		                    
		                ]
		            });
		            
		         // objGrid.jqxGrid('updatebounddata');
       }
       
       
       function borrarItemsPreaprobacion (id) {
        	    oper='delpar';
          	    var url = "<?php echo site_url("mar/campanas/ajax"); ?>";
				
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
											    $("#preaprobacionGrid").jqxGrid('updatebounddata');
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
       
       function initNoInteresGrid(){
             
       	        
         $("#noInteresGrid").jqxGrid(
		            {
		                width: 770,
		                height: 250,
		                //source: detalles(),
		                editable: true,
		                theme: tema,
		                keyboardnavigation: false,
		                //showstatusbar: true,
		                //statusbarheight: 25,
		                //showaggregates: true,
		                 showtoolbar: true,
		                 rendertoolbar: function (toolbar) { 
		                  var me = this;
		                  var container = $("<div style='margin: 5px;'></div>");
		                  toolbar.append(container);
		                  //Codigo para boton Nuevo
		                   container.append('<div id="addnoInteres" style="float: left; position:relative; margin:auto;"><img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/iconue.png" />&nbsp;Nuevo</div>');
		                   $("#addnoInteres").jqxButton({theme: tema});
		                   $("#addnoInteres").bind('click', function () {
		                       
							  	  var datarow = {
			                  	   id: 'New'
			                     
			                       
			                       
			                   };
			                  //jqxAlert.alert ('Nuevo detalle.');
			                  var commit = $("#noInteresGrid").jqxGrid('addrow', null, datarow);
								
		                    });
		                    
		                    
		                    
		                },
		                columns: [
		                    { text: 'Id', datafield: 'id', width: 0, hidden: true},
		                    { text: 'Parametro', datafield: 'parametro_id',  displayfield: 'descripcion',  columntype: 'combobox', 
		                        initeditor: function (row, value, editor) {
		                        	
		                        	 editor.jqxComboBox({ source: adpSituacionesNoInteres(), displayMember: 'descripcion', valueMember: 'id' });
		                        }                      
		                   },
		                      { text: 'Borrar', datafield: 'Borrar', width: 80, columntype: 'button',id:'number', cellsrenderer: function () {
			                     return "Borrar";
			                     }, buttonclick: function (row) {
			                  	          /*
			                              var selectedrowindex = $("#noInteresGrid").jqxGrid('getselectedrowindex');
			                               var rowscount = $("#noInteresGrid").jqxGrid('getdatainformation').rowscount;
			                               if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			                               var id = $("#noInteresGrid").jqxGrid('getrowid', selectedrowindex);
			                               var commit = $("#noInteresGrid").jqxGrid('deleterow', id);
			                               }
			                               */
			                               var selectedrowindex = $("#noInteresGrid").jqxGrid('getselectedrowindex');
			                               var rowscount = $("#noInteresGrid").jqxGrid('getdatainformation').rowscount;
			                               if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			                               var dataRecord = $("#noInteresGrid").jqxGrid('getrowdata', selectedrowindex);
			                               if (dataRecord.id) {
			                                 borrarItemsNoInteres(dataRecord.id);
			                               } 
			                               var id = $("#noInteresGrid").jqxGrid('getrowid', selectedrowindex);
			                               //alert(dataRecord.id);
			                                var commit = $("#noInteresGrid").jqxGrid('deleterow', id);
			                               
			                               }
								 
			                  }
			                 }  
		                    
		                    
		                ]
		            });
		            
		         // objGrid.jqxGrid('updatebounddata');
       }
       
        function borrarItemsNoInteres (id) {
        	    oper='delpar';
          	    var url = "<?php echo site_url("mar/campanas/ajax"); ?>";
				
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
											    $("#noInteresGrid").jqxGrid('updatebounddata');
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
       
        function initPreguntasGrid(){
             
         $("#preguntasGrid").jqxGrid(
		            {
		                width: 770,
						height:385,
		                theme: tema,
						editable: true,
						//source: customersAdapterPreguntas,
		                keyboardnavigation: false,
		                showtoolbar: true,
		                 rendertoolbar: function (toolbar) { 
		                  var me = this;
		                  var container = $("<div style='margin: 5px;'></div>");
		                  toolbar.append(container);
		                  //Codigo para boton Nuevo
		                   container.append('<div id="addPreguntas" style="float: left; position:relative; margin:auto;"><img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/iconue.png" />&nbsp;Nuevo</div>');
						   $("#addPreguntas").jqxButton({theme: tema});
		                   $("#addPreguntas").bind('click', function () {
		                       
								var datarow = {
			                  	   id: 'New'
			                       
			                   };
			                  //jqxAlert.alert ('Nuevo detalle.');
			                  var commit = $("#preguntasGrid").jqxGrid('addrow', null, datarow);
							  
		                    });
		                    container.append('<div id="addEscalas" style="float: left; position:relative; margin:auto;"><img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/icopar.png" />&nbsp;Configuración</div>');
		                    $("#addEscalas").jqxButton({theme: tema});
		                    $("#addEscalas").bind('click', function () {
		                      //editarPreguntas();
							  	createElementsNuevo();
					 			$("#eventWindowNuevo").jqxWindow('open');
		                    });
		                    
		                },
		                columns: [
							{ text: 'Orden ', datafield: 'orden', width:55},
		                    { text: 'Id', datafield: 'id', width: 0, hidden: true},
							{ text: 'Pregunta', datafield: 'detalle_pregunta', width:360},
						    { text: 'Escala', datafield: 'tipo_respuesta_id',  displayfield: 'tipo_respuesta',  columntype: 'combobox', 
		                       initeditor: function (row, value, editor) {
		                        	editor.jqxComboBox({ source: customersAdapterEscala(), displayMember: 'nombre_escala', valueMember: 'id', autoComplete: true,
		                           
		                        	
		                        	});
		                        	
		                        } 
		                                             
		                    },
							{ text: 'Obligatorio', datafield: 'obligatorio',columntype: 'checkbox', width:80},
							{ text: 'Borrar', datafield: 'Borrar', width: 60, columntype: 'button',id:'number', cellsrenderer: function () {
			                     return "Borrar";
			                     }, buttonclick: function (row) {
			                  	           /*
			                               var selectedrowindex = $("#preguntasGrid").jqxGrid('getselectedrowindex');
			                               var rowscount = $("#preguntasGrid").jqxGrid('getdatainformation').rowscount;
			                               if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			                               var id = $("#preguntasGrid").jqxGrid('getrowid', selectedrowindex);
			                               var commit = $("#preguntasGrid").jqxGrid('deleterow', id);
			                               }
			                               */
			                               var selectedrowindex = $("#preguntasGrid").jqxGrid('getselectedrowindex');
			                               var rowscount = $("#preguntasGrid").jqxGrid('getdatainformation').rowscount;
			                               if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			                               var dataRecord = $("#preguntasGrid").jqxGrid('getrowdata', selectedrowindex);
			                               if (dataRecord.id) {
			                                 borrarPreguntas(dataRecord.id);
			                               } 
			                               var id = $("#preguntasGrid").jqxGrid('getrowid', selectedrowindex);
			                               //alert(dataRecord.id);
			                                var commit = $("#preguntasGrid").jqxGrid('deleterow', id);
			                               
			                               }
								 
			                  }
			                 }  
		                    
		                    
		                ]
		            });
		            
		         // objGrid.jqxGrid('updatebounddata');
       }
       
       
       function borrarPreguntas (id) {
        	    oper='delpreg';
          	    var url = "<?php echo site_url("mar/campanas/ajax"); ?>";
				
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
											    $("#preguntasGrid").jqxGrid('updatebounddata');
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
       
        function opnuevaEscala(){
			
                        operEsc='add';
                        //var url = "<?php echo site_url("mar/campanas/ajax"); ?>";
                        createElementsEscala();
						document.getElementById("frmEscala").reset();
						$("#eventWindowEscala").jqxWindow('open');
						
						$("#idescala").val('New');
                       
			       
		}  
		
		 function opnuevaRespuesta(){
			
                        operRes='add';
                        //var url = "<?php echo site_url("mar/campanas/ajax"); ?>";
                        createElementsRespuesta();
						document.getElementById("frmRespuesta").reset();
						$("#eventWindowRespuesta").jqxWindow('open');
						$("#idrespuesta").val('New');
                       
			       
		}  
		
		
		
		
		
		
		
	
		
		
		function opeditarEscala(){
			         operEsc = 'edit';
			         //var url = "<?php echo site_url("mar/campanas/ajax"); ?>"; 
                 	 var selectedrowindex = $("#escalasGrid").jqxGrid('getselectedrowindex');
                       
                        if (selectedrowindex >= 0 ) {
                           
                            var offset = $("#escalasGrid").offset();
                            // get the clicked row's data and initialize the input fields.
	                        var dataRecord = $("#escalasGrid").jqxGrid('getrowdata', selectedrowindex );
	                        // show the popup window.
	                        createElementsEscala();
							document.getElementById("frmEscala").reset();
							$("#cboipopregunta").jqxComboBox({promptText: "Seleccionar Escala:", source: customersAdapter(), displayMember: "tipo", valueMember: "id"});        
							$("#idescala").val(dataRecord.id);
							$("#inpescala").val(dataRecord.nombre_escala);
							$("#cboipopregunta").val(dataRecord.tipo_pregunta_id);
							$("#chkoptotro").val(dataRecord.opcion_otro);
							$("#chkmultresp").val(dataRecord.multiple_respuesta);
							$("#eventWindowEscala").jqxWindow('open');
							
							
	                        }else{
	                        	jqxAlert.alert('Seleccione un registro','Editar');
	                        }
                      
      	}	
      	
      			function opeditarRespuestas(){
			         operRes = 'edit';
			         //var url = "<?php echo site_url("mar/campanas/ajax"); ?>"; 
                 	 var selectedrowindex = $("#opcionesGrid").jqxGrid('getselectedrowindex');
                       
                        if (selectedrowindex >= 0 ) {
                           
                            var offset = $("#opcionesGrid").offset();
                            // get the clicked row's data and initialize the input fields.
	                        var dataRecord = $("#opcionesGrid").jqxGrid('getrowdata', selectedrowindex );
	                        // show the popup window.
	                        createElementsRespuesta();
							document.getElementById("frmRespuesta").reset();
							$("#cborescala").jqxComboBox({promptText: "Seleccionar Escala:", source: datos_escalas(2), displayMember: "nombre", valueMember: "id"});        
                            $("#idrespuesta").val(dataRecord.id);
							$("#cborescala").val(dataRecord.escalas_id);
							$("#inrordenrespuesta").val(dataRecord.orden);
							$("#inropcion").val(dataRecord.detalle);
							$("#eventWindowRespuesta").jqxWindow('open');
							
							
							
                              
                              
							
	                        }else{
	                        	jqxAlert.alert('Seleccione un registro','Editar');
	                        }
                      
      	}	
      	
      	
      	 //codigo para inicializacion del formulario
        function createElementsEscala() {
        	$('#eventWindowEscala').jqxWindow({
                //resizable: false,
                width: 500,
                height: 300,
				theme: tema,
                minWidth: 500,
                isModal: true,
                modalOpacity: 0.01, 
                minHeight: 300,  
								
                cancelButton: $("#btnCancelEscala"),
                initContent: function () {
                	$('#idescala').jqxInput({disabled: true,width: '100px',theme: tema });
                    $('#inpescala').jqxInput({width: '200px',theme: tema });
                    $('#cboipopregunta').jqxComboBox({width: '200px',height: '20px',theme: tema});
                    $('#chkoptotro').jqxCheckBox({width: '100px',theme: tema });
                    $('#chkmultresp').jqxCheckBox({width: '100px',theme: tema });
                    $('#btnSaveEscala').jqxButton({width: '65px',theme: tema });
                    $('#btnCancelEscala').jqxButton({ width: '65px',theme: tema });
                    
                    
                    $('#btnSaveEscala').focus();
                }
            });
            $('#eventWindowEscala').jqxWindow('focus');
            $('#eventWindowEscala').jqxValidator('hide');
        }



 function createElementsRespuesta() {
        	$('#eventWindowRespuesta').jqxWindow({
                //resizable: false,
                width: 500,
                height: 300,
				theme: tema,
                minWidth: 500,
                isModal: true,
                modalOpacity: 0.01, 
                minHeight: 300,  
								
                cancelButton: $("#btnCancelRespuesta"),
                initContent: function () {
                	$('#idrespuesta').jqxInput({disabled: true,width: '100px',theme: tema });
                    $('#cborescala').jqxComboBox({width: '200px',height: '20px',theme: tema});
                    $('#inrordenrespuesta').jqxInput({width: '200px',theme: tema });
                    $('#inropcion').jqxInput({width: '200px',theme: tema });
                    $('#btnSaveRespuesta').jqxButton({width: '65px',theme: tema });
                    $('#btnCancelRespuesta').jqxButton({ width: '65px',theme: tema });
                    
                    
                    $('#btnSaveRespuesta').focus();
                }
            });
            $('#eventWindowRespuesta').jqxWindow('focus');
            $('#eventWindowRespuesta').jqxValidator('hide');
        }


       function adpparametricas(){
        	var datos =
				{
					datatype: "json",
					datafields: [
						{ name: 'id' },
						{ name: 'nombre' },
						{ name: 'estado' }
					],
					url: '<?php echo site_url("mar/campanas/parametricas"); ?>',
					async: false
				};
				
		         var dataAdapter = new $.jqx.dataAdapter(datos); 
        	    return dataAdapter;
        }
        
   
        function adpformasPago(){
        	var tabla_id=1
        	var url = "<?php echo site_url("mar/campanas/datostablas"); ?>"+"/"+tabla_id;
                	 
        	var datos =
				{
					datatype: "json",
					datafields: [
						{ name: 'id' },
						{ name: 'codigo' },
						{ name: 'descripcion' },
						{ name: 'estado' }
					],
					id: 'id',
					url: url,
					pagesize: 20,
					async: false
				};
				
		         var dataAdapter = new $.jqx.dataAdapter(datos); 
        	    return dataAdapter;
        }
       
       
       function adpEstadosPreaprobacion(){
        	var tabla_id=2
        	var url = "<?php echo site_url("mar/campanas/datostablas"); ?>"+"/"+tabla_id;
                	 
        	var datos =
				{
					datatype: "json",
					datafields: [
						{ name: 'id' },
						{ name: 'codigo' },
						{ name: 'descripcion' },
						{ name: 'estado' }
					],
					id: 'id',
					url: url,
					pagesize: 20,
					async: false
				};
				
		         var dataAdapter = new $.jqx.dataAdapter(datos); 
        	    return dataAdapter;
        }
        
       function adpSituacionesNoInteres(){
        	var tabla_id=3
        	var url = "<?php echo site_url("mar/campanas/datostablas"); ?>"+"/"+tabla_id;
                	 
        	var datos =
				{
					datatype: "json",
					datafields: [
						{ name: 'id' },
						{ name: 'codigo' },
						{ name: 'descripcion' },
						{ name: 'estado' }
					],
					id: 'id',
					url: url,
					pagesize: 20,
					async: false
				};
				
		         var dataAdapter = new $.jqx.dataAdapter(datos); 
        	    return dataAdapter;
        } 
       

                   //funcion que carga los datos de detalle de tarifas de los productos en el grid
            function detalles(camp_id) {
               var url="<?php echo site_url("mar/campanas/detalle"); ?>"+"/"+camp_id;
               var source ={
						                datatype: "json",
						                datafields: [
                   					       { name: 'id', type: 'number' },
			               		           { name: 'campana_id', type: 'number' },
					                       { name: 'producto', value: 'producto_id', values: { source: dataAdapterProductos().records, value: 'id', name: 'nombre' } },
					                       { name: 'producto_id', type: 'number' },
					                       { name: 'costo_unitario', type: 'number' },
					                       { name: 'cantidad', type: 'number' },
					                       { name: 'valor', type: 'number' }
					                    ],
						                id: 'id',
						                url: url,
						            };
			             
                   
                 var dataAdapter = new $.jqx.dataAdapter(source, {
						                //loadComplete: function (data) { },
						                //loadError: function (xhr, status, error) { }      
						            });
									         
               return dataAdapter;
           
            }
            
              function campana_formapago(camp_id, tabla_id) {
               var url="<?php echo site_url("mar/campanas/detalleparametros"); ?>"+"/"+camp_id+"/"+tabla_id;
               var source ={
						                datatype: "json",
						                datafields: [
                   					       { name: 'id', type: 'number' },
			               		           { name: 'campana_id', type: 'number' },
			               		           //{ name: 'parametrica_id', type: 'number' },
					                       { name: 'descripcion', value: 'parametro_id', values: { source: adpformasPago().records, value: 'id', name: 'nombre' } },
					                       { name: 'parametro_id', type: 'number' }
					                      
					                    ],
						                id: 'id',
						                url: url,
						            };
			             
                   
                 var dataAdapter = new $.jqx.dataAdapter(source, {
						                //loadComplete: function (data) { },
						                //loadError: function (xhr, status, error) { }      
						            });
									         
               return dataAdapter;
           
            }
            
             function campana_preaprobacion(camp_id, tabla_id) {
               var url="<?php echo site_url("mar/campanas/detalleparametros"); ?>"+"/"+camp_id+"/"+tabla_id;
               var source ={
						                datatype: "json",
						                datafields: [
                   					       { name: 'id', type: 'number' },
			               		           { name: 'campana_id', type: 'number' },
			               		           //{ name: 'parametrica_id', type: 'number' },
					                       { name: 'descripcion', value: 'parametro_id', values: { source: adpEstadosPreaprobacion().records, value: 'id', name: 'nombre' } },
					                       { name: 'parametro_id', type: 'number' }
					                      
					                    ],
						                id: 'id',
						                url: url,
						            };
			             
                   
                 var dataAdapter = new $.jqx.dataAdapter(source, {
						                //loadComplete: function (data) { },
						                //loadError: function (xhr, status, error) { }      
						            });
									         
               return dataAdapter;
           
            }
           function campana_nointeres(camp_id, tabla_id) {
               var url="<?php echo site_url("mar/campanas/detalleparametros"); ?>"+"/"+camp_id+"/"+tabla_id;
               var source ={
						                datatype: "json",
						                datafields: [
                   					       { name: 'id', type: 'number' },
			               		           { name: 'campana_id', type: 'number' },
			               		           //{ name: 'parametrica_id', type: 'number' },
					                       { name: 'descripcion', value: 'parametro_id', values: { source: adpEstadosPreaprobacion().records, value: 'id', name: 'nombre' } },
					                       { name: 'parametro_id', type: 'number' }
					                      
					                    ],
						                id: 'id',
						                url: url,
						            };
			             
                   
                 var dataAdapter = new $.jqx.dataAdapter(source, {
						                //loadComplete: function (data) { },
						                //loadError: function (xhr, status, error) { }      
						            });
									         
               return dataAdapter;
           
            }
            
            
   //// funciones para mantenedor de encuesta  
	   function createElementsNuevo() {
	   	      
            $('#eventWindowNuevo').jqxWindow({
                resizable: false,
                width: 650,
                height: 450,
                theme: tema,
                minHeight: 450,  
                isModal: true,
                modalOpacity: 0.01, 
                initContent: function () {
				
				 $('#jqxTabs1').jqxTabs({theme: tema}); 
				 initOpcionesGrid(); 
			     initEscalasGrid();				
                }
            });
            $('#eventWindowNuevo').jqxWindow('focus');
            $('#eventWindowNuevo').jqxValidator('hide');
        }
		
	
		
	  
	   
	   function editarPreguntas(){
			         oper = 'edit';
			         var url = "<?php echo site_url("mar/preguntas/ajax"); ?>"; 
                 	 createElementsNuevo();
					 $("#eventWindowNuevo").jqxWindow('open');							
						
      	}	
	   
	   function preguntas_datos(campana){
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
					//{ name: 'tipo_respuesta'},
			        { name: 'tipo_respuesta', value: 'tipo_respuesta_id', values: { source: customersAdapterEscala().records, value: 'id', name: 'nombre_escala' } },
					{ name: 'obligatorio'}
				],
				url: "<?php echo site_url("mar/preguntas/preguntas_encuesta"); ?>"+"/"+campana
			};
		var customersAdapterPreguntas = new $.jqx.dataAdapter(customersPreguntas);
		return customersAdapterPreguntas;
		}
		
		
		function datos_escalas(valuet) {
			 var source =
				{
					dataType: "json",
					dataFields: [
						{ name: 'id' },
						{ name: 'nombre' }
					],
					url: "<?php echo site_url("mar/campanas/escala_detalle"); ?>"+"/"+valuet
				};
			var ordersAdapter = new $.jqx.dataAdapter(source);	
			return ordersAdapter;
		}
		
		
		
		function customersAdapter(){   
		var source =
			{
				dataType: "json",
				dataFields: [
					{ name: 'id'},
					{ name: 'tipo'}
				],
				url: '<?php echo site_url("mar/campanas/tipo_pregunta"); ?>'
			};
		var dataAdapter = new $.jqx.dataAdapter(source);
		return dataAdapter;
		}


function customersAdapterEscala(){
		var source =
			{
				dataType: "json",
				dataFields: [
					{ name: 'id'},
					{ name: 'tipo_pregunta_id'},
					{ name: 'tipo', value: 'tipo_pregunta_id', values: { source: customersAdapter().records, value: 'id', name: 'tipo' } },
                    { name: 'opcion_otro'},
					{ name: 'multiple_respuesta'},
					{ name: 'nombre_escala', type: 'string'}
				],
				url: '<?php echo site_url("mar/campanas/escala_details"); ?>'
			};
		var dataAdapter = new $.jqx.dataAdapter(source);
		return dataAdapter;
	}	


  		
		function ordersAdapterOpciones() {
			 var source =
				{
					dataType: "json",
					dataFields: [
						{ name: 'id' },
						{ name: 'escalas_id' },
						//{ name: 'escala' },
					    { name: 'escala', value: 'escalas_id', values: { source: datos_escalas(2).records, value: 'id', name: 'nombre' } },
						{ name: 'orden' },
						{ name: 'detalle' }
					],
					url: "<?php echo site_url("mar/campanas/opciones_detalle"); ?>"
				};
			var dataAdapter = new $.jqx.dataAdapter(source);	
			return dataAdapter;
			
		}
       
 function initEscalasGrid(){
             
       	        
         $("#escalasGrid").jqxGrid(
		            {
		                width: 615,
		                height: 370,
		                source: customersAdapterEscala(),
		                editable: false,
		                theme: tema,
		                sortable: true,
			            //showfilterrow: true,
			            filterable: true,
			            //pageable: true,
		                 //autoheight: true,
		                keyboardnavigation: false,
		                showtoolbar: true,
		                rendertoolbar: function (toolbar) { 
		                  var me = this;
		                  var container = $("<div style='margin: 5px;'></div>");
		                  toolbar.append(container);
		                  //Codigo para boton Nuevo
		                   container.append('<div id="addEscala" style="float: left; position:relative; margin:auto;"><img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/iconue.png" />&nbsp;Nuevo</div>');
		                   $("#addEscala").jqxButton({theme: tema});
		                   $("#addEscala").bind('click', function () {
		                       opnuevaEscala();	
		                    });
		                    
		                    //Codigo para boton Nuevo
		                   container.append('<div id="EditEscala" style="float: left; position:relative; margin:auto;"><img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/icoedi.png" />&nbsp;Editar</div>');
		                   $("#EditEscala").jqxButton({theme: tema});
		                   $("#EditEscala").bind('click', function () {
		                       opeditarEscala();
								
		                    }); 
		                    
		                },
		                columns: [
		                    { text: 'Id', datafield: 'id', width: 0, hidden: true},
							{ text: 'Escala', datafield: 'nombre_escala',columntype: 'textbox', width:140},
						    { text: 'Tipo de pregunta', datafield: 'tipo_pregunta_id',  displayfield: 'tipo',  columntype: 'combobox', 
		                       initeditor: function (row, value, editor) {
		                        	
		                        	 editor.jqxComboBox({ source: customersAdapter(), displayMember: 'tipo', valueMember: 'id' });
		                        }                      
		                    },
							{ text: 'Opcion otro', width:90,columntype: 'checkbox', datafield: 'opcion_otro' },
							{ text: 'Multiple respues', datafield: 'multiple_respuesta', columntype: 'checkbox', width:100},
					        { text: 'Borrar', datafield: 'Borrar', width: 65, columntype: 'button',id:'number', cellsrenderer: function () {
			                     return "Borrar";
			                     }, buttonclick: function (row) {
			                     	
			                     	          	  
			                              var selectedrowindex = $("#escalasGrid").jqxGrid('getselectedrowindex');
			                               var rowscount = $("#escalasGrid").jqxGrid('getdatainformation').rowscount;
			                               if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			                               var dataRecord = $("#escalasGrid").jqxGrid('getrowdata', selectedrowindex);
			                               if (dataRecord.id) {
			                                 borrarEscala(dataRecord.id);
			                               } 
			                               var id = $("#escalasGrid").jqxGrid('getrowid', selectedrowindex);
			                               //alert(dataRecord.id);
			                                var commit = $("#escalasGrid").jqxGrid('deleterow', id);
			                               
			                               }
								 
			                  }
			                 }  
		                    
		                    
		                ]
		            });
		            
		         // objGrid.jqxGrid('updatebounddata');
       } 
       
   function initOpcionesGrid(){
         var valuet= 2;   
       	        
         $("#opcionesGrid").jqxGrid(
		            {
		                width: 615,
		                height: 370,
		                source: ordersAdapterOpciones(),
		                editable: false,
		                theme: tema,
		                sortable: true,
			            //showfilterrow: true,
			            filterable: true,
			            //pageable: true,
		                 //autoheight: true,
		                keyboardnavigation: false,
		                showtoolbar: true,
		                rendertoolbar: function (toolbar) { 
		                  var me = this;
		                  var container = $("<div style='margin: 5px;'></div>");
		                  toolbar.append(container);
		                  //Codigo para boton Nuevo
		                   container.append('<div id="addOpciones" style="float: left; position:relative; margin:auto;"><img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/iconue.png" />&nbsp;Nuevo</div>');
		                   $("#addOpciones").jqxButton({theme: tema});
		                   $("#addOpciones").bind('click', function () {
		                      	opnuevaRespuesta();
		                    });
		                    
		                    //Codigo para boton Nuevo
		                   container.append('<div id="EditOpciones" style="float: left; position:relative; margin:auto;"><img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/icoedi.png" />&nbsp;Editar</div>');
		                   $("#EditOpciones").jqxButton({theme: tema});
		                   $("#EditOpciones").bind('click', function () {
		                          opeditarRespuestas();
			                });
		                    
		                },
		                columns: [
		                    { text: 'Id', datafield: 'id', width: 0, hidden: true},
							
		                    { text: 'Escala', datafield: 'escalas_id',  displayfield: 'escala',  columntype: 'combobox', 
		                        initeditor: function (row, value, editor) {
		                        	 editor.jqxComboBox({ source: datos_escalas(valuet), displayMember: 'nombre', valueMember: 'id' });
		                        }                      
		                    },
		                    { text: 'Orden', datafield: 'orden', width:160},
						    { text: 'Opcion', datafield: 'detalle', width:160},
					        { text: 'Borrar', datafield: 'Borrar', width: 70, columntype: 'button',id:'number', cellsrenderer: function () {
			                     return "Borrar";
			                     }, buttonclick: function (row) {
			                  	  
			                              var selectedrowindex = $("#opcionesGrid").jqxGrid('getselectedrowindex');
			                               var rowscount = $("#opcionesGrid").jqxGrid('getdatainformation').rowscount;
			                               if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			                               var id = $("#opcionesGrid").jqxGrid('getrowid', selectedrowindex);
			                               var commit = $("#opcionesGrid").jqxGrid('deleterow', id);
			                               }
								 
			                  }
			                 }  
		                    
		                    
		                ]
		            });
		            
		         // objGrid.jqxGrid('updatebounddata');
       }     
       
       
        function borrarEscala (id) {
        	
                operEsc='del';
          	    var url = "<?php echo site_url("mar/campanas/saveEscala"); ?>";
				
									var escala = {  
										accion: operEsc,
										id: id
										
									};	
										
									$.ajax({
										type: "POST",
										url: url,
										data: escala,
										success: function (data) {
											if(data=true){
											    $("#escalasGrid").jqxGrid('updatebounddata');
												$("#opcionesGrid").jqxGrid('updatebounddata');
												$("#eventWindowEscala").jqxWindow('hide');
                              				   //jqxAlert.alert("El dato se grabó correctamente.");
											}else{
												jqxAlert.alert("Problemas al guardar.");
											}
										},
										error: function (msg) {
											alert(msg.responseText);
										}
									});	
           	
        };
        
        
         function  dataAdapterProductos(){
        //data para producto
            var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'id', type: 'number' },
                    { name: 'nombre', type: 'string' }
                 ],
                id: 'id',
                url: "<?php echo site_url("inv/productos/ajax"); ?>",
                pagesize: 20,
                async: false
            };
            var dataAdapter = new $.jqx.dataAdapter(source, {
            	//autoBind: true,
                loadComplete: function (data) { },
                loadError: function (xhr, status, error) { }      
            });
            return dataAdapter; 
        }
        function dataAdapterCampanas(){
         var source =
        {
            datatype: "json",
            datafields: [
                { name: 'id', type: 'string' },
                { name: 'nombre', type: 'string' },
                { name: 'descripcion', type: 'string' },
                { name: 'dialogo_llamada', type: 'string' },
                { name: 'texto_mail', type: 'string' },
                { name: 'texto_rechazo', type: 'string' },
                { name: 'texto_cobertura', type: 'string' },
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
            loadComplete: function (data) { },
            loadError: function (xhr, status, error) { }      
        });
        return dataAdapter;
        }
        
        
        function gridMainCampanas(){   
        //Codigo de operaciones en la Grilla
        $("#jqxgrid").jqxGrid({
            width : '100%',
            height: '100%',
            source: dataAdapterCampanas(),
			theme: tema,
            sortable: true,
            //showfilterrow: true,
            filterable: true,
            pageable: true,
            //autoheight: true,
            ready: function () {
                   $("#jqxgrid").jqxGrid('sortby', 'id', 'asc');
            },
            
            columns: [
                { text: 'Id', datafield: 'id', width: '5%' },
                { text: 'Nombre', datafield: 'nombre', width: '25%' },
                { text: 'Descripción', datafield: 'descripcion', width: '35%',hidden:false},
                { text: 'Dialogo llamada', datafield: 'dialogo_llamada', width: '10%',hidden:true},
                { text: 'Texto mail', datafield: 'texto_mail', width: '10%',hidden:true},
                { text: 'Texto rechazo', datafield: 'texto_rechazo', width: '10%',hidden:true},
                { text: 'Texto cobertura', datafield: 'texto_cobertura', width: '10%',hidden:true},
                { text: 'Fecha ingreso', datafield: 'fecha_ing', width: '15%' },
                { text: 'Fecha modifición', datafield: 'fecha_mod', width: '15%' },
                { text: 'Estado', datafield: 'estado', width: '5%' }
                     ]
         });
       }

		
        
</script>
<div class="main">
 <div class='titnavbg'>
    <div class='titnavtit'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/seg.png">&nbsp;&nbsp;Marketing: Campa&ntilde;a</div>
    <div class='titnavlog'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/log_titulo.png"></div>
 </div>
  <div style='margin-left: 0px; margin-top: 5px;' id='jqxMenu'></div> 
      <div style='margin-left: 0px; margin-top: 5px;' id="jqxgrid"></div>
      
   
      <div style="visibility: hidden;  display:none;" id="jqxWidget">
        <div id="eventWindow">
            <div>Campa&ntilde;a</div>
            <div>
                <div>
                    <form id="frmCampana">
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
                                <td align="right">Descripción:</td>
                                <td align="left"><textarea id="descripcion"></textarea></td>
                               </tr>
                             <tr style="visibility: hidden; display:none;">
                                <td align="right">Estado:</td>
                                <td align="left"><input id="estado" /></td>
                            </tr>
                           
                        </table>
                        
                        <div id='jqxTabs'>
			            <ul>
			               
			                <li style="margin-left: 5px">Texto llamadas</li>
			                <li>Texto mails</li>
			                <li>Encuesta</li>
			                <li>Productos</li>
			                <li>Forma/pago</li>
			                <li>Preaprobacion</li>
			                <li>Rechazo</li>
			                <li>Cobertura</li>
			                
			            </ul>
			            
			            <div>
			            	 <table>
			            	   <tr>
                                <td align="right"></td>
                                <td align="left"><textarea style="visibility: hidden;  display:none;" id="dialogo_llamada"></textarea></td>
                               </tr>
			            	 </table>
			            </div>	
			            <div>
			            	 <table>
			            	   <tr>
                                <td align="right"></td>
                                <td align="left"><textarea style="visibility: hidden;  display:none;" id="texto_mail"></textarea></td>
                               </tr>
			            	 </table>
			            </div>
			             <div>
						 	       <table>
			             			 <tr>
										<td align="left"><div style='margin-left: 5px; margin-top: 5px;' id="preguntasGrid"></div></td> 
									 </tr>
									</table>
								
						 </div>	
                        <div>
                        	<table>
                        	  <tr>
		                        <td align="left"><div style='margin-left: 5px; margin-top: 5px;' id="productosGrid"></div></td>
                    		  </tr>
                    		 </table>
			             </div>
			             <div>
			             	<table>
			             
			             	<tr>
		                        <td align="left"><div style='margin-left: 5px; margin-top: 5px;' id="formaPagoGrid"></div></td>
		                       
                    		 </tr>
                    		</table>
			             </div>
			             <div>
			             	<table>
			             			             	
			             	<tr>
		                        <td align="left"><div style='margin-left: 5px; margin-top: 5px;' id="preaprobacionGrid"></div></td>
		                       
                    		 </tr>
                    		</table>
			             </div>
			             <div>
			             	<table>
			             	 <tr>
			             		<td align="left">Argumentación en caso de rechazo:</td>
			             	 </tr>
			             	<tr>
                                <td align="left"><textarea id="texto_rechazo"></textarea></td>
                             </tr>
			             	<tr>
			             		<td align="left">Razones desinterés:</td>
			             	 </tr>		             	
			             	<tr>
		                        <td align="left"><div style='margin-left: 5px; margin-top: 5px;' id="noInteresGrid"></div></td>
		                       
                    		 </tr>
                    		</table>
			             </div>
			           
			            <div>
			             	<table>
			             	 <tr>
			             		<td align="left">Argumentación de cobertura:</td>
			             	 </tr>
			             	 <tr>
                                <td align="left"><textarea id="texto_cobertura"></textarea></td>
                             </tr>
			             	</table>
			             </div>
			            
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
      
      <div style="visibility: hidden; display:none;" id="jqxWidget2">			
		<div id="eventWindowNuevo">
            <div>Gesti&oacute;n de opciones de respuesta</div>
            <div>
                <div>
                    <form id="fmprNuevo" method="post">
                    	
							<div id='jqxTabs1'>
			                <ul>
			                  <li style="margin-left: 30px;">Opciones de respuesta</li>
			                  <li>Escalas</li>
			                </ul>
			                <div>
                        	  <table>
                        	    <tr>
		                        <td align="left"><div id="opcionesGrid"></div></td>
		                        </tr>
                    		  </table>
			                </div>
			                <div>
                        	  <table>
                        	    <tr>
		                        <td align="left"><div id="escalasGrid"></div></td>
                    		    </tr>
                    		  </table>
			                </div>
			               </div>
                                                    
                        
                    </form>
                </div>
            </div>
      </div>
  </div> 
  
  
   <div style="visibility: hidden; display:none;" id="jqxWidget3">			
		<div id="eventWindowEscala">
            <div>Escala</div>
            <div>
                <div>
                    <form id="frmEscala" method="post">
                    	
							<table>
                            <tr>
                                <td align="right">Id:</td>
                                <td align="left"><input id="idescala"/></td>
                            </tr>
                            <tr>
                                <td align="right">Escala:</td>
                                <td align="left"><input id="inpescala" /></td>
                            </tr>
                             <tr>
                                <td align="right">Tipo de pregunta:</td>
                                <td align="left"><div id="cboipopregunta"></div></td>
                              </tr>
                              
                              <tr>
                                <td align="right">Opcion otro:</td>
                                <td align="left"><div id="chkoptotro"></div></td>
                              </tr>
                              
                              <tr>
                                <td align="right">Multiple respuesta:</td>
                                <td align="left"><div id="chkmultresp"></div></td>
                              </tr>
                              
                              <tr>
                                <td align="right"></td>
                                <td style="padding-top: 10px;" align="right"><input style="margin-right: 5px;" type="button" id="btnSaveEscala" value="Grabar" /><input id="btnCancelEscala" type="button" value="Cancelar" /></td>
                              </tr>
                            
                           
                        </table>
                                                    
                        
                    </form>
                </div>
            </div>
      </div>
  </div>   
  
  
  <div style="visibility: hidden; display:none;" id="jqxWidget4">			
		<div id="eventWindowRespuesta">
            <div>Respuesta</div>
            <div>
                <div>
                    <form id="frmRespuesta" method="post">
                    	
							<table>
                            <tr>
                                <td align="right">Id:</td>
                                <td align="left"><input id="idrespuesta"/></td>
                            </tr>
                            <tr>
                                <td align="right">Tipo:</td>
                                <td align="left"><div id="cborescala"></div></td>
                              </tr>
                             <tr>
                                <td align="right">Orden:</td>
                                <td align="left"><input id="inrordenrespuesta"/></td>
                            </tr>
                             <tr>
                                <td align="right">Opción:</td>
                                <td align="left"><input id="inropcion"/></td>
                            </tr>
                              
                              
                              
                              <tr>
                                <td align="right"></td>
                                <td style="padding-top: 10px;" align="right"><input style="margin-right: 5px;" type="button" id="btnSaveRespuesta" value="Grabar" /><input id="btnCancelRespuesta" type="button" value="Cancelar" /></td>
                              </tr>
                            
                           
                        </table>
                                                    
                        
                    </form>
                </div>
            </div>
      </div>
  </div>   
    
  
</div>