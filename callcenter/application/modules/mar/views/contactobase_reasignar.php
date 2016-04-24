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
        function createElementsReasignar() {
        	//urelistaCampanas();
        	urelistaEmpleados();
            $('#eventWindowReasignar').jqxWindow({
                resizable: false,
                width: '550px',
                Height: '200px',
                theme: tema,
                minHeight: 200,
                isModal: true,
                modalOpacity: 0.01,  
                //cancelButton: $("#btnCancel"),
                initContent: function () {
                     $("#btnreProcesar").click(function () {
                     	var empleado1_id=$("#reempleado1_id").val();
		                var empleado2_id=$("#reempleado2_id").val();
		                if(empleado1_id==empleado2_id){
		                	jqxAlert.alert('Seleccione empleados diferentes.');
		                }
                    	else{
                    		reasignar();
                    		}
		                    
                    });
                     $('#btnreProcesar').focus();
    
                }
            });
            $('#eventWindowReasignar').jqxWindow('focus');
            $('#eventWindowReasignar').jqxValidator('hide');
             
        }
      function abrirReasignacion(){
      	
      	 createElementsReasignar();
      	 $('#btnreProcesar').jqxButton({theme: tema, width: '65px' });			
         $('#eventWindowReasignar').jqxWindow('open');
	 	 
	   }
	   
	  function reasignar(){
			             oper = 'reasig';
			             var url = "<?php echo site_url("mar/contactos_base/ajax"); ?>" 
                 	   
		                        var proceso = {
		                            accion: oper,
		                            campana_id: $("#listcampana").val(),
		                            empleado1_id: $("#reempleado1_id").val(),
		                            empleado2_id: $("#reempleado2_id").val(),
		                        };
		                            
								jqxAlert.verify('Esta seguro de ejecutar la acción asignar?','Confirma asignar', function(r) {
							    if(r){
		                        $.ajax({
		                            type: "POST",
		                            url: url,
		                            data: proceso,
		                            success: function (data) {
		                            	
		                                if(data=true){
		                                    $("#eventWindowReasignar").jqxWindow('hide');
		                                    $("#jqxgrid").jqxGrid('updatebounddata');
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
	   
        
         function urelistaEmpleados(){
        	$("#reempleado1_id").jqxDropDownList({
		 	        theme: tema,
					source: adpempleados(),
					width: 350,
					height: 25,
					selectedIndex: 0,
					displayMember: 'empleado',
					valueMember: 'id'
			});  
			$("#reempleado2_id").jqxDropDownList({
		 	        theme: tema,
					source: adpempleados(),
					width: 350,
					height: 25,
					selectedIndex: 0,
					displayMember: 'empleado',
					valueMember: 'id'
			});  
        }			
		/*
		function urelistaCampanas(){
		   $("#recampana_id").jqxDropDownList({
		 	        theme: tema,
					source: adpcampana(),
					width: 350,
					height: 25,
					selectedIndex: 0,
					displayMember: 'nombre',
					valueMember: 'id'
			});			
		}
        */
        
        
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


<div style="visibility: hidden; display:none;" id="jqxWidgetReasignar">			
		<div style="display:none;" id="eventWindowReasignar">
            <div>Reasignacion de contactos a gestores-campaña</div>
            <div>
                <div>
                    <form id="frmReasignar">
                    	<div style='margin-left: 0px; margin-top: 5px;'>
                    	<table>
                    		<!--<tr>
                    			<td>Campaña</td>
                    			<td><div style='float: left;' id='recampana_id'></div></td>
                    		</tr>-->
                    		<tr>
                    			<td>Cartera de:</td>
                    			<td><div style='float: left;' id='reempleado1_id'></div></td>
                    		</tr>
                    		<tr>
                    			<td>Asignar a:</td>
                    			<td><div style='float: left;' id='reempleado2_id'></div></td>
                    		</tr>
                    		<tr>
                    			<td></td>
                    			<td><input style="margin-right: 5px;" type="button" id="btnreProcesar" value="Procesar" /></td>
                       
                    		</tr>
                    		
                    	</table>
					     
					    </div>
						
                    </form>
                </div>
            </div>
      </div>
  </div>   
   

