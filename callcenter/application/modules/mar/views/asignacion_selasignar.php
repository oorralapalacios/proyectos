<!-- <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.filter.js"></script>
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
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxcheckbox.js"></script>-->
 <script type="text/javascript">
 
    
      //codigo para inicializacion del formulario
        function createElementsSelAsignar() {
        	
        	//alert('hi');
        	//ulistaCampanas();
        	
        	
        	//initselgridContactos();
        	//mlistaCampanas2();
        	//var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
	        //gridSelContactosCampana(icamp.value);	
            $('#eventWindowSelAsignar').window({
                resizable: false,
                width: '600px',
                height: '20%',
                modal: true,
                minimizable: false,  
                maximizable:false,
                collapsible:false,
                minimized:true
            });
           
            //$('#eventWindowSelAsignar').jqxWindow('focus');
            //$('#eventWindowSelAsignar').jqxValidator('hide');
             
        }
        
      function setControlesAsignacion(){
      	//$('#id_cartera3').jqxInput({theme: tema, disabled: true,width: '0px' });
                	//$('#sremp1_id').jqxInput({theme: tema, width: '150px' });
                	 $('#btnSelAsignarGC').jqxButton({theme: tema, width: '65px' });	
      	             $('#btnSelAsignarIN').jqxButton({theme: tema, width: '250px' });
                    //$('#id_campana3').jqxInput({theme: tema, width: '150px' });
                     $('#btnSelAsignarGC').focus();
                     
                     $("#btnSelAsignarGC").click(function () {
                    	selasignarGC();
                     });
                     
                     $("#btnSelAsignarIN").click(function () {
                    	sasignarseguimiento();
                     });
      };
      
      function abrirSelAsignacion(){
      	 //$('#eventWindowSelAsignar').jqxWindow({autoOpen: false})
      	 //alert('hi');
      	 //document.getElementById("frmSelAsignar").reset();
      	 usellistaEmpleados();
         setControlesAsignacion();
      	 createElementsSelAsignar();
      	 $('#eventWindowSelAsignar').window('open');
         //$("#seljqxgrid").jqxGrid('updatebounddata');
	 	 
	   }
	   
	   function gridSelContactosCampana(campid){
	   	    var adp=adpcontactossingestor(campid);
			$("#seljqxgrid").jqxGrid({
				source: adp,
				sortable: true,
			    filterable: true,
				virtualmode: true,
				pageable: true,
			    rendergridrows: function()
				{
					  return adp.records;     
				},})
	   }
	   
	   function gridBuscaSelContactosCampana(campid,campo,valor){
			$("#seljqxgrid").jqxGrid({source: adpbuscacontactossingestor(campid,campo,valor)})
		}
		  
		function adpcontactossingestor(camp_id){
		var url = "<?php echo site_url("mar/contactos_base/ajax"); ?>";
		var soper = 'dataselasig';
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
            //pagenum: 2,
            //pagesize: 20,
            //async: false,
            filter: function(){
	 	      $("#seljqxgrid").jqxGrid('updatebounddata', 'filter');
	        },
	        sort: function(){
		      $("#seljqxgrid").jqxGrid('updatebounddata', 'sort');
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
		
		
		
	   
	   function initselgridContactos(){
			$("#seljqxgrid").jqxGrid({
            width : '784px',
            height: '515px',
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
            columnsresize: true,
            pagermode: 'simple',
            pagesize: 20,
            
            //showtoolbar: true,
            //Codigo para la barra de herramientas de la grilla
             columns: [
                { text: 'Id', datafield: 'id', width: '5%',hidden:true },
               	{ text: 'Identificacion', datafield: 'identificacion', width: '10%' },
				{ text: 'Cliente', datafield: 'cliente', width: '25%' },
				{ text: 'Movil', datafield: 'telefono_movil', width: '10%'},
				{ text: 'Ciudad', datafield: 'ciudad', width: '15%' },
				{ text: 'Forma de pago', datafield: 'forma_pago', width: '20%'},
				{ text: 'Fecha de activacion', datafield: 'fecha_activacion', width: '20%'},
				{ text: 'Banco', datafield: 'banco', width: '20%'},
				{ text: 'Tarifa_basica', datafield: 'tarifa_basica', width: '20%'},
				{ text: 'Plan', datafield: 'plan', width: '20%'},
				{ text: 'Fecha de creación', datafield: 'fecha_ing', width: '12%' },
				{ text: 'Fecha de modificación', datafield: 'fecha_mod', width: '12%' },
				//{ text: 'Estado', datafield: 'estado', width: '5%' },
               
              
            ],
            
        });
        
        }
	   
	   function selasignarGC(){
	   	
	  
                    AsigItems = [];	
                    AsigItems.length=0;
                    var getselectedrowindexes = $('#jqxgrid').jqxGrid('getselectedrowindexes');
                     
                         for (var i = 0; i < getselectedrowindexes.length; i++) {
                         	
                     	 var selectedRowData = $('#jqxgrid').jqxGrid('getrowdata', getselectedrowindexes[i]);
                     	 var item={
                     	 	       campana_id: selectedRowData.campana_id,
                     	 	       identificacion: selectedRowData.identificacion,
                     	 	       telefono_movil: selectedRowData.telefono_movil,
                     	 	       cliente: selectedRowData.cliente,
                     	 	       ciudad: selectedRowData.ciudad
                     	 	      };
                     	 AsigItems.push(item);
                         }
                        
			             oper = 'aselasigGC';
			             var url = "<?php echo site_url("mar/asignaciones/ajax"); ?>" 
                 	   
		                        var proceso = {
		                            accion: oper,
		                            empleado_id: $("#selempleado_id").val(),
		                            //alert(dataRecord.campana),
		                            //campana_id: $("#listcampana").val(),
		                            //campana_id: $("#id_campana3").val(),
		                            //campana_id: dataRecord.campana,
		                            
		                            registros: AsigItems,
		                        };
		                        jqxAlert.verify('Esta seguro de ejecutar la acción asignar?','Confirma asignar', function(r) {
							    if(r){
		                        $.ajax({
		                            type: "POST",
		                            url: url,
		                            data: proceso,
		                            success: function (data) {
		                            	 //var llamada_id=data;   
		                                if(data=true){
		                                    //$("#eventWindowSelAsignar").jqxWindow('hide');
		                                    
		                                    $("#jqxgrid").jqxGrid('updatebounddata');
		                                    $("#jqxgrid").jqxGrid('clearselection');
		                                    //$("#jqxgrid").jqxGrid('updatebounddata');
		                                   		                                    
		                                    //alert("Asignación de contactos ejecutada correctamente.");
		                                }else{
		                                    jqxAlert.alert("Problemas al asignar.");
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
                         
	   }	
	   
	  function sasignarseguimiento(){
	  	            SelAsigItems = [];	
                    SelAsigItems.length=0;
                    var getselectedrowindexes = $('#jqxgrid').jqxGrid('getselectedrowindexes');
                         for (var i = 0; i < getselectedrowindexes.length; i++) {
                     	 var selectedRowData = $('#jqxgrid').jqxGrid('getrowdata', getselectedrowindexes[i]);
                     	 var item={
                     	 		   campana_id: selectedRowData.campana_id,
                     	 	       identificacion: selectedRowData.identificacion,
                     	 	       telefono_movil: selectedRowData.telefono_movil,
                     	 	       cliente: selectedRowData.cliente,
                     	 	       ciudad: selectedRowData.ciudad
                     	 	      };
                     	 SelAsigItems.push(item);
                         }
	  	 
	  	 
			             oper = 'aselasigIN';
			             var url = "<?php echo site_url("mar/asignaciones/ajax"); ?>" 
                 	   
		                        var proceso = {
		                            accion: oper,
		                            //campana_id: $("#listcampana").val(),
		                            empleado_id: $("#selempleado_id").val(),
		                            registros: SelAsigItems,
		                            
		                        };
								jqxAlert.verify('Esta seguro de ejecutar la acción asignar?','Confirma asignar', function(r) {
							    if(r){
		                        $.ajax({
		                            type: "POST",
		                            url: url,
		                            data: proceso,
		                            success: function (data) {
		                                if(data=true){
		                                    //$("#eventWindowSelAsignar").jqxWindow('hide');
		                                    $("#jqxgrid").jqxGrid('updatebounddata');
		                                    $("#jqxgrid").jqxGrid('clearselection');
		                                    //$("#jqxgrid").jqxGrid('updatebounddata');
		                                    //alert("Reasignación de contactos ejecutada correctamente.");
		                                }else{
		                                    jqxAlert.alert("Problemas al asignar.");
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
	   
        
         function usellistaEmpleados(){
        	$("#selempleado_id").jqxDropDownList({
		 	        theme: tema,
					source: adpempleados(),
					width: 350,
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
					url: '<?php echo site_url("emp/empleados/getTeleoperadores"); ?>',
					async: false
				};
				
		         var dataAdapter = new $.jqx.dataAdapter(datos); 
        	    return dataAdapter;
        }
		
		   function mlistaCampanas2(){
        	 $('#campana_id2').jqxDropDownList({
							theme: tema,
							source: adpcampana1(),
							width: 350,
							height: 25,
						    selectedIndex: 0,
							displayMember: 'nombre',
							valueMember: 'id'
		         });  
        }
		   
		   function adpcampana2(){
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

</script>


<div style="visibility: hidden; display:none;" id="jqxWidgetSelAsignar">			
		<div  id="eventWindowSelAsignar" title="Asignación de contactos a gestores-campaña">
              <div>
                <div>
                    <form id="frmSelAsignar">
                    	<div style='margin-left: 0px; margin-top: 5px;'>
                    	<table>
                    		<!--<tr>
                    			<td>Campaña:</td>
                    			<td><div style='float: left;' id='campana_id2'></div></td>
                    		</tr>-->
                    		
                    		
                    		<tr>
                    			
                    			<td>Teleoperador(a):</td>
                    			<td><div style='float: left;' id='selempleado_id'></div></td>
             				</tr>
                    		<tr>
                    		
                    			<td><input style="margin-right: 5px;" type="button" id="btnSelAsignarGC" value="Asignar" /></td>
                   		 		<td><input style="margin-right: 5px;" type="button" id="btnSelAsignarIN" value="Asignar Inbound" /></td>	
                    		</tr>
                    		
                    	</table>
					     <!--<div style='float: left;' id='seljqxgrid'></div>
					    </div>-->
						
                    </form>
                </div>
            </div>
      </div>
  </div>   
   

