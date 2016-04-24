<script type="text/javascript">

 function createElementsInfo() {
            $('#eventWindowInfo').jqxWindow({
                resizable: true,
                width: '80%',
                height: '80%',
				theme: tema,
                minWidth: 200,
                minHeight: 200, 
                isModal: true,
                modalOpacity: 0.01, 
                //okButton: $('#btnSave'),
				cancelButton: $("#btnCancel"),
				initContent: function () {
					$('#jqxTabsInfo').jqxTabs({theme:tema, width: '100%',height: "75%"});
					$('#infoid').jqxInput({theme:tema,disabled: true,width: '100px' });
					$('#infoidentificacion').jqxInput({theme:tema,disabled: true,width: '200px'});
					$('#infonombres').jqxInput({theme:tema,disabled: true,width: '300px'  });
					$('#infoapellidos').jqxInput({theme:tema,disabled: true, width: '300px'  });
                    //$('#infobtnSave').jqxButton({theme:tema,width: '65px' });
                    //$('#infobtnCancel').jqxButton({theme:tema, width: '65px' });
                    //$('#infobtnSave').focus();
                }
            });
            $('#eventWindowInfo').jqxWindow('focus');
            $('#eventWindowInfo').jqxValidator('hide');
            
            }
            
function opinfoadicional(){
			         //oper = 'edit';
			         //var url = "<?php echo site_url("mar/contactos/ajax"); ?>" 
                 	 var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                       
                        if (selectedrowindex >= 0 ) {
                            //var id = $("#jqxgrid").jqxGrid('getrowid', selectedrowindex);
                            //var commit = $("#jqxgrid").jqxGrid('updaterow', id, datarow);
                            //$("#jqxgrid").jqxGrid('ensurerowvisible', selectedrowindex);
                            
                            var offset = $("#jqxgrid").offset();
                            // get the clicked row's data and initialize the input fields.
	                        var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex );
	                        // show the popup window.
	                        createElementsInfo();
	                        document.getElementById("formInfo").reset();
	                        $("#infoid").val(dataRecord.contacto_id);
	                        $("#infoidentificacion").val(dataRecord.identificacion);
							$("#infonombres").val(dataRecord.nombres);
							$("#infoapellidos").val(dataRecord.apellidos);
							$("#eventWindowInfo").jqxWindow('open');
							info_adicional(dataRecord.id);
							
							initgridHistoriaLlamadas(infodetalleLlamadas(dataRecord.contacto_id));
						    initgridHistoriaCampanas(infodetalleCampanas(dataRecord.contacto_id));
						    initgridHistoriaCitas(infodetalleCitas(dataRecord.contacto_id));
							
	                        }else{
	                        	jqxAlert.alert('Seleccione un registro','Editar');
	                        }
		}
            
            
