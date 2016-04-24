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
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxeditor.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/otwidgets/validadoc.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxdatatable.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxsplitter.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/jqwidgets/jqxscrollbar.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/fullcalendar/lib/moment.min.js"></script>
 <script type="text/javascript">
      var tema= "ui-redmond";
      var temaMv="arctic";
      var oper;
      var url = "<?php echo site_url("mar/contactos_all/ajax"); ?>"; 
      $(document).ready(function () {
        //Codigo de menu de operaciones
		var tid="<?php echo $_GET["tid"]; ?>";
	    menuopciones(tid);
         //Codigo Splitter
		$('#fSplitterr').jqxSplitter({theme: tema, width: '100%', height: '100%', panels: [{ size: '15%' },{ size: '85%' }] });
		//Codigo de consulta en la Grilla
		  contactos_all(); 
       
       $("#btImportar").click(function () {
		 	var oper='import';
		 	var url = "<?php echo site_url("mar/contactos_all/ajax"); ?>" 
		 	
		 	var isValid=ValidaImportado();
			
                if (isValid) {
                	$("#drop").jqxGrid('showloadelement');
                	$("#btImportar").jqxButton({ disabled: true});
                	
                	 var contactos = {  
                        accion: oper,
                        empleado_id: $("#empleado_id").val(),
                        campana_id: $("#campana_id").val(),
                        importados: $("#drop").jqxGrid('getrows')
                    };		
					
                    $.ajax({
                    	type: "POST",
                        url: url,
                        data: contactos,
                        //beforeSend:ProgressBar(),
                        success: function (data) {
                        	
                        	if(data=true){
                        		$("#drop").jqxGrid('hideloadelement');
								$("#btImportar").jqxButton({ disabled: false});
                                $("#eventWindow").jqxWindow('hide');
                                $("#jqxgrid").jqxGrid('updatebounddata');
                                //alert("El dato se grab� correctamente.");
                                //jqxAlert.alert ('El dato se grabó correctamente.');
                            }else{
                                //alert("Problemas al guardar.");
                                jqxAlert.alert ('Problemas al guardar.');
                                $("#drop").jqxGrid('hideloadelement');
                                $("#btImportar").jqxButton({ disabled: false});
                            }
                        },
                        error: function (msg) {
                            //alert(msg.responseText);
                            //jqxAlert.alert(msg.responseText);
                        }
                    });	
                }else{
                	$("#drop").jqxGrid('hideloadelement');
                	jqxAlert.alert('Validación incorrecta, revise y corrija los datos','Proceso de validación');
                	$("#btImportar").jqxButton({ disabled: false});
               	}
        });   
	    
    });
 
 
 
   	   	 
   	 function menuopciones(padre_id){
			
			//var view='contacto_view'
			var url="<?php echo site_url("login/login/tool_rol"); ?>"+"/"+padre_id;
			  
            var source =
			{
			datatype: "json",
			datafields: [
			{ name: 'id' },
			{ name: 'padre_id' },
			{ name: 'nombre' },
			{ name: 'subMenuWidth' }
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
			 //$("#jqxMenu").jqxMenu({source: records, theme: tema, autoSizeMainItems: false, showTopLevelArrows: true, width: '100%'});
             $("#jqxMenu").jqxMenu({source: records, theme: temaMv, autoSizeMainItems: false, showTopLevelArrows: true, width: '100%',  height:'100%' ,mode: 'vertical'});
             $("#jqxMenu").css("visibility", "visible");
             $("#jqxMenu").on('itemclick', function (event) {
             	    var opt=$(event.args).text();
                    switch (opt) {
					    case 'Nuevo':
					        opnuevo();
					        break;
					    case 'Editar':
					        opeditar();
					        break;
					    case 'Borrar':
					        opborrar();
					        break;
					     case 'Contactos':
					      	contactos_all();
					        break;
					        
					    case 'Reconsultar':
					        opreconsular();
					        break;
					    case 'Subir archivo':
					        opsubir();
					        break;
					    case 'Gestionar':
					        opgestionar();
					        break;
					    case 'Ver detalle':
					        opinfoadicional();
					        break;
					        				    
					    default:
					    
					   //contactosasignados();
					} 
               	 });
        } 
   	 function adpcontactos(){
		var url = "<?php echo site_url("mar/contactos_all/datos"); ?>";
		var source =
        {
            datatype: "json",
            datafields: [
                { name: 'id', type: 'numeric' },
                { name: 'contacto_id', type: 'numeric' },
                { name: 'identificacion', type: 'string' },
				{ name: 'nombres', type: 'string' },
				{ name: 'apellidos', type: 'string' },
				{ name: 'ciudad', type: 'string' },
                                { name: 'movil', type: 'string' },
				{ name: 'telefono', type: 'string' },
				{ name: 'convenional', type: 'string' },
				{ name: 'direccion', type: 'string' },
				{ name: 'observaciones', type: 'string' },
				{ name: 'fecha_ing', type: 'string' },
				{ name: 'fecha_mod', type: 'string' },
				{ name: 'estado', type: 'string' }
            ],
            // id: 'id',
            url: url,
            root:'Rows',
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
				}
            
        };
		 var dataAdapter = new $.jqx.dataAdapter(source);
		 return dataAdapter;
		}
    function opnuevo(){
			
			       // show the popup window.
                    oper = 'add';
                    var url = "<?php echo site_url("mar/contactos_all/ajax"); ?>" 
                    //$('#telefonosGrid').jqxGrid('clear');
                    //$('#correosGrid').jqxGrid('clear');
                    createElementsNuevo();
                    document.getElementById("fmprNuevo").reset();
                    $("#id").val('New');
	                $("#identificacion").val('');
					$("#nombre").val('');
					$("#apellido").val('');
					$("#ciudad").val('');
                    $("#direccion").val('');
                    $("#telefonosGrid").jqxGrid({ source: detalles()});
                    $("#correosGrid").jqxGrid({ source: detalles()});
                    $("#eventWindowNuevo").jqxWindow('open');
                    $("#estado").val('AC');
		}
		
		function opeditar(){
			         oper = 'edit';
			         var url = "<?php echo site_url("mar/contactos/ajax"); ?>" 
                 	 var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                       
                        if (selectedrowindex >= 0 ) {
                            //var id = $("#jqxgrid").jqxGrid('getrowid', selectedrowindex);
                            //var commit = $("#jqxgrid").jqxGrid('updaterow', id, datarow);
                            //$("#jqxgrid").jqxGrid('ensurerowvisible', selectedrowindex);
                            
                            var offset = $("#jqxgrid").offset();
                            // get the clicked row's data and initialize the input fields.
	                        var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex );
	                        // show the popup window.
	                        createElementsNuevo();
	                        document.getElementById("fmprNuevo").reset();
	                        $("#id").val(dataRecord.id);
	                        $("#identificacion").val(dataRecord.identificacion);
							$("#nombre").val(dataRecord.nombres);
							$("#apellido").val(dataRecord.apellidos);
							$("#ciudad").val(dataRecord.ciudad);
							$("#direccion").val(dataRecord.direccion);
							$("#telefono").val(dataRecord.movil);
							$("#email").val(dataRecord.email);
	                        $("#estado").val(dataRecord.estado);
	                        $("#telefonosGrid").jqxGrid({ source: detalles(dataRecord.id,'telefono')});
	                        $("#correosGrid").jqxGrid({ source: detalles(dataRecord.id,'email')});
							$("#eventWindowNuevo").jqxWindow('open');
	                        }else{
	                        	jqxAlert.alert('Seleccione un registro','Editar');
	                        }
                      
      	}	
		
		function opborrar(){
			             oper = 'del';
			             var url = "<?php echo site_url("mar/contactos_all/ajax"); ?>" 
                 	     var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                         if (selectedrowindex >= 0) {
                        	    
		                        //editrow = row;
		                        var offset = $("#jqxgrid").offset();
		                        var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex);
		                        var contacto = {
		                            accion: oper,
		                            id: dataRecord.id
		                        };
								jqxAlert.verify('Esta seguro de Borrar?','Confirma borrar', function(r) {
							    if(r){
		                        $.ajax({
		                            type: "POST",
		                            url: url,
		                            data: contacto,
		                            success: function (data) {
		                                if(data=true){
		                                    //$("#eventWindowNuevo").jqxWindow('hide');
		                                    $("#jqxgrid").jqxGrid('updatebounddata');
		                                    //alert("El dato se Elimin� correctamente.");
		                                }else{
		                                    jqxAlert.alert("Problemas al Eliminar.");
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
                         
	                        }else{
	                        	jqxAlert.alert('Seleccione un registro','Borrar');
	                        }
                      
		}	
		function opreconsular(){
			 $("#jqxgrid").jqxGrid('updatebounddata');
		}	
		
		function opsubir(){
			  
                    oper = 'upload';
                    var url = "<?php echo site_url("mar/contactos_all/ajax"); ?>" 
                    createElements();
                    document.getElementById("fmpr").reset();
                    ulistaEmpleados();
                    ulistaCampanas();
                    $("#eventWindow").jqxWindow('open');
		}	
		
		
				  
		 function setTitulo(titulo){
		 	$("#subtitulo").empty();
    		$('#subtitulo').append(titulo);
    		
		 }
		 
		 function getTitulo(){
		 	return $('#subtitulo').text();
		 	
		 }
		 
		  function setGridDatos(){
		  	var opt= getTitulo();
        	switch (opt) {
					  
					   case 'Contactos':
					      	contactos_all();
					        break;
					       
					    default:
					      contactos_all();
					} 
		  }
		  
		 function contactos_all(){
		   gridDatos(adpcontactos(),'Contactos'); 
		 }
		 
		
						  		
		function gridDatos(adp,titulo){
    		setTitulo(titulo);
    		$("#jqxgrid").jqxGrid({
            width : '100%',
            height: '94%',
            theme: tema,
            source: adp,
            //groupable: true,
            sortable: true,
            //showfilterrow: true,
            //groupsexpandedbydefault: true,
            filterable: true,
            pageable: true,
            //autoheight: true,
            columnsresize: true,
            pagermode: 'simple',
            pagesize: 20,
            virtualmode: true,
			    rendergridrows: function()
				{
					  return adp.records;     
				},
            /*showtoolbar: true,
            rendertoolbar: function (toolbar) {
            	toolbar.empty();
            	var me = this;
                    var container = $("<div style='margin: 5px;'></div>");
                    var span = $("<span style='float: left; margin-top: 5px; margin-right: 4px;'>"+titulo + "</span>");
               toolbar.append(container);
                    container.append(span);
            },*/
            //showtoolbar: true,
            //Codigo para la barra de herramientas de la grilla
            columns: [
                { text: 'Id', datafield: 'id', width: '5%',hidden:true },
               	{ text: 'contacto_id', datafield: 'contacto_id', width: '5%',hidden:true },
				{ text: 'empleado_id', datafield: 'empleado_id', width: '5%',hidden:true },
				{ text: 'campana_id', datafield: 'campana_id', width: '5%',hidden:true },
				{ text: 'Empleado', datafield: 'empleado', width: '10%',hidden:true },
				{ text: 'Campa&ntilde;a', datafield: 'campana', width: '10%',hidden:true },
                { text: 'Identificacion', datafield: 'identificacion', width: '8%' },
				{ text: 'Nombres', datafield: 'nombres', width: '15%' },
				{ text: 'Apellidos', datafield: 'apellidos', width: '15%' },
				{ text: 'Ciudad', datafield: 'ciudad', width: '15%' },
				{ text: 'Movil', datafield: 'movil', width: '15%' },
				//{ text: 'Convencional', datafield: 'convencional', width: '15%' },
				{ text: 'Direccion', datafield: 'direccion', width: '20%'},
				{ text: 'Observaciones', datafield: 'observaciones', width: '10%',hidden:true  },
				{ text: 'Fecha de creación', datafield: 'fecha_ing', width: '12%' },
				{ text: 'Fecha de modificación', datafield: 'fecha_mod', width: '12%' },
				{ text: 'Estado', datafield: 'estado', width: '5%' },
               
              
            ],
             //groups: ['campana','empleado']
        });
		}
    
    	      //funcion que carga los datos de detalle de tarifas de los productos en el grid
            function detalles(conta_id,tipo) {
               var url="<?php echo site_url("mar/contactos_all/detalle"); ?>"+"/"+conta_id+"/"+tipo;
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
						            };
			             
                   
                 var dataAdapter = new $.jqx.dataAdapter(source);
									         
               return dataAdapter;
           
            }
            
            
             
            
            
     function DirectorioContacto(conta_id,identificacion,apellidos,nombres) {
               //$("#frmVisualizar").empty();
               var tipo='Telefono'
               var url="<?php echo site_url("mar/contactos_all/detalleAll"); ?>"+"/"+conta_id;
               
               var source ={
						                datatype: "json",
						                datafields: [
													{ name: 'id' },
													{ name: 'campo' },
													{ name: 'tipo' },
													{ name: 'valor' },
													],
						                id: 'id',
						                url: url,
						            };
			                        var dataAdapter = new $.jqx.dataAdapter(source);
				  					         
              
             $("#datosTelefonos").jqxDropDownList({theme: tema, source: dataAdapter, displayMember: "valor", valueMember: "valor", width: 170, height: 200,
             renderer: function (index, label, value) {
               var item = dataAdapter.records[index];
               var imgurl; 
               imgurl='<?php echo base_url(); ?>assets/img/call.png';
               var img = '<img height="25" width="25" src="' + imgurl + '"/>';
             	var table = '<table style="min-width: 130px;"><tr><td style="width: 80px;">' + img + '</td><td>' + datarecord.tipo + '</td></tr><tr><td>' + datarecord.valor + '</td></tr></table>';
             	return table
             }	
             });
           
            }        
            
    
</script>
<div class="main">
	<div class='titnavbg'>
      <div class='titnavtit'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/seg.png">&nbsp;&nbsp;Marketing: <a id="subtitulo"></a></div>
      <div class='titnavlog'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/log_titulo.png"></div>
    </div>
    
	<!--<div style='margin-left: 0px; margin-top: 5px;' id='jqxMenu'></div> 
	<div style='margin-left: 0px; margin-top: 5px;'>
     <div style='float: left;' id='listcampana'></div>
     <div style='float: left;' id='listempleado'></div>
    </div>
	<div style='margin-left: 0px; margin-top: 35px;' id="jqxgrid"></div>	--> 	            	

</div>

<div id="fSplitterr">
			         	<div class="splitter-panel">
			         		 <div id='jqxMenu'>
				         </div>
      	                
			            </div>
			            <div class="splitter-panel">
			            	<div style='margin-left: 0px; margin-top: 5px;'>
						     <!--<div style='float: left;' id='listcampana'></div>
						     <div style='float: left;' id='listempleado'></div>-->
						     </div>
			            	<div  style='margin-left: 2px; margin-top: 5px;' id="jqxgrid"></div>
			            </div>
       </div>


