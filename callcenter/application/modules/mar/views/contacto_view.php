 <style>
   .gray {
	color: #999;
	/*background-color: gray\9;*/
	}
	
	/*.gray:not(.jqx-grid-cell-selected), .jqx-widget .gray:not(.jqx-grid-cell-hover) {
	color: black;
	background-color: gray !important;
	}*/
	
	
</style>
 <script type="text/javascript">
      var tema= "ui-redmond";
      var temaMv="arctic";
      var oper;
      var url = "<?php echo site_url("mar/contactos/ajax"); ?>"; 
      $(document).ready(function () {
       
       
        //Codigo de menu de operaciones
		var tid="<?php echo $_GET["tid"]; ?>";
		
        menuopciones(tid);
        
		initgridDatos();
		mlistaCampanas();
		mlistaEmpleados();
	    //createElementsNuevo();
	    
	    //Codigo Splitter
		//$('#mainSplitter').jqxSplitter({ width: '100%', height: 590, panels: [{ size: 220 },{ size: 600 }] });
		$('#fSplitterr').jqxSplitter({theme: tema, width: '100%', height: '100%', panels: [{ size: '18%' },{ size: '82%' }] });
		//Codigo de consulta en la Grilla
		 var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
         var iemp = $("#listempleado").jqxDropDownList('getSelectedItem');
         switch (tid) {
					    case '10':
					        gridDatos(adpcontactos(icamp.value,iemp.value,'dataGC'),'Contactos asignados'); 
					        break;
					    case '12':
					        gridDatos(adpcontactos(icamp.value,iemp.value,'dataSTA'),'Seguimiento telefónico asignado');
					        //gridDatos(adpcontactos(icamp.value,iemp.value,'dataST'),'Seguimiento telefónico'); 
					        break;
					     case '213':
					        gridDatos(adpcontactos(icamp.value,iemp.value,'dataIN'),'Inbound');
					        //gridDatos(adpcontactos(icamp.value,iemp.value,'dataST'),'Seguimiento telefónico'); 
					        break;
				     }
         //gridDatos(adpcontactos(icamp.value,iemp.value,'dataGC'),'Contactos asignados'); 
		 //gridDatos(adpcontactos(icamp.value,iemp.value),'Contactos asignados'); 
		 $('#listcampana').on('select', function (event) {
		  	setGridDatos();
		  });	
          $('#listempleado').on('select', function (event) {
          	setGridDatos();
          });			
          
       		 
       $("#btImportar").click(function () {
		 	var oper='import';
		 	var url = "<?php echo site_url("mar/contactos/ajax"); ?>" 
		 	
		 	var isValid=ValidaImportado();
			
                if (isValid) {
                	$("#drop").jqxGrid('showloadelement');
                	$("#btImportar").jqxButton({ disabled: true});
                	
                	 var contactos = {  
                        accion: oper,
                        empleado_id: $("#empleado_id").val(),
                        campana_id: $("#campana_id").val(),
                        importados: $("#drop").jqxGrid('getrows')
                    };		
					
                    $.ajax({
                    	type: "POST",
                        url: url,
                        data: contactos,
                        //beforeSend:ProgressBar(),
                        success: function (data) {
                        	
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
 
     
 
   	   	 
   	 function menuopciones(padre_id){
			
			//var view='contacto_view'
			var url="<?php echo site_url("login/login/tool_rol"); ?>"+"/"+padre_id;
			  
            var source =
			{
			datatype: "json",
			datafields: [
			{ name: 'id' },
			{ name: 'padre_id' },
			{ name: 'nombre' },
			{ name: 'subMenuWidth' }
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
			 //$("#jqxMenu").jqxMenu({source: records, theme: tema, autoSizeMainItems: false, showTopLevelArrows: true, width: '100%'});
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
					        
					    case 'Contactos asignados':
					      	contactosasignados();
					        break;
					    case 'Números equivocados':
					       numerosequivocados();
		                   break;
		                case 'No titulares':
					        notitulares();
					        break;   
					    case 'No interesados':
					       nointeresados();
					       break;      
					    case 'Fuera de cobertura':
					       fueracobertura();
					       break;   
					    case 'Seguimiento telefónico':
					       seguimientotelefonico();
					       break;
					     case 'Inbound':
					       seguimientoInbound();
					       break;
					     case 'Asignado':
					       seguimientotelefonicoasignado();
					       break;
					     case 'Gestionado':
					       seguimientotelefonicogestionado();
					       break;
					       
					    case 'Pago directo':   
					      pagodirecto();
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
					        
					    case 'Citas mal canalizadas':
					        malacita();
					        break;
					        
					    case 'Canceladas en validacion':
					        cancelocita();
					        break;
					        
					    //Regestion
					    case 'Ventas incompletas':
					        ventasincompletas();
					        break;
					    case 'Interesados/visitados':
					         interesadosvisitados();
					        break;
					    case 'No interesados/visitados':
					         nointeresadosvisitados();
					        break;
						case 'Visitas Canceladas':
						    visitascanceladas();
						    break;
						case 'No visitados':
						    novisitados();
						    break;	
						    				    
					    default:
					    
					   //contactosasignados();
					} 
               	 });
        } 
        
      
        
      function adpcontactos(camp_id, emp_id,soper){
		var url = "<?php echo site_url("mar/contactos/ajax"); ?>";
		//var soper = 'dataGC';
		var datos = {accion: soper,
			         camp_id: camp_id,
			         emp_id: emp_id
			         };
		var source =
        {
            datatype: "json",
            datafields: [
                { name: 'id', type: 'numeric' },
                { name: 'contacto_id', type: 'numeric' },
				{ name: 'empleado_id', type: 'numeric' },
				{ name: 'campana_id', type: 'numeric' },
				{ name: 'contacto_campana_id', type: 'string' },
                { name: 'empleado', type: 'string' },
				{ name: 'campana', type: 'string' },
				{ name: 'tipo_gestion', type: 'tipo_gestion' },
				{ name: 'identificacion', type: 'string' },
				{ name: 'nombres', type: 'string' },
				{ name: 'apellidos', type: 'string' },
				{ name: 'ciudad', type: 'string' },
				{ name: 'movil', type: 'string' },
				{ name: 'fecha_hora', type: 'string' },
				{ name: 'estado_llamada', type: 'string' },
				{ name: 'convenional', type: 'string' },
				{ name: 'direccion', type: 'string' },
				{ name: 'observaciones', type: 'string' },
				{ name: 'fecha_ing', type: 'string' },
				{ name: 'fecha_mod', type: 'string' },
				{ name: 'estado', type: 'string' },
				//agregados por conservar estructura
				{ name: 'tipo_cliente_id', type: 'string' },
				{ name: 'forma_pago', type: 'string' },
                { name: 'estado_preaprobacion', type: 'string' },
                { name: 'codigo_preaprobacion', type: 'string' },
                { name: 'perfil', type: 'string' },
                { name: 'limite_credito', type: 'string' },
                { name: 'financiamiento', type: 'string' },
                { name: 'limite_credito_tc', type: 'string' },
                { name: 'financiamiento_tc', type: 'string' },
                { name: 'observacion', type: 'string' },
                { name: 'cita_id', type: 'string' },
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
		 
		
		function adpcitas(camp_id, emp_id,soper){
		var url = "<?php echo site_url("mar/valcitas/ajax"); ?>";
		//var soper = 'dataGC';
		var datos = {accion: soper,
			         camp_id: camp_id,
			         emp_id: emp_id
			         };
		var source =
        {
            datatype: "json",
            datafields: [
                    { name: 'id', type: 'string' },
                    { name: 'tipo_gestion', type: 'string' },
                    { name: 'padre_id', type: 'string' },
                    { name: 'tipo_cliente_id', type: 'string' },
                    { name: 'contacto_campana_id', type: 'string' },
                    { name: 'contacto_id', type: 'string' },
                    { name: 'llamada_id', type: 'string' },
                    { name: 'empresa_id', type: 'string' },
                    { name: 'campana_id', type: 'string' },
                    { name: 'identificacion', type: 'string' },
                    { name: 'nombres', type: 'string' },
                    { name: 'apellidos', type: 'string' },
                    { name: 'contacto', type: 'string' },
                    { name: 'ciudad', type: 'string' },
                    { name: 'movil', type: 'string' },
                    { name: 'direccion', type: 'string' },
                    { name: 'ruc', type: 'string' },
                    { name: 'razon_social', type: 'string' },
                    { name: 'campana', type: 'string' },
                    { name: 'forma_pago', type: 'string' },
                    { name: 'estado_preaprobacion', type: 'string' },
                    { name: 'codigo_preaprobacion', type: 'string' },
                    { name: 'perfil', type: 'string' },
                    { name: 'limite_credito', type: 'string' },
                    { name: 'financiamiento', type: 'string' },
                    { name: 'limite_credito_tc', type: 'string' },
                    { name: 'financiamiento_tc', type: 'string' },
                    { name: 'observacion', type: 'string' },
					{ name: 'cita_estado', type: 'string' },
					{ name: 'fecha_hora', type: 'string' },
					{ name: 'fecha_ing', type: 'string' },
                    { name: 'fecha_mod', type: 'string' },
                    { name: 'estado', type: 'string' },
                    { name: 'cita_id', type: 'string' },
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
   		
		
			
		function adpgestion(camp_id, emp_id,soper){
		var url = "<?php echo site_url("mar/gescitas/ajax"); ?>";
		//var soper = 'dataGC';
		var datos = {accion: soper,
			         camp_id: camp_id,
			         emp_id: emp_id
			         };
		var source =
        {
            datatype: "json",
            datafields:[
                    { name: 'id', type: 'string' },
                    { name: 'tipo_gestion', type: 'string' },
                    { name: 'tipo_cliente_id', type: 'string' },
                    { name: 'contacto_campana_id', type: 'string' },
                    { name: 'contacto_id', type: 'string' },
                    { name: 'llamada_id', type: 'string' },
                    { name: 'empresa_id', type: 'string' },
                    { name: 'campana_id', type: 'string' },
                    { name: 'fecha_hora', type: 'string' },
                    { name: 'identificacion', type: 'string' },
                    { name: 'nombres', type: 'string' },
                    { name: 'apellidos', type: 'string' },
                    { name: 'contacto', type: 'string' },
                    { name: 'movil', type: 'string' },
                    { name: 'ciudad', type: 'string' },
                    { name: 'direccion', type: 'string' },
                    { name: 'ruc', type: 'string' },
                    { name: 'razon_social', type: 'string' },
                    { name: 'campana', type: 'string' },
                    { name: 'forma_pago', type: 'string' },
                    { name: 'estado_preaprobacion', type: 'string' },
                    { name: 'codigo_preaprobacion', type: 'string' },
                    { name: 'perfil', type: 'string' },
                    { name: 'limite_credito', type: 'string' },
                    { name: 'financiamiento', type: 'string' },
                    { name: 'limite_credito_tc', type: 'string' },
                    { name: 'financiamiento_tc', type: 'string' },
                    { name: 'observacion', type: 'string' },
                    { name: 'gestor', type: 'string' },
					{ name: 'cita_estado', type: 'string' },
					{ name: 'fecha_ing', type: 'string' },
                    { name: 'fecha_mod', type: 'string' },
                    { name: 'estado', type: 'string' },
                    { name: 'cita_id', type: 'string' },
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
					url: '<?php echo site_url("emp/empleados/getJerarquiaTeleoperadores"); ?>',
					async: false
				};
				
		         var dataAdapter = new $.jqx.dataAdapter(datos); 
        	    return dataAdapter;
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
         function mlistaEmpleados(){
         	 $('#listempleado').jqxDropDownList({
							source: adpempleados(),
							width: 300,
							//height: 20,
							theme: tema,
							selectedIndex: 0,
							displayMember: 'empleado',
							valueMember: 'id'
					}); 
         }
       
        
    function opnuevo(){
			
			       // show the popup window.
                    oper = 'add';
                    var url = "<?php echo site_url("mar/contactos/ajax"); ?>" 
                    //$('#telefonosGrid').jqxGrid('clear');
                    //$('#correosGrid').jqxGrid('clear');
                    createElementsNuevo();
                    document.getElementById("fmprNuevo").reset();
                    nlistaEmpleados();
				    nlistaCampanas();
                    $("#id").val('New');
	                $("#contacto_idN").val('');
	                $("#identificacion").val('');
					$("#nombre").val('');
					$("#apellido").val('');
					$("#ciudad").val('');
                    $("#direccion").val('');
                    $("#telefonosGrid").jqxGrid({ source: detalles()});
                    $("#correosGrid").jqxGrid({ source: detalles()});
                    $("#eventWindowNuevo").jqxWindow('open');
                    $("#estado").val('AC');
		}
		
		function opeditar(){
			         oper = 'edit';
			         var url = "<?php echo site_url("mar/contactos/ajax"); ?>" 
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
	                        nlistaEmpleados();
				            nlistaCampanas();
	                        $("#id").val(dataRecord.id);
	                        $("#contacto_idN").val(dataRecord.contacto_id);
	                        $("#empleado_idN").val(dataRecord.empleado_id);
							$("#campana_idN").val(dataRecord.campana_id);
							$("#identificacion").val(dataRecord.identificacion);
							$("#nombre").val(dataRecord.nombres);
							$("#apellido").val(dataRecord.apellidos);
							$("#ciudad").val(dataRecord.ciudad);
							$("#direccion").val(dataRecord.direccion);
							$("#telefono").val(dataRecord.movil);
							$("#email").val(dataRecord.email);
	                        $("#estado").val(dataRecord.estado);
	                        $("#telefonosGrid").jqxGrid({ source: detalles(dataRecord.contacto_id,'telefono')});
	                        $("#correosGrid").jqxGrid({ source: detalles(dataRecord.contacto_id,'email')});
							$("#eventWindowNuevo").jqxWindow('open');
	                        }else{
	                        	jqxAlert.alert('Seleccione un registro','Editar');
	                        }
                      
      	}	
		
		function opborrar(){
			             oper = 'del';
			             var url = "<?php echo site_url("mar/contactos/ajax"); ?>" 
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
		
		//function opsubir(){
			  
          //          oper = 'upload';
          //          var url = "<?php echo site_url("mar/contactos/ajax"); ?>" 
          //          createElements();
          //          document.getElementById("fmpr").reset();
          //          ulistaEmpleados();
          //          ulistaCampanas();
          //          $("#eventWindow").jqxWindow('open');
		//}	
		
		
		
		function opgestionar(){
			var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                      
                	 if (selectedrowindex >= 0) {
                            //oper = 'ver';
	                        //editrow = row;
	                        var offset = $("#jqxgrid").offset();
	                        // get the clicked row's data and initialize the input fields.
	                        var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex);
	                        // show the popup window.
	                        //alert ('ver');
	                        
	                               document.getElementById("frmVisualizar").reset();
	                               createElementsVisualizar();
					                //detallesTelefonos(dataRecord.contacto_id,dataRecord.identificacion,dataRecord.apellidos,dataRecord.nombres);
			                        //detallesMails(dataRecord.contacto_id,dataRecord.identificacion,dataRecord.apellidos,dataRecord.nombres);
			                        //DirectorioContacto(dataRecord.id,dataRecord.identificacion,dataRecord.apellidos,dataRecord.nombres);
			                        muestraDialogoCampana(1, dataRecord.campana_id,dataRecord.identificacion,dataRecord.apellidos,dataRecord.nombres,dataRecord.empleado);
			                        // alert(dataRecord.campana_id+' '+dataRecord.contacto_id);
			                        preguntas_datos(dataRecord.campana_id,dataRecord.contacto_id,dataRecord.id);
			                        $("#vid").val(dataRecord.id);
			                        $("#vtipogestion").val(dataRecord.tipo_gestion);
			                        $('#vpadreid').val(dataRecord.cita_id);
			                        $("#vidcontactocampana").val(dataRecord.contacto_campana_id);
			                        $("#vproceso").val('Gestión telefónica');
			                        $('#vidcampana').val(dataRecord.campana_id);
			                        $("#vidcontacto").val(dataRecord.contacto_id);
			                        $("#videntificacion").val(dataRecord.identificacion);
			                        $("#vnombre").val(dataRecord.nombres);
									$("#vapellido").val(dataRecord.apellidos);
									$("#vciudad").val(dataRecord.ciudad);
									$("#vmovil").val(dataRecord.movil);
									$("#vdireccion").val(dataRecord.direccion);
									initgridLlamadasTelefonicas(detalleLlamadas(dataRecord.contacto_id));
									$("#eventWindowVisualizar").jqxWindow('open');
							
								
	                        }else{
	                        	jqxAlert.alert('Seleccione un registro','Seleccion de registros');
	                        }
                       
		}	    
		
				 
		
        
   		 //funcion que carga dialogo de campaña para el contacto
            function muestraDialogoCampana(dialogo, camp_id,identificacion, apellidos, nombres, empleado) {
               $("#campDialogo").empty();          
               var url="<?php echo site_url("mar/contactos/campana"); ?>"+"/"+camp_id;
               var source ={
						                datatype: "json",
						                datafields: [
													{ name: 'id' },
													{ name: 'nombre' },
													{ name: 'descripcion' },
													{ name: 'dialogo_llamada' },
													{ name: 'texto_email' }
													],
						                id: 'id',
						                url: url,
						            };
			             
                 
                  
                 var dataAdapter = new $.jqx.dataAdapter(source, {
						                loadComplete: function (data) { 
						                	   
						                	   
						                	   var container;
						                	   if (dialogo==1) {
						                	    container = data.dialogo_llamada;
						                	   }
						                	   if (dialogo==2) {
						                	    container = data.texto_email;
						                	   }
  					                	       container=container.replace('{campana}', data.nombre);
  					                	       container=container.replace('{identificacion}', identificacion);
  					                	       container=container.replace('{empleado}', empleado);
											   do {
												   container=container.replace('{cliente}', nombres+' '+apellidos);
												} while(container.indexOf('{cliente}') >= 0);
  					                	       
   		                                       $('#campDialogo').append(container);
   		                                       
   		                                     
   		                                        
									              

						                },
						                //loadError: function (xhr, status, error) { }      
						            });
									         
               //return dataAdapter;
             dataAdapter.dataBind();
            }
        
            function opciones_respuestas(tipo_respuesta){
            	
            	var source ={
										dataType: "json",
										dataFields: [
											{ name: 'id'},
											{ name: 'detalle'},
											{ name: 'multiple_respuesta'},
											{ name: 'opcion_otro'}
										],
										id: 'id',
										url: "<?php echo site_url("mar/campanas/opciones_encuesta"); ?>"+"/"+tipo_respuesta
									};
				           var dataAdapter = new $.jqx.dataAdapter(source, {
				           	            async:true,
				           			    autoBind:true,        	
										beforeLoadComplete: function (data) { 
										var itemRespuesta;
										//var container="<table>";
										var container;
										for(j=0;j<data.length;j++){
											
											//alert(data[j]['detalle']);
											if (data[j]['multiple_respuesta']==1){
												var objeto_respuesta="<input type = 'checkbox'/>"+data[j]['detalle'];
												//$('#datosEncuesta').append("<tr><td colspan='2'>"+objeto_respuesta+"</td></tr>");
												itemRespuesta="<tr><td colspan='2'>"+objeto_respuesta+"</td></tr>";
												container += itemRespuesta;
												//container += itemRespuesta;
											}else{
												var objeto_respuesta="<input type='radio'/>"+data[j]['detalle'];
												//$('#datosEncuesta').append("<tr><td colspan='2'>"+objeto_respuesta+"</td></tr>");
												itemRespuesta="<tr><td colspan='2'>"+objeto_respuesta+"</td></tr>";
												container += itemRespuesta;
												//container += itemRespuesta;
											}
											//$('#datosEncuesta').append("<tr><td colspan='2'>"+objeto_respuesta+"</td></tr>");
										
										 }
										 //container += "</table>";
								         $('#datosEncuesta').append(container);
								        
								         //return itemRespuesta;
								         },
									});
									
									//dataAdapter.dataBind();
            	
            }
          
    				 
		
        function preguntas_datos(camp_id,contacto_id,contacto_campana_id){
        	
			$("#datosEncuesta").empty(); 
			var url = "<?php echo site_url("mar/preguntas/ajax"); ?>";
		    var soper = 'dataPG';
		    var datos = {
		    	     accion: soper,
			         campana_id: camp_id,
			         contacto_id: contacto_id,
			         contacto_campana_id: contacto_campana_id,
			         };
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
						{ name: 'tipo_respuesta'},
						{ name: 'multiple_respuesta'},
						{ name: 'opciones'},
						{ name: 'obligatorio'}
					],
					id: 'id',
                    type: 'POST',
                    url: url,
                    data: datos,
                    async: false
				};
			
			 var dataAdapterPreg = new $.jqx.dataAdapter(customersPreguntas, {
			 	        autoBind: true,
						loadComplete: function (data) { 
							   
							   var pregunta;
							   var orden;
							   $('#datosEncuesta').append("<table>");
								for(i=0;i<data.length;i++){
								 id_pregunta = data[i]['id'];
								 pregunta = data[i]['detalle_pregunta'];
								 orden = data[i]['orden'];
								
								 var tipo_respuesta = data[i]['tipo_respuesta_id'];
								 var opciones = data[i]['opciones'];
								 if (opciones==''){
								 	 $('#datosEncuesta').append("<tr><td>"+orden+".- </td><td>"+data[i]['detalle_pregunta']+"</td><tr></tr><td colspan='2'><input id='resp_"+id_pregunta+"' value='"+data[i]['respuesta_texto']+"'/><td></tr>");
							 	 	//$('#datosEncuesta').append("<tr><td>"+orden+".- </td><td>"+data[i]['detalle_pregunta']+"</td><td><input id='resp_"+id_pregunta+"' value='"+data[i]['respuesta_texto']+"'/><td></tr>");
								 }else{
								 	$('#datosEncuesta').append("<tr><td>"+orden+".- </td><td>"+data[i]['detalle_pregunta']+"</td></tr>");
								 }
								 
								 for(j=0;j<opciones.length;j++){
									
								 	if (opciones[j]['respuesta']==opciones[j]['detalle']){var check='checked';}else{var check='';}
										//alert(opciones[j]['respuesta']);
									 $('#datosEncuesta').append("<tr><td colspan=2><input type='"+opciones[j]['objeto']+"' id='"+opciones[j]['detalle']+"' name='"+id_pregunta+"'  value = '"+opciones[j]['detalle']+"' "+check+">"+opciones[j]['detalle']+"</td></tr>");
									
									 }
								}
								
								$('#datosEncuesta').append("</table>");
						},
						
					});
									         
               //return dataAdapter;
             //dataAdapterPreg.dataBind();
			 
			 $("#btnGuardaEncuesta").on('click', function () {
			 		//seleccion();
			 		var dataAdapterPreg = new $.jqx.dataAdapter(customersPreguntas, {
						loadComplete: function (data) { 
						for(i=0;i<data.length;i++){
							 id_pregunta = data[i]['id'];
							 multi = data[i]['multiple_respuesta'];
							 var opciones = data[i]['opciones'];
							 if (opciones==''){
								var resp=$("#resp_"+id_pregunta).val();	
								envio_datos(resp,id_pregunta,multi);
							 }
								 
								 for(j=0;j<opciones.length;j++){
									if (document.getElementById(""+opciones[j]['detalle']+"").checked==true){
										var resp = document.getElementById(""+opciones[j]['detalle']+"").value;
										envio_datos(resp,id_pregunta,multi);
									
									}	
																									 
								 }
						}
					}
					});
					dataAdapterPreg.dataBind();	
			 });		 
		}    
		
		
		
		
		function envio_datos(resp,id_pregunta,multi){
			
			var sidcontactocampana=$("#vid").jqxInput('val');
			var sidcontacto=$("#vidcontacto").jqxInput('val'); 
										///alert(sidcontacto);
					var respuesta = {
						accion: 'SaveRP',
						resp: resp,
						contacto_campana:sidcontactocampana,
						contacto: sidcontacto,
						preg: id_pregunta,
						multi: multi
					};
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("mar/preguntas/ajax"); ?>",
						data: respuesta,
						success: function (data) {
							//alert(data);
							if(data=true){
                           	  jqxAlert.alert ('La encuesta se grabó correctamente.');
                            }else{
                                //alert("Problemas al guardar.");
                                jqxAlert.alert ('Problemas al guardar.');
                            }
							
						},
						error: function (msg) {
							jqxAlert.alert(msg.responseText);
						}
					});
		 }
		
		//function gridContactosCampana(campid,empid){
		function gridDatos(adp,titulo){
    		setTitulo(titulo);
			//var adp = adpcontactos(campid,empid);
			//$("#jqxgrid").jqxGrid({source: adpcontactos(campid,empid)})
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
					  
					   case 'Contactos asignados':
					      	contactosasignados();
					        break;
					        
					    case 'Números equivocados':
					       numerosequivocados();
		                   break;
		                case 'No titulares':
					        notitulares();
					        break;   
					    case 'No interesados':
					       nointeresados();
					       break;      
					     
					    case 'Fuera de cobertura':
					       fueracobertura();
					       break;
					         
					    case 'Seguimiento telefónico':
					       seguimientotelefonico();
					       break;
					    
					    case 'Seguimiento telefónico asignado':
					       seguimientotelefonicoasignado()
					       break;   
					    
					    case 'Seguimiento telefónico gestionado':
					       seguimientotelefonicogestionado()
					       break;
					       
					       case 'Inbound':
					       seguimientoInbound();
					       break;
					       
					    case 'Pago directo':  
					      pagodirecto();
					      break;   
					      
					    case 'Citas mal canalizadas':
					        malacita();
					        break;
					        
					    case 'Canceladas en validacion':
					        cancelocita();
					        break;  
					       
					    case 'Ventas incompletas':
					        ventasincompletas();
					        break;
					    case 'Interesados/visitados':
					         interesadosvisitados();
					        break;
					    case 'No interesados/visitados':
					         nointeresadosvisitados();
					        break;
						case 'Visitas Canceladas':
						    visitascanceladas();
						    break;
						case 'No visitados':
						    novisitados();
						    break;	
					        
					    
					       
					    default:
					      contactosasignados();
					} 
		  }
		  
		 function contactosasignados(){
		 	var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
		    var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
		   gridDatos(adpcontactos(icamp.value,iemp.value,'dataGC'),'Contactos asignados'); 
		 }
		 
		 function numerosequivocados(){
		 	 var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
		     var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
		     //gridDatos(adpcontactosequivocados(icamp.value,iemp.value),'Números equivocados');
		     gridDatos(adpcontactos(icamp.value,iemp.value,'dataEQ'),'Números equivocados');
		     
		 }
		 
		 function notitulares(){
		 	var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
		    var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
		    //gridDatos(adpcontactosnotitulares(icamp.value,iemp.value),'No titulares');
		    gridDatos(adpcontactos(icamp.value,iemp.value,'dataNT'),'No titulares'); 
		 } 
		 
		 function nointeresados(){
		 	var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
		    var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
		    gridDatos( adpcontactos(icamp.value,iemp.value,'dataNI'),'No interesados'); 
		 }
		 
		 function fueracobertura(){
		 	var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
		    var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
		    //gridDatos( adpcontactosfueracobertura(icamp.value,iemp.value),'Fuera de cobertura'); 
		    gridDatos( adpcontactos(icamp.value,iemp.value,'dataFC'),'Fuera de cobertura'); 
		 }
		 
		 
		 function pagodirecto(){
		 	var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
		    var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
		    //gridDatos( adpcontactospagodirecto(icamp.value,iemp.value),'Pago directo');
		    gridDatos( adpcontactos(icamp.value,iemp.value,'dataPD'),'Pago directo'); 
		 }
		 
		 
		 function seguimientotelefonico(){
		 	var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
		    var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
		    //gridDatos(adpseguimiento(icamp.value,iemp.value),'Seguimiento telefónico'); 
		    gridDatos(adpcontactos(icamp.value,iemp.value,'dataST'),'Seguimiento telefónico'); 
					        
		 }
		 
		 function seguimientoInbound(){
		 	var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
		    var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
		    //gridDatos(adpseguimiento(icamp.value,iemp.value),'Seguimiento telefónico'); 
		    gridDatos(adpcontactos(icamp.value,iemp.value,'dataIN'),'Inbound'); 
					        
		 }
		 
		 
		 function seguimientotelefonicoasignado(){
		 	var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
		    var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
		    //gridDatos(adpseguimiento(icamp.value,iemp.value),'Seguimiento telefónico'); 
		    gridDatos(adpcontactos(icamp.value,iemp.value,'dataSTA'),'Seguimiento telefónico asignado'); 
					        
		 }
		 
		 function seguimientotelefonicogestionado(){
		 	var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
		    var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
		    //gridDatos(adpseguimiento(icamp.value,iemp.value),'Seguimiento telefónico'); 
		    gridDatos(adpcontactos(icamp.value,iemp.value,'dataSTR'),'Seguimiento telefónico gestionado'); 
					        
		 }
		 
		  function malacita(){
		 	var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
		    var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
		    //gridDatos(adpmalacita(icamp.value,iemp.value),'Citas mal canalizadas'); 
		     gridDatos(adpcitas(icamp.value,iemp.value,'dataCMC'),'Citas mal canalizadas');
		 } 
		 
		  function cancelocita(){
		 	var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
		    var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
		    //gridDatos(adpcancelocita(icamp.value,iemp.value),'Canceladas en validacion'); 
		    gridDatos(adpcitas(icamp.value,iemp.value,'dataCCA'),'Citas canceladas');
		 }
		 
		 function ventasincompletas(){
		 	regestion=1;
		 	var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
		    var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
		    //gridDatos(adpVentasInCompletadas(icamp.value,iemp.value),'Ventas incompletas');
		    gridDatos(adpgestion(icamp.value,iemp.value,'dataRGVI'),'Ventas incompletas'); 
		 }
		 
		 
		 
		
		function interesadosvisitados(){
			regestion=1;
			var icamp = $("#listcampana").jqxDropDownList('getSelectedItem');
		    var iemp = $("#listempleado").jqxDropDownList('getSelectedItem');
			//gridDatos(adpInteresados(icamp.value, iemp.value),'Interesados/visitados');
			gridDatos(adpgestion(icamp.value,iemp.value,'dataRGVIN'),'Interesados/visitados');	
		}
					  
		function nointeresadosvisitados(){
			regestion=1;
			 var icamp = $("#listcampana").jqxDropDownList('getSelectedItem');
			 var iemp = $("#listempleado").jqxDropDownList('getSelectedItem');
			 //gridDatos(adpNoInteresados(icamp.value,iemp.value),'No interesados/visitados');
			 gridDatos(adpgestion(icamp.value,iemp.value,'dataRGVNI'),'No interesados/visitados');
		}
	    
	    function visitascanceladas(){
	    	 regestion=1;
	    	 var icamp = $("#listcampana").jqxDropDownList('getSelectedItem');
	    	 var iemp = $("#listempleado").jqxDropDownList('getSelectedItem');
			 //gridDatos(adpCitasCanceladas(icamp.value,iemp.value),'Visitas Canceladas');
			 gridDatos(adpgestion(icamp.value,iemp.value,'dataRGVCA'),'Visitas Canceladas');
			                 
	    }
						
		function novisitados(){
			 regestion=1;
			 var icamp = $("#listcampana").jqxDropDownList('getSelectedItem');
		 	 var iemp = $("#listempleado").jqxDropDownList('getSelectedItem');
			 //gridDatos(adpNoVisitados(icamp.value,iemp.value),'No visitados');
			 gridDatos(adpgestion(icamp.value,iemp.value,'dataRGVNV'),'No visitados');
		}
						  		
		function initgridDatos(){
    		$("#jqxgrid").jqxGrid({
            width : '100%',
            height: '94%',
            theme: tema,
            //source: adp,
            //groupable: true,
            sortable: true,
            //showfilterrow: true,
            //groupsexpandedbydefault: true,
            filterable: true,
            pageable: true,
            //autoheight: true,
            columnsresize: true,
            pagermode: 'simple',
            pagesize: 50,
            
            //showtoolbar: true,
            //Codigo para la barra de herramientas de la grilla
            columns: [
                { text: 'Id', datafield: 'id', width: '5%',hidden:true },
               	{ text: 'contacto_id', datafield: 'contacto_id', width: '5%',hidden:true },
				{ text: 'empleado_id', datafield: 'empleado_id', width: '5%',hidden:true },
				{ text: 'campana_id', datafield: 'campana_id', width: '5%',hidden:true },
				{ text: 'Empleado', datafield: 'empleado', width: '10%',hidden:true },
				{ text: 'Campa&ntilde;a', datafield: 'campana', width: '10%',hidden:true },
				{ text: 'Tipo', datafield: 'tipo_gestion', width: '8%',cellclassname: cellclassname},
                { text: 'Identificacion', datafield: 'identificacion', width: '10%',cellclassname: cellclassname},
				{ text: 'Nombres', datafield: 'nombres', width: '15%',cellclassname: cellclassname },
				{ text: 'Apellidos', datafield: 'apellidos', width: '15%',cellclassname: cellclassname },
				{ text: 'Ciudad', datafield: 'ciudad', width: '15%',cellclassname: cellclassname },
				{ text: 'Movil', datafield: 'movil', width: '15%',cellclassname: cellclassname },
				{ text: 'Fecha asignada', datafield: 'fecha_hora', width: '15%',cellclassname: cellclassname, hidden:false },
				{ text: 'Observaciones', datafield: 'observaciones', width: '10%',cellclassname: cellclassname },
				{ text: 'Convencional', datafield: 'convencional', width: '15%', hidden:true },
				{ text: 'Direccion', datafield: 'direccion', width: '20%',cellclassname: cellclassname},
				{ text: 'Fecha de creación', datafield: 'fecha_ing', width: '12%',cellclassname: cellclassname },
				{ text: 'Fecha de modificación', datafield: 'fecha_mod', width: '12%',hidden:true },
				{ text: 'Estado', datafield: 'estado', width: '5%',cellclassname: cellclassname },
				//{ text: 'cita_id', datafield: 'cita_id', width: '5%',cellclassname: cellclassname },
				{ text: 'Estado llamada', datafield: 'estado_llamada', width: '15%',
				 cellclassname: cellclassname, hidden:true },
               
              
            ],
             
        });
		}
		
	
		
		var cellsrenderer = function (row, column, value, defaultHtml) {
                if (value) {
                    var element = $(defaultHtml);
                    element.css({ 'background-color': 'Yellow', 'width': '100%', 'height': '100%', 'margin': '0px' });
                    return element[0].outerHTML;
                }
                return defaultHtml;
            }
            
            
            var cellclassname = function (row, columnfield, value, data) {
				if (data.estado_llamada) {
				return 'gray';
				}
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
      <div class='titnavtit'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/seg.png">&nbsp;&nbsp;Marketing: <a id="subtitulo"></a></div>
      <div class='titnavlog'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/log_titulo.png"></div>
    </div>
    
	<!--<div style='margin-left: 0px; margin-top: 5px;' id='jqxMenu'></div> 
	<div style='margin-left: 0px; margin-top: 5px;'>
     <div style='float: left;' id='listcampana'></div>
     <div style='float: left;' id='listempleado'></div>
    </div>
	<div style='margin-left: 0px; margin-top: 35px;' id="jqxgrid"></div>	--> 	            	

</div>

<div id="fSplitterr">
			         	<div class="splitter-panel">
			         		 <div id='jqxMenu'>
				         </div>
      	                
			            </div>
			            <div class="splitter-panel">
			            	<div style='margin-left: 0px; margin-top: 5px;'>
						     <div style='float: left;' id='listcampana'></div>
						     <div style='float: left;' id='listempleado'></div>
						     </div>
			            	<div  style='margin-left: 0px; margin-top: 35px;' id="jqxgrid"></div>
			            </div>
       </div>


