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
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxlistbox.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxeditor.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/otwidgets/validadoc.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdatatable.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxsplitter.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxscrollbar.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/fullcalendar/lib/moment.min.js"></script>
 <script type="text/javascript">
      var tema= "ui-redmond";
      var temaMv="arctic";
      $(document).ready(function () {
       
       
        //Codigo de menu de operaciones
		var tid="<?php echo $_GET["tid"]; ?>";
        menuopciones(tid);
        initgridDatos();
		mlistaCampanas();
		mlistaEmpleados();
               
        //Codigo Splitter
		//$('#mainSplitter').jqxSplitter({ width: '100%', height: 590, panels: [{ size: 220 },{ size: 600 }] });
		 $('#fSplitterr').jqxSplitter({theme: tema, width: '100%', height: '100%', panels: [{ size: '15%' },{ size: '85%' }] });
		
		
		//Codigo de consulta en la Grilla
		 var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
         var iemp = $("#listempleado").jqxDropDownList('getSelectedItem');
		 //gridContactosCampana(icamp.value,iemp.value)	 
		 //gridDatos(adpcontactos(icamp.value,iemp.value),'Contactos seguimiento telefónico'); 
		  gridDatos(adpcontactos(icamp.value,iemp.value,'dataST'),'Seguimiento telefónico'); 
		
		 $('#listcampana').on('select', function (event) {
		 	        var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
		            var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
		            //gridContactosCampana(icamp.value,iemp.value);
		            //gridDatos(adpcontactos(icamp.value,iemp.value),'Contactos seguimiento telefónico'); 
		             gridDatos(adpcontactos(icamp.value,iemp.value,'dataST'),'Seguimiento telefónico'); 
		
                  });	
          $('#listempleado').on('select', function (event) {
          	        var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
		            var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
		            //gridContactosCampana(icamp.value,iemp.value);
		            //gridDatos(adpcontactos(icamp.value,iemp.value),'Contactos seguimiento telefónico'); 
		             gridDatos(adpcontactos(icamp.value,iemp.value,'dataST'),'Seguimiento telefónico'); 
		
                  });			

  
    });
 
 
 
   	
   	 var oper;
     var url = "<?php echo site_url("mar/seguimientos/ajax"); ?>";  
   	 function menuopciones(padre_id){
			
			var view='seguimiento_view'
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
			 //$("#jqxMenu").jqxMenu({source: records, theme: tema, autoSizeMainItems: false, showTopLevelArrows: true, width: '100%'});
             $("#jqxMenu").jqxMenu({source: records, theme: temaMv, autoSizeMainItems: false, showTopLevelArrows: true, width: '100%',  height:'100%' ,mode: 'vertical'});
             $("#jqxMenu").css("visibility", "visible");
             $("#jqxMenu").on('itemclick', function (event) {
             	  //alert($(event.args).text());
                    //$("#eventLog").text("Id: " + event.args.id + ", Text: " + $(event.args).text());
                    var opt=$(event.args).text();
                    switch (opt) {
					   
					    case 'Editar':
					        opeditar();
					        break;
					    /*case 'Borrar':
					        opborrar();
					        break;*/
					    case 'Reconsultar':
					        opreconsular();
					        break;
					   
					    case 'Gestionar':
					        opgestionar();
					        break;
					        
					     case 'Ver detalle':
					        opinfoadicional();
					        break;
					        
					    default:
					        //default code block
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
                { name: 'empleado', type: 'string' },
				{ name: 'campana', type: 'string' },
				{ name: 'identificacion', type: 'string' },
				{ name: 'nombres', type: 'string' },
				{ name: 'apellidos', type: 'string' },
				{ name: 'ciudad', type: 'string' },
				{ name: 'movil', type: 'string' },
				{ name: 'fecha_hora', type: 'string' },
				{ name: 'convenional', type: 'string' },
				{ name: 'direccion', type: 'string' },
				{ name: 'observaciones', type: 'string' },
				{ name: 'fecha_ing', type: 'string' },
				{ name: 'fecha_mod', type: 'string' },
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
        
      function adpcontactos2(camp_id, emp_id){
		var url = "<?php echo site_url("mar/contactos/ajax"); ?>";
		var soper = 'dataST';
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
                { name: 'empleado', type: 'string' },
				{ name: 'campana', type: 'string' },
				{ name: 'identificacion', type: 'string' },
				{ name: 'nombres', type: 'string' },
				{ name: 'apellidos', type: 'string' },
				{ name: 'ciudad', type: 'string' },
				{ name: 'movil', type: 'string' },
				{ name: 'fecha_hora', type: 'string' },
				{ name: 'convenional', type: 'string' },
				{ name: 'direccion', type: 'string' },
				{ name: 'observaciones', type: 'string' },
				{ name: 'fecha_ing', type: 'string' },
				{ name: 'fecha_mod', type: 'string' },
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
     
   	 function adpcontactos1(camp_id, emp_id){
		var url = "<?php echo site_url("mar/seguimientos/datos"); ?>"+"/"+camp_id+"/"+emp_id;
		var source =
        {
            datatype: "json",
            datafields: [
                { name: 'id', type: 'numeric' },
                { name: 'contacto_id', type: 'numeric' },
				{ name: 'empleado_id', type: 'numeric' },
				{ name: 'campana_id', type: 'numeric' },
                { name: 'empleado', type: 'string' },
				{ name: 'campana', type: 'string' },
				{ name: 'identificacion', type: 'string' },
				{ name: 'nombres', type: 'string' },
				{ name: 'apellidos', type: 'string' },
				{ name: 'movil', type: 'string' },
				{ name: 'fecha_hora', type: 'string' },
				{ name: 'ciudad', type: 'string' },
				{ name: 'direccion', type: 'string' },
				{ name: 'observaciones', type: 'string' },
				{ name: 'fecha_ing', type: 'string' },
				{ name: 'fecha_mod', type: 'string' },
				{ name: 'estado', type: 'string' }
            ],
            id: 'id',
            url: url,
            pagesize: 20,
            async: false
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
       
       
    		
		function opeditar(){
			         oper = 'edit';
			         var url = "<?php echo site_url("mar/seguimientos/ajax"); ?>" 
                 	 var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                       
                        if (selectedrowindex >= 0 ) {
                            
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
			             var url = "<?php echo site_url("mar/seguimientos/ajax"); ?>" 
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
	                        detallesTelefonos(dataRecord.contacto_id,dataRecord.identificacion,dataRecord.apellidos,dataRecord.nombres);
	                        detallesMails(dataRecord.contacto_id,dataRecord.identificacion,dataRecord.apellidos,dataRecord.nombres);
	                        //DirectorioContacto(dataRecord.id,dataRecord.identificacion,dataRecord.apellidos,dataRecord.nombres);
	                        muestraDialogoCampana(1, dataRecord.campana_id,dataRecord.identificacion,dataRecord.apellidos,dataRecord.nombres,dataRecord.empleado);
	                        preguntas_datos(dataRecord.campana_id,dataRecord.contacto_id);
	                        $("#vid").val(dataRecord.id);
	                        $("#vproceso").val('Seguimiento telefónico');
	                        $('#vidcampana').val(dataRecord.campana_id);
	                        $("#vidcontacto").val(dataRecord.contacto_id);
	                        $("#videntificacion").val(dataRecord.identificacion);
	                        $("#vnombre").val(dataRecord.nombres);
							$("#vapellido").val(dataRecord.apellidos);
							$("#vciudad").val(dataRecord.ciudad);
							$("#vdireccion").val(dataRecord.direccion);
							initgridLlamadasTelefonicas(detalleLlamadas(dataRecord.contacto_id));
							$("#eventWindowVisualizar").jqxWindow('open');
	                        }else{
	                        	jqxAlert.alert('Seleccione un registro','Gestión');
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
          
    		function preguntas_datos1(camp_id){
			$("#datosEncuesta").empty(); 
			var source =
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
						{ name: 'obligatorio'}
					],
					id: 'id',
					url: "<?php echo site_url("mar/preguntas/preguntas_datos"); ?>"+"/"+camp_id
				};
			
			 var dataAdapter = new $.jqx.dataAdapter(source, {
			 	        async:true,
				        autoBind:true,
						beforeLoadComplete: function (data) { 
							   
							   var pregunta;
							   var orden;
							   // var container="<table>";
							   
							   $('#datosEncuesta').append("<table>");
								for(i=0;i<data.length;i++){
								 var itemPregunta;
								 
								 //pregunta = data[i]['detalle_pregunta']+" "+data[i]['obligatorio'];
								 pregunta = data[i]['detalle_pregunta'];
								 orden = data[i]['orden'];
								 var tipo_respuesta = data[i]['tipo_respuesta_id'];
								 //$('#datosEncuesta').append("<tr><td>"+orden+".- </td><td>"+pregunta+"</td></tr>");
								
								 if (data[i]['tipo_pregunta_id']==1){ 
									var objeto_respuesta = "<input id='caja' style='width:80'/>";
									$('#datosEncuesta').append("<tr><td>"+orden+".- </td><td>"+pregunta+"</td><td>"+objeto_respuesta+"</td></tr>");
									//itemPregunta="<tr><td>"+orden+".- </td><td>"+pregunta+"</td><td>"+objeto_respuesta+"</td></tr>";
									//container += itemPregunta;
									//$('#datosEncuesta').append("<tr><td>"+objeto_respuesta+"</td></tr>");
								 }else{
								 	
								  	
									$('#datosEncuesta').append("<tr><td>"+orden+".- </td><td>"+pregunta+"</td></tr>");
									 //itemPregunta="<tr><td>"+orden+".- </td><td>"+pregunta+"</td></tr>";
								     //container += itemPregunta;
								     //document.getElementById("myDIV")
								     //$('#datosEncuesta').append('<div id="myDIV"/>');
								     //var obj=document.getElementById("myDIV");
								     opciones_respuestas(tipo_respuesta);
								     
								     
									 
								 }
								
								}
								//container += "</table>";
								//$('#datosEncuesta').append(container);
								$('#datosEncuesta').append("</table>");
								
						},
						//loadError: function (xhr, status, error) { }      
					});
									         
               //return dataAdapter;
             //dataAdapter.dataBind();
		}
		
		function preguntas_datos_jj(camp_id){
    		$("#datosEncuesta").empty(); 
		    			
			  //var url="<?php echo site_url("mar/preguntas/preguntas_datos"); ?>"+"/"+camp_id;
			  $.getJSON(url, {format: "json"}, function(data) {
							   //var container="<div>";
							   $('#datosEncuesta').append("<div>");
							   var pregunta;
							   var orden;
							  
							   
								for(i=0;i<data.length;i++){
								 var itemPregunta;
								 //var itemsResp;
								 //pregunta = data[i]['detalle_pregunta']+" "+data[i]['obligatorio'];
								 pregunta = data[i]['detalle_pregunta'];
								 orden = data[i]['orden'];
								 var tipo_respuesta = data[i]['tipo_respuesta_id'];
								
								 if (data[i]['tipo_pregunta_id']==1){ 
									var objeto_respuesta = "<input id='caja' style='width:80'/>";
									itemPregunta="<h3>"+orden+".- "+pregunta+" "+objeto_respuesta+"</h3>";
									//container += itemPregunta;
									$('#datosEncuesta').append(itemPregunta);
								 }else{
								 	
								  	
									 itemPregunta="<h3>"+orden+".- "+pregunta+"</h3>";
								     //container += itemPregunta;	
								     $('#datosEncuesta').append(itemPregunta);					
									
									 
									 var url="<?php echo site_url("mar/campanas/opciones_encuesta"); ?>"+"/"+tipo_respuesta;
									 $.getJSON(url, {format: "json"}, function(data) { 
										var itemRespuesta;
										//$('#datosEncuesta').append("<ul>");
										for(j=0;j<data.length;j++){
											
											if (data[j]['multiple_respuesta']==1){
												var objeto_respuesta="<input type = 'checkbox'>"+data[j]['detalle']+"</input>";
												itemRespuesta="<li>"+objeto_respuesta+"</li>";
												$('#datosEncuesta').append(itemRespuesta);
											}else{
												var objeto_respuesta="<input type='radio'>"+data[j]['detalle']+"</input>";
												itemRespuesta="<li>"+objeto_respuesta+"</li>";
												$('#datosEncuesta').append(itemRespuesta);
											}
										
										}
										
										//$('#datosEncuesta').append("</ul>");
										});
										
								 }
								 
								}
								
								$('#datosEncuesta').append("</div>");
								//container += "</div>";
								//alert(container);
								//$('#datosEncuesta').append(container);
						 });
								
		}
		 
		
        function preguntas_datos(camp_id,contacto_id){
			$("#datosEncuesta").empty(); 
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
					url: "<?php echo site_url("mar/preguntas/preguntas_datos"); ?>"+"/"+camp_id+"/"+contacto_id
				};
			
			 var dataAdapterPreg = new $.jqx.dataAdapter(customersPreguntas, {
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
								 	$('#datosEncuesta').append("<tr><td>"+orden+".- </td><td>"+data[i]['detalle_pregunta']+"</td><td><input id='resp_"+id_pregunta+"' value='"+data[i]['respuesta_texto']+"'/><td></tr>");
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
             dataAdapterPreg.dataBind();
			 
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
			var sidcontacto=$("#vidcontacto").jqxInput('val'); 
										///alert(sidcontacto);
					var respuesta = {
						resp: resp,
						contacto: sidcontacto,
						preg: id_pregunta,
						multi: multi
					};
					$.ajax({
						type: "POST",
						url: "<?php echo site_url("mar/preguntas/saveRespuesta"); ?>",
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
		  
		   function setTitulo(titulo){
		 	$("#subtitulo").empty();
    		$('#subtitulo').append(titulo);
    		
		 }
		 
		 function getTitulo(){
		 	return $('#subtitulo').text();
		 	
		 }
		 
		
    		function initgridDatos(){
			$("#jqxgrid").jqxGrid({
            width : '100%',
            height: '94%',
            theme: tema,
            //source: adpcontactos(campid,empid),
            //groupable: true,
            sortable: true,
            //showfilterrow: true,
            //groupsexpandedbydefault: true,
            filterable: true,
            pageable: true,
            //autoheight: true,
            columnsresize: true,
            //pagermode: 'simple',
            //showtoolbar: true,
            //Codigo para la barra de herramientas de la grilla
            //rendertoolbar: function (toolbar) { 
                //var me = this;
     		//},
            columns: [
                { text: 'Id', datafield: 'id', width: '5%',hidden:true },
               	{ text: 'contacto_id', datafield: 'contacto_id', width: '5%',hidden:true },
				{ text: 'empleado_id', datafield: 'empleado_id', width: '5%',hidden:true },
				{ text: 'campana_id', datafield: 'campana_id', width: '5%',hidden:true },
				{ text: 'Empleado', datafield: 'empleado', width: '10%',hidden:true },
				{ text: 'Campa&ntilde;a', datafield: 'campana', width: '10%',hidden:true },
				{ text: 'Teléfono', datafield: 'movil', width: '10%' },
				{ text: 'Fecha hora', datafield: 'fecha_hora', width: '14%' },
                { text: 'Identificacion', datafield: 'identificacion', width: '10%' },
				{ text: 'Nombres', datafield: 'nombres', width: '12%' },
				{ text: 'Apellidos', datafield: 'apellidos', width: '12%' },
				{ text: 'Ciudad', datafield: 'ciudad', width: '15%' },
				{ text: 'Observaciones', datafield: 'observaciones', width: '20%'},
				{ text: 'Direccion', datafield: 'direccion', width: '20%'},
				{ text: 'Fecha de creación', datafield: 'fecha_ing', width: '14%' },
				//{ text: 'Fecha de modificación', datafield: 'fecha_mod', width: '12%' },
				{ text: 'Estado', datafield: 'estado', width: '5%' },
            ],
             //groups: ['campana','empleado']
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




