
    <script type="text/javascript">
        var tematab= "ui-redmond";
        var tema= "ui-redmond";
        $(document).ready(function () {
        	//initTab(); 
        	menu();
        	addTab('Inicio', 'welcome');
        
        });
        function initTab(){
        	 $('#mainjqxTabs').jqxTabs({theme: tematab, height: '100%', width: '100%',showCloseButtons: true});
        }	
        
        
        /*function addTab(title, url){
        	
        	var content = '<iframe scrolling="auto" frameborder="0"  src="'+url+'" style="width:100%;height:100%;"></iframe>'; 
        	$('#mainjqxTabs').jqxTabs('addLast', title, content); 
        
        	
        }*/
        
        function addTab(title, url){  
			if ($('#tt').tabs('exists', title)){  
				$('#tt').tabs('select', title);  
			} else { 
				var content = '<iframe scrolling="auto" frameborder="0"  src="'+url+'" style="width:100%;height:100%;"></iframe>';  
				$('#tt').tabs('add',{ 
					title:title,  
					content:content,  
					closable:true
				});  
			} 
		}  
        
        
        function menu(){
           
           var url="<?php echo site_url("login/login/menu_rol"); ?>";
		   
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
			//localdata: data
			url:url,
			async: false
			};
			// create data adapter.
			var dataAdapter = new $.jqx.dataAdapter(source);
			// perform Data Binding.
			dataAdapter.dataBind();
			var records = dataAdapter.getRecordsHierarchy('id', 'padre_id', 'items', [{ name: 'nombre', map: 'label'}]);
			$("#navBar").jqxMenu({theme: tema, source: records, autoSizeMainItems: false, showTopLevelArrows: true, width: '100%'});
            $("#navBar").css("visibility", "visible");
            $("#navBar").on('itemclick', function (event) {
             	  
             	  var opt=$(event.args).text();
                    switch (opt) {
					    case 'Salir':
					        window.location.assign("login/logout")
					      break;
					    default:
					        opcion(event.args.id)
					} 
             	  
            });
        }
       
       function opcion(id){
		
			var url="<?php echo site_url("seg/opciones/item"); ?>"+"/"+id;
		    var source =
			{
			datatype: "json",
			datafields: [
			{ name: 'id' },
			{ name: 'nombre' },
			{ name: 'url' }
			],
			id: 'id',
			url: url
			};
			// create data adapter.
			var dataAdapter = new $.jqx.dataAdapter(source, {
						                loadComplete: function (data) { 
						                	//verifico que exista una url para redireccionar;
						                	if (!data.url=="") {
						                		//Utilizacion del Onject DOM para embeber Objetos de 
						                		//forma dinamica  en la seccion de contenido
						                		//document.getElementById('myObject').data = data.url ;
						                		addTab(data.nombre,data.url);
						                		//addTab(data.nombre,data.url+'?sid'+data.id);
						                		}
						                	
						                	
						                },
						            });
            // perform Data Binding.
			dataAdapter.dataBind();
		
	 }
        
        
       
	</script>
	
	
	
    
     
  