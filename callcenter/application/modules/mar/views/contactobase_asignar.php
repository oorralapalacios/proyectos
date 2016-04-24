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
 
    
      //codigo para inicializacion del formulario
        function createElementsAsignar() {
        	//ulistaCampanas();
        	ulistaEmpleados();
            $('#eventWindowAsignar').jqxWindow({
                resizable: false,
                width: '550px',
                Height: '200px',
                theme: tema,
                minHeight: 200,
                isModal: true,
                modalOpacity: 0.01,  
                //cancelButton: $("#btnCancel"),
                initContent: function () {
                    $("#btnProcesar").click(function () {
                    	asignar();
                    });
                     $('#btnProcesar').focus();
                }
            });
            $('#eventWindowAsignar').jqxWindow('focus');
            $('#eventWindowAsignar').jqxValidator('hide');
             
        }
      function abrirAsignacion(){
      	 createElementsAsignar();
      	 $('#cantidad').jqxInput({width: '200px', height: 25, theme: tema, placeHolder: "Ingrese cantidad" });
		 $('#btnProcesar').jqxButton({theme: tema, width: '65px' });			
         $('#eventWindowAsignar').jqxWindow('open');
	 	 
	   }
	   
	   function asignar(){
	   	
			             oper = 'asig';
			             var url = "<?php echo site_url("mar/contactos_base/ajax"); ?>" 
                 	   
		                        var proceso = {
		                            accion: oper,
		                            empleado_id: $("#empleado_id").val(),
		                            campana_id: $("#listcampana").val(),
		                            registros: $('#cantidad').val(),
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
		                                    $("#eventWindowAsignar").jqxWindow('hide');
		                                    $("#jqxgrid").jqxGrid('updatebounddata');
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
	   
        
         function ulistaEmpleados(){
        	$("#empleado_id").jqxDropDownList({
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
					url: '<?php echo site_url("emp/empleados/getJerarquia"); ?>',
					async: false
				};
				
		         var dataAdapter = new $.jqx.dataAdapter(datos); 
        	    return dataAdapter;
        }
		
		

</script>


<div style="visibility: hidden; display:none;" id="jqxWidgetAsignar">			
		<div style="display:none;" id="eventWindowAsignar">
            <div>Asignación de contactos a gestores-campaña</div>
            <div>
                <div>
                    <form id="frmAsignar">
                    	<div style='margin-left: 0px; margin-top: 5px;'>
                    	<table>
                    		<!--<tr>
                    			<td>Campaña</td>
                    			<td><div style='float: left;' id='campana_id'></div></td>
                    		</tr>-->
                    		<tr>
                    			<td>Teleoperador(a):</td>
                    			<td><div style='float: left;' id='empleado_id'></div></td>
                    		</tr>
                    		<tr>
                    			<td>Total/Registros:</td>
                    			<td><input style='float: left;' id='cantidad'></input>
                    			<input style="margin-right: 5px;" type="button" id="btnProcesar" value="Procesar" /></td>
                       
                    		</tr>
                    		
                    	</table>
					     
					    </div>
						
                    </form>
                </div>
            </div>
      </div>
  </div>   
   