function info_adicional(contacto_id){
			$("#infoadicional").empty(); 
			
			var tipo='adicional'	
			var url="<?php echo site_url("mar/contactos/detalle"); ?>"+"/"+contacto_id+"/"+tipo;
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
						                async: true
						            };
			             
                   
             			
			 var dataAdapter = new $.jqx.dataAdapter(source, {
						loadComplete: function (data) { 
							  
							   $('#infoadicional').append("<table>");
								for(i=0;i<data.length;i++){
								 id = data[i]['id'];
								 campo_id = data[i]['campo_id'];
								 campo = data[i]['campo'];
								 valor = data[i]['valor'];
								 	 $('#infoadicional').append("<tr><td>"+data[i]['campo']+": "+"</td><td><input disabled class='jqx-input jqx-widget-content-" + tema + "' type='text' style='height: 20px; width: 300px;' id='resp_"+campo_id+"' value='"+data[i]['valor']+"'/><td></tr>");
							 	}
								
								$('#infoadicional').append("</table>");
						},
						
					});
									         
               //return dataAdapter;
            dataAdapter.dataBind();
			 
			
		} 
		
		
		function initgridHistoriaCampanas(adp){
			$("#jqxgridcampanas").jqxGrid({
            width : '99%',
            height: '94%',
            theme: tema,
            source: adp,
            //sortable: true,
            filterable: true,
            pageable: true,
            columnsresize: true,
            pagermode: 'simple',
            pagesize: 50,
            virtualmode: true,
			rendergridrows: function()
				{
					  return adp.records;     
				},
            //Codigo para la barra de herramientas de la grilla
           columns: [
                { text: '', datafield: 'rownum'},
                { text: 'Id', datafield: 'id', width: '5%',hidden:true },
               	{ text: 'Movil', datafield: 'telefono', width: '12%'},
				{ text: 'Gestor', datafield: 'gestor', width: '20%' },
				{ text: 'Campaña', datafield: 'campana', width: '25%'},
				{ text: 'Proceso', datafield: 'proceso', width: '15%'},
				{ text: 'Bandeja', datafield: 'bandeja', width: '10%'},
				{ text: 'Fecha de creación', datafield: 'fecha_ing', width: '20%' },
				//{ text: 'Fecha de modificación', datafield: 'fecha_mod', width: '15%' },
				
				
				//{ text: 'Estado', datafield: 'estado', width: '5%' },
               
              
            ],
          
            
        });
       }
		
				
		function initgridHistoriaLlamadas(adp){
			$("#jqxgridllamadas").jqxGrid({
            width : '99%',
            height: '94%',
            theme: tema,
            source: adp,
            //sortable: true,
            filterable: true,
            pageable: true,
            columnsresize: true,
            pagermode: 'simple',
            pagesize: 50,
            virtualmode: true,
			rendergridrows: function()
				{
					  return adp.records;     
				},
            //Codigo para la barra de herramientas de la grilla
            columns: [
		                    { text: '', datafield: 'rownum'},
		                    { text: 'Id', datafield: 'id', width: 0, hidden:true },
		                    { text: 'Contacto_id', datafield: 'contacto_id', width: 0 , hidden:true},
		                    { text: 'Número', datafield: 'telefono', width: '15%' },
		                    { text: 'Inicio', datafield: 'inicio', width: '20%' },
		                    //{ text: 'Fin', datafield: 'fin', width: '20%' },
		                    { text: 'Duracion', datafield: 'duracion', width: '10%' },
		                    { text: 'Gestor', datafield: 'gestor', width: '20%' },
		                    { text: 'Estado', datafield: 'llamada_estado', width: '12%' },
		                    { text: 'Campaña', datafield: 'campana', width: '20%' },
		                    { text: 'Proceso', datafield: 'proceso', width: '20%' },
		                    { text: 'Respuesta', datafield: 'respuesta_recibida', width: '25%' }
		                    
		                ]
          
            
        });
       }
       
       function infodetalleLlamadas(conta_id) {
        	    var url = "<?php echo site_url("mar/contactos/llamadasfiltradaspaginadas"); ?>"+"/"+conta_id;
		
                var source = {  
                        datatype: "json",
                        datafields: [
													{ name: 'rownum' },
													{ name: 'id' },
													{ name: 'contacto_id' },
													{ name: 'telefono' },
													{ name: 'inicio' },
													{ name: 'fin' },
													{ name: 'duracion' },
													{ name: 'gestor' },
													{ name: 'llamada_estado' },
													{ name: 'campana' },
													{ name: 'proceso' },
													{ name: 'respuesta_recibida' }
													],
											
						                id: 'id',
						                url: url,
						                root:'Rows',
							            filter: function(){
								 	      $("#jqxgridllamadas").jqxGrid('updatebounddata', 'filter');
								        },
								        sort: function(){
									      $("#jqxgridllamadas").jqxGrid('updatebounddata', 'sort');
								        },
							            
							            beforeprocessing: function(data)
											{		
												source.totalrecords = data[0].TotalRows;
											}
                };		
                var dataAdapter = new $.jqx.dataAdapter(source);
			    return dataAdapter;
           
                    
		};
		
		function infodetalleCampanas(conta_id) {
        	    var url = "<?php echo site_url("mar/contactos/campanasfiltradaspaginadas"); ?>"+"/"+conta_id;
		
                var source = {  
                        datatype: "json",
                        datafields: [
													{ name: 'rownum' },
													{ name: 'id' },
													{ name: 'contacto_id' },
													{ name: 'telefono' },
													{ name: 'campana' },
													{ name: 'gestor' },
													{ name: 'proceso' },
													{ name: 'bandeja' },
													{ name: 'fecha_ing' },
													{ name: 'fecha_mod' },
													
													],
											
						                id: 'id',
						                url: url,
						                root:'Rows',
							            filter: function(){
								 	      $("#jqxgridllamadas").jqxGrid('updatebounddata', 'filter');
								        },
								        sort: function(){
									      $("#jqxgridllamadas").jqxGrid('updatebounddata', 'sort');
								        },
							            
							            beforeprocessing: function(data)
											{		
												source.totalrecords = data[0].TotalRows;
											}
                };		
                var dataAdapter = new $.jqx.dataAdapter(source);
			    return dataAdapter;
           
                    
		};
		
		function infodetalleCitas(conta_id) {
        	    var url = "<?php echo site_url("mar/contactos/citasfiltradaspaginadas"); ?>"+"/"+conta_id;
		
                var source = {  
                        datatype: "json",
                        datafields: [
													{ name: 'rownum' },
													{ name: 'id' },
													{ name: 'contacto_id' },
													{ name: 'telefono' },
													{ name: 'campana' },
													{ name: 'cita_estado' },
													{ name: 'asesor' },
													{ name: 'fecha_hora' },
													{ name: 'observacion' },
													{ name: 'fecha_ing' },
													{ name: 'fecha_mod' },
													
													],
											
						                id: 'id',
						                url: url,
						                root:'Rows',
							            filter: function(){
								 	      $("#jqxgridllamadas").jqxGrid('updatebounddata', 'filter');
								        },
								        sort: function(){
									      $("#jqxgridllamadas").jqxGrid('updatebounddata', 'sort');
								        },
							            
							            beforeprocessing: function(data)
											{		
												source.totalrecords = data[0].TotalRows;
											}
                };		
                var dataAdapter = new $.jqx.dataAdapter(source);
			    return dataAdapter;
           
                    
		};
				
		function initgridHistoriaCitas(adp){
			$("#jqxgridcitas").jqxGrid({
            width : '99%',
            height: '94%',
            theme: tema,
            source: adp,
            //groupable: true,
            //sortable: true,
            //showfilterrow: true,
            //groupsexpandedbydefault: true,
            filterable: true,
            //selectionmode: 'checkbox',
            pageable: true,
            //autoheight: true,
            columnsresize: true,
            pagermode: 'simple',
            pagesize: 50,
            //showtoolbar: true,
            //Codigo para la barra de herramientas de la grilla
            columns: [
                { text: '', datafield: 'rownum'},
                { text: 'Id', datafield: 'id', width: '5%',hidden:true },
                { text: 'Fecha de cita', datafield: 'fecha_hora', width: '20%' },
               	{ text: 'Campaña', datafield: 'campana', width: '20%' },
				//{ text: 'Movil', datafield: 'telefono', width: '10%'},
				{ text: 'Gestor/Asesor', datafield: 'asesor', width: '20%'},
				{ text: 'Estado', datafield: 'cita_estado', width: '15%' },
				{ text: 'Observacion', datafield: 'observacion', width: '20%'},
				{ text: 'Fecha de creación', datafield: 'fecha_ing', width: '20%' },
				//{ text: 'Fecha de modificación', datafield: 'fecha_mod', width: '15%' }
				
				
			
               
              
            ],
          
            
        });
       
         
		}
		

</script>

<div style="visibility: hidden;  display:none;" id="jqxWidgetInfo">
			<div id="eventWindowInfo">
			<div>Información de Contactos</div>
			<div>
			   <div>
				<form id="formInfo">
				 <table>
                    
                    <tr>
                        <td align="right">Id:</td>
                        <td align="left"><input id="infoid"/></td>
                    </tr>
                    <tr>
                        <td align="right">Identificación:</td>
                        <td align="left"><input id="infoidentificacion" /></td>
                    </tr>
                    <tr>
                        <td align="right">Nombre:</td>
                        <td align="left"><input id="infonombres" /></td>
                    </tr>
                     <tr>
                        <td align="right">Apellidos:</td>
                        <td align="left"><input id="infoapellidos" /></td>
                    </tr>
                   </table>
                   
                   <div id='jqxTabsInfo'>
			                <ul>
			                   <li style="margin-left: 30px;">Gestión de campañas</li>
			                   <li>Historial de llamadas</li>
			                   <li>Gestión de citas</li>
			                   <li>Información Adicional</li>
			                </ul>
			                
			                <div style='margin-left: 2px; margin-top: 2px;' id="jqxgridcampanas"></div>
			                <div style='margin-left: 2px; margin-top: 2px;' id="jqxgridllamadas"></div>
			                <div style='margin-left: 2px; margin-top: 2px;' id="jqxgridcitas"></div>
			                <div>
                        	  <table>
                        	    <tr>
		                        <td align="left"><div style='margin-left: 5px; margin-top: 5px;' id="infoadicional"></div></td>
		                        </tr>
                    		  </table>
			                </div>
			               
                   
                 <!-- <table>
			                <tr>
                                <td align="right"></td>
                                <td style="padding-top: 10px;" align="right"><input style="margin-right: 5px;" type="button" id="infobtnSave" value="Save" /><input id="infobtnCancel" type="button" value="Cancel" /></td>
                            </tr>
                   </table>  --> 
				 </form>
				
				</div>
			</div>
	       </div>		
       </div>


