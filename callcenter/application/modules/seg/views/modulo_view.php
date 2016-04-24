<?php echo modules::run('login/menu_rol');?>
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
    $(document).ready(function () {
        //carga datos iniciales en grilla
        loadGrid(1);
        
        //combo modulos
        var s2 = {
            datatype: "json",
            datafields: [
                { name: 'id'},
                { name: 'nombre'}
            ],
            url: '<?php echo site_url("seg/modulos/get_modulos/"); ?>',
            async: false
        };
        var da2 = new $.jqx.dataAdapter(s2);
        $("#ddlModulos").jqxDropDownList({
            source: da2,
            width: 150,
			theme: "ui-start",
            height: 25,
            selectedIndex: 0,
            displayMember: 'nombre',
            valueMember: 'id'
        });   
        
        //carga datos en grilla
        function loadGrid(id){
            var url = '<?php echo site_url("seg/modulos/ajax/"); ?>/'+id;
            var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'id', type: 'string' },
                    { name: 'modulo_id', type: 'string' },
                    { name: 'nombre', type: 'string' },
                    { name: 'url', type: 'string' },
                    { name: 'orden', type: 'string' },
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
				theme: "ui-start",
                source: da1,
                columns: [
                    /*{ text: 'id', datafield: 'id', width: '5%', hidden:true },
                    { text: 'modulo_id', datafield: 'modulo_id', width: '5%', hidden:true },*/
                    { text: 'nombre', datafield: 'nombre', width: '30%' },
                    { text: 'url', datafield: 'url', width: '35%' },
                    { text: 'orden', datafield: 'orden', width: '15%' },
                    { text: 'Estado', datafield: 'estado', width: '20%' }
                ]
            });
        }
            
        
        //botones
        $("#btnBuscar").jqxButton({ theme: "ui-start", width: '85px', height: '19px'});
        $("#btnBuscar").on('click', function () {
            var item = $("#ddlModulos").jqxDropDownList('getSelectedItem'); 
            loadGrid(item.value);
        });
        $("#btnNuevo").jqxButton({ theme: "ui-start", width: '85px', height: '19px'});
        $("#btnNuevo").on('click', function () {
             $("#winNuevo").jqxWindow('open');
             var item = $("#ddlModulos").jqxDropDownList('getSelectedItem'); 
             $("#txtModulo").jqxInput({value: item.label});
             $("#txtModulo").jqxInput({disabled: true});
        });
        $("#btnEditar").jqxButton({ theme: "ui-start", width: '85px', height: '19px'});
        $("#btnEditar").on('click', function () {
            var rowindex = $('#jqxGrid').jqxGrid('getselectedrowindex');
            if(rowindex<0){
                alert('Seleccione un registo por favor.');
            }else{
                $("#winEditar").jqxWindow('open');
                var item = $("#ddlModulos").jqxDropDownList('getSelectedItem');
                $("#txtModuloEdi").jqxInput({value: item.label});
                $("#txtModuloEdi").jqxInput({disabled: true});
                
                var valnom = $('#jqxGrid').jqxGrid('getcellvalue', rowindex, "nombre");
                var valurl = $('#jqxGrid').jqxGrid('getcellvalue', rowindex, "url");
                var valord = $('#jqxGrid').jqxGrid('getcellvalue', rowindex, "orden");
                $("#txtNombreEdi").jqxInput({value: valnom});
                $("#txtUrlEdi").jqxInput({value: valurl});
                $("#txtOrdenEdi").jqxInput({value: valord});
            }
        });
        $("#btnBorrar").jqxButton({ theme: "ui-start", width: '85px', height: '19px'});
        $("#btnBorrar").on('click', function () {
            var rowindex = $('#jqxGrid').jqxGrid('getselectedrowindex');
            if(rowindex<0){
                alert('Seleccione un registo por favor.');
            }else{
			
                alert('Acción de borrado.');
            }
        });
        
        
        
        $("#sendButton").on('click', function () {
             null;
        });
        
        //ventanas
        $("#winNuevo").jqxWindow({ 
            width: 400, 
			theme: "ui-start",
            isModal: true, 
            autoOpen: false, 
            draggable: false, 
            resizable: false, 
            title: 'Nueva opción'
        });
         $("#winEditar").jqxWindow({ 
            width: 400, 
			theme: "ui-start",
            isModal: true, 
            autoOpen: false, 
            draggable: false, 
            resizable: false, 
            title: 'Editar opción'
        });
        
        
        
        
    });
