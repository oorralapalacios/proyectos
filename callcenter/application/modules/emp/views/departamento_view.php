 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.filter.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.sort.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.pager.js"></script> 
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxpanel.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxlistbox.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdropdownlist.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdatatable.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxtreegrid.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxpanel.js"></script> 
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxwindow.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxcheckbox.js"></script>
 <script type="text/javascript">
        var tema= "ui-redmond";
        var oper;
        var url = "<?php echo site_url("emp/departamentos/ajax"); ?>";
        
        $(document).ready(function () {
        	//ejecuta funcion que llama a menu CRUD
        	var tid="<?php echo $_GET["tid"]; ?>";
          	menuopciones(tid);
        	//ejecuta funcion que carga datos
        	treegridDatos();
        	 //combo departamentos
        	listaDependencias();
        	//ejecuta funcion de validacion
        	validador();
        	
        	 //evento grabar
	         $("#btnSave").click(function () {
	           	 grabar();
	         })
        	
         });
            // prepare the data
            //var oper;
            
            
            function menuopciones(padre_id){
			//var view='departamento_view'
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
			         var selection = $("#jqxtreegridDatos").jqxTreeGrid('getSelection');
                 	
                        if (selection[0].id) {
                        	
                            createElements();
							document.getElementById("form").reset();
							$("#id").val(selection[0].id);
							$("#orden").val(selection[0].orden);
							$("#nombre").val(selection[0].nombre);
							$("#listpadres").val(selection[0].padre_id);
							$("#estado").val(selection[0].estado);
							$("#eventWindow").jqxWindow('open');
												
							
	                        }else{
	                        	jqxAlert.alert('Seleccione un registro','Editar');
	                        }
                      
      	}
	
		
		function opborrar(){
			            oper = 'del';
			           var selection = $("#jqxtreegridDatos").jqxTreeGrid('getSelection');
                         if (selection[0].id) {
                        	    
		                       
		                        var contacto = {
		                            accion: oper,
		                            id: selection[0].id
		                        };
								jqxAlert.verify('Esta seguro de Borrar?','Confirma borrar', function(r) {
							    if(r){
		                        $.ajax({
		                            type: "POST",
		                            url: url,
		                            data: contacto,
		                            success: function (data) {
		                                if(data=true){
		                                   opreconsular();
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
			//datos de departamentos
			 treegridDatos();
			  //combo departamentos
        	listaDependencias();
		}	
		
		
	 function listaDependencias(){
		var url = "<?php echo site_url("emp/departamentos/listacbo"); ?>";
		var source =
				{
					datatype: "json",
					datafields: [
						{ name: 'id' },
						{ name: 'nombre' },
						{ name: 'padre_id' }
					],
					hierarchy:
	                {
	                    keyDataField: { name: 'id' },
	                    parentDataField: { name: 'padre_id' }
	                },
					id: 'id',
					url: url
				};
				
		      var dataAdapter = new $.jqx.dataAdapter(source); 
			   $('#listpadres').jqxDropDownList({
							source: dataAdapter,
							width: 200,
							//height: 20,
						    theme: tema,
						    selectedIndex: 0,
							displayMember: 'nombre',
							valueMember: 'id'
		         });  	
	 }
     
     //funcion para inicializacion del grid de datos
	 function treegridDatos(){
	 	//url ubicacion de archivo json
	 	var url = "<?php echo site_url("emp/departamentos/ajax"); ?>";
	 	//create source
	 	var source={
			datatype: "json",
			datafields: [
			{ name: 'id' },
			{ name: 'nombre' },
			{ name: 'padre_id' },
			{ name: 'fecha_ing', type: 'string' },
            { name: 'fecha_mod', type: 'string' },
			{ name: 'estado' }
			],
			hierarchy:
                {
                	keyDataField: { name: 'id' },
                    parentDataField: { name: 'padre_id' }
                },
			id: 'id',
			url: url
		   };
		   
		   // create data adapter.
			var dataAdapter = new $.jqx.dataAdapter(source);
	 	
	 	
	 	$("#jqxtreegridDatos").jqxTreeGrid({
	 		
	 		 width: '100%',
	 		 //height: '90%',
	 		 //hierarchicalCheckboxes: true,
	 		 theme: tema,
	 		 //checkboxes: true,
             source: dataAdapter,
             //altRows: true,
             //columnsresize: true,
             //sortable: true,
             columns: [
             { text: 'Id', datafield: 'id',  hidden:true },
             { text: 'Departamento', datafield: 'nombre', width: '40%'},
             { text: 'Padre_id', datafield: 'padre_id' , hidden:true},
             { text: 'Fecha de creación', datafield: 'fecha_ing', width: '20%' },
             { text: 'Fecha de modificación', datafield: 'fecha_mod', width: '20%' },
             { text: 'Estado', datafield: 'estado',hidden:true }
             ]
	 	});
	 	
	 	 $('#jqxtreegridDatos').on('rowCheck', function (event) {
         var args = event.args;
         var row = args.row;
         var padre_id=row.id;
         //var hijo_id=row.padre_id;
         //$("#jqxtreegridDatos").jqxTreeGrid('checkRow',hijo_id);
         var records = new Array();
               for (var i = 0; i < dataAdapter.records.length; i++) {
                    var record = dataAdapter.records[i];
                    if (record.padre_id == padre_id) {
                    	records[records.length] = record;
                    }
                }
                
                for(var i=0; i< records.length; i++){
                	 
                      $("#jqxtreegridDatos").jqxTreeGrid('checkRow',records[i].id);
                	  
                	  
                }
                 
        });
        $('#jqxtreegridDatos').on('rowUncheck', function (event) {
         var args = event.args;
         var row = args.row;
         var padre_id=row.id
         var records = new Array();
               for (var i = 0; i < dataAdapter.records.length; i++) {
                    var record = dataAdapter.records[i];
                    if (record.padre_id == padre_id) {
                    	records[records.length] = record;
                    	
                    }
                }
                for(var i=0; i< records.length; i++){
                	//alert(record.id);
                         $("#jqxtreegridDatos").jqxTreeGrid('uncheckRow',records[i].id);
                }
                
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
                height: 250,
                theme: tema,
                minWidth: 200,
                minHeight: 200,
                isModal: true,
                modalOpacity: 0.01,  
                //okButton: $('#btnSave'),
				cancelButton: $("#btnCancel"),
				initContent: function () {
					$('#id').jqxInput({ theme: tema, disabled: true,width: '100px' });
					$('#nombre').jqxInput({ theme: tema, width: '200px'});
					$('#estado').jqxInput({ theme: tema, disabled: true, width: '20px'  });
                    $('#btnSave').jqxButton({ theme: tema, width: '65px' });
                    $('#btnCancel').jqxButton({ theme: tema, width: '65px' });
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
		                padre_id: $("#listpadres").val(),
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
									opreconsular();
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
	    <div class='titnavtit'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/inv.png">&nbsp;&nbsp;Empresa: Departamentos</div>
	    <div class='titnavlog'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/log_titulo.png"></div>
	</div>
      <div style='margin-left: 0px; margin-top: 5px;' id='jqxMenu'></div> 
      <div  style='margin-left: 0px; margin-top: 5px;' id="jqxtreegridDatos"></div>
     
      <div style="visibility: hidden; display:none;" id="jqxWidget">
			<div id="eventWindow">
			<div>Departamento</div>
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
                    <td align="right">Jerárquico Superior:</td>
                         <td align="left"><div style='float: left;' id='listpadres'></div></td>
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
</div>