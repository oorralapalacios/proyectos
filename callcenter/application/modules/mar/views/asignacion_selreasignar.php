 <!--<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxgrid.filter.js"></script>
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
        function createElementsSelReAsignar() {
        	$('#eventWindowSelReasignar').window({
		     	resizable: false,
                width: '600px',
                height: '20%',
                modal: true,
                minimizable: false,  
                maximizable:false,
                collapsible:false,
                minimized:true
		     	});
		     }
		     	// yo autoOpen: false,
                // yo esizable: false,
            
                // yo theme: tema,
                // yo minHeight: 200,  
                // yo isModal: true,
                // yo modalOpacity: 0.01, 
                //cancelButton: $("#btnCancel"),
              /*  initContent: function () {
                	//$('#id_cartera').jqxInput({theme: tema, disabled: true,width: '0px' });
                	$('#sremp1_id').jqxInput({theme: tema, width: '150px' });
                	//$('#camp_id4').jqxInput({theme: tema, width: '150px' });
                	$('#btnsreasignar').focus();
                    
                	
                    $("#btnsreasignar").click(function () {
                     	 if ($("#sreempleado1_id").val()!=$("#sreempleado2_id").val()){
                     	 	sreasignar();
                     	 }else{
                     	 	jqxAlert.alert('Elija empleados diferentes.');
                     	 }
                    });
                    
                    $("#btnsreasignarseguimiento").click(function () {
                    	 if ($("#sreempleado1_id").val()!=$("#sreempleado2_id").val()){
                     	 	sreasignarseguimiento();
                     	 }else{
                     	 	jqxAlert.alert('Elija empleados diferentes.');
                     	 }
                    });
    
                }
            });
            $('#eventWindowSelReasignar').jqxWindow('focus');
            $('#eventWindowSelReasignar').jqxValidator('hide');
             
        }*/
        
        function setControlesReasignacion(){
        
                   	 //$('#sremp1_id').jqxInput({theme: tema, width: '150px' });
                	
                	 $('#btnSelReasignarGC').jqxButton({theme: tema, width: '65px' });
                	
                	 $('#btnSelReasignarIN').jqxButton({theme: tema, width: '250px' });
                     
                     $('#btnSelReasignarGC').focus();
                     
                     $("#btnSelReasignarGC").click(function () {
                    	  selreasignarGC();
                    	
                     });
                     
                     $("#btnSelReasignarIN").click(function () {
                    	               	sreasignarseguimiento();
                    		 });
      };
      
      function abrirSelReasignacion(){
      	
      	 usrelistaEmpleados();
      	 setControlesReasignacion();
      	 createElementsSelReAsignar();
      	 $('#eventWindowSelReasignar').window('open');
      	 
      	 /* YO document.getElementById("frmSelReasignar").reset();
      	 createElementsSelReasignar();
      	 $('#btnsreasignar').jqxButton({theme: tema, width: '100px' });
      	 $('#btnsreasignarseguimiento').jqxButton({theme: tema, width: '250px' });
      	 $('#eventWindowSelReasignar').jqxWindow('open');
      	 gridDatosReasignacion();*/
      		// yo usrelistaEmpleados();
        	//mlistaCampanas1()
		    // yo initselrgridContactos();
		     // yo gridDatosReasignacion();  ojo arriba cual se se llama
	 	 
	  }
	   
	  function gridDatosReasignacion(){
	  	    var icamp = $("#listcampana").jqxDropDownList('getSelectedItem');
            var iemp = $("#sreempleado1_id").jqxDropDownList('getSelectedItem');
		    srgridSelContactosCampana(icamp.value,iemp.value);	
	  } 
	   
	  function srgridSelContactosCampana(campid,empid){
			var adp=sradpcontactoscongestor(campid,empid);
			$("#selrejqxgrid").jqxGrid({
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
	   
	   function srgridBuscaSelContactosCampana(campid,empid,campo,valor){
			$("#selrejqxgrid").jqxGrid({source: sradpbuscacontactoscongestor(campid,empid,campo,valor)})
		  }
		  
      
		function sradpcontactoscongestor(camp_id,emp_id){
		var url = "<?php echo site_url("mar/contactos_base/ajax"); ?>";
		var soper = 'dataselreasig';
		var datos = {accion: soper,
			         camp_id: camp_id,
			         emp_id: emp_id
			         };
		var source =
        {
            datatype: "json",
             datafields: [
                { name: 'id', type: 'numeric' },
                //{ name: 'contacto_id', type: 'numeric' },
                { name: 'padre_id', type: 'numeric' },
                { name: 'identificacion', type: 'string' },
				{ name: 'nombres', type: 'string' },
				{ name: 'apellidos', type: 'string' },
				{ name: 'ciudad', type: 'string' },
				{ name: 'direccion', type: 'string' },
				{ name: 'fecha_hora', type: 'string' },
				{ name: 'bandeja', type: 'string' },
				{ name: 'observaciones', type: 'string' },
				{ name: 'telefono', type: 'string' },
				{ name: 'fecha_ing', type: 'string' },
				{ name: 'fecha_mod', type: 'string' },
				{ name: 'gestor', type: 'string' },
				{ name: 'proceso', type: 'string' },
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
	 	      $("#selrejqxgrid").jqxGrid('updatebounddata', 'filter');
	        },
	        sort: function(){
		      $("#selrejqxgrid").jqxGrid('updatebounddata', 'sort');
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
		
	   
	function initselrgridContactos(){
	   	
			$("#selrejqxgrid").jqxGrid({
            width : '785px',
            height: '455px',
            theme: tema,
            //source: adpcontactos(),
            //groupable: true,
            sortable: true,
            //showfilterrow: true,
            //groupsexpandedbydefault: true,
            filterable: true,
            selectionmode: 'checkbox',
            pageable: true,
            editable: true,
            //autoheight: true,
            columnsresize: true,
            pagermode: 'simple',
            pagesize: 20,
            
            //showtoolbar: true,
            //Codigo para la barra de herramientas de la grilla
            columns: [
                { text: 'Id', datafield: 'id', width: '5%',hidden:true },
                { text: 'padre_id', datafield: 'padre_id', width: '5%',hidden:true },
                { text: 'contacto_id', datafield: 'contacto_id', width: '5%',hidden:true },
                { text: 'Bandeja', datafield: 'bandeja', width: '5%',pinned: true, editable:false },
                { text: 'Asignación', datafield: 'fecha_hora', width: '18%', editable:false  },
               	{ text: 'Identificacion', datafield: 'identificacion', width: '12%', editable:false   },
               	{ text: 'Movil', datafield: 'telefono', width: '12%',pinned: true,editable:false  },
				{ text: 'Nombres', datafield: 'nombres', width: '15%',editable:false },
				{ text: 'Apellidos', datafield: 'apellidos', width: '15%',editable:false  },
				{ text: 'Ciudad', datafield: 'ciudad', width: '15%',editable:false  },
				{ text: 'Observaciones', datafield: 'observaciones', width: '40%' },
				//{ text: 'Gestor', datafield: 'gestor', width: '15%' },
				//{ text: 'Proceso', datafield: 'proceso', width: '15%' },
				//{ text: 'Direccion', datafield: 'direccion', width: '20%'},
				{ text: 'Fecha de creación', datafield: 'fecha_ing', width: '20%',editable:false },
				//{ text: 'Fecha de modificación', datafield: 'fecha_mod', width: '12%' },
	      ],
            
        });
        
    }
	   
	  function selreasignarGC(){
	  	            SelRasigItems = [];	
                    SelRasigItems.length=0;
                    var getselectedrowindexes = $('#jqxgrid').jqxGrid('getselectedrowindexes');
                         for (var i = 0; i < getselectedrowindexes.length; i++) {
                     	 var selectedRowData = $('#jqxgrid').jqxGrid('getrowdata', getselectedrowindexes[i]);
                     	 var item={
                     	 		   campana_id: selectedRowData.campana_id,
                     	 		   id: selectedRowData.id, 
                     	 		   telefono: selectedRowData.telefono_movil,
                     	 	       padre_id:selectedRowData.padre_id,
                     	 	       contacto_id:selectedRowData.contacto_id
                     	 	      };
                     	 SelRasigItems.push(item);
                         }
	  	              	oper = 'selreasigGC';
			             var url = "<?php echo site_url("mar/asignaciones/ajax"); ?>" 
                 	   
		                        var proceso = {
		                            accion: oper,
		                            //campana_id: $("#listcampana").val(),
		                            //empleado1_id: $("#sreempleado1_id").val(),
		                            empleado2_id: $("#sreempleado2_id").val(),
		                            registros: SelRasigItems,
		                            
		                        };
		                         
								jqxAlert.verify('Esta seguro de ejecutar la acción de reasignación?','Confirma reasignar contactos', function(r) {
							    if(r){
		                        $.ajax({
		                            type: "POST",
		                            url: url,
		                            data: proceso,
		                            success: function (data) {
		                                if(data=true){
		                                    //$("#jqxgrid").jqxGrid('updatebounddata');
		                                    $("#jqxgrid").jqxGrid('updatebounddata');
		                                    $("#jqxgrid").jqxGrid('clearselection');
		                                    //alert("Reasignación de contactos ejecutada correctamente.");
		                                }else{
		                                    jqxAlert.alert("Problemas al reasignar.");
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
      //aqui me qde
     function sreasignarseguimiento(){
	  	            SelRasigItems = [];	
                    SelRasigItems.length=0;
                    var getselectedrowindexes = $('#jqxgrid').jqxGrid('getselectedrowindexes');
                         for (var i = 0; i < getselectedrowindexes.length; i++) {
                     	 var selectedRowData = $('#jqxgrid').jqxGrid('getrowdata', getselectedrowindexes[i]);
                     	 var item={
                     	 		   campana_id: selectedRowData.campana_id,
                     	 		   id: selectedRowData.id, 
                     	 		   telefono: selectedRowData.telefono_movil,
                     	 	       padre_id:selectedRowData.padre_id,
                     	 	       contacto_id:selectedRowData.contacto_id
                     	 	       //observaciones:selectedRowData.observaciones
                     	 	       };
                     	 SelRasigItems.push(item);
                         }
	  	 
			             oper = 'selreasigIN';
			             var url = "<?php echo site_url("mar/asignaciones/ajax"); ?>" 
                 	   
		                        var proceso = {
		                            accion: oper,
		                            //campana_id: $("#listcampana").val(),
		                            //empleado1_id: $("#sreempleado1_id").val(),
		                            empleado2_id: $("#sreempleado2_id").val(),
		                            registros: SelRasigItems,
		                            
		                        };
		                        //alert(proceso.empleado2_id);
		                        jqxAlert.verify('Esta seguro de ejecutar la acción asignar?','Confirma asignar', function(r) {
							    if(r){
		                        $.ajax({
		                            type: "POST",
		                            url: url,
		                            data: proceso,
		                            success: function (data) {
		                                if(data=true){
		                                    //$("#eventWindowSelReasignar").jqxWindow('hide');
		                                    //$("#jqxgrid").jqxGrid('updatebounddata');
		                                    $("#jqxgrid").jqxGrid('updatebounddata');
		                                    $("#jqxgrid").jqxGrid('clearselection');
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
        
         function usrelistaEmpleados(){
        	/*$("#sreempleado1_id").jqxDropDownList({
		 	        theme: tema,
					source: sradpempleados(),
					width: 360,
					height: 25,
					selectedIndex: 0,
					displayMember: 'empleado',
					valueMember: 'id'
			
			});*/  
			$("#sreempleado2_id").jqxDropDownList({
		 	        theme: tema,
					source: sradpempleados(),
					width: 360,
					height: 25,
					selectedIndex: 0,
					displayMember: 'empleado',
					valueMember: 'id'
			});  
        }			
	
        
   function mlistaCampanas1(){
        	 $('#campana_id1').jqxDropDownList({
							theme: tema,
							source: adpcampana1(),
							width: 350,
							height: 25,
						    selectedIndex: 0,
							displayMember: 'nombre',
							valueMember: 'id'
		         });  
   }
        
    function sradpempleados(){
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
        
      	function adpcampana1(){
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


<div style="visibility: hidden; display:none;" id="jqxWidgetSelReasignar">			
		<div id="eventWindowSelReasignar" title="Reasignacion de contactos a gestores">
            <div>
                <div>
                    <form id="frmSelReasignar">
                    	<div style='margin-left: 0px; margin-top: 5px;'>
                    	<table>
                    					
                    		<tr>
                    			<td>Asignar a:</td>
                    			<td><div style='float: left;' id='sreempleado2_id'></div></td>
                    		</tr>
                    		<tr>
                    			<td><input style="margin-right: 5px;" type="button" id="btnSelReasignarGC" value="Reasignar" /></td>
                    			<td><input style="margin-right: 5px;" type="button" id="btnSelReasignarIN" value="Reasignar Inbound" /></td>
                    		</tr>
                    		
                    	</table>
                    							
                    </form>
                </div>
            </div>
      </div>
  </div>   
   