</script>
<div class='titnavbg'>
    <div class='titnavtit'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/seg.png">&nbsp;&nbsp;Seguridad: Módulos y opciones</div>
    <div class='titnavlog'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/log_titulo.png"></div>
</div>
<div class="main">
    <div class="divbtn">
        <div style='float: left; padding-top: 5px; font-size: 14px;'>&nbsp;Módulos&nbsp;</div>
        <div id='ddlModulos' style='float: left; position:relative; margin:auto;'></div>
        <div style='float: left;'>&nbsp;</div>
        <div id='btnBuscar' style='float: left; position:relative; margin:auto;' >
            <img style="vertical-align: middle;" src='<?php echo base_url(); ?>assets/img/icover.png' />&nbsp;Buscar
        </div>
        <div style='float: left;'>&nbsp;</div>
        <div style='float: left;'>&nbsp;</div>
        <div style='float: left;'>&nbsp;</div>
        <div id='btnNuevo' style='float: left; position:relative; margin:auto;' >
            <img style="vertical-align: middle;" src='<?php echo base_url(); ?>assets/img/iconue.png' />&nbsp;Nuevo
        </div>
        <div style='float: left;'>&nbsp;</div>
        <div id='btnEditar' style='float: left; position:relative; margin:auto;' >
            <img style="vertical-align: middle;" src='<?php echo base_url(); ?>assets/img/icoedi.png' />&nbsp;Editar
         </div>
        <div style='float: left;'>&nbsp;</div>
        <div id='btnBorrar' style='float: left; position:relative; margin:auto;' >
            <img style="vertical-align: middle;" src='<?php echo base_url(); ?>assets/img/icobor.png' />&nbsp;Borrar
        </div>
    </div>
    <div id="jqxGrid"></div>   
    
    
    <div id='winNuevo'>
        <div>
            <form id="form" method="post" action="#">
                <table>
                    <tr>
                        <td><b>Módulo:</b></td>
                        <td><input type="text" id="txtModulo" class="text-input" style="width:200px" maxlength="90" /></td>
                    </tr>
                    <tr>
                        <td>Nombre:</td>
                        <td><input type="text" id="txtNombre" class="text-input" style="width:200px" maxlength="90" /></td>
                    </tr>
                    <tr>
                        <td>Url:</td>
                        <td><input type="text" id="txtUrl" class="text-input" style="width:300px" maxlength="140" /></td>
                    </tr>
                    <tr>
                        <td>Orden:</td>
                        <td><input type="text" id="txtOrden" class="text-input" style="width:50px" maxlength="40" /></td>
                    </tr>
                </table>
                <div style="clear: both;"></div>
                <input type="button" value="Guardar" id="sendButton" />
            </form>
        </div>
    </div>
    <div id='winEditar'>
        <div>
            <form id="form" method="post" action="#">
                <table>
                    <tr>
                        <td><b>Módulo:</b></td>
                        <td><input type="text" id="txtModuloEdi" class="text-input" style="width:200px" maxlength="90" /></td>
                    </tr>
                    <tr>
                        <td>Nombre:</td>
                        <td><input type="text" id="txtNombreEdi" class="text-input" style="width:200px" maxlength="90" /></td>
                    </tr>
                    <tr>
                        <td>Url:</td>
                        <td><input type="text" id="txtUrlEdi" class="text-input" style="width:300px" maxlength="140" /></td>
                    </tr>
                    <tr>
                        <td>Orden:</td>
                        <td><input type="text" id="txtOrdenEdi" class="text-input" style="width:50px" maxlength="40" /></td>
                    </tr>
                </table>
                <div style="clear: both;"></div>
                <input type="button" value="Guardar cambios" id="sendButton" />
            </form>
        </div>
    </div>
        
</div>