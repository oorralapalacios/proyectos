 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.filter.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.sort.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.pager.js"></script> 
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxpanel.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxlistbox.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdropdownlist.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxmaskedinput.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/otwidgets/validadoc.js"></script>
    <script type="text/javascript">
        var tema= "ui-redmond";
        $(document).ready(function () {
            // prepare the data
            var oper;
            var url = "<?php echo site_url("inv/proveedores/ajax"); ?>";
            var tid="<?php echo $_GET["tid"]; ?>";
          	menuopciones(tid);
          	
			function menuopciones(padre_id){
			//var view='proveedor_view'
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
                        var url = "<?php echo site_url("inv/proveedores/ajax"); ?>";
                        createElements();
						document.getElementById("form").reset();
						$("#eventWindow").jqxWindow('open');
						$("#id").val('New');
						$("#estado").val('AC');
			       
		}  
				
		function opeditar(){
			         oper = 'edit';
			         var url = "<?php echo site_url("inv/proveedores/ajax"); ?>"; 
                 	 var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                       
                        if (selectedrowindex >= 0 ) {
                           
                            var offset = $("#jqxgrid").offset();
                            // get the clicked row's data and initialize the input fields.
	                        var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex );
	                        // show the popup window.
	                        createElements();
							//document.getElementById("form").reset();
							 $("#id").val(dataRecord.id);
							 $("#ruc").val(dataRecord.ruc);
							 $("#razon_social").val(dataRecord.razon_social);
							 $("#nombre_comercial").val(dataRecord.nombre_comercial);
							 $("#telefono").jqxMaskedInput('maskedValue',dataRecord.telefono);
						  	 $("#celular").jqxMaskedInput('maskedValue',dataRecord.celular);
							 $("#email").val(dataRecord.email);
							 $("#estado").val(dataRecord.estado);
							 $("#eventWindow").jqxWindow('open');
								
	                        }else{
	                        	jqxAlert.alert('Seleccione un registro','Editar');
	                        }
                      
      	}	
		
		function opborrar(){
			             oper = 'del';
			             var url = "<?php echo site_url("inv/proveedores/ajax"); ?>";
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
		                                   // $("#eventWindowNuevo").jqxWindow('hide');
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
                    { name: 'ruc', type: 'string' },
                    { name: 'razon_social', type: 'string' },
                    { name: 'nombre_comercial', type: 'string' },
                    { name: 'celular', type: 'string' },
                    { name: 'telefono', type: 'string' },
                    { name: 'email', type: 'string' },
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
                  { text: 'Id', datafield: 'id', width: '5%' },
                  { text: 'Ruc', datafield: 'ruc', width: '12%' },
                  { text: 'Razon Social', datafield: 'razon_social', width: '15%' },
                  { text: 'Nombre Comercial', datafield: 'nombre_comercial', width: '20%' },
                  { text: 'Celular', datafield: 'celular', width: '10%' },
                  { text: 'Telefono', datafield: 'telefono', width: '10%' },
                  { text: 'Email', datafield: 'email', width: '20%' },
                  { text: 'Estado', datafield: 'estado', width: '10%' },
                     ]
                
            });
                     
            //codigo para validacion de entradas
            $('#eventWindow').jqxValidator({
             	hintType: 'label',
                animationDuration: 0,
                rules: [
                { input: '#ruc', message: 'RUC es requerido!', action: 'keyup, blur', rule: 'required' },
                { input: '#ruc', message: 'RUC debe tener 13 caracteres!', action: 'keyup, blur', rule: 'length=13,13' },
                { input: '#razon_social', message: 'Razón social!', action: 'keyup, blur', rule: 'required' },
                { input: '#razon_social', message: 'Razón social debe contener solo letras!', action: 'keyup', rule: 'notNumber' },
                { input: '#razon_social', message: 'Razón social debe contener de 3 a 30 caracteres!', action: 'keyup', rule: 'length=3,30' },
                { input: '#nombre_comercial', message: 'Nombre comercial es requerido!', action: 'keyup, blur', rule: 'required' },
                { input: '#nombre_comercial', message: 'Razón social debe contener solo letras!', action: 'keyup', rule: 'notNumber' },
                { input: '#nombre_comercial', message: 'Razón social debe contener de 3 a 40 caracteres!', action: 'keyup', rule: 'length=3,40' },
                { input: '#telefono', message: 'Telefono es requerido!', action: 'keyup, blur', rule: 'required' },
                { input: '#celular', message: 'Celular es requerido!', action: 'keyup, blur', rule: 'required' },
                { input: '#email', message: 'email es requerido!', action: 'keyup, blur', rule: 'required' },
                { input: '#email', message: 'e-mail invalido!', action: 'keyup', rule: 'email' }
                ]
            });	
            
            //codigo para inicializacion del formulario
            function createElements() {
            
            $('#eventWindow').jqxWindow({
                resizable: true,
                width: 400,
                height: 300,
				theme: tema,
                minWidth: 400,
                minHeight: 300,
                isModal: true,
                modalOpacity: 0.01,  
                //okButton: $('#btnSave'),
				cancelButton: $("#btnCancel"),
				initContent: function () {
					$('#id').jqxInput({theme:tema,disabled: true,width: '100px' });
					$('#ruc').jqxInput({theme:tema,width: '150px' });
					//$("#ruc").jqxMaskedInput({theme:tema, width: 150, height: 22, mask: '#############'});
					$('#razon_social').jqxInput({theme:tema,width: '200px'});
					$('#nombre_comercial').jqxInput({theme:tema,width: '200px'});
					$("#telefono").jqxMaskedInput({theme:tema, width: 200, height: 22, promptChar:' ', mask: '#########'});
					$("#celular").jqxMaskedInput({theme:tema, width: 200, height: 22, promptChar:' ',   mask: '##########'});
			        $('#email').jqxInput({theme:tema,width: '200px'});
					$('#estado').jqxInput({theme:tema,disabled: true, width: '20px'  });
                    $('#btnSave').jqxButton({theme:tema,width: '65px' });
                    $('#btnCancel').jqxButton({theme:tema, width: '65px' });
                    $("#ruc").jqxMaskedInput('clearValue')
                    $("#telefono").jqxMaskedInput('clearValue');
                    $("#celular").jqxMaskedInput('clearValue');
                    $('#btnSave').focus();
                }
            });
            
            $('#eventWindow').jqxWindow('focus');
            $('#eventWindow').jqxValidator('hide');
            
            }
            
          function ValidaDatos(){
           var esValido=true;
           if (!validaDoc($("#ruc").val())){
          	 jqxAlert.alert('RUC invalido!');
          	 esValido=false;
           }
           if (!validaTelefonoFijo($("#telefono").val())){
          	 jqxAlert.alert('Teléfono fijo invalido!');
          	 esValido=false;
           }
           if (!validaTelefonoMovil($("#celular").val())){
          	 jqxAlert.alert('Teléfono móvil invalido!');
          	 esValido=false;
           }
            
          	return esValido;
          }
            
          
            // codigo para afectar la base por insert o update.
	        $("#btnSave").click(function () {
                var validationResult = function (isValid) {
                    if (isValid) {
                       
                      var datos = {  
                       	accion: oper,
					   	id: $("#id").val(),
		                ruc: $("#ruc").val(),
		                razon_social: $("#razon_social").val(),
		                nombre_comercial: $("#nombre_comercial").val(),
		                telefono: $("#telefono").val(),
		                celular: $("#celular").val(),
		                email: $("#email").val(),
		                estado: $("#estado").val()
		               };		
		               //alert(JSON.stringify(producto));
		               //if (validaDoc($("#ruc").val())){
		               	if (ValidaDatos()){
		               	 //apprise('EL NUMERO DE DOCUMENTO INGRESADO ES CORRECTO');
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
			            })
		               }
		               else{
		               	//jqxAlert.alert('RUC invalido!');
		               }
		              
                    }
                }
                $('#eventWindow').jqxValidator('validate', validationResult);    	
		
			});	
        
           
        });
    </script>
	
 <div class='main'>
 	  <div class='titnavbg'>
	     <div class='titnavtit'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/inv.png">&nbsp;&nbsp;Inventario: Proveedores</div>
	    <div class='titnavlog'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/log_titulo.png"></div>
	  </div>
      <div style='margin-left: 0px; margin-top: 5px;' id='jqxMenu'></div> 
      <div  style='margin-left: 0px; margin-top: 5px;' id="jqxgrid"></div>
      <div style="visibility: hidden; display:none;" id="jqxWidget">

			<div id="eventWindow">
			<div>Proveedor</div>
			<div>
				<div>
				<form id="form">
					<table>
                  
                    <tr>
                        <td align="right">Id:</td>
                        <td align="left"><input id="id"/></td>
                    </tr>
                    <tr>
                        <td align="right">RUC:</td>
                        <td align="left"><input id="ruc" /></td>
                    </tr>
                    <tr>
                        <td align="right">Razon social:</td>
                        <td align="left"><input id="razon_social" /></td>
                    </tr>
                    <tr>
                        <td align="right">Nombre comercial:</td>
                        <td align="left"><input id="nombre_comercial" /></td>
                    </tr>
                    <tr>

                        <td align="right">Telefono:</td>
                        <td align="left"><input id="telefono" /></td>
                    </tr>
                    <tr>
                        <td align="right">Celular:</td>
                        <td align="left"><input id="celular" /></td>
                    </tr>
                    <tr>
                        <td align="right">email:</td>
                        <td align="left"><input id="email" /></td>
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