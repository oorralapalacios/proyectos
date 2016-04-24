<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.filter.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.sort.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.pager.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxpanel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdropdownlist.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxcombobox.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxlistbox.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxradiobutton.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxbuttongroup.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxtabs.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxmaskedinput.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/otwidgets/validadoc.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
    	var tema= "energyblue";
        var oper;
        var url = "<?php echo site_url("emp/empleados/ajax"); ?>";
		var tid="<?php echo $_GET["tid"]; ?>";
        menuopciones(tid);
		getComboRoles();
		getDepartamentos();
		setControles();
		
        var source =
        {
            datatype: "json",
            datafields: [
                { name: 'id', type: 'string' },
				{ name: 'rol_id', type: 'numeric' },
				{ name: 'usuario_id', type: 'numeric' },
				{ name: 'rol_usuario_id', type: 'numeric' },
				{ name: 'usuario', type: 'numeric' },
                { name: 'rol', type: 'string' },
                { name: 'departamento', type: 'string' },
                { name: 'departamento_id', type: 'numeric'},
				{ name: 'identificacion', type: 'string' },
				{ name: 'nombres', type: 'string' },
				{ name: 'apellidos', type: 'string' },
				{ name: 'genero', type: 'string' },
				{ name: 'direccion', type: 'string' },
				{ name: 'telefono', type: 'string' },
				{ name: 'celular', type: 'string' },
				{ name: 'email', type: 'string' },
				{ name: 'correo_institucional', type: 'string' },
                { name: 'estado', type: 'string' }
            ],
            id: 'id',
            url: url
        };
		
		
        var dataAdapter = new $.jqx.dataAdapter(source, {
            loadComplete: function (data) { },
            loadError: function (xhr, status, error) { }      
        });
        
        function menuopciones(padre_id){
			
			//var view='empleado_view'
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
         	        document.getElementById("fmpr").reset();
                    oper = 'add';
                    createElements();
                    getComboRoles();
				    getDepartamentos();
                    $("#eventWindow").window('open');
                    $("#id").val('New');
                    $("#rol_id").val(1);
                    $("#departamento_id").val(0);
                    $("#femenino").jqxRadioButton({ checked: false});
                    $("#masculino").jqxRadioButton({ checked: false});
                    $("#estado").val('AC');
        }
        
        function opeditar(){
        	            //document.getElementById("fmpr").reset();           
                        oper = 'edit';
                        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                        if (selectedrowindex >= 0 ) {
                        var offset = $("#jqxgrid").offset();
                        // get the clicked row's data and initialize the input fields.
                        var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex );
                        // show the popup window.
						if (dataRecord.estado=='AC'){
							createElements();
							getComboRoles();
				            getDepartamentos();
							$("#id").val(dataRecord.id);
							$("#rol_id").val(dataRecord.rol_id);
							$("#rol_usuario_id").val(dataRecord.rol_usuario_id);
							$("#usuario_id").val(dataRecord.usuario_id);
							$("#departamento_id").val(dataRecord.departamento_id);
							$("#identificacion").val(dataRecord.identificacion);
							$("#nombre").val(dataRecord.nombres);
							$("#apellido").val(dataRecord.apellidos);
							$("#genero").val(dataRecord.genero);
							$("#direccion").val(dataRecord.direccion);
							$("#telefono").jqxMaskedInput('maskedValue',dataRecord.telefono);
							$("#celular").jqxMaskedInput('maskedValue',dataRecord.celular);
							//$("#telefono").val(dataRecord.telefono);
							//$("#celular").val(dataRecord.celular);
							$("#email").val(dataRecord.email);
							$("#correo_institucional").val(dataRecord.correo_institucional);
							$("#estado").val(dataRecord.estado);
							if(dataRecord.genero=='F'){
								$("#femenino").jqxRadioButton({ checked: true});			
							}else{
								$("#masculino").jqxRadioButton({ checked: true});
							}
							$("#eventWindow").window('open');
						}else{
							alert("No se puede editar registro.");
						}
						}else{
	                        	jqxAlert.alert('Seleccione un registro','Editar');
	                    }
        } 
        
        
         function opborrar(){
        	            oper = 'del';
                        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                        if (selectedrowindex >= 0 ) {
                        var offset = $("#jqxgrid").offset();
                        // get the clicked row's data and initialize the input fields.
                        var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex );
                        var empleado = {
                            accion: oper,
                            id: dataRecord.id,
							usuario_id: dataRecord.usuario_id
                        };
						jqxAlert.verify('Esta seguro de Borrar?','Dialogo de confirmacion', function(r) {
					    if(r){
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: empleado,
                            success: function (data) {
                                if(data=true){
                                    $("#eventWindow").window('close');
                                    $("#jqxgrid").jqxGrid('updatebounddata');
                                    alert("El dato se Elimin� correctamente.");
                                }else{
                                    alert("Problemas al Eliminar.");
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
                     }else{
	                        	jqxAlert.alert('Seleccione un registro','Borrar');
	                 }
        	
        }	
        
        function opreconsular(){
			 $("#jqxgrid").jqxGrid('updatebounddata');
		}
		
		function getDepartamentos(){
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
			   $('#departamento_id').jqxDropDownList({
							source: dataAdapter,
							width: 200,
							//height: 20,
						    theme: tema,
						    selectedIndex: 0,
							displayMember: 'nombre',
							valueMember: 'id'
		         });  	
	 }
		
		function getComboRoles(){
            var sr = {
                datatype: "json",
                datafields: [
                    { name: 'id'},
                    { name: 'nombre'}
                ],
                url: '<?php echo site_url("seg/roles/get_roles/"); ?>',
                async: false
            };
            var dar = new $.jqx.dataAdapter(sr);
            $("#rol_id").jqxDropDownList({
                source: dar,
                width: 180,
                theme: tema,
                selectedIndex: 0,
                displayMember: 'nombre',
                valueMember: 'id'
            });  
        }
		
		//Codigo de operaciones en la Grilla
        $("#jqxgrid").jqxGrid({
            width : '100%',
            height: '80%',
            source: dataAdapter,
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
				{ text: 'rol_id', datafield: 'rol_id', width: '5%',hidden:true },
				{ text: 'usuario_id', datafield: 'usuario_id', width: '5%',hidden:true },
				{ text: 'rol_usuario_id', datafield: 'rol_usuario_id', width: '5%',hidden:true },
				{ text: 'Rol', datafield: 'rol', width: '8%' },
				{ text: 'Departamento', datafield: 'departamento', width: '8%' },
				{ text: 'departamento_id', datafield: 'departamento_id', width: '5%',hidden:true },
				{ text: 'Usuario', datafield: 'usuario', width: '8%' },
                { text: 'Identificacion', datafield: 'identificacion', width: '8%' },
				{ text: 'Nombres', datafield: 'nombres', width: '10%' },
				{ text: 'Apellidos', datafield: 'apellidos', width: '10%' },
				{ text: 'Genero', datafield: 'genero', width: '3%' },
				{ text: 'Direccion', datafield: 'direccion', width: '10%' },
				{ text: 'Telefono', datafield: 'telefono', width: '8%' },
				{ text: 'Celular', datafield: 'celular', width: '9%' },
				{ text: 'E-mail', datafield: 'email', width: '15%' },
				{ text: 'Correo Institucional', datafield: 'correo_institucional', width: '15%' },
                { text: 'Estado', datafield: 'estado', width: '4%' },
          ]
        });
       
        
		
		//codigo para validacion de entradas
        $('#eventWindow').jqxValidator({
            hintType: 'label',
            animationDuration: 0,
            rules: [
                { input: '#identificacion', message: 'Identificaci�n debe tener 10 caracteres!', action: 'keyup, blur', rule: 'length=10,10' },
				{ input: '#nombre', message: 'Nombres es requerido!', action: 'keyup, blur', rule: 'required' },
				{ input: '#apellido', message: 'Apellidos es requerido!', action: 'keyup, blur', rule: 'required' },
				{ input: '#genero', message: 'Genero es requerido!', action: 'keyup, blur', rule: 'required' },
				{ input: '#direccion', message: 'Direccion es requerido!', action: 'keyup, blur', rule: 'required' },
				{ input: '#telefono', message: 'Telefono es requerido!', action: 'keyup, blur', rule: 'required' },
                { input: '#celular', message: 'Celular es requerido!', action: 'keyup, blur', rule: 'required' },
				{ input: '#email', message: 'email es requerido!', action: 'keyup, blur', rule: 'required' },
                { input: '#email', message: 'e-mail invalido!', action: 'keyup', rule: 'email' },
                { input: '#correo_institucional', message: 'email es requerido!', action: 'keyup, blur', rule: 'required' },
                { input: '#correo_institucional', message: 'e-mail invalido!', action: 'keyup', rule: 'email' }
            ]
        });	
        
        		
        //codigo para inicializacion del formulario
        function createElements() {
            $('#eventWindow').window({
                resizable: false,
                width: '700px',
                height: '80%',
                modal: true,
                minimizable: false,  
                maximizable:false,
                collapsible:false,
                minimized:true
            });
            //$('#eventWindow').jqxWindow('focus');
            //$('#eventWindow').jqxValidator('hide');
       };
		
		function setControles(){
			        $('#id').jqxInput({disabled: true,width: '100px' });
                   // $('#usuario').jqxComboBox({width: '200px',placeHolder: "Ingrese usuario" });
				    $('#identificacion').jqxInput({width: '200px',theme: tema, placeHolder: "Ingrese identificacion" });
					$('#nombre').jqxInput({width: '400px',theme: tema, placeHolder: "Ingrese nombre" });
					$('#apellido').jqxInput({width: '400px',theme: tema, placeHolder: "Ingrese apellido" });
					$("#femenino").jqxRadioButton({ theme: tema, width: 250, height: 25});
            		$("#masculino").jqxRadioButton({theme: tema, width: 250, height: 25});
					$('#genero').jqxInput({theme: tema,disabled: true,width: '0px'});
					$("#femenino").on('checked', function () {
							  $("#genero").val('F');
					});
					
					$("#masculino").on('checked', function () {
							   $("#genero").val('M');
					});
					$('#direccion').jqxInput({theme: tema, width: '400px',placeHolder: "Ingrese direccion" });
					$("#telefono").jqxMaskedInput({theme: tema, width: 400, height: 22, promptChar:' ', mask: '#########'});
					$("#celular").jqxMaskedInput({theme: tema, width: 400, height: 22, promptChar:' ',   mask: '##########'});
			        //$("#telefono").jqxInput({theme: tema, width: '400px', placeHolder: "Ingrese telefono"});
					//$("#celular").jqxInput({theme: tema, width: '400px', placeHolder: "Ingrese celular"});
			        $('#email').jqxInput({theme: tema, width: '400px',placeHolder: "Ingrese email" });
					$('#correo_institucional').jqxInput({theme: tema, width: '400px',placeHolder: "Ingrese correo" });
                    $('#estado').jqxInput({theme: tema, disabled: true, width: '20px'  });
                    $('#btnSave').jqxButton({theme: tema, width: '65px' });
                    $('#btnCancel').jqxButton({theme: tema, width: '65px' });
                     $('#btnCancel').click(function(){
                     	$("#eventWindow").window('close');
                     });
                    $('#btnSave').focus();
		};
		
		     
          function ValidaDatos(){
           var esValido=true;
           if (!validaDoc($("#identificacion").val())){
          	 jqxAlert.alert('Identificación invalida!');
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
                    var empleado = {  
                        accion: oper,
                        id: $("#id").val(),
                        rol_id: $("#rol_id").val(),
						usuario_id: $("#usuario_id").val(),
						rol_usuario_id: $("#rol_usuario_id").val(),
						departamento_id: $("#departamento_id").val(),
						identificacion: $("#identificacion").val(),
						nombres: $("#nombre").val(),
						apellidos: $("#apellido").val(),
						genero: $("#genero").val(),
						direccion: $("#direccion").val(),
						telefono: $("#telefono").val(),
						celular: $("#celular").val(),
						email: $("#email").val(),
						correo_institucional: $("#correo_institucional").val(),
                        estado: $("#estado").val()
                    };	
                    	
                 	if (ValidaDatos()){
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: empleado,
                        success: function (data) {
							//alert(data);
							if(data=true){
                                $("#eventWindow").window('close');
                                $("#jqxgrid").jqxGrid('updatebounddata');
                                alert("El dato se grabo correctamente.");
                            }else{
                                alert("Problemas al guardar.");
                            }
                        },
                        error: function (msg) {
                            //alert(msg.responseText);
                        }
                    })
                    }
		             else{
		               	//jqxAlert.alert('Cédula invalida!');
		            }	
                }
            }
            $('#eventWindow').jqxValidator('validate', validationResult);    	
        });
       
    });
</script>

<div class="main">
	<div class='titnavbg'>
     <div class='titnavtit'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/seg.png">&nbsp;&nbsp;Empresa: Empleados</div>
     <div class='titnavlog'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/log_titulo.png"></div>
    </div>
    <div style='margin-left: 0px; margin-top: 5px;' id='jqxMenu'></div>
    <div style='margin-left: 0px; margin-top: 5px;' id="jqxgrid"></div>
    <div style="visibility: hidden; display:none;" id="jqxWidget">
        <div id="eventWindow" title="Empleado">
             <div>
                <div>
                    <form id="fmpr">
                        <table>
                            <tr>
                                <td align="right">Id:</td>
                                <td align="left" colspan="2"><input id="id"/></td>
                            </tr>
                            <tr>
                                <td align="right">Rol:</td>
                                <td align="left" colspan="2"><div id="rol_id"></div><input type="hidden" id="usuario_id" /><input type="hidden" id="rol_usuario_id" /></td>
                            </tr>
                            <tr>
                                <td align="right">Departamento:</td>
                                <td align="left" colspan="2"><div id="departamento_id"></div><input type="hidden" id="usuario_id1" /><input type="hidden" id="roles_usuarios_id1" /></td>
                            </tr>
							<tr>
                                <td align="right">Identificacion:</td>
                                <td align="left" colspan="2"><input id="identificacion" /></td>
                            </tr>
							<tr>
                                <td align="right">Nombres:</td>
                                <td align="left" colspan="2"><input id="nombre" /></td>
                            </tr>
							<tr>
                                <td align="right">Apellidos:</td>
                                <td align="left" colspan="2"><input id="apellido" /></td>
                            </tr>
							<tr>
                                <td align="right">Genero:</td>
                                <td align="left"><div style="margin-top: 10px;">
											<div style="margin: 3px;" id="femenino">
												Femenino</div>
											<div style="margin: 3px;" id="masculino">
												Masculino</div>
										</div></td>
										<td align="left"><input id="genero" type="hidden"/></td>
                            </tr>
							<tr>
                                <td align="right">Direccion:</td>
                                <td align="left" colspan="2"><input id="direccion" /></td>
                            </tr>
							<tr>
                                <td align="right">Telefono:</td>
                                <td align="left" colspan="2"><input id="telefono" /></td>
                            </tr>
							<tr>
                                <td align="right">Celular:</td>
                                <td align="left" colspan="2"><input id="celular" /></td>
                            </tr>
							<tr>
                                <td align="right">E-mail:</td>
                                <td align="left" colspan="2"><input id="email" /></td>
                            </tr>
							<tr>
                                <td align="right">Correo Institucional:</td>
                                <td align="left" colspan="2"><input id="correo_institucional" /></td>
                            </tr>
                            <tr>
                                <td align="right">Estado:</td>
                                <td align="left" colspan="2"><input id="estado" /></td>
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