function Parametricas () {
   /*parametros externos*/
   this.ajaxurl;
   
   /*variables globales*/
   var oper;
   var ajaxurl;

   this.init=function(){
   	    ajaxurl=this.ajaxurl;
   	    
    	loadtoolbar();
    	getTitulo();
    	loadgrid();
    	validador();
    	
		
		 // codigo para afectar la base por insert o update.
        $("#btnSave").click(function () {
        	 save();
			
          });
		
   	
   };
   
    function setTitulo(titulo){
		 	$(".subtitulo").empty();
    		$('.subtitulo').append(titulo);
    		
		 }
		 
     		 
    getTitulo=function (){
		
		var operb = 'datatit';
		var datos = {accion: operb};
		var source =
				{
					datatype: "json",
					datafields: [
						{ name: 'id' },
						{ name: 'nombre' },
					
					
					],
					
					 id: 'id',
			   	     type: 'POST',
			         url:ajaxurl,
			         data:datos,
			         async: false
				};
				//alert(datos.identificacion);
		      var dataAdapter = new $.jqx.dataAdapter(source,{
		      	autoBind: true,
		      	loadComplete: function (records) {
		      		
		      		setTitulo(records[0]['nombre']);
		      	  
		      		 
		      	},
		      }); 
		      
			 	
	 };
   
    save=function (){
					   
			    var validationResult = function (isValid) {
                if (isValid) {
                    var datos = {  
                        accion: oper,
                        id: $("#id").val(),
                        codigo: $("#codigo").val(),
						descripcion: $("#descripcion").val(),
						estado: $("#estado").val()
                    };	
                    
                 	                	
                    $.ajax({
                        type: "POST",
                        url: ajaxurl,
                        data: datos,
                        success: function (data) {
                        	//alert(data);
                        	var mensaje=data; 
							if(data=true){
                                
                                if (mensaje=='exists'){
                                	alert("Dato ya existe.");
                                }else{
                                    $("#jqxgrid").jqxGrid('updatebounddata');
                                    $("#eventWindow").jqxWindow('hide');
                                    //alert("El dato se grabó correctamente.");
                                }
                                
                            }else{
                                alert("Problemas al guardar.");
                            }
                        },
                        error: function (msg) {
                            //alert(msg.responseText);
                        }
                    });
                   
                };
            };
            $('#eventWindow').jqxValidator('validate', validationResult);    	
     	
                
		    };
   
   loadgrid=function(){
   	oper = 'datadet';
	var datos = {accion: oper};
   	var source =
        {
            datatype: "json",
            datafields: [
                { name: 'id', type: 'string' },
                { name: 'orden', type: 'string' },
				{ name: 'codigo', type: 'string' },
				{ name: 'descripcion', type: 'string' },
				{ name: 'fecha_ing', type: 'string' },
				{ name: 'fecha_mod', type: 'string' },
				{ name: 'usuario_ing', type: 'string' },
				{ name: 'usuario_mod', type: 'string' },
				{ name: 'estado', type: 'string' }
            ],
            id: 'id',
			type: 'POST',
			url:ajaxurl,
			data:datos,
			//async: false
        };
		
		
        var dataAdapter = new $.jqx.dataAdapter(source, {
            loadComplete: function (data) { },
            loadError: function (xhr, status, error) { }      
        });
       
		
		//Codigo de operaciones en la Grilla
        $("#jqxgrid").jqxGrid({
            width : '100%',
            height: '100%',
            source: dataAdapter,
            theme: tema,
            sortable: true,
            //showfilterrow: true,
            filterable: true,
            pageable: true,
            pagermode: 'simple',
            pagesize: 50,
            
            //autoheight: true,
            ready: function () {
                   $("#jqxgrid").jqxGrid('sortby', 'id', 'asc');
            },
            columns: [
                { text: 'Id', datafield: 'id', width: '5%', hidden:true },
                { text: 'Orden', datafield: 'orden', width: '20%', hidden:true  },
				{ text: 'Codigo', datafield: 'codigo', width: '20%' },
				{ text: 'Descripcion', datafield: 'descripcion', width: '80%' },
				{ text: 'Fecha_ing', datafield: 'fecha_ing', width: '15%' },
				{ text: 'Fecha_mod', datafield: 'fecha_mod', width: '15%' },
				{ text: 'Usuario ingreso', datafield: 'usuario_ing', width: '15%' },
			    { text: 'Usuario modifica', datafield: 'usuario_mod', width: '15%' },
				{ text: 'Estado', datafield: 'estado', width: '4%' },
          ]
        });
   	
   };
   
   loadtoolbar=function(){
			oper = 'tool';
		    var datos = {accion: oper};
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
			type: 'POST',
			url:ajaxurl,
			data:datos,
			async: false
			};
			// create data adapter.
			var dataAdapter = new $.jqx.dataAdapter(source);
			// perform Data Binding.
			dataAdapter.dataBind();
			var records = dataAdapter.getRecordsHierarchy('id', 'padre_id', 'items', [{ name: 'nombre', map: 'label'}]);
			 $("#jqxMenu").jqxMenu({source: records, theme: tema, autoSizeMainItems: false, showTopLevelArrows: true, width: '100%'});
             $("#jqxMenu").css("visibility", "visible");
             $("#jqxMenu").on('itemclick', function (event) {
             	  //alert($(event.args).text());
                    //$("#eventLog").text("Id: " + event.args.id + ", Text: " + $(event.args).text());
                    var opt=$(event.args).text();
                    switch (opt) {
					    case 'Nuevo':
					          add();
					        break;
					    case 'Editar':
					        edit();
					        break;
					    case 'Borrar':
					        del();
					        break;
					    case 'Reconsultar':
					       refresh();
					        break;
					    default:
					        //default code block
					} 
               	 });
       };
       
       
      add= function (){
         	        document.getElementById("fmpr").reset();
                    createElements();
                    //getComboRoles();
				    //getDepartamentos();
				    oper = 'add';
                    $("#eventWindow").jqxWindow('open');
                    $("#id").val('New');
                    $("#estado").val('AC');
       };
        
        
      edit=function (){
        	            //document.getElementById("fmpr").reset();           
                       
                        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                        if (selectedrowindex >= 0 ) {
                        var offset = $("#jqxgrid").offset();
                        // get the clicked row's data and initialize the input fields.
                        var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex );
                        // show the popup window.
						if (dataRecord.estado=='AC'){
							createElements();
							oper = 'edit';
							$("#id").val(dataRecord.id);
							$("#codigo").val(dataRecord.codigo);
							$("#descripcion").val(dataRecord.descripcion);
							$("#estado").val(dataRecord.estado);
							$("#eventWindow").jqxWindow('open');
						}else{
							alert("No se puede editar registro.");
						}
						}else{
	                        	jqxAlert.alert('Seleccione un registro','Editar');
	                    }
        } ;
        
        
         del=function (){
        	            oper = 'del';
                        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                        if (selectedrowindex >= 0 ) {
                        var offset = $("#jqxgrid").offset();
                        // get the clicked row's data and initialize the input fields.
                        var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', selectedrowindex );
                        var empleado = {
                            accion: oper,
                            id: dataRecord.id,
							usuario_id: dataRecord.usuario_id
                        };
						jqxAlert.verify('Esta seguro de Borrar?','Dialogo de confirmacion', function(r) {
					    if(r){
					       $.ajax({
                            type: "POST",
                            url: ajaxurl,
                            data: empleado,
                            success: function (data) {
                                if(data=true){
                                    $("#eventWindow").jqxWindow('hide');
                                    $("#jqxgrid").jqxGrid('updatebounddata');
                                    alert("El dato se Elimin� correctamente.");
                                }else{
                                    alert("Problemas al Eliminar.");
                                }
                            },
                            error: function (msg) {
                                alert(msg.responseText);
                            }
                        });	
						}else{
					        // el usuario ha clicado 'No'
					        
					    }
                     }); 
                     }else{
	                        	jqxAlert.alert('Seleccione un registro','Borrar');
	                 }
        	
        };	
        
        refresh=function (){
			 $("#jqxgrid").jqxGrid('updatebounddata');
		};
		
		
		validador= function (){
          //codigo para validacion de entradas
	        $('#eventWindow').jqxValidator({
	            hintType: 'label',
	            animationDuration: 0,
	            rules: [
	                { input: '#codigo', message: 'Identificaci�n debe tener 5 caracteres!', action: 'keyup, blur', rule: 'length=5,5' },
					{ input: '#descripcion', message: 'Descripcion es requerida!', action: 'keyup, blur', rule: 'required' },
					
	            ]
	        });	
          }; 
          
           
         //codigo para inicializacion del formulario
          createElements= function() {
            $('#eventWindow').jqxWindow({
                resizable: false,
                width: '350px',
                height: '200px',
                //minWidth: 200,
                theme: tema,
                //minHeight: 500,  
                cancelButton: $("#btnCancel"),
                initContent: function () {
                    $('#id').jqxInput({disabled: true,width: '100%' });
                    $('#codigo').jqxInput({width: '100%',theme: tema, placeHolder: "Ingrese código" });
					$('#descripcion').jqxInput({width: '100%',theme: tema, placeHolder: "Ingrese descripcion" });
					$('#estado').jqxInput({theme: tema, disabled: true, width: '100%'  });
                    $('#btnSave').jqxButton({theme: tema, width: '65px' });
                    $('#btnCancel').jqxButton({theme: tema, width: '65px' });
                    $('#btnSave').focus();
                }
            });
            $('#eventWindow').jqxWindow('focus');
            $('#eventWindow').jqxValidator('hide');
       };

		
       
   
}