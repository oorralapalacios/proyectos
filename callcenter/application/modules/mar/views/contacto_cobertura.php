<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdatetimeinput.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxcalendar.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxtooltip.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/globalization/globalize.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxscrollbar.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxlistbox.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxcombobox.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/globalization/globalize.culture.es-ES.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/fullcalendar/lib/moment.min.js"></script>
<script type="text/javascript">

     function cobertura(conta_id, camp_id){
     	document.getElementById("frmCobertura").reset();	
     	createElementsCobertura();
     	$("#eventWindowCobertura").jqxWindow('open');
     	info_cobertura(camp_id);
     	reglas();
     }
 
     function createElementsCobertura() {
            $('#eventWindowCobertura').jqxWindow({
            	resizable: false,
                width: 500,
                Height: 200,
                theme: tema,
                //minHeight: 300,
                isModal: true,
                modalOpacity: 0.01,   
                initContent: function () {
                	$('#coid').jqxInput({theme: tema,disabled: true, width: '100px', height: 20});
                	$('#coidcampana').jqxInput({theme: tema,width: '100px', height: 20});
                	$('#coidcontacto').jqxInput({theme: tema,width: '100px', height: 20});
                	$('#cotexto_cobertura').jqxPanel({theme: tema, width: 470, height: 70});
                	$('#cociudad').jqxInput({theme: tema, width: 470});
                	$("#cobtnOk").jqxButton({theme: tema,width: '70px', height: 25 });
                    cociudades();
                   
   		           $("#cobtnOk").click(function () {
   		           	  //alert('ok');
   		           	  var contacto_id=$('#didcontacto').jqxInput('val');
   		              var campana_id=$('#didcampana').jqxInput('val');
   		              var telefono=$('#dtelefono').jqxInput('val');
   		              var padre_id=$('#didllamada').jqxInput('val');
   		              var inicio=$('#dinicio').jqxInput('val');
   		              var proceso=$('#vproceso').val();
   		              var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
				      var empleado_id=iemp.value;
   		              var oper='fcober';
   		              var url = "<?php echo site_url("mar/contactos/ajax"); ?>"; 
   		           	  var validationResult = function (isValid) {
		                if (isValid) {
		                	
		                    var contacto = {  
		                        accion: oper,
		                        //id: $("#id").val(),
		                        contacto_id: contacto_id,
								ciudad: $("#cociudad").val()
								
		                    };		
							
		                    $.ajax({
		                        type: "POST",
		                        url: url,
		                        data: contacto,
		                        success: function (data) {
									if(data=true){
										finalizarConFueraCober(contacto_id,empleado_id,campana_id,telefono,padre_id,inicio,proceso)
										//$("#eventWindowNuevo").jqxWindow('hide');
		                                //$("#jqxgrid").jqxGrid('updatebounddata');
		                                //alert("El dato se grab� correctamente.");
		                                //jqxAlert.alert ('El dato se grabó correctamente.');
		                            }else{
		                                //alert("Problemas al guardar.");
		                                jqxAlert.alert ('Problemas al guardar.');
		                            }
		                        },
		                        error: function (msg) {
		                            alert(msg.responseText);
		                        }
		                    });	
		                }
		            }
		            $('#eventWindowCobertura').jqxValidator('validate', validationResult); 
   		           	  
   		       
   		            });		      				
                }
            });
            $('#eventWindowCobertura').jqxWindow('focus');
            $('#eventWindowCobertura').jqxValidator('hide');
        }
        
        
       
            
            function  info_cobertura(camp_id){
          	
          	  $('#cotexto_cobertura').jqxPanel('clearcontent');
          	   var url="<?php echo site_url("mar/contactos/campana"); ?>"+"/"+camp_id;
          	   var source ={
						                datatype: "json",
						                datafields: [
													{ name: 'id' },
													{ name: 'nombre' },
													{ name: 'descripcion' },
													{ name: 'texto_cobertura' }
													],
						                id: 'id',
						                url: url,
						            };
				
				 var dataAdapter = new $.jqx.dataAdapter(source, {
						                loadComplete: function (data) { 
						                	  
						                	   var container;
						                	   container = data.texto_cobertura;
						                	 
						                	   $('#cotexto_cobertura').jqxPanel('append', container);
						                	 
   		                                 
						                },
						               //loadError: function (xhr, status, error) { }
						            });
									         
             dataAdapter.dataBind(); 
		 	
          }
          
          function cociudades(){
       	
       	        var timer;
                $('#cociudad').jqxInput({
                	
                    source: function (query, response) {
                        var dataAdapter = new $.jqx.dataAdapter
                        (
                            {
                                datatype: "jsonp",
                                datafields:
                                [
                                    { name: 'countryName' }, { name: 'name' },
                                    { name: 'population', type: 'float' },
                                    { name: 'continentCode' },
                                    { name: 'adminName1' }
                                ],
                                url: "http://api.geonames.org/searchJSON",
                                data:
                                {
                                    country:"EC",
                                    featureClass: "P",
                                    continent:"SA",
                                    style: "full",
                                    maxRows: 12,
                                    username: "jqwidgets"
                                }
                            },
                            {
                                autoBind: true,
                                formatData: function (data) {
                                    data.name_startsWith = query;
                                    return data;
                                },
                                loadComplete: function (data) {
                                    if (data.geonames.length > 0) {
                                        response($.map(data.geonames, function (item) {
                                            return {
                                                label: item.name + (item.adminName1 ? ", " + item.adminName1 : "") + ", " + item.countryName,
                                                value: item.name
                                            }
                                        }));
                                    }
                                }
                            }
                        );
                    }
                });
                    
       }
       
        function reglas(){
         	$('#eventWindowCobertura').jqxValidator({
		            hintType: 'label',
		            animationDuration: 0,
		            rules: [
		              { input: '#cociudad', message: 'Ciudad requerida!', action: 'keyup, blur', rule: 'required' }
												
						
		            ]
		            });	
         }
       
       function finalizarConFueraCober(contacto_id,empleado_id,campana_id,telefono,padre_id,inicio,proceso){
	     	       var url = "<?php echo site_url("mar/contactos/ajax"); ?>";
	     	       var oper='addllamada';
				      var llamada = {  
		                        accion: oper,
		                        padre_id: padre_id,
		                        contacto_campana_id: $("#vid").val(),
		                        contacto_id: contacto_id,
		                        empleado_id: empleado_id,
		                        campana_id: campana_id,
								telefono: telefono,
								inicio: inicio,
								fin: moment().format('YYYY-MM-DD HH:mm:ss'),
		                		llamada_estado: 'Finalizada',
		                		proceso:proceso,
		                		respuesta: 'Fuera de cobertura',
								
						    };	
						   
							$.ajax({
		                        type: "POST",
		                        url: url,
		                        data: llamada,
		                        success: function (data) {
		                         	                          
		                           //var llamada_id=data;                   					          
		                           if(data=true){
		                           	       
		                           		    $("#eventWindowCobertura").jqxWindow('hide');
		                           		    $('#eventWindowDialogo').jqxWindow('hide');
		                           		    $('#eventWindowVisualizar').jqxWindow('hide');
		                                    $("#gtelefonosGrid").jqxGrid('updatebounddata');  
		                                    $("#jqxgrid").jqxGrid('updatebounddata');
		                   				 		
										//jqxAlert.alert ('El dato se grabó correctamente.');
		                            }else{
		                                //alert("Problemas al guardar.");
		                                //jqxAlert.alert ('Problemas al guardar.');
		                            }
		                            
		                        },
		                        error: function (msg) {
		                            alert(msg.responseText);
		                        }
		                    });
	     }
 
</script>		
 
 <div style="visibility: hidden; display:none;" id="jqxWidgetCobertura">		    
      <div style="display:none;" id="eventWindowCobertura">
            <div>Cobertura</div>
            <div>
                <div>
                   <form id="frmCobertura" method="post">
                       <input type="hidden" id="coid"/>
                   	   <input type="hidden" id="coidcampana"/>
                       <input type="hidden" id="coidcontacto"/>
                       <div id="cotexto_cobertura"></div>
                       <div>Ingrese ciudad:</div>
                       <input style="margin-top: 5px;" id="cociudad"/>
                       <div></div>
                       <input style="margin-right: 5px; margin-top: 10px" type="button" id="cobtnOk" value="Ok" />
                      
					  
                    </form>
                </div>
            </div>
      </div>
   </div>   