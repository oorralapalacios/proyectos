 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.filter.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.sort.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.pager.js"></script> 
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxpanel.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxlistbox.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdropdownlist.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdatetimeinput.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxcalendar.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdropdownlist.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxcheckbox.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxbuttongroup.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxsplitter.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxscrollbar.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.columnsresize.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxexpander.js"></script>

   <script type="text/javascript">
	   //var tema= "ui-redmond";
	    $(document).ready(function () {
	    	$('#fSplitter').jqxSplitter({theme: tema, width: '100%', height: '100%', panels: [{ size: '40%' },{ size: '60%' }] });
            teleoperador();
            estadogestion();
	    	intGridCitas();
	    	$("#parameter_form").jqxExpander({ theme:tema,  toggleMode: 'none', width: '100%', height: '100%', showArrow: false });
            var iemp = $("#teleoperadorTel").jqxDropDownList('getSelectedItem');
		    gridCitas(adpGestionCitas(iemp.value,'dataGCA'),'Citas asignadas');
		            $('#teleoperadorTel').on('select', function (event) {
		          	          			              
				              setGridCitas();
				             
		              });
		              
		              $('#estadogestion').on('select', function (event) {
		              	 var args = event.args;
                         var item = $('#estadogestion').jqxDropDownList('getItem', args.index);
		              	 
		          	          setTitulo(item.label); 			              
				              setGridCitas();
				             
		              });        
	    	 
	    	
	    	
	    	 //generaReporteCit();
				
	    })
	   
                
            function teleoperador(){
            	$("#teleoperadorTel").jqxDropDownList({
									source: adpempleados(),
									theme: tema,
									width: 220,
									height: 25,
									selectedIndex: 0,
									displayMember: 'empleado',
									valueMember: 'id'
			        				});  
            }
            
            
             var sourceestados = [
                    "Citas asignadas",
                    "Ventas completas",
                    "Ventas incompletas"
                  
		        ];
            function estadogestion(){
            	$("#estadogestion").jqxDropDownList({
									source: sourceestados,
									theme: tema,
									width: 220,
									height: 25,
									selectedIndex: 0,
									displayMember: 'empleado',
									valueMember: 'id'
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
					url: '<?php echo site_url("emp/empleados/getVendedores"); ?>',
					async: false
				};
				
		         var dataAdapter = new $.jqx.dataAdapter(datos); 
        	    return dataAdapter;
           }
        	
	
		
		function setTitulo(titulo){
		 	$("#subtitulo").empty();
    		$('#subtitulo').append(titulo);
    		
    	 }
		 
		 function getTitulo(){
		 	return $('#subtitulo').text();
		 }
		
		function setGridCitas(){
        	var opt= getTitulo();
        	switch (opt) {
					  
					   case 'Citas asignadas':
					       	 var iemp = $("#teleoperadorTel").jqxDropDownList('getSelectedItem');
					          gridCitas(adpGestionCitas(iemp.value,'dataGCA'),'Citas asignadas');
			                 
					        break;
					        
					    case 'Ventas completas':
					    
					         var iemp = $("#teleoperadorTel").jqxDropDownList('getSelectedItem');
			                  gridCitas(adpGestionCitas(iemp.value,'dataGVC'),'Ventas completas');
					         break;
					         
					    case 'Ventas incompletas':
					         var iemp = $("#teleoperadorTel").jqxDropDownList('getSelectedItem');
			                 gridCitas(adpGestionCitas(iemp.value,'dataGVI'),'Ventas incompletas');
					        break;
					        
					    case 'Interesados':
					        var iemp = $("#teleoperadorTel").jqxDropDownList('getSelectedItem');
			                gridCitas(adpGestionCitas(iemp.value,'dataGVIN'),'Interesados');
					        break;
					    
					    case 'No interesados':
					         var iemp = $("#teleoperadorTel").jqxDropDownList('getSelectedItem');
			                 gridCitas(adpGestionCitas(iemp.value,'dataGVNI'),'No interesados');
			                 break;
			                 
			                 
			             case 'Citas canceladas':
					         var iemp = $("#teleoperadorTel").jqxDropDownList('getSelectedItem');
			                 gridCitas(adpGestionCitas(iemp.value,'dataGVCA'),'Citas canceladas');
			                 break;
			             
			             case 'No visitados':
			                 var iemp = $("#teleoperadorTel").jqxDropDownList('getSelectedItem');
			                 gridCitas(adpGestionCitas(iemp.value,'dataGVNV'),'No visitados');
					         break;   
			                 
			                
					    default:
					        var iemp = $("#teleoperadorTel").jqxDropDownList('getSelectedItem');
			                gridCitas(adpGestionCitas(iemp.value,'dataGCA'),'Citas asignadas');
					} 
        }
		
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
               //source: adpCitas(emp_id),
				theme: tema,
				width: '100%', 
				height: '80%',
                sortable: true,
                //showfilterrow: true,
                filterable: true,
                pageable: true,
                columnsresize: true,
                pagermode: 'simple',
                
                columns: [
                  { text: 'contacto_id', datafield: 'contacto_id', width: '10%', hidden:'True' },
                  { text: '', datafield: 'Ver', width: 80, columntype: 'button',id:'number', cellsrenderer: function () {
			                     return "Ver";
			                  }, buttonclick: function (row) {
			                  	  
			                              
			                               var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
			                               var rowscount = $("#jqxgrid").jqxGrid('getdatainformation').rowscount;
			                               if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
			                               var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex);
			                               if (dataRecord.contacto_id) {
			                                 generaReporteCit();
			                               } 
			                              
			                               }
								 
			                  }
			        },
			        { text: 'Contacto', datafield: 'contacto', width: '50%' },
			        { text: 'Identificacion', datafield: 'identificacion', width: '25%' },
			        { text: 'Movil', datafield: 'movil', width: '25%' },
                   
                 
                ]
                
            });
        	
        }

    </script>
    
    <div class="main">
    	<div class='titnavbg'>
	     <div class='titnavtit'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/inv.png">&nbsp;&nbsp;Reportes: <a id="subtitulo"></a></div>
	     <div class='titnavlog'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/log_titulo.png"></div>
	    </div>
     <div id="fSplitter">
			         	<div class="splitter-panel">
			         		 <div id="parameter_form" style="font-family: Verdana; font-size: 12px;">
					         <div>
					           Parametros del Reporte
					         </div>
					         <div style="font-family: Verdana; font-size: 12px;">
			         		<form id="formDialogTel">
								<table>
                                    <tr>
				                        <td align="right">Asesor:</td>
				                        <td align="left"><div id="teleoperadorTel"</div></td>
				                    </tr>
				                    <tr>
				                        <td align="right">Estado:</td>
				                       	<td align="left"><div id="estadogestion"</div></td>
				                    </tr>
				                    
				                </table>
				                 <div id="jqxgrid"></div>
						     </form>
						     </div>
						     
						  </div>
						</div>
			            <div class="splitter-panel">
			            	 <div style='margin-left: 0px; margin-top: 0px;' id="reporte"></div>
			            	 <div id="ventana" style='white-space: nowrap;'>
						                <script>
												function generaReporteCit(){
													var empleado = $("#teleoperadorTel").text();
													var id_empleado = $('#teleoperadorTel').val(); 
													var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
													var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex); 
													//alert(id_empleado+' '+dataRecord.contacto_id+' '+empleado);
													url= "<?php echo site_url("rep/citres/generar_pdfCita"); ?>"+"/"+id_empleado+"/"+dataRecord.contacto_id+"/"+empleado;
													document.getElementById('ventana').innerHTML = "<iframe src='"+url+"' width='100%' height='600'></iframe>";
												}
										</script>
						               
						            </ul>
						        </div> 
			            </div>
       </div>  
     
         	
	  
   </div>   
       
      