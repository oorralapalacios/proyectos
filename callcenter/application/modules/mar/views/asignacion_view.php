 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.filter.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.sort.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.pager.js"></script> 
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxpanel.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.edit.js"></script> 
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.selection.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.grouping.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.columnsresize.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxlistbox.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdropdownlist.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdropdownbutton.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxcombobox.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxnumberinput.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxmaskedinput.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxtabs.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxbuttongroup.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxeditor.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/otwidgets/validadoc.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdatatable.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxsplitter.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxscrollbar.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxcheckbox.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/fullcalendar/lib/moment.min.js"></script>
 <script type="text/javascript">
      var tema= "ui-redmond";
      var temaMv="arctic";
      var oper;
      var url = "<?php echo site_url("mar/asignaciones/ajax"); ?>"; 
      $(document).ready(function () {
       
       
        //Codigo de menu de operaciones
		var tid="<?php echo $_GET["tid"]; ?>";
		//alert(tid);
        menuopciones(tid);
		initgridContactos();
		//mlistaCampanas();
		//mlistaEmpleados();
	   	
		//Codigo de consulta en la Grilla
		//gridContacto();	 
	 	$('#fSplitter').jqxSplitter({theme: tema, width: '100%', height: '89%', panels: [{ size: '15%' },{ size: '85%' }] });
         
	   //var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
	   gridDatos(adpcontactosgeneral(),'Base de contactos');
	  //$('#listcampana').on('select', function (event) {
	    //        	setGridDatos();
          //        });	
     	 
       $("#btImportar").click(function () {
       	    var oper='import';
		 	var url = "<?php echo site_url("mar/asignaciones/ajax"); ?>" 
		 	var isValid=ValidaImportado();
			
                if (isValid) {
                	$("#drop").jqxGrid('showloadelement');
                	$("#btImportar").jqxButton({ disabled: true});
                   	//armar script sql con arreglos de importados
					//alert(contactos.data.length)
					 var campana_id = $("#listcampana").val();
					 var data=$("#drop").jqxGrid('getrows')
					 var fields="";
					      fields+="("
					         +"identificacion, "
					         +"cliente, "
					         +"ciudad, "
					         +"telefono_movil, "
					         +"forma_pago, "
					         +"fecha_activacion, "
					         +"banco, "
					         +"tarifa_basica, "
					         +"plan, "
					         +"campana_id, "
					         +"fecha_ing, "
					         +"usuario_ing)"
					 var values="";
					 //var estado="AC";
					 var fecha_ing="CURRENT_TIMESTAMP";
					 var usuario_ing="<?php echo modules::run('login/usuario'); ?>";
					 for(j=0;j<data.length;j++){
					     values+="("
					         +"'"+$.trim(data[j]['identificacion'])+"', "
					         +"'"+$.trim(data[j]['cliente'])+"', "
					         +"'"+$.trim(data[j]['ciudad'])+"', "
					         +"'"+$.trim(data[j]['telefono_movil'])+"', "
					         +"'"+$.trim(data[j]['forma_pago'])+"', "
					         +"'"+$.trim(data[j]['fecha_activacion'])+"', "
					         +"'"+$.trim(data[j]['banco'])+"', "
					         +"'"+$.trim(data[j]['tarifa_basica'])+"', "
					         +"'"+$.trim(data[j]['plan'])+"', "
					         +"'"+$.trim(campana_id)+"', "
					         +""+fecha_ing+", "
					         +"'"+usuario_ing+"')"
					       if (j<data.length-1){values+=", ";};
					         //finds+=""
					         //+"'"+data[j]['identificacion']+"'"
					         //if (j<data.length-1){finds+=", ";};
					        
					};
					 var proceso = {  
                        accion: oper,
                        campana_id: $("#listcampana").val(),
                        //finds: finds,
                        fields: fields,
                        values: values,
                                               
                    };	
					//alert(finds);
                    $.ajax({
                    	type: "POST",
                        url: url,
                        data: proceso,
                        //beforeSend:ProgressBar(),
                        success: function (data) {
                            //var mensaje=$.trim(data); 
                        	//document.getElementById("out").value=mensaje;
                        	//alert(mensaje);
                        	if(data=true){
                        		$("#drop").jqxGrid('hideloadelement');
								$("#btImportar").jqxButton({ disabled: false});
                                $("#eventWindow").jqxWindow('hide');
                                $("#jqxgrid").jqxGrid('updatebounddata');
                                //alert("El dato se grab� correctamente.");
                                //jqxAlert.alert ('El dato se grabó correctamente.');
                            }else{
                                //alert("Problemas al guardar.");
                                jqxAlert.alert ('Problemas al guardar.');
                                $("#drop").jqxGrid('hideloadelement');
                                $("#btImportar").jqxButton({ disabled: false});
                            }
                        },
                        error: function (msg) {
                            //alert(msg.responseText);
                            //jqxAlert.alert(msg.responseText);
                        }
                    });	
                }else{
                	$("#drop").jqxGrid('hideloadelement');
                	jqxAlert.alert('Validación incorrecta, revise y corrija los datos','Proceso de validación');
                	$("#btImportar").jqxButton({ disabled: false});
               	}
        });   
	    
    });
 
    function setGridDatos(){
		  	var opt= getTitulo();
        	switch (opt) {
					  			   
					  
					   case 'Base de contactos':
					        //baseContanctos();
					        baseContactosGeneral();
					        break;
					   case 'Consulta de bajas':  
					        consultaBajas();
					        break;    
					   default:
					    
					} 
		  }
		  
  function baseContactosGeneral(){
   		
		                    gridDatos(adpcontactosgeneral(),'Base de contactos');
   }		  
		  
   function baseContanctos(){
   		var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
		                    gridDatos(adpcontactos(icamp.value),'Base de contactos');
   }
   
   function consultaBajas(){
     	var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
		                    gridDatos(adpcontactosbajas(icamp.value),'Consulta de bajas'); 
   }
     
 
   function mlistaCampanas(){
        	 $('#listcampana').jqxDropDownList({
							source: adpcampana(),
							width: 300,
							//height: 20,
						    theme: tema,
						    selectedIndex: 0,
							displayMember: 'nombre',
							valueMember: 'id'
		         });  
        }
 
    function setTitulo(titulo){
		 	$("#subtitulo").empty();
    		$('#subtitulo').append(titulo);
    	 }
		 
		 function getTitulo(){
		 	return $('#subtitulo').text();
		 }
		 
     function setGridDatos(){
		  	var opt= getTitulo();
        	switch (opt) {
					  
					   case 'Base de contactos':
					      	  var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
		                      gridDatos(adpcontactos(icamp.value),'Base de contactos'); 
		
					        break;
					        
					    case 'Consulta de bajas':
					         var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
		                     gridDatos(adpcontactosbajas(icamp.value),'Consulta de bajas'); 
					         break;
					         
					                   
			                 
			                
					    default:
					      
					} 
		  }
	
	 function gridDatos(adp,titulo){
		  	setTitulo(titulo);
			$("#jqxgrid").jqxGrid({source: adp,
				sortable: true,
			    filterable: true,
				virtualmode: true,
				pageable: true,
			    rendergridrows: function()
				{
					  return adp.records;     
				},
				})
		  }
     
   	 function menuopciones(padre_id){
			
			//var view='contactobase_view'
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
			 $("#jqxMenu").jqxMenu({source: records, theme: temaMv, autoSizeMainItems: false, showTopLevelArrows: true, width: '100%',  height:'100%' ,mode: 'vertical'});
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
					    case 'Subir archivo':
					        opsubir();
					        break;
					    case 'Gestionar':
					        opgestionar();
					        break;
					    case 'Ver detalle':
					        opinfoadicional();
					        break;
					    case 'Asignación':
					        opasignar();
					        break;
					    case 'Sel asignación':
					        opselasignar();
					        break;    
					    case 'Reasignación':
					        opReasignar();
					        break;
					    case 'Sel reasignación':
					     	opSelReasignar();
					        break; 
					    case 'Base de contactos':
					        baseContanctos();
					        break;
					   case 'Consulta de bajas':  
					        consultaBajas();
					        break;
					    case 'Baja':
					        opbaja();
					        break; 
					    case 'Activa baja':
					        opactivabaja();
					        break;  
					    default:
					        //default code block
					         
		
					} 
               	 });
        } 
        
    /*function opconsultabajas(){
     	var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
        gridContactosBajas(icamp.value);	

     }*/
    
    
     function adpcontactosgeneral(){
		var url = "<?php echo site_url("mar/asignaciones/ajax"); ?>";
		var soper = 'dataup';
		var datos = {accion: soper
			         };
		var source =
        {
            datatype: "json",
            datafields: [
                { name: 'id', type: 'numeric' },
                { name: 'contacto_id', type: 'numeric' },
                { name: 'padre_id', type: 'numeric' },
                { name: 'campana_id', type: 'numeric' },
                { name: 'campana', type: 'string' },
                { name: 'tipo_subida', type: 'string' },
                { name: 'estado_ultima_llamada', type: 'string' },
                { name: 'fecha_ultima_llamada', type: 'string' },
                { name: 'identificacion', type: 'string' },
				{ name: 'cliente', type: 'string' },
				{ name: 'telefono_movil', type: 'string' },
				{ name: 'ciudad', type: 'string' },
				{ name: 'email', type: 'string' },
				{ name: 'aprobacion', type: 'string' },
				{ name: 'limite_plan', type: 'string' },
				{ name: 'limite_equipo', type: 'string' },
				{ name: 'forma_pago', type: 'string' },
				{ name: 'fecha_activacion', type: 'string' },
				{ name: 'banco', type: 'string' },
				{ name: 'tarifa_basica', type: 'string' },
				{ name: 'plan', type: 'string' },
				{ name: 'fecha_ing', type: 'string' },
				{ name: 'fecha_mod', type: 'string' },
				{ name: 'ultimo_teleoperador_asignado', type: 'string' },
				{ name: 'fecha_ultima_teleoperacion', type: 'string' },
				{ name: 'empleado_ultima_llamada', type: 'string' },
				{ name: 'estado_ultima_cita', type: 'string' },
				{ name: 'fecha_ultima_cita', type: 'string' },
				//{ name: 'proceso', type: 'string' },
				{ name: 'estado', type: 'string' }
            ],
            id: 'id',
            type: 'POST',
            url: url,
            data: datos,
            root: 'Rows',
            //pagenum: 2,
            //pagesize: 20,
            //async: false,
            filter: function(){
	 	      $("#jqxgrid").jqxGrid('updatebounddata', 'filter');
	        },
	        sort: function(){
		      $("#jqxgrid").jqxGrid('updatebounddata', 'sort');
	        },
            
            beforeprocessing: function(data)
				{		
					//alert(data[0].TotalRows);
					source.totalrecords = data[0].TotalRows;
				},
           
        };
        
		 var dataAdapter = new $.jqx.dataAdapter(source);
		 return dataAdapter;
		
		}
    
        
   	 function adpcontactos(camp_id){
		var url = "<?php echo site_url("mar/asignaciones/ajax"); ?>";
		var soper = 'dataup';
		var datos = {accion: soper,
			         camp_id: camp_id
			         };
		var source =
        {
            datatype: "json",
            datafields: [
                { name: 'id', type: 'numeric' },
                { name: 'campana_id', type: 'numeric' },
                { name: 'tipo_subida', type: 'string' },
                { name: 'identificacion', type: 'string' },
				{ name: 'cliente', type: 'string' },
				{ name: 'telefono_movil', type: 'string' },
				{ name: 'ciudad', type: 'string' },
				{ name: 'email', type: 'string' },
				{ name: 'aprobacion', type: 'string' },
				{ name: 'limite_plan', type: 'string' },
				{ name: 'limite_equipo', type: 'string' },
				{ name: 'forma_pago', type: 'string' },
				{ name: 'fecha_activacion', type: 'string' },
				{ name: 'banco', type: 'string' },
				{ name: 'tarifa_basica', type: 'string' },
				{ name: 'plan', type: 'string' },
				{ name: 'fecha_ing', type: 'string' },
				{ name: 'fecha_mod', type: 'string' },
				//{ name: 'gestor', type: 'string' },
				//{ name: 'proceso', type: 'string' },
				{ name: 'estado', type: 'string' }
            ],
            id: 'id',
            type: 'POST',
            url: url,
            data: datos,
            root: 'Rows',
            //pagenum: 2,
            //pagesize: 20,
            //async: false,
            filter: function(){
	 	      $("#jqxgrid").jqxGrid('updatebounddata', 'filter');
	        },
	        sort: function(){
		      $("#jqxgrid").jqxGrid('updatebounddata', 'sort');
	        },
            
            beforeprocessing: function(data)
				{		
					//alert(data[0].TotalRows);
					source.totalrecords = data[0].TotalRows;
				},
           
        };
        
		 var dataAdapter = new $.jqx.dataAdapter(source);
		 return dataAdapter;
		
		}
		
		
		function adpcontactosbajas(camp_id){
		var url = "<?php echo site_url("mar/asignaciones/ajax"); ?>"; 
		var soper = 'datadown';
		var datos = {accion: soper,
			         camp_id: camp_id
			        };
		var source =
        {
            datatype: "json",
            datafields: [
                { name: 'id', type: 'numeric' },
                { name: 'campana_id', type: 'numeric' },
                { name: 'identificacion', type: 'string' },
				{ name: 'cliente', type: 'string' },
				{ name: 'telefono_movil', type: 'string' },
				{ name: 'ciudad', type: 'string' },
				{ name: 'email', type: 'string' },
				{ name: 'aprobacion', type: 'string' },
				{ name: 'limite_plan', type: 'string' },
				{ name: 'limite_equipo', type: 'string' },
				{ name: 'forma_pago', type: 'string' },
				{ name: 'fecha_activacion', type: 'string' },
				{ name: 'banco', type: 'string' },
				{ name: 'tarifa_basica', type: 'string' },
				{ name: 'plan', type: 'string' },
				{ name: 'fecha_ing', type: 'string' },
				{ name: 'fecha_mod', type: 'string' },
				//{ name: 'gestor', type: 'string' },
				//{ name: 'proceso', type: 'string' },
				{ name: 'estado', type: 'string' }
            ],
            id: 'id',
            type: 'POST',
            url: url,
            data: datos,
            root: 'Rows',
            //pagesize: 20,
            //async: false
             filter: function(){
	 	      $("#jqxgrid").jqxGrid('updatebounddata', 'filter');
	        },
	        sort: function(){
		      $("#jqxgrid").jqxGrid('updatebounddata', 'sort');
	        },
            
            beforeprocessing: function(data)
				{		
					//alert(data[0].TotalRows);
					source.totalrecords = data[0].TotalRows;
				},
				
        };
		 var dataAdapter = new $.jqx.dataAdapter(source);
		 return dataAdapter;
		}
		
		function adpcampana(){
			var datos =
				{
					datatype: "json",
					datafields: [
						{ name: 'id' },
						{ name: 'nombre' },
						{ name: 'descripcion' }
					],
					url: '<?php echo site_url("mar/campanas/ajax"); ?>',
					async: false
				};
				
		       var dataAdapter = new $.jqx.dataAdapter(datos); 
			   return dataAdapter;
		}
        
        function adpempleados(){
        	var datos =
				{
					datatype: "json",
					datafields: [
						{ name: 'id' },
						{ name: 'nombres' },
						{ name: 'apellidos' },
						{ name: 'empleado' }
					],
					url: '<?php echo site_url("emp/empleados/getJerarquia"); ?>',
					async: false
				};
				
		         var dataAdapter = new $.jqx.dataAdapter(datos); 
        	    return dataAdapter;
        }
        
        
       
        
    function opnuevo(){
			
			       // show the popup window.
                    oper = 'add';
                    var url = "<?php echo site_url("mar/asignaciones/ajax"); ?>" 
                    createElementsNuevo();
                    document.getElementById("fmprNuevo").reset();
                    $("#id").val('New');
	                $("#identificacion").val('');
					$("#cliente").val('');
					$("#telefono_movil").val('');
					$("#ciudad").val('');
                    $("#forma_pago").val('');
                    $("#fecha_activacion").val('');
                    $("#banco").val('');
                    $("#tarifa_basica").val('');
                    $("#plan").val('');
                    $("#eventWindowNuevo").jqxWindow('open');
                    $("#estado").val('AC');
		}
		
		function opeditar(){
			         oper = 'edit';
			         var url = "<?php echo site_url("mar/asignaciones/ajax"); ?>" 
                 	 var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                       
                        if (selectedrowindex >= 0 ) {
                            //var id = $("#jqxgrid").jqxGrid('getrowid', selectedrowindex);
                            //var commit = $("#jqxgrid").jqxGrid('updaterow', id, datarow);
                            //$("#jqxgrid").jqxGrid('ensurerowvisible', selectedrowindex);
                           
                            var offset = $("#jqxgrid").offset();
                            // get the clicked row's data and initialize the input fields.
	                        var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex );
	                        // show the popup window.
	                         
	                        createElementsNuevo();
	                        document.getElementById("fmprNuevo").reset();
	                        $("#id").val(dataRecord.id);
	                        $("#identificacion").val(dataRecord.identificacion);
							$("#cliente").val(dataRecord.cliente);
							$("#telefono_movil").val(dataRecord.telefono_movil);
							$("#ciudad").val(dataRecord.ciudad);
							$("#forma_pago").val(dataRecord.forma_pago);
							$("#fecha_activacion").val(dataRecord.fecha_activacion);
							$("#banco").val(dataRecord.banco);
							$("#tarifa_basica").val(dataRecord.tarifa_basica);
							$("#plan").val(dataRecord.plan);
	                        $("#estado").val(dataRecord.estado);
	                        $("#eventWindowNuevo").jqxWindow('open');
	                        }else{
	                        	jqxAlert.alert('Seleccione un registro','Editar');
	                        }
                      
      	}	
		
		function opborrar(){
			             oper = 'del';
			             var url = "<?php echo site_url("mar/asignaciones/ajax"); ?>" 
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
		
		function opbaja(){
			             oper = 'baja';
			             var url = "<?php echo site_url("mar/asignaciones/ajax"); ?>" 
                 	     var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                         if (selectedrowindex >= 0) {
                        	    
		                        //editrow = row;
		                        var offset = $("#jqxgrid").offset();
		                        var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex);
		                        var contacto = {
		                            accion: oper,
		                            id: dataRecord.id,
		                            campana_id: $("#listcampana").val(),
		                            movil:dataRecord.movil
		                            
		                        };
								jqxAlert.verify('Esta seguro de dar de baja?','Confirma dar de baja', function(r) {
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
		                                    jqxAlert.alert("Problemas al dar de baja.");
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
		
		function opactivabaja(){
			             oper = 'acbaja';
			             var url = "<?php echo site_url("mar/asignaciones/ajax"); ?>" 
                 	     var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                         if (selectedrowindex >= 0) {
                        	    
		                        //editrow = row;
		                        var offset = $("#jqxgrid").offset();
		                        var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex);
		                        var contacto = {
		                            accion: oper,
		                            id: dataRecord.id,
		                            campana_id: $("#listcampana").val(),
		                            movil:dataRecord.movil
		                            
		                        };
								jqxAlert.verify('Esta seguro de activar de baja?','Confirma activar baja', function(r) {
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
		                                    jqxAlert.alert("Problemas al activar baja.");
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
	                        	jqxAlert.alert('Seleccione un registro','Activar baja');
	                        }
                      
		}		
		
		function opreconsular(){
			 $("#jqxgrid").jqxGrid('updatebounddata');
		}	
		
		function opsubir(){
			  
                    oper = 'upload';
                    var url = "<?php echo site_url("mar/asignaciones/ajax"); ?>" 
                    createElements();
                    document.getElementById("fmpr").reset();
                    //ulistaCampanas();
                    $("#eventWindow").jqxWindow('open');
		}	
		
		function opasignar(){
			
     	  abrirAsignacion();
        }
        
        /*function opselasignar(){
			
     	  abrirSelAsignacion();
        }*/
       
       function opselasignar(){
       	var getselectedrowindexes = $('#jqxgrid').jqxGrid('getselectedrowindexes');
                   var cont=0; 
                        for (var i = 0; i < getselectedrowindexes.length; i++) {
                         	
                     	 var selectedRowData = $('#jqxgrid').jqxGrid('getrowdata', getselectedrowindexes[i]);
                     	                	 	        
                     	 	    if (selectedRowData.ultimo_teleoperador_asignado){
		                         	jqxAlert.alert('Uno de los registros de cliente seleccionado tiene Teleoperador, realice una reasignación','Información');
	                        	}else{
	                        				cont=cont+1;
	                        	}
	                        	                         	                     	 	       
                        }
                         /*if (cont==getselectedrowindexes.length)
                         {
                         	abrirSelAsignacion();
                         }*/
              	if (getselectedrowindexes<=0) {
              		jqxAlert.alert('Seleccione un registro','Seleccionar');
	             }
	              else{
	                        	 	if (cont==getselectedrowindexes.length){
	                        	 		
	                        	abrirSelAsignacion();
	                        	 	}
									}
                       }
        
        function opReasignar(){
		  abrirReasignacion();
        }
        
        /*function opSelReasignar(){
		  abrirSelReasignacion();
		  
        }*/
        
        function opSelReasignar(){
		  var getselectedrowindexes = $('#jqxgrid').jqxGrid('getselectedrowindexes');
                   var cont=0; 
                        for (var i = 0; i < getselectedrowindexes.length; i++) {
                         	
                     	 var selectedRowData = $('#jqxgrid').jqxGrid('getrowdata', getselectedrowindexes[i]);
                     	                	 	        
                     	 	    if (selectedRowData.ultimo_teleoperador_asignado){
                     	 	      	cont=cont+1; 	
	                        	}else{
	                        		jqxAlert.alert('Uno de los registros de cliente seleccionado no tiene Teleoperador, realice una asignación','Información');
	                        		
	                        	}
	                        	                         	                     	 	       
                        }
                         /*if (cont==getselectedrowindexes.length)
                         {
                         	abrirSelAsignacion();
                         }*/
              	if (getselectedrowindexes<=0) {
              		jqxAlert.alert('Seleccione un registro','Seleccionar');
	             }
	              else{
	                        	 	if (cont==getselectedrowindexes.length){
		                        	 	alert('prueba');
	                        	 			abrirSelReasignacion();
	                        	 	}
							}
        }
        
        /*function opSelReasignar(){
        	var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
        	 
                         if (selectedrowindex >= 0) {
                        	   
		                        //editrow = row;
		                        var offset = $("#jqxgrid").offset();
		                        var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex);
		                        
		                        //createElementsSelReasignar(); 
		                         //alert('f');	
		                        //document.getElementById("frmSelReasignar").reset();
		                        //$("#id_cartera").val(dataRecord.id);
	                        	//$("#sremp1_id").val(dataRecord.ultimo_teleoperador_asignado);
	                        	if (dataRecord.ultimo_teleoperador_asignado){
	                        	  alert(dataRecord.ultimo_teleoperador_asignado);
	                        
	                        	  $("#sremp1_id").val(dataRecord.ultimo_teleoperador_asignado);
	                        	 	   abrirSelReasignacion();
	                        	  
	                        	  //$("#camp_id4").val(dataRecord.campana);
	                        	}else{
	                        	
	                        	jqxAlert.alert('Cliente no tiene Teleoperador, realice una asignación','Información');
		                        //abrirSelReasignacion();
		                       }}
		                       else
		                       {
		                       jqxAlert.alert('Seleccione un registro','Seleccionar');	
		                       }
		}*/
		
		
		
		
   		
		  
		  
    		function initgridContactos(){
			$("#jqxgrid").jqxGrid({
            width : '100%',
            height: '98%',
            theme: tema,
            //source: adpcontactos(),
            //groupable: true,
            sortable: true,
            //showfilterrow: true,
            //groupsexpandedbydefault: true,
            filterable: true,
            selectionmode: 'checkbox',
            pageable: true,
            //autoheight: true,
            //virtualmode: true,
            columnsresize: true,
            pagermode: 'simple',
            pagesize: 50,
            //showtoolbar: true,
            //Codigo para la barra de herramientas de la grilla
            columns: [
                { text: 'Id', datafield: 'id', width: '5%',hidden:true },
                { text: 'Campana_id', datafield: 'campana_id', width: '5%',hidden:true },
                { text: 'padre_id', datafield: 'padre_id', width: '5%',hidden:true },
                { text: 'contacto_id', datafield: 'contacto_id', width: '5%',hidden:true },
                { text: 'Movil', datafield: 'telefono_movil', width: '10%'},
                { text: 'Campaña', datafield: 'campana', width: '18%' },
                { text: 'Teleoperador', datafield: 'ultimo_teleoperador_asignado', width: '13%' },
                { text: 'Ultima Asignación', datafield: 'fecha_ultima_teleoperacion', width: '14%' },
                { text: 'Llamada Ultimo Asesor', datafield: 'empleado_ultima_llamada', width: '15%' },
                { text: 'Ultima LLamada', datafield: 'fecha_ultima_llamada', width: '14%' },
                { text: 'Estado LLamada', datafield: 'estado_ultima_llamada', width: '13%' },
                { text: 'Ultima Cita', datafield: 'fecha_ultima_cita', width: '14%' },
                { text: 'Estado Cita', datafield: 'estado_ultima_cita', width: '10%' },
               	{ text: 'Identificacion', datafield: 'identificacion', width: '10%' },
				{ text: 'Cliente', datafield: 'cliente', width: '25%' },
				{ text: 'Ciudad', datafield: 'ciudad', width: '8%' },
				{ text: 'Tipo', datafield: 'tipo_subida', width: '4%' },
				{ text: 'Forma de pago', datafield: 'forma_pago', width: '20%',hidden:true},
				{ text: 'Fecha de activacion', datafield: 'fecha_activacion', width: '20%',hidden:true},
				{ text: 'Banco', datafield: 'banco', width: '20%',hidden:true},
				{ text: 'Tarifa_basica', datafield: 'tarifa_basica', width: '20%',hidden:true},
				{ text: 'Plan', datafield: 'plan', width: '20%',hidden:true},
				{ text: 'Fecha de creación', datafield: 'fecha_ing', width: '12%' ,hidden:true},
				{ text: 'Fecha de modificación', datafield: 'fecha_mod', width: '12%' ,hidden:true},
				
				//{ text: 'Estado', datafield: 'estado', width: '5%' },
               
              
            ],
          
            
        });
       
         
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
													{ name: 'campo' },
													{ name: 'tipo' },
													{ name: 'valor' },
													],
						                id: 'id',
						                url: url,
						            };
			                        var dataAdapter = new $.jqx.dataAdapter(source);
				  					         
              
             $("#datosTelefonos").jqxDropDownList({theme: tema, source: dataAdapter, displayMember: "valor", valueMember: "valor", width: 170, height: 200,
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
            
    
</script>
<div class="main">
	<div class='titnavbg'>
      <div class='titnavtit'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/seg.png">&nbsp;&nbsp;Marketing: <a id="subtitulo"></div>
      <div class='titnavlog'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/log_titulo.png"></div>
    </div>
	           	

</div>
 <div id="fSplitter">
			         	<div class="splitter-panel">
			         		 <div id='jqxMenu'>
				         </div>
      	                
			            </div>
			            <div class="splitter-panel">
			            	
			            	<div style='margin-left: 0px; margin-top: 5px;' id="jqxgrid"></div>
			            	
			            </div>
       </div>




