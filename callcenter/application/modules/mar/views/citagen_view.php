
 <script type="text/javascript">
  var tema= "ui-redmond";
  var temaMv="arctic";
  $(document).ready(function () {
  	      	var tid="<?php echo $_GET["tid"]; ?>";
            menuopciones(tid);
            intGridCitas();
          	mlistaEmpleados();
          	//mlistaEstados();
           	$('#fSplitter').jqxSplitter({theme: tema, width: '100%', height: '100%', panels: [{ size: '15%' },{ size: '85%' }] });
           
        
		    var iemp = $("#listempleado").jqxDropDownList('getSelectedItem');
			//gridCitas(adpCitasAsignadas(iemp.value),'Citas asignadas');
            gridCitas(adpGestionCitas(iemp.value,'dataGCA'),'Citas asignadas');
            $('#listempleado').on('select', function (event) {
            	     setGridCitas();
          	         
                  });	
          
   });
   
   function adpGestionCitas(emp_id,soper){
		var url = "<?php echo site_url("mar/gescitas/ajax"); ?>";
		//var soper = 'dataGC';
		var datos = {accion: soper,
			          emp_id: emp_id
			         };
		var source =
        {
            datatype: "json",
            datafields: datafieldsCitas,
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
   
       datafieldsCitas=[
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
                    
                ]
        
      			
		
		
	function gridCitas(adp,titulo){
        	setTitulo(titulo);
        	 //Codigo de operaciones en la Grilla
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
        
   function intGridCitas(){
        	
            $("#jqxgrid").jqxGrid(
            {
                width : '100%',
                height: '94%',
                //source: adp,
				theme: tema,
                sortable: true,
                //showfilterrow: true,
                filterable: true,
                //selectionmode: 'multiplecellsextended',
                //filtermode: 'excel',
                pageable: true,
                columnsresize: true,
                pagermode: 'simple',
                columns: [
                  { text: 'Id', datafield: 'id', width: '8%', hidden:'True' },
                  { text: 'Tipo', datafield: 'tipo_gestion', width: '8%' },
                  { text: 'Fecha hora', datafield: 'fecha_hora', width: '15%' },
                  { text: 'Identificacion', datafield: 'identificacion', width: '8%' },
                  { text: 'Contacto', datafield: 'contacto', width: '20%' },
                  { text: 'Movil', datafield: 'movil', width: '20%' },
                  { text: 'Campana', datafield: 'campana', width: '20%' },
                  { text: 'Gestor', datafield: 'gestor', width: '20%' },
                  { text: 'Observacion', datafield: 'observacion', width: '35%' },
                  { text: 'Ruc', datafield: 'ruc', width: '10%' },
                  { text: 'Razon social', datafield: 'razon_social', width: '20%' },
				  { text: 'Fecha de creación', datafield: 'fecha_ing', width: '20%' },
                  //{ text: 'Fecha de modificación', datafield: 'fecha_mod', width: '20%' },
                  //{ text: 'Estado', datafield: 'estado', width: '20%' },
                 
                ]
                
            });
        	
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
					url: '<?php echo site_url("emp/empleados/getJerarquiaVendedores"); ?>',
					async: false
				};
				
		         var dataAdapter = new $.jqx.dataAdapter(datos); 
        	    return dataAdapter;
        }
        
        function adpestadocita(){
               var tabla_id=8;
        	   var url = "<?php echo site_url("mar/campanas/datostablas"); ?>"+"/"+tabla_id;
               var source ={
						                datatype: "json",
						                datafields: [
                   					      { name: 'id', type: 'number' },
			               		          { name: 'descripcion', type: 'string' },
					                      
					                    ],
						                id: 'id',
						                url: url,
						            };
			             
                   
                 var dataAdapter = new $.jqx.dataAdapter(source);
                 return dataAdapter;
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
         
          function mlistaEstados(){
         	 $('#listestados').jqxDropDownList({
							source: adpestadocita(),
							width: 300,
							//height: 20,
							theme: tema,
							selectedIndex: 0,
							displayMember: 'descripcion',
							valueMember: 'descripcion'
					}); 
         }
         
         
         function setTitulo(titulo){
		 	$("#subtitulo").empty();
    		$('#subtitulo').append(titulo);
    		if (titulo=='Ventas completas') {
    			
    			$('#jqxMenu').jqxMenu('disable', '82', true);
    		} else {
    			$('#jqxMenu').jqxMenu('disable', '82', false);
    		}
    	 }
		 
		 function getTitulo(){
		 	return $('#subtitulo').text();
		 }
         
         
        function setGridCitas(){
        	var opt= getTitulo();
        	switch (opt) {
					  
					   case 'Citas asignadas':
					       	 var iemp = $("#listempleado").jqxDropDownList('getSelectedItem');
			                 //gridCitas(adpCitasAsignadas(iemp.value),'Citas asignadas');
			                 gridCitas(adpGestionCitas(iemp.value,'dataGCA'),'Citas asignadas');
			                 
					        break;
					        
					    case 'Ventas completas':
					    
					         var iemp = $("#listempleado").jqxDropDownList('getSelectedItem');
			                 //gridCitas(adpVentasCompletadas(iemp.value),'Ventas completas');
			                  gridCitas(adpGestionCitas(iemp.value,'dataGVC'),'Ventas completas');
					         break;
					         
					    case 'Ventas incompletas':
					         var iemp = $("#listempleado").jqxDropDownList('getSelectedItem');
			                 //gridCitas(adpVentasInCompletadas(iemp.value),'Ventas incompletas');
			                 gridCitas(adpGestionCitas(iemp.value,'dataGVI'),'Ventas incompletas');
					        break;
					        
					    case 'Interesados':
					        var iemp = $("#listempleado").jqxDropDownList('getSelectedItem');
			                //gridCitas(adpInteresados(iemp.value),'Interesados');
			                gridCitas(adpGestionCitas(iemp.value,'dataGVIN'),'Interesados');
					        break;
					    
					    case 'No interesados':
					         var iemp = $("#listempleado").jqxDropDownList('getSelectedItem');
			                 //gridCitas(adpNoInteresados(iemp.value),'No interesados');
			                 gridCitas(adpGestionCitas(iemp.value,'dataGVNI'),'No interesados');
			                 break;
			                 
			                 
			             case 'Citas canceladas':
					         var iemp = $("#listempleado").jqxDropDownList('getSelectedItem');
			                 //gridCitas(adpCitasCanceladas(iemp.value),'Citas canceladas');
			                 gridCitas(adpGestionCitas(iemp.value,'dataGVCA'),'Citas canceladas');
			                 break;
			             
			             case 'No visitados':
			                 var iemp = $("#listempleado").jqxDropDownList('getSelectedItem');
			                 //gridCitas(adpNoVisitados(iemp.value),'No visitados');
			                 gridCitas(adpGestionCitas(iemp.value,'dataGVNV'),'No visitados');
					         break;   
			                 
			                
					    default:
					        var iemp = $("#listempleado").jqxDropDownList('getSelectedItem');
			                gridCitas(adpGestionCitas(iemp.value,'dataGCA'),'Citas asignadas');
					} 
        }
        
       	function menuopciones(padre_id){
			//var view='citagen_view'
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
             	  //alert($(event.args).text());
                    //$("#eventLog").text("Id: " + event.args.id + ", Text: " + $(event.args).text());
                    var opt=$(event.args).text();
                    switch (opt) {
					    case 'Gestionar':
					        opgestionar();
					        break;
					        
					   case 'Citas asignadas':
					       	 var iemp = $("#listempleado").jqxDropDownList('getSelectedItem');
			                 //gridCitas(adpCitasAsignadas(iemp.value),'Citas asignadas');
			                 gridCitas(adpGestionCitas(iemp.value,'dataGCA'),'Citas asignadas');
					         break;
					        
					    case 'Ventas completas':
					         var iemp = $("#listempleado").jqxDropDownList('getSelectedItem');
			                 //gridCitas(adpVentasCompletadas(iemp.value),'Ventas completas');
			                 gridCitas(adpGestionCitas(iemp.value,'dataGVC'),'Ventas completas');
					         break;
					    case 'Ventas incompletas':
					         var iemp = $("#listempleado").jqxDropDownList('getSelectedItem');
			                 //gridCitas(adpVentasInCompletadas(iemp.value),'Ventas incompletas');
					        gridCitas(adpGestionCitas(iemp.value,'dataGVI'),'Ventas incompletas');
					        break;
					    case 'Interesados':
					         var iemp = $("#listempleado").jqxDropDownList('getSelectedItem');
			                 //gridCitas(adpInteresados(iemp.value),'Interesados');
			                 gridCitas(adpGestionCitas(iemp.value,'dataGVIN'),'Interesados');
			                 break; 
			            case 'No interesados':
			                 var iemp = $("#listempleado").jqxDropDownList('getSelectedItem');
			                 //gridCitas(adpNoInteresados(iemp.value),'No interesados');
			                 gridCitas(adpGestionCitas(iemp.value,'dataGVNI'),'No interesados');
					         break;
					         
					      case 'Citas canceladas':
			                 var iemp = $("#listempleado").jqxDropDownList('getSelectedItem');
			                 //gridCitas(adpCitasCanceladas(iemp.value),'Citas canceladas');
			                 gridCitas(adpGestionCitas(iemp.value,'dataGVCA'),'Citas canceladas');
					         break;
					        
					      case 'No visitados':
			                 var iemp = $("#listempleado").jqxDropDownList('getSelectedItem');
			                 //gridCitas(adpNoVisitados(iemp.value),'No visitados');
			                 gridCitas(adpGestionCitas(iemp.value,'dataGVNV'),'No visitados');
					         break;
					         
					    case 'Agenda':
					        opragenda();
					        break;
					    case 'Reconsultar':
					        opreconsular();
					        break;
					    default:
					       //default code block
					} 
               	 });
        } 
        
       
        
        function opragenda(){
        	
        	//document.getElementById("frmAgenda").reset();
           	createElementsAgenda();
        	$("#eventWindowAgenda").jqxWindow('open');
        	var iemp = $("#listempleado").jqxDropDownList('getSelectedItem');
   			borrarAgenda();
        	load_agenda(iemp.value);
        	
        }
        
       function opgestionar(){
			var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                      
                	 if (selectedrowindex >= 0) {
                             var offset = $("#jqxgrid").offset();
	                        // get the clicked row's data and initialize the input fields.
	                        dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex);
	                        // show the popup window.
	                        preguntas_datos(dataRecord.campana_id,dataRecord.contacto_id,dataRecord.contacto_campana_id);
	                        genabrirDialogo(dataRecord.contacto_id,dataRecord.campana_id,dataRecord.contacto_campana_id)
	                        }else{
	                        	jqxAlert.alert('Seleccione un registro','Gestión');
	                        }
                       
		}
				   
        
		
			
		function opreconsular(){
			 $("#jqxgrid").jqxGrid('updatebounddata');
		}	
    
	   function preguntas_datos(camp_id,contacto_id,contacto_campana_id){
			$("#gendatosEncuesta").empty(); 
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
							   $('#gendatosEncuesta').append("<table>");
								for(i=0;i<data.length;i++){
								 id_pregunta = data[i]['id'];
								 pregunta = data[i]['detalle_pregunta'];
								 orden = data[i]['orden'];
								 var tipo_respuesta = data[i]['tipo_respuesta_id'];
								 var opciones = data[i]['opciones'];
								 if (opciones==''){
								 	$('#gendatosEncuesta').append("<tr><td>"+orden+".- </td><td>"+data[i]['detalle_pregunta']+"</td><tr></tr><td colspan='2'><input id='resp_"+id_pregunta+"' value='"+data[i]['respuesta_texto']+"'/><td></tr>");
								 	//$('#gendatosEncuesta').append("<tr><td>"+orden+".- </td><td>"+data[i]['detalle_pregunta']+"</td><td><input id='resp_"+id_pregunta+"' value='"+data[i]['respuesta_texto']+"'/><td></tr>");
								 }else{
								 	$('#gendatosEncuesta').append("<tr><td>"+orden+".- </td><td>"+data[i]['detalle_pregunta']+"</td></tr>");
								 }
								 
								 for(j=0;j<opciones.length;j++){
									
								 	if (opciones[j]['respuesta']==opciones[j]['detalle']){var check='checked';}else{var check='';}
										//alert(opciones[j]['respuesta']);
									 $('#gendatosEncuesta').append("<tr><td colspan=2><input type='"+opciones[j]['objeto']+"' id='"+opciones[j]['detalle']+"' name='"+id_pregunta+"'  value = '"+opciones[j]['detalle']+"' "+check+">"+opciones[j]['detalle']+"</td></tr>");
									
									 }
								}
								
								$('#gendatosEncuesta').append("</table>");
						},
						
					});
									         
             
			 	 
		}
		
		
    </script>
<div class="main">
	<div class='titnavbg'>
      <div class='titnavtit'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/inv.png">&nbsp;&nbsp;Marketing: <a id="subtitulo"></a></div>
      <div class='titnavlog'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/log_titulo.png"></div>
    </div>
 
     
      
       <div id="fSplitter">
			         	<div class="splitter-panel">
			         		 <div id='jqxMenu'></div>
      	                
			            </div>
			            <div class="splitter-panel">
			            	<div style='margin-left: 5px; margin-top: 5px;'>
						     <div style='float: left;' id='listempleado'></div>
						    </div>
						   
			            	<div  style='margin-left: 0px; margin-top: 35px;' id="jqxgrid"></div>
			            </div>
       </div>
 </div>