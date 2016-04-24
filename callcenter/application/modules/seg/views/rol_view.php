<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxcore.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdata.js"></script>
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
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxbuttons.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxscrollbar.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxmenu.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdatatable.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxtreegrid.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxwindow.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxpasswordinput.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxinput.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxtabs.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxsplitter.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxvalidator.js"></script>
<script type="text/javascript">
    var tema= "ui-redmond";
    $(document).ready(function () {
        //carga datos iniciales en grilla
        menuopciones();
        initControl();
        listRoles();
        listModulos();
        loadDatos();
        $('#ddlRoles').on('select', function (event) {
        	 loadDatos();
		  });	
          $('#ddlModulos').on('select', function (event) {
          	 loadDatos();
          });
         
        function initControl(){
         	 $('#jqxSplitter').jqxSplitter({theme: tema, width: '100%', height: '100%', panels: [{ size: '50%' }, { size: '50%' }] });
        }
          
        function loadDatos(){
	      	var irol = $("#ddlRoles").jqxDropDownList('getSelectedItem'); 
	        var imod = $("#ddlModulos").jqxDropDownList('getSelectedItem'); 
	        loadTreeOpciones(irol.value,imod.value);
	        loadTreeDepartamentos(irol.value,imod.value);
        }
        
        // select or unselect rows when the checkbox is checked or unchecked.
        $("#jqxGrid").bind('cellendedit', function (event) {
            if (event.args.value) {
                $("#jqxGrid").jqxGrid('selectrow', event.args.rowindex);
            }
            else {
                $("#jqxGrid").jqxGrid('unselectrow', event.args.rowindex);
            }
        });
       
        
        
        $("#btnSaveOpciones").jqxButton({ theme: tema, width: '85px', height: '19px'});
        $("#btnSaveOpciones").on('click', function (){
         	       	
         	guarda_roles_opciones();
         	
         	
         });
       
       $("#btnSaveDepartamentos").jqxButton({ theme: tema, width: '85px', height: '19px'});
        $("#btnSaveDepartamentos").on('click', function (){
         	       	
         
         	guarda_roles_departamentos();
         	
         });
       
       
         
       
       function guarda_roles_opciones(){
               var valrol = $("#ddlRoles").jqxDropDownList('getSelectedItem');
         	   var valmod = $("#ddlModulos").jqxDropDownList('getSelectedItem');
         	   var lblrol = valrol.label;
         	   var rows = $("#jqxGrid").jqxTreeGrid('getRows');
         	   
         	   var rowsData  = [];
		       var datosTree = function(rows)
		       {
		          for(var i = 0; i < rows.length; i++)
		          {
		              
		              rowsData.push(rows[i]);
		              if (rows[i].records)
		              {
		                  datosTree(rows[i].records);
		              }
		          }
		       };
		       datosTree(rows);
		         	   
            var opcsel = "";
            var totsel = 0;
            //cuento las seleccionadas
            for(var i = 0; i < rowsData.length; i++){
                var row = rowsData[i];
                if(row.available=='true'){totsel++; }
            }
            //array de seleccionadas
            var consel = 0;
            for(var i = 0; i < rowsData.length; i++){
                var row = rowsData[i];
                if(row.available=='true'){
                    consel++;
                    if(consel==totsel){ opcsel += row.opcion_id; }else{ opcsel += row.opcion_id+","; }
                }
            }
            
            if(consel > 0){
                var vardel = {  
                    accion: 'delopcrol',
                    rol_id: valrol.value,
                    modulo_id: valmod.value
                };
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url("seg/roles/ajax/2/1"); ?>",
                    data: vardel,
                    success: function (data) {
                        if(data=true){
                            //asigna opciones roles
                            var varasi = {  
                                accion: 'guaopcrol',
                                rol_id: valrol.value,
                                opcion_id: opcsel
                            };
                            $.ajax({
                                type: "POST",
                                url: "<?php echo site_url("seg/roles/ajax/2/1"); ?>",
                                data: varasi,
                                success: function (data) {
                                    if(data=true){
                                        alert("Opciones asignadas correctamente para el rol ["+lblrol+"]");
                                     }else{
                                        alert("Problemas al asignar opciones para el rol ["+lblrol+"]");
                                    }
                                },
                                error: function (msg) {
                                    alert(msg.responseText);
                                }
                            });
                            
                        }else{
                            alert("Problemas al guardar.");
                        }
                    },
                    error: function (msg) {
                        alert(msg.responseText);
                    }
                });	
            }
            
       }
       
       function guarda_roles_departamentos(){
       	       var valrol = $("#ddlRoles").jqxDropDownList('getSelectedItem');
         	   var valmod = $("#ddlModulos").jqxDropDownList('getSelectedItem');
         	   var lblrol = valrol.label;
         	   var rows = $("#jqxtreegridDatos").jqxTreeGrid('getRows');
         	    
         	   var rowsData  = [];
		       var datosTree = function(rows)
		       {
		          for(var i = 0; i < rows.length; i++)
		          {
		              
		              rowsData.push(rows[i]);
		              if (rows[i].records)
		              {
		                  datosTree(rows[i].records);
		                  
		              }
		          }
		       };
		       datosTree(rows);
		     
            var depsel = "";
            var totsel = 0;
            //cuento las seleccionadas
            for(var i = 0; i < rowsData.length; i++){
                var row = rowsData[i];
                if(row.available=='true'){totsel++; }
            }
             
		         	   
            //array de seleccionadas
            var csel = 0;
            for(var i = 0; i < rowsData.length; i++){
                var row = rowsData[i];
                
                if(row.available=='true'){
                    csel++;
                    if(csel==totsel){ depsel += row.departamento_id; }else{ depsel += row.departamento_id+","; }
                    
                }
                
            }
            
            if(csel > 0){
            	
                  var vardel = {  
                    accion: 'deldeprol',
                    rol_id: valrol.value,
                    modulo_id: valmod.value
                };
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url("seg/roles/ajax/2/1"); ?>",
                    data: vardel,
                    success: function (data) {
                        if(data=true){
                            //asigna opciones roles
                            var varasi = {  
                                accion: 'guadeprol',
                                rol_id: valrol.value,
                                departamento_id: depsel
                            };
                            $.ajax({
                                type: "POST",
                                url: "<?php echo site_url("seg/roles/ajax/2/1"); ?>",
                                data: varasi,
                                success: function (data) {
                                    if(data=true){
                                        alert("Permisos asignados para el rol ["+lblrol+"]");
                                     }else{
                                        alert("Problemas al asignar departamento para el rol ["+lblrol+"]");
                                     }
                                },
                                error: function (msg) {
                                    alert(msg.responseText);
                                }
                            });
                            
                        }else{
                            alert("Problemas al guardar.");
                        }
                    },
                    error: function (msg) {
                        alert(msg.responseText);
                    }
                });	
            }
            
       }
       
       
        
      //funcion para inicializacion del grid de datos
	 function loadTreeDepartamentos(rol_id,modulo_id){
	 	//url ubicacion de archivo json
	 	var url = '<?php echo site_url("seg/roles/get_departamentos"); ?>/'+rol_id+'/'+modulo_id;
	     
	 	//create source
	 	var source={
			datatype: "json",
			datafields: [
			{ name: 'available', type: 'boolean' },
			{ name: 'departamento_id', type: 'integer' },
			{ name: 'departamento', type: 'string'  },
			{ name: 'padre_id' , type: 'string' },
			{ name: 'estado' }
			],
			hierarchy:
                {
                	keyDataField: { name: 'departamento_id' },
                    parentDataField: { name: 'padre_id' }
                },
			id: 'departamento_id',
			url: url
		   };
		   
		  	   
		   // create data adapter.
			//var dataAdapter = new $.jqx.dataAdapter(source);
	 	var dataAdapter = new $.jqx.dataAdapter(source, {
                loadComplete: function (data) { 
                	for (var i = 0; i < data.length; i++) {
                		if (data[i].available=='true') {
                		 $("#jqxtreegridDatos").jqxTreeGrid('checkRow',data[i].departamento_id);
                        }
	                    if (data[i].available=='true') {
	                		 $("#jqxtreegridDatos").jqxTreeGrid('checkRow',data[i].departamento_id);
	                    }else{
	                    	$("#jqxtreegridDatos").jqxTreeGrid('uncheckRow',data[i].departamento_id);
	                    }
                      
                     }
                	},
                loadError: function (xhr, status, error) { }      
            });
	 	
	 	$("#jqxtreegridDatos").jqxTreeGrid({
	 		
	 		 width: '98%',
	 		 height: '90%',
	 		 theme: tema,
	 		 source: dataAdapter,
	 		 checkboxes: true,
	 		 columns: [
             { text: '', datafield: 'available', width: '10%', hidden:true },
             { text: 'departamento_id', datafield: 'departamento_id',  hidden:true },
             { text: 'Departamentos', datafield: 'departamento', width: '100%'},
             { text: 'Padre_id', datafield: 'padre_id' , hidden:true},
             { text: 'Estado', datafield: 'estado',hidden:true }
             ]
           
	 	});
	 	 
	 	 
	 	 $('#jqxtreegridDatos').on('rowCheck', function (event) {
         var args = event.args;
         var row = args.row;
         var padre_id=row.departamento_id;
         $("#jqxtreegridDatos").jqxTreeGrid('setCellValue', row.departamento_id, 'available', 'true');
         //$("#jqxtreegridDatos").jqxTreeGrid('setCellValue', row.padre_id, 'available', 'true');
         var records = new Array();
          
                 
        });
        $('#jqxtreegridDatos').on('rowUncheck', function (event) {
         var args = event.args;
         var row = args.row;
         var padre_id=row.departamento_id
         $("#jqxtreegridDatos").jqxTreeGrid('setCellValue', row.departamento_id, 'available', 'false');
       
                
        });
        
         // select or unselect rows when the checkbox is checked or unchecked.
        $("#jqxtreegridDatos").bind('cellendedit', function (event) {
            if (event.args.value) {
                $("#jqxtreegridDatos").jqxGrid('selectrow', event.args.rowindex);
            }
            else {
                $("#jqxtreegridDatos").jqxGrid('unselectrow', event.args.rowindex);
            }
        });
  }
  
  
    
   
        
    });
    
     function menuopciones(){
			 $("#jqxMenu").jqxMenu({theme: tema, width: '100%', height: '30px', autoOpen: false, autoCloseOnMouseLeave: false, showTopLevelArrows: true});
                $("#jqxMenu").css('visibility', 'visible');
     }
     
     function listRoles(){
     	//combo roles
        var s2 = {
            datatype: "json",
            datafields: [
                { name: 'id'},
                { name: 'nombre'}
            ],
            url: '<?php echo site_url("seg/roles/get_roles/"); ?>',
            async: false
        };
        var da2 = new $.jqx.dataAdapter(s2);
        $("#ddlRoles").jqxDropDownList({
            source: da2,
            width: 250,
            height: 25,
			theme: tema,
            selectedIndex: 0,
            displayMember: 'nombre',
            valueMember: 'id'
        });   
     }
     
     function listModulos(){
     	//combo modulos
        var s3 = {
            datatype: "json",
            datafields: [
                { name: 'id'},
                { name: 'nombre'}
            ],
            url: '<?php echo site_url("seg/modulos/get_modulos/"); ?>',
            async: false
        };
        var da3 = new $.jqx.dataAdapter(s3);
        $("#ddlModulos").jqxDropDownList({
            source: da3,
            width: 150,
            height: 25,
			theme: tema,
            selectedIndex: 0,
            displayMember: 'nombre',
            valueMember: 'id'
        }); 
     }
     
      
     
             //carga datos en grilla
        function loadTreeOpciones(rol_id,modulo_id){
            var url = '<?php echo site_url("seg/roles/ajax/"); ?>/'+rol_id+'/'+modulo_id;
            var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'available', type: 'boolean' },
                    { name: 'opcion_id', type: 'integer' },
                    { name: 'opcion', type: 'string' },
                    { name: 'tipo', type: 'string' },
                    { name: 'url', type: 'string' },
                    { name: 'orden', type: 'string' },
                    { name: 'padre_id', type: 'string' }
                ],
                hierarchy:
                {
                	keyDataField: { name: 'opcion_id' },
                    parentDataField: { name: 'padre_id' }
                },
                id: 'opcion_id',
                url: url
            };
            var da1 = new $.jqx.dataAdapter(source, {
                loadComplete: function (data) { 
                	for (var i = 0; i < data.length; i++) {
                		if (data[i].available=='true') {
                		 $("#jqxGrid").jqxTreeGrid('checkRow',data[i].opcion_id);
                        }
	                    if (data[i].available=='true') {
	                		 $("#jqxGrid").jqxTreeGrid('checkRow',data[i].opcion_id);
	                    }else{
	                    	$("#jqxGrid").jqxTreeGrid('uncheckRow',data[i].opcion_id);
	                    }
                       
                       
                    }
                	},
                loadError: function (xhr, status, error) { }      
            });
            $("#jqxGrid").jqxTreeGrid({
                width : '98%',
                height: '90%',
				theme: tema,
                source: da1,
                checkboxes: true,
                columns: [
                    { text: '', datafield: 'available', width: '10%', hidden:true },
                    { text: 'opcion_id', datafield: 'opcion_id', width: '15%', hidden:true },
                    { text: 'Opciones', datafield: 'opcion', width: '100%' },
                    //{ text: 'Tipo', datafield: 'tipo', width: '40%' },
                    //{ text: 'url', datafield: 'url', width: '30%' },
                    //{ text: 'Orden', datafield: 'orden', width: '20%' },
                    { text: 'padre_id', datafield: 'padre_id', width: '15%', hidden:true }
                ]
            });
                 
            
         $('#jqxGrid').on('rowCheck', function (event) {
         var args = event.args;
         var row = args.row;
         var padre_id=row.opcion_id;
         $("#jqxGrid").jqxTreeGrid('setCellValue', row.opcion_id, 'available', 'true');
         $("#jqxGrid").jqxTreeGrid('setCellValue', row.padre_id, 'available', 'true');
         
         var records = new Array();
               for (var i = 0; i < da1.records.length; i++) {
                    var record = da1.records[i];
                    if (record.padre_id == padre_id) {
                    	records[records.length] = record;
                    }
                }
                
                for(var i=0; i< records.length; i++){
                	 
                      $("#jqxGrid").jqxTreeGrid('checkRow',records[i].opcion_id);
                	       	  
                }
                 
                
                
        });
        $('#jqxGrid').on('rowUncheck', function (event) {
         var args = event.args;
         var row = args.row;
         var padre_id=row.opcion_id
         $("#jqxGrid").jqxTreeGrid('setCellValue', row.opcion_id, 'available', 'false');
           
         var records = new Array();
               for (var i = 0; i < da1.records.length; i++) {
                    var record = da1.records[i];
                    if (record.padre_id == padre_id) {
                    	records[records.length] = record;
                    	
                    }
                     
                }
                for(var i=0; i< records.length; i++){
                	
                         $("#jqxGrid").jqxTreeGrid('uncheckRow',records[i].opcion_id);
                         
                }
               
                                
        });
            
        }
        
     
</script>

<div class="main">
	<div class='titnavbg'>
      <div class='titnavtit'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/seg.png">&nbsp;&nbsp;Seguridad: Roles y permisos</div>
   	  <div class='titnavlog'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/log_titulo.png"></div>
     </div>
	
  	<div style='margin-left: 0px; margin-top: 5px;' id='jqxMenu'>
   		<ul>
   			<li style='list-style: none;' ignoretheme='true'>
   			   <div style='float: left; padding-top: 5px; font-size: 14px;'>&nbsp;Roles&nbsp;</div>
   			</li>
   			<li style='list-style: none;' ignoretheme='true'>
   				<div id='ddlRoles' style='float: left; position:relative; margin:auto;'></div>
		    </li>
		    
		    <li style='list-style: none;' ignoretheme='true'>
		    	<div style='float: left; padding-top: 5px; font-size: 14px;'>&nbsp;Módulos&nbsp;</div>
		    </li>
	        <li style='list-style: none;' ignoretheme='true'>
		        
		        <div id='ddlModulos' style='float: left; position:relative; margin:auto;'></div>
		    </li>
		        			
   		</ul>
        
    </div>
    
     <div style='margin-left: 0px; margin-top: 5px;' id='jqxSplitter'>
            <div id="content1">
                <div style='margin-left: 8px; margin-top: 5px;'  id='btnSaveOpciones' style='float: left; position:relative; margin:auto;' >
		                            <img style="vertical-align: middle;" src='<?php echo base_url(); ?>assets/img/llave.png' />&nbsp;Asignar 
		        </div>
		        <div style='margin-left: 8px; margin-top: 8px;' id="jqxGrid"></div>  
		    </div>
            <div id="content2">
                 <div style='margin-left: 8px; margin-top: 5px;'  id='btnSaveDepartamentos' style='float: left; position:relative; margin:auto;' >
		                              <img style="vertical-align: middle;" src='<?php echo base_url(); ?>assets/img/llave.png' />&nbsp;Asignar  
		         </div>
	             <div  style='margin-left: 8px; margin-top: 8px;' id="jqxtreegridDatos"></div>
            </div>
        </div>

    
 
    
    
</div>