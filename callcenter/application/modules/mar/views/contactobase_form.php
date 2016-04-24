<script type="text/javascript">
         
         var createElementsNuevo=function()  {
         	
            $('#eventWindowNuevo').jqxWindow({
                resizable: false,
                width: '570px',
                height: '370px',
                theme: tema,
                minWidth: 470,
                minHeight: 370,  
                isModal: true,
                modalOpacity: 0.01, 
                //autoOpen: false,
                cancelButton: $("#btnCancel"),
                initContent: function () {
                $('#id').jqxInput({theme: tema, disabled: true,width: '0px' });
				$('#identificacion').jqxInput({theme: tema, width: '150px' });
			    $('#cliente').jqxInput({theme: tema, width: '400px'});
			    $('#telefono_movil').jqxInput({theme: tema, width: '400px'});
			    $('#ciudad').jqxInput({theme: tema, width: '400px'});
			    $('#forma_pago').jqxInput({theme: tema, width: '400px'});
			    $('#fecha_activacion').jqxInput({theme: tema, width: '400px'});
			    $('#banco').jqxInput({theme: tema, width: '400px'});
			    $('#tarifa_basica').jqxInput({theme: tema, width: '400px'});
			    $('#plan').jqxInput({theme: tema, width: '400px'});
				$('#estado').jqxInput({theme: tema, disabled: true, width: '20px'  });
				//$("#estado").val('AC');
				$('#btnSave').jqxButton({theme: tema, width: '65px' });
				$('#btnCancel').jqxButton({theme: tema, width: '65px' });
				ciudades($('#ciudad'));
				//codigo para validacion de entradas
		        $('#eventWindowNuevo').jqxValidator({
		            hintType: 'label',
		            animationDuration: 0,
		            rules: [
		                { input: '#identificacion', message: 'Identificaci�n debe tener 10 caracteres!', action: 'keyup, blur', rule: 'length=10,10' },
						{ input: '#cliente', message: 'Cliente es requerido!', action: 'keyup, blur', rule: 'required' },
						{ input: '#telefono_movil', message: 'Teléfono móvil es requerido!', action: 'keyup, blur', rule: 'required' },
						{ input: '#ciudad', message: 'Ciudad es requerida!', action: 'keyup, blur', rule: 'required' }
					 ]
		        });	
		        // codigo para afectar la base por insert o update.
		        $("#btnSave").click(function () {
				   var validationResult = function (isValid) {
		                if (isValid) {
		                	
		                    var contacto = {  
		                        accion: oper,
		                        campana_id: $("#listcampana").val(),
		                        id: $("#id").val(),
		                        identificacion: $("#identificacion").val(),
								cliente: $("#cliente").val(),
								telefono_movil: $("#telefono_movil").val(),
								ciudad: $("#ciudad").val(),
								forma_pago: $("#forma_pago").val(),
								fecha_activacion: $("#fecha_activacion").val(),
								banco: $("#banco").val(),
								tarifa_basica: $("#tarifa_basica").val(),
								plan: $("#plan").val(),
								estado: $("#estado").val(),
		                        
		                    };		
							
		                    $.ajax({
		                        type: "POST",
		                        url: url,
		                        data: contacto,
		                        success: function (data) {
									if(data=true){
										
										$("#eventWindowNuevo").jqxWindow('hide');
		                                $("#jqxgrid").jqxGrid('updatebounddata');
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
		            $('#eventWindowNuevo').jqxValidator('validate', validationResult);    	
		        });
			
                $('#btnSave').focus();
                }
            });
            $('#eventWindowNuevo').jqxWindow('focus');
            $('#eventWindowNuevo').jqxValidator('hide');
         }
        
        function campos(tipo) {
			var url="<?php echo site_url("mar/contactos/campos"); ?>"+"/"+tipo;
			var source =
						{
							datatype: "json",
							datafields: [
								{ name: 'id' },
								{ name: 'campo' }
							],
							url: url,
							async: false
						};
			var dataAdapter = new $.jqx.dataAdapter(source);
			return dataAdapter;
		} 		
        
 
       function ciudades($ciudad){
       	
       	        var timer;
                $ciudad.jqxInput({
                	
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
      
        
 
</script>		
<div style="visibility: hidden; display:none;" id="jqxWidget2">			
		<div id="eventWindowNuevo">
            <div>Gestion de Contactos Subidos</div>
            <div>
                <div>
                    <form id="fmprNuevo" method="post">
                    	<input name="id" style="margin-top: 5px;"  type="hidden" id="id"/>
                       
                          <table>
                            <tr>
							    <td align="right">Identificación:</td>
							    <td align="left"> <input name="identificacion" style="margin-top: 5px;" id="identificacion"/></td>
							</tr>
							<tr>
								<td align="right">Cliente:</td>
								<td align="left"> <input name="cliente" style="margin-top: 5px;" id="cliente"/></td>
							</tr>
							<tr>
								<td align="right">Teféfono móvil:</td>
								<td align="left"> <input name="telefono_movil" style="margin-top: 5px;" id="telefono_movil"/></td>
							</tr>
						    <tr>
						    	<td align="right">Ciudad:</td>
								<td align="left"> <input name="ciudad" style="margin-top: 5px;" id="ciudad"/></td>
							</tr>
							<tr>
						    	<td align="right">Forma de pago:</td>
								<td align="left"> <input name="forma_pago" style="margin-top: 5px;" id="forma_pago"/></td>
							</tr>
							
							<tr>
						    	<td align="right">Fecha activación:</td>
								<td align="left"> <input name="fecha_activacion" style="margin-top: 5px;" id="fecha_activacion"/></td>
							</tr>
							
							<tr>
						    	<td align="right">Banco:</td>
								<td align="left"> <input name="banco" style="margin-top: 5px;" id="banco"/></td>
							</tr>
							<tr>
						    	<td align="right">Tarifa básica:</td>
								<td align="left"> <input name="tarifa_basica" style="margin-top: 5px;" id="tarifa_basica"/></td>
							</tr>
							
							<tr>
						    	<td align="right">Plan:</td>
								<td align="left"> <input name="plan" style="margin-top: 5px;" id="plan"/></td>
							</tr>
							
							<tr>
								<td><input type="hidden" id="estado"></td>
							</tr>
							
						
							</table>
							
                          
                           <table>
			                <tr>
                                <td align="right"></td>
                                <td style="padding-top: 10px;" align="right"><input style="margin-right: 5px;" type="button" id="btnSave" value="Grabar" /><input id="btnCancel" type="button" value="Cancelar" /></td>
                            </tr>
                         </table>   
                        
                    </form>
                </div>
            </div>
      </div>
  </div>   
   
   