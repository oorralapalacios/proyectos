
 <script type="text/javascript">
  var tema= "ui-redmond";
  var temaMv="arctic";
  $(document).ready(function () {
  	        var tid="<?php echo $_GET["tid"]; ?>";
          	menuopciones(tid);
          	intGridDatos();
          	mlistaCampanas();
          	mlistaEmpleados();
           $('#fSplitterr').jqxSplitter({theme: tema, width: '100%', height: '100%', panels: [{ size: '15%' },{ size: '85%' }] });
			//citasnuevas();
			citasconfirmadas();			
			$('#listcampana').on('select', function (event) {
		  	setGridDatos();
		  });	
          $('#listempleado').on('select', function (event) {
          	setGridDatos();
          });	
          
   });
   
   function gridDatos(adp,titulo){
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
        
   function intGridDatos(adp,titulo){
        	
			 //Codigo de operaciones en la Grilla
            $("#jqxgrid").jqxGrid(
            {
                width : '100%',
                height: '94%',
                //source: adp,
				theme: tema,
                sortable: true,
                //showfilterrow: true,
                filterable: true,
                //selectionmode: 'multiplecellsextended',
                //filtermode: 'excel',
                pageable: true,
                //autoheight: true,
                columnsresize: true,
                pagermode: 'simple',
                pagesize: 20,
                //ready: function () {
                //    $("#jqxgrid").jqxGrid('sortby', 'id', 'asc');
                //},
                
                columns: [
                  { text: 'Id', datafield: 'id', width: '8%', hidden:'True' },
                  { text: 'Tipo', datafield: 'tipo_gestion', width: '8%' },
                  { text: 'Identificacion', datafield: 'identificacion', width: '10%' },
                  { text: 'Contacto', datafield: 'contacto', width: '20%' },
                  { text: 'Ciudad', datafield: 'ciudad', width: '20%' },
                  { text: 'Movil', datafield: 'movil', width: '20%' },
                  { text: 'Direccion', datafield: 'direccion', width: '20%' },
                  { text: 'Ruc', datafield: 'ruc', width: '10%' },
                  { text: 'Razon social', datafield: 'razon_social', width: '20%' },
                  { text: 'Campana', datafield: 'campana', width: '20%' },
                  { text: 'Observacion', datafield: 'observacion', width: '35%' },
				  { text: 'Fecha de creación', datafield: 'fecha_ing', width: '20%' },
                  //{ text: 'Fecha de modificación', datafield: 'fecha_mod', width: '20%' },
                  //{ text: 'Estado', datafield: 'estado', width: '20%' },
                 
                ]
                
            });
        	
        }
        
        function adpcitas(camp_id, emp_id,soper){
		var url = "<?php echo site_url("mar/valcitas/ajax"); ?>";
		//var soper = 'dataGC';
		var datos = {accion: soper,
			         camp_id: camp_id,
			         emp_id: emp_id
			         };
		var source =
        {
            datatype: "json",
            datafields: [
                    { name: 'id', type: 'string' },
                    { name: 'tipo_gestion', type: 'string' },
                    { name: 'padre_id', type: 'string' },
                    { name: 'tipo_cliente_id', type: 'string' },
                    { name: 'contacto_campana_id', type: 'string' },
                    { name: 'contacto_id', type: 'string' },
                    { name: 'llamada_id', type: 'string' },
                    { name: 'empresa_id', type: 'string' },
                    { name: 'campana_id', type: 'string' },
                    { name: 'identificacion', type: 'string' },
                    { name: 'nombres', type: 'string' },
                    { name: 'apellidos', type: 'string' },
                    { name: 'contacto', type: 'string' },
                    { name: 'ciudad', type: 'string' },
                    { name: 'movil', type: 'string' },
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
					{ name: 'cita_estado', type: 'string' },
					{ name: 'fecha_hora', type: 'string' },
					{ name: 'fecha_ing', type: 'string' },
                    { name: 'fecha_mod', type: 'string' },
                    { name: 'estado', type: 'string' },
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
					url: '<?php echo site_url("emp/empleados/getJerarquiaTeleoperadores"); ?>',
					async: false
				};
				
		         var dataAdapter = new $.jqx.dataAdapter(datos); 
        	    return dataAdapter;
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
        
        function mlistaEmpleados(){
         	 $('#listempleado').jqxDropDownList({
							source: adpempleados(),
							width: 300,
							//height: 20,
							theme: tema,
							selectedIndex: 0,
							displayMember: 'empleado',
							valueMember: 'id'
					}); 
         }
         
        function mlistaCampanas(){
        	 $('#listcampana').jqxDropDownList({
							source: adpcampana(),
							width: 300,
							//height: 20,
						    theme: tema,
						    selectedIndex: 0,
							displayMember: 'nombre',
							valueMember: 'id'
		         });  
        }
        
       	function menuopciones(padre_id){
			//var view='citaval_view'
			var url="<?php echo site_url("login/login/tool_rol"); ?>"+"/"+padre_id;
			  
            var source =
			{
			datatype: "json",
			datafields: [
			{ name: 'id' },
			{ name: 'padre_id' },
			{ name: 'nombre' },
			{ name: 'valor' }
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
			 //$("#jqxMenu").jqxMenu({source: records, theme: temaMv, autoSizeMainItems: false, showTopLevelArrows: true, width: '100%'});
			 $("#jqxMenu").jqxMenu({source: records, theme: temaMv, autoSizeMainItems: false, showTopLevelArrows: true, width: '100%',  height:'100%' ,mode: 'vertical'});
             $("#jqxMenu").css("visibility", "visible");
             $("#jqxMenu").on('itemclick', function (event) {
             	  //alert($(event.args).text());
                    //$("#eventLog").text("Id: " + event.args.id + ", Text: " + $(event.args).text());
                    var opt=$(event.args).text();
                    switch (opt) {
					    case 'Gestionar':
					        opgestionar()
					        break;
					    case 'Reconsultar':
					        opreconsular();
					        break;
					    case 'Citas nuevas':
					        citasnuevas();
					       break;    
					    case 'Citas confirmadas':
					        citasconfirmadas();
					        break;
					    case 'Citas no confirmadas':
					        citasnoconfirmadas();
					        break;
					    case 'Citas mal canalizadas':
					        malacita();
					        break;
					    case 'Citas canceladas':
					        cancelocita();
					        break;
					    case 'Citas postergadas':
					        postergocita();
					        break;
					    default:
					        //default code block
					} 
               	 });
        } 
        
       
		function opgestionar(){
			var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                      
                	 if (selectedrowindex >= 0) {
                             var offset = $("#jqxgrid").offset();
	                        // get the clicked row's data and initialize the input fields.
	                        dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex);
	                        // show the popup window.
	                        asipreguntas_datos(dataRecord.campana_id,dataRecord.contacto_id,dataRecord.contacto_campana_id);
	                        asiabrirDialogo(dataRecord.contacto_id,dataRecord.campana_id,dataRecord.contacto_campana_id);
	                        }else{
	                        	jqxAlert.alert('Seleccione un registro','Gestión');
	                        }
                       
		}
				
		
		
		
			
		function opreconsular(){
			 $("#jqxgrid").jqxGrid('updatebounddata');
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
					  
					   case 'Citas nuevas':
					        citasnuevas();
					       break;  
					   case 'Citas confirmadas':
					        citasconfirmadas();
					        break;   
					   case 'Citas no confirmadas':
					       citasnoconfirmadas();
					       break;      
					     
					   case 'Citas mal canalizadas':
					        malacita();
					        break;
					         
					   case 'Citas canceladas':
					        cancelocita();
					        break;   
					         
					    case 'Citas postergadas':
					       postergocita();
					       break;
					      
					    default:
					      //contactosasignados();
					} 
		  }
		  
		  
		 function citasnuevas(){
		 	  var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
		      var iemp = $("#listempleado").jqxDropDownList('getSelectedItem');
           	  //gridDatos(adpcitasnuevas(icamp.value,iemp.value),'Citas nuevas')
           	   gridDatos(adpcitas(icamp.value,iemp.value,'dataCN'),'Citas nuevas');
		 }
			
		 function citasconfirmadas(){
		    var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
		    var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
		   //gridDatos(adpcitaconfirmada(icamp.value,iemp.value),'Citas confirmadas'); 
		    gridDatos(adpcitas(icamp.value,iemp.value,'dataCC'),'Citas confirmadas');
		 }
		 
		  function citasnoconfirmadas(){
		 	 var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
		     var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
		     //gridDatos(adpcitanoconfirmada(icamp.value,iemp.value),'Citas no confirmadas');
		     gridDatos(adpcitas(icamp.value,iemp.value,'dataCNC'),'Citas no confirmadas');
		 }
		 
		 function malacita(){
		 	var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
		    var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
		    //gridDatos(adpmalacita(icamp.value,iemp.value),'Citas mal canalizadas');
		    gridDatos(adpcitas(icamp.value,iemp.value,'dataCMC'),'Citas mal canalizadas');  
		 } 
		 
		 function cancelocita(){
		 	var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
		    var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
		    //gridDatos(adpcancelocita(icamp.value,iemp.value),'Citas canceladas');
		    gridDatos(adpcitas(icamp.value,iemp.value,'dataCCA'),'Citas canceladas'); 
		 }
		 function postergocita(){
		 	var icamp = $("#listcampana").jqxDropDownList('getSelectedItem'); 
		    var iemp = $("#listempleado").jqxDropDownList('getSelectedItem'); 
		    //gridDatos( adppostergocita(icamp.value,iemp.value),'Citas postergadas'); 
		    gridDatos(adpcitas(icamp.value,iemp.value,'dataCPO'),'Citas postergadas'); 
		 }	 	 
		
		 
		
		
    </script>
<div class="main">
	  <div class='titnavbg'>
       <div class='titnavtit'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/inv.png">&nbsp;&nbsp;Marketing: <a id="subtitulo"></a></div>
       <div class='titnavlog'><img border='0'style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/log_titulo.png"></div>
      </div>
       </div>
      
     <!-- <div style='margin-left: 0px; margin-top: 5px;' id='jqxMenu'></div> 
      <div style='margin-left: 0px; margin-top: 5px;'>
          <div style='float: left;' id='listempleado'></div>
      </div>
      <div style='margin-left: 0px; margin-top: 35px;' id="jqxgrid"></div>
       
 </div>-->
 

<div id="fSplitterr">
			         	<div class="splitter-panel">
			         		 <div id='jqxMenu'>
				         </div>
      	                
			            </div>
			            <div class="splitter-panel">
			            	<div style='margin-left: 0px; margin-top: 5px;'>
						     <div style='float: left;' id='listcampana'></div>
						     <div style='float: left;' id='listempleado'></div>
						     </div>
			            	<div  style='margin-left: 0px; margin-top: 35px;' id="jqxgrid"></div>
			            </div>
       </div>