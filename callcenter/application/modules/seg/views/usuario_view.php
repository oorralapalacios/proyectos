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
<script type="text/javascript">
    var tema= "ui-redmond";
    $(document).ready(function () {
    	 menuopciones();
        //carga datos iniciales en grilla
        loadGrid();
        
        function menuopciones(){
			 $("#jqxMenu").jqxMenu({theme: tema, width: '100%', height: '30px', autoOpen: false, autoCloseOnMouseLeave: false, showTopLevelArrows: true});
                $("#jqxMenu").css('visibility', 'visible');
        }
        
        //carga datos en grilla
        function loadGrid(){
            var url = '<?php echo site_url("seg/usuarios/ajax/"); ?>';
            var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'id', type: 'integer' },
                    { name: 'usuario_id', type: 'integer' },
                    { name: 'usuario', type: 'string' },
                    { name: 'nombre', type: 'string' },
                    { name: 'rol', type: 'string' },
                    { name: 'ultimo_acceso', type: 'string' },
                    { name: 'numero_accesos', type: 'integer' },
                    { name: 'estado', type: 'string' }
                ],
                id: 'id',
                url: url
            };
            var da1 = new $.jqx.dataAdapter(source, {
                loadComplete: function (data) { },
                loadError: function (xhr, status, error) { }      
            });
            $("#jqxGrid").jqxGrid({
                width : '100%',
                height: '80%',
				theme: tema,
                source: da1,
                //showfilterrow: true,
                filterable: true,
                columns: [
                    { text: 'id', datafield: 'id', width: '5%', hidden:true },
                    { text: 'id_usuario', datafield: 'usuario_id', width: '7%', hidden:true },
                    { text: 'usuario', datafield: 'usuario', width: '11%' },
                    { text: 'nombre', datafield: 'nombre', width: '27%' },
                    { text: 'rol', datafield: 'rol', width: '16%' },
                    { text: 'ultimo_acceso', datafield: 'ultimo_acceso', width: '20%' },
                    { text: '# accesos', datafield: 'numero_accesos', width: '7%' },
                    { text: 'estado', datafield: 'estado', width: '7%' }
                ]
            });
        }
            
        //botones
        $("#btnResetear").jqxButton({ theme: tema, width: '125px', height: '19px'});
        $("#btnResetear").click(function () {
            var rowindex = $('#jqxGrid').jqxGrid('getselectedrowindex');
            if(rowindex<0){
                alert('Seleccione un registo por favor.');
            }else{
                $("#winConResetar").jqxWindow('open');
            }
            
        });
        $("#btnEditarRol").jqxButton({theme: tema, width: '110px', height: '19px'});
        $("#btnEditarRol").click(function () {
            var rowindex = $('#jqxGrid').jqxGrid('getselectedrowindex');
            if(rowindex<0){
                alert('Seleccione un registo por favor.');
            }else{
                $("#winEdiRol").jqxWindow('open');
                var valusuid = $('#jqxGrid').jqxGrid('getcellvalue', rowindex, "usuario_id");
                var valusu = $('#jqxGrid').jqxGrid('getcellvalue', rowindex, "usuario");
                var valnom = $('#jqxGrid').jqxGrid('getcellvalue', rowindex, "nombre");
                var valrolact = $('#jqxGrid').jqxGrid('getcellvalue', rowindex, "rol");
                $("#txtUsuarioId").jqxInput({value: valusuid});
                $("#txtUsuario").jqxInput({value: valusu});
                $("#txtNombre").jqxInput({value: valnom});
                $("#txtRolActual").jqxInput({value: valrolact});
                //combo
                getComboRoles();
                //desahilita txt
                $("#txtUsuarioId").jqxInput({disabled: true});
                $("#txtUsuario").jqxInput({disabled: true});
                $("#txtNombre").jqxInput({disabled: true});
                $("#txtRolActual").jqxInput({disabled: true});
                
                
            }
        });
        $('#btnEdiRolGuardar').jqxButton({theme:tema,width: '65px' });  
        $("#btnEdiRolGuardar").click(function () {
            var rowindex = $('#jqxGrid').jqxGrid('getselectedrowindex');
            var valusu = $('#jqxGrid').jqxGrid('getcellvalue', rowindex, "usuario");
            var valusuid = $('#jqxGrid').jqxGrid('getcellvalue', rowindex, "usuario_id");
            var item = $("#CbxRoles").jqxDropDownList('getSelectedItem');
            var valrolid = item.value;
            
            var varedirol = {  
                accion: 'edirol',
                usuario_id: valusuid,
                rol_id: valrolid
            };		

            $.ajax({
                type: "POST",
                url: "<?php echo site_url("seg/usuarios/ajax/"); ?>",
                data: varedirol,
                success: function (data) {
                    if(data=true){
                        $("#winEdiRol").jqxWindow('close');
                        $("#jqxGrid").jqxGrid('updatebounddata');
                        alert("Rol cambiado para el usuario ["+valusu+"]");
                    }else{
                        alert("Problemas al guardar.");
                    }
                },
                error: function (msg) {
                    alert(msg.responseText);
                }
            });	
        });   
            $('#btnEdiRolCancelar').jqxButton({theme:tema,width: '65px' });
            $("#btnEdiRolCancelar").click(function () {
            $("#winEdiRol").jqxWindow('close');
        });
        
        //combos
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
            $("#CbxRoles").jqxDropDownList({
                source: dar,
                width: 180,
				theme: tema,
                selectedIndex: 0,
                displayMember: 'nombre',
                valueMember: 'id'
            });  
        }
            
            
        
        //ventanas
        $("#winConResetar").jqxWindow({ 
            width: 300, 
			theme: tema,
            isModal: true, autoOpen: false,
            draggable: false, resizable: false
        });
       
        $('#btnAceptar').jqxButton({theme:tema,width: '65px' });  
        $("#btnAceptar").click(function () {
            var rowindex = $('#jqxGrid').jqxGrid('getselectedrowindex');
            var valusu = $('#jqxGrid').jqxGrid('getcellvalue', rowindex, "usuario");
            var varres = {  
                accion: 'res',
                usuario: valusu
            };		

            $.ajax({
                type: "POST",
                url: "<?php echo site_url("seg/usuarios/ajax/"); ?>",
                data: varres,
                success: function (data) {
                    if(data=true){
                        $("#winConResetar").jqxWindow('close');
                        $("#jqxGrid").jqxGrid('updatebounddata');
                        alert("Clave reseteada para el usuario ["+valusu+"]");
                    }else{
                        alert("Problemas al guardar.");
                    }
                },
                error: function (msg) {
                    alert(msg.responseText);
                }
            });	
        });
        $('#btnCancelar').jqxButton({theme:tema,width: '65px' });  
        $("#btnCancelar").click(function () {
            $("#winConResetar").jqxWindow('close');
        });
        
        //
        $("#winEdiRol").jqxWindow({ 
            width: 400,
            height: 250,
			theme: tema,
            isModal: true, autoOpen: false, 
            draggable: false, resizable: false,
            initContent: function () {
            	
    
            }
        });
     
        
    });
</script>
<div class="main">
	<div class='titnavbg'>
      <div class='titnavtit'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/seg.png">&nbsp;&nbsp;Seguridad: Usuarios</div>
      <div class='titnavlog'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/log_titulo.png"></div>
    </div>
    <div style='margin-left: 0px; margin-top: 5px;' id='jqxMenu'>
   		<ul>
   			<li style='list-style: none;' ignoretheme='true'>
   				<div id='btnResetear' style='float: left; position:relative; margin:auto;' >
                <img style="vertical-align: middle;" src='<?php echo base_url(); ?>assets/img/icoref.png' />&nbsp;Resetear clave
                </div>
		    </li>
		    <li style='list-style: none;' ignoretheme='true'>
		        <div id='btnEditarRol' style='float: left; position:relative; margin:auto;' >
                <img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/icoedi.png" />&nbsp;Cambiar rol
                </div>
		    </li>
		        			
   		</ul>
        
    </div>
    
    <div style='margin-left: 0px; margin-top: 5px;' id="jqxGrid"></div> 
</div>
<div>
	
    
    
     
    
    <div style="visibility: hidden;">
    <div id="winConResetar">
        <div><img width="14" height="14" src="<?php echo base_url(); ?>assets/img/help.png" /> Confirmación</div>
        <div>
            <div>
                ¿Realmente desea resetear clave del usuario seleccionado?
            </div>
            <div>
            <div style="float: right; margin-top: 15px;">
                <input type="button" id="btnAceptar" value="Aceptar" style="margin-right: 5px" />
                <input type="button" id="btnCancelar" value="Cancelar" />
            </div>
            </div>
        </div>
    </div>
   
    <div id='winEdiRol'>
        <div><img width="14" height="14" src="<?php echo base_url(); ?>assets/img/help.png" /> Cambiar rol</div>
        <div>
            <form id="form" method="post" action="#">
                <table>
                    <tr>
                        <td><!--usuario_id:--></td>
                        <td><input type="hidden" id="txtUsuarioId" class="text-input" style="width:20px" maxlength="3" /></td>
                    </tr>
                    <tr>
                        <td>Usuario:</td>
                        <td><input type="text" id="txtUsuario" class="text-input" style="width:100px" maxlength="10" /></td>
                    </tr>
                    <tr>
                        <td>Nombre:</td>
                        <td><input type="text" id="txtNombre" class="text-input" style="width:300px" maxlength="150" /></td>
                    </tr>
                    <tr>
                        <td>Rol actual:</td>
                        <td><input type="text" id="txtRolActual" class="text-input" style="width:170px" maxlength="100" /></td>
                    </tr>
                    <tr>
                        <td>Nuevo rol:</td>
                        <td><div id="CbxRoles"></div></td>
                    </tr>
                </table>
                <div style="clear: both;"></div>
                 <div style="float: right; margin-top: 15px;">
                   <input type="button" id="btnEdiRolGuardar" value="Aceptar" style="margin-right: 5px" />
                   <input type="button" id="btnEdiRolCancelar" value="Cancelar" />
                 </div>
            </form>
        </div>
    </div>
    </div>
</div>