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
	   var tema= "ui-redmond";
	    $(document).ready(function () {
	    	mostrarDialogTel();	
            $('#fSplitter').jqxSplitter({theme: tema, width: '100%', height: '100%', panels: [{ size: '20%' },{ size: '80%' }] });
            generaReporteTel();
	    })
	  
			
        function mostrarDialogTel(){
	   	    $("#parameter_form").jqxExpander({ theme:tema,  toggleMode: 'none', width: '100%', height: '100%', showArrow: false });
       
	   		    $('#desdeTel').jqxDateTimeInput({theme: tema, width: '160px' });
				$('#desdeTel').jqxDateTimeInput({formatString: "yyyy-MM-dd"});
				$('#hastaTel').jqxDateTimeInput({theme: tema, width: '160px'});
				$('#hastaTel').jqxDateTimeInput({formatString: "yyyy-MM-dd"});
				teleoperador();
				$("#jqxCheckBoxTel").jqxCheckBox({theme: tema, width: 160, height: 25});
                $('#btnPrintTel').jqxButton({theme: tema, width: '65px' });
                //$('#btnPrintTel').focus();
                $("#btnPrintTel").click(function () {
				   generaReporteTel();
				});   		
			 
        } 
            
            function teleoperador(){
            	$("#teleoperadorTel").jqxDropDownList({
									source: adpempleados(),
									theme: tema,
									width: 160,
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
        
    </script>
    
    <div class="main">
    	<div class='titnavbg'>
	     <div class='titnavtit'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/inv.png">&nbsp;&nbsp;Reportes: Citas por validar</div>
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
						                        <td align="right">Desde:</td>
						                        <td align="left"><div id="desdeTel"></div></td>
						                    </tr>
						                    <tr>
						                        <td align="right">Hasta:</td>
						                        <td align="left"><div id="hastaTel"></div></td>
						                    </tr>
						                     <tr>
						                        <td align="right">Operador:</td>
						                        <td align="left"><div id="teleoperadorTel"</div></td>
						                    </tr>
						                    <tr>
						                        <td align="right"></td>
						                        <td align="left"> <div id='jqxCheckBoxTel' style='margin-left: 0px; float: left;'>Todos</div></td>
						                    </tr>
						                    <tr>
						                        <td align="right"></td>
						                        <td style="padding-top: 10px;" align="right"><input style="margin-right: 5px;" type="button" id="btnPrintTel" value="Imprimir" /></td>
						                    </tr>
						                </table>
						                 
							 </form>
							 </div>
						  </div>
						</div>
			            <div class="splitter-panel">
			            	 <div style='margin-left: 0px; margin-top: 0px;' id="reporte"></div>
			            	 <div id="ventana" style='white-space: nowrap;'>
						                <script>
											function generaReporteTel(){
												var fecha_ini = $('#desdeTel').val();
												var fecha_fin = $('#hastaTel').val();
						
												if ($('#jqxCheckBoxTel').val()==true){
													var id_empleado = 0;
													var empleado = 'Todos';
												}else{
													var id_empleado = $('#teleoperadorTel').val();
													var empleado = $("#teleoperadorTel").text();
												} 
												
												url= "<?php echo site_url("rep/citporvals/generar_pdfCitVal"); ?>"+"/"+id_empleado+"/"+fecha_ini+"/"+fecha_fin+"/"+empleado; 
												document.getElementById('ventana').innerHTML = "<iframe src='"+url+"' width='100%' height='600'></iframe>";
											}
										</script>
						               
						            </ul>
						        </div> 
			            </div>
       </div>   
   
     
   </div>   
       