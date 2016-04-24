	<script type="text/javascript">
	
	    //codigo para inicializacion del formulario
        function createElements() {
            $('#eventWindow').jqxWindow({
                resizable: false,
                width: '100%',
                Height: '86%',
                theme: 'ui-le-frog',
                minHeight: 450,  
                title: 'Subida de contactos de EXCEL',
                cancelButton: $("#btCancel"),
                initContent: function () {
                	
                	
                    $('#btImportar').jqxButton({theme: 'ui-le-frog', width: '100px' });
                    $('#btCancel').jqxButton({theme: 'ui-le-frog', width: '100px' });
                   
                     //alert('Hola');
                    gridExportado();
                }
            });
            $('#eventWindow').jqxWindow('focus');
            $('#eventWindow').jqxValidator('hide');
             
        }
        
         function ulistaCampanas(){
		   $("#campana_id").jqxDropDownList({
		 	        theme: tema,
					source: adpcampana(),
					width: 350,
					height: 25,
					selectedIndex: 0,
					displayMember: 'nombre',
					valueMember: 'id'
			});			
		}
        		
		 function gridExportado(){
            	                
        						
								$("#drop").jqxGrid({theme: 'office', width: '100%', height: "350px",  editable: true, filterable: true ,
								    //pageable: true,
								    //selectionmode: 'multiplecellsadvanced',
								     columnsresize: true,
								     pageable: true,
						            //autoheight: true,
						             columnsresize: true,
						             pagermode: 'simple',
						             pagesize: 50,
									 columns: [
									     { text: '', datafield: 'Borrar', width: 60, columntype: 'button',id:'number', cellsrenderer: function () {
						                     return "Borrar";
						                      //return '<div style="width: 100%"><img src="../../../Custom Images/pencil.png" style="margin-left: 25%" /></div>';
						                      //return '<div id="removeButton" style="float: left; position:relative; margin:auto;"><img style="vertical-align: middle;" src="<?php echo base_url(); ?>assets/img/icobor.png" />&nbsp;Borrar</div>';
						                   }, buttonclick: function (row) {
						                  	  
						                              var selectedrowindex = $("#drop").jqxGrid('getselectedrowindex');
						                              if (selectedrowindex >= 0){
						                                var id = $("#drop").jqxGrid('getrowid', selectedrowindex);
						                                var commit = $("#drop").jqxGrid('deleterow', id);
						                               }
						                             
											 
						                   }
						                  },  
									      { text: 'Identificacion', datafield: 'identificacion', width: 100, cellclassname: cellidentificacion },
						                  { text: 'Cliente', datafield: 'cliente', width: 200, cellclassname: cellnombrecliente },
						                  { text: 'Ciudad', datafield: 'ciudad', width: 150 },
						                  { text: 'Telefono movil', datafield: 'telefono_movil', width: 150, cellclassname:celltelmovil  },
							              { text: 'Forma pago', datafield: 'forma_pago', width: 100 },
							              { text: 'Fecha activacion', datafield: 'fecha_activacion', width: 100 },
							              { text: 'Banco', datafield: 'banco', width: 200 },
							              { text: 'Tarifa basica', datafield: 'tarifa_basica', width: 100 },
							              { text: 'Plan', datafield: 'plan', width: 200 },
							                 
						              ]});
								
        }
	
	   var cellidentificacion = function (row, columnfield, value) {
            if (columnfield='identificacion'){
	            if (value==undefined){
	               return 'red';
	             }
	              if (!validaDoc(value)){
	               return 'red';
	             }  
            }
             
            }
            var cellnombrecliente = function (row, columnfield, value) {
            if (columnfield='nombre_cliente'){
	            if (value==undefined){
	               return 'red';
	             }
	              if (!validaNombres(value)){
	               return 'red';
	             }  
            }
            }
            var cellnombre = function (row, columnfield, value) {
            if (columnfield='nombres'){
	            if (value==undefined){
	               return 'red';
	             }
	              if (!validaNombres(value)){
	               return 'red';
	             }  
            }
            }
            var cellapellido = function (row, columnfield, value) {
            if (columnfield='apellidos'){
	            if (value==undefined){
	               return 'red';
	             }
	              if (!validaApellidos(value)){
	               return 'red';
	             }  
            }
            }
            
            var celltelmovil = function (row, columnfield, value) {
            if (columnfield='telefono_movil'){
	            if (value==undefined){
	               return 'red';
	             }
	              if (!validaTelefonoMovil(value)){
	               return 'red';
	             }  
            }
            }
           
		  /*function ValidaImportado(){
		  	var valida=true
		  	if (valida) return true; else return false;
		  }*/
         function ValidaImportado(){
          var rows = $("#drop").jqxGrid('getrows');	
          var valida=true
          for (var i = 0; i < rows.length; i++) {
          	var row=rows[i];
             /*if (row.identificacion==undefined){
              valida=false;
             }else if (!validaDoc(row.identificacion)){
              valida=false;
             }else 
             if (row.nombre_cliente==undefined){
              valida=false;
             }else if (!validaNombres(row.nombre_cliente)){
              valida=false;
             }*//*
             else if (row.nombres==undefined){
               valida=false;
             }else if (!validaNombres(row.nombres)){
               valida=false;
             }else if (row.apellidos==undefined){
                valida=false;
             }else if (!validaApellidos(row.apellidos)){
                valida=false;
             }*/
             /*else*/
             if (!validaTelefonoMovil(row.telefono_movil)){
                valida=false;
             }
          } 
            
           if (valida) return true; else return false;
         }
          

         
         
		
	</script>
	
	<div style="visibility: hidden; display:none;"  id="jqxWidget1">
        <div id="eventWindow">
             <div>
                <div>
                      <form id="fmpr">
                       
                      </form>
				            <style>
				            	#drop{
								border:2px dashed #bbb;
								-moz-border-radius:5px;
								-webkit-border-radius:5px;
								border-radius:5px;
								/*padding:25px;
								text-align:center;
								font:20pt bold,"Vollkorn";color:#bbb*/
								}
								/*#btImportar{
								width:15%;
								}*/
								.green {
								color: black\9;
								background-color: #b6ff00\9;
								}
								.yellow {
								color: black\9;
								background-color: yellow\9;
								}
								.red {
								/*color: black\9;
								background-color: #e83636\9;*/
								border:2px dashed #e83636\9;
								-moz-border-radius:5px;
								-webkit-border-radius:5px;
								border-radius:5px;
								 }
														
								.green:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected), .jqx-widget .green:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected) {
								color: black;
								background-color: #b6ff00;
								}
								.yellow:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected), .jqx-widget .yellow:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected) {
								color: black;
								background-color: yellow;
								}
								.red:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected), .jqx-widget .red:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected) {
								color: black;
								background-color: #e83636;
								}
				            </style>
							<p><b>Descarge formato Excel de ejemplo </b><a href="<?php echo base_url();?>/contactos.xlsx">Aqui</a></p>
							<b>Seleccione un archivo de Excel de extensión (XLSX/XLSB/XLSM)</b><br />
							<input type="file" name="xlfile" id="xlf"/>
							<br />
							<b>Arrastre un archivo XLSX or XLSM or XLSB aquí para verlo</b><br />
							<div id="drop">Drop un archivo XLSX or XLSM or XLSB aquí para verlo</div>
							<pre id="out"></pre>
							<!--<textarea id="out"></textarea>-->
							<div style="visibility: hidden; display:none;">
							Formato de subida:
							<select name="format">
							<option value="json"> JSON</option>
							</select>
							</div>
							<input id="btImportar" type = "submit" name="enviar" value="Importar..."/>
							<input id="btCancel" type = "submit" name="cancelar" value="Cancelar"/>
							
							<br />
							 <script type="text/javascript" src="<?php echo base_url();?>assets/js-xlsx-master/shim.js"></script>
							 <script type="text/javascript" src="<?php echo base_url();?>assets/js-xlsx-master/jszip.js"></script>
							 <script type="text/javascript" src="<?php echo base_url();?>assets/js-xlsx-master/xlsx.js"></script>
							 <script type="text/javascript">
								var rABS = typeof FileReader !== "undefined" && typeof FileReader.prototype !== "undefined" && typeof FileReader.prototype.readAsBinaryString !== "undefined";
								var use_worker = typeof Worker !== 'undefined';
								var transferable = use_worker;
								
								var wtf_mode = false;
								
								function fixdata(data) {
									var o = "", l = 0, w = 10240;
									for(; l<data.byteLength/w; ++l) o+=String.fromCharCode.apply(null,new Uint8Array(data.slice(l*w,l*w+w)));
									o+=String.fromCharCode.apply(null, new Uint8Array(data.slice(l*w)));
									return o;
								}
								
								function ab2str(data) {
									var o = "", l = 0, w = 10240;
									for(; l<data.byteLength/w; ++l) o+=String.fromCharCode.apply(null,new Uint16Array(data.slice(l*w,l*w+w)));
									o+=String.fromCharCode.apply(null, new Uint16Array(data.slice(l*w)));
									return o;
								}
								
								function s2ab(s) {
									var b = new ArrayBuffer(s.length*2), v = new Uint16Array(b);
									for (var i=0; i != s.length; ++i) v[i] = s.charCodeAt(i);
									return [v, b];
								}
								
								function xlsxworker_noxfer(data, cb) {
									var worker = new Worker('./xlsxworker.js');
									worker.onmessage = function(e) {
										switch(e.data.t) {
											case 'ready': break;
											case 'e': console.error(e.data.d); break;
											case 'xlsx': cb(JSON.parse(e.data.d)); break;
										}
									};
									var arr = rABS ? data : btoa(fixdata(data));
									worker.postMessage({d:arr,b:rABS});
								}
								
								function xlsxworker_xfer(data, cb) {
									var worker = new Worker(rABS ? './xlsxworker2.js' : './xlsxworker1.js');
									worker.onmessage = function(e) {
										switch(e.data.t) {
											case 'ready': break;
											case 'e': console.error(e.data.d); break;
											default: xx=ab2str(e.data).replace(/\n/g,"\\n").replace(/\r/g,"\\r"); console.log("done"); cb(JSON.parse(xx)); break;
										}
									};
									if(rABS) {
										var val = s2ab(data);
										worker.postMessage(val[1], [val[1]]);
									} else {
										worker.postMessage(data, [data]);
									}
								}
								
								function xlsxworker(data, cb) {
									transferable = document.getElementsByName("xferable")[0].checked;
									if(transferable) xlsxworker_xfer(data, cb);
									else xlsxworker_noxfer(data, cb);
								}
								
								function get_radio_value( radioName ) {
									var radios = document.getElementsByName( radioName );
									for( var i = 0; i < radios.length; i++ ) {
										if( radios[i].checked || radios.length === 1 ) {
											return radios[i].value;
										}
									}
								}
								
								function to_json(workbook) {
									var result = {};
									workbook.SheetNames.forEach(function(sheetName) {
										var roa = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
										if(roa.length > 0){
											result[sheetName] = roa;
										}
									});
									
									return result;
								}
								
								function to_csv(workbook) {
									var result = [];
									workbook.SheetNames.forEach(function(sheetName) {
										var csv = XLSX.utils.sheet_to_csv(workbook.Sheets[sheetName]);
										if(csv.length > 0){
											//result.push("SHEET: " + sheetName);
											//result.push("");
											result.push(csv);
										}
									});
									return result.join("\n");
								}
								
								function to_formulae(workbook) {
									var result = [];
									workbook.SheetNames.forEach(function(sheetName) {
										var formulae = XLSX.utils.get_formulae(workbook.Sheets[sheetName]);
										if(formulae.length > 0){
											result.push("SHEET: " + sheetName);
											result.push("");
											result.push(formulae.join("\n"));
										}
									});
									return result.join("\n");
								}
								
								var tarea = document.getElementById('b64data');
								function b64it() {
									
									if(typeof console !== 'undefined') console.log("onload", new Date());
									var wb = XLSX.read(tarea.value, {type: 'base64',WTF:wtf_mode});
									process_wb(wb);
								}
								
								function process_wb(wb) {
									
									var output = "";
									switch(get_radio_value("format")) {
										case "json":
										  //alert(to_csv(wb));
											output = JSON.stringify(to_json(wb), 2, 2);
											var source = {
								               datatype: "json",
								               datafields: [
								                   { name: 'telefono_movil', type: 'string' },
								                   { name: 'identificacion', type: 'string' },
								                   { name: 'cliente', type: 'string' },
								                   { name: 'ciudad', type: 'string' },
								                   { name: 'forma_pago', type: 'string' },
								                   { name: 'fecha_activacion', type: 'string' },
								                   { name: 'banco', type: 'string' },
								                   { name: 'tarifa_basica', type: 'string' },
								                   { name: 'plan', type: 'string' },
								               ],
								                id: 'id',
								                localdata: output,
								                async: false
								            };
								         
											
											 var dataAdapter = new $.jqx.dataAdapter(source);
											 $("#drop").jqxGrid({source: dataAdapter});
																			
											
											break;
										
									}
									
									
								}
								
								var drop = document.getElementById('drop');
								function handleDrop(e) {
									e.stopPropagation();
									e.preventDefault();
									rABS = 0;
									use_worker = 0;
									var files = e.dataTransfer.files;
									var i,f;
									for (i = 0, f = files[i]; i != files.length; ++i) {
										var reader = new FileReader();
										var name = f.name;
										reader.onload = function(e) {
											if(typeof console !== 'undefined') console.log("onload", new Date(), rABS, use_worker);
											var data = e.target.result;
											if(use_worker) {
												xlsxworker(data, process_wb);
											} else {
												var wb;
												if(rABS) {
													wb = XLSX.read(data, {type: 'binary'});
												} else {
												var arr = fixdata(data);
													wb = XLSX.read(btoa(arr), {type: 'base64'});
												}
												process_wb(wb);
											}
										};
										if(rABS) reader.readAsBinaryString(f);
										else reader.readAsArrayBuffer(f);
									}
								}
								
								function handleDragover(e) {
									e.stopPropagation();
									e.preventDefault();
									e.dataTransfer.dropEffect = 'copy';
								}
								
								if(drop.addEventListener) {
									drop.addEventListener('dragenter', handleDragover, false);
									drop.addEventListener('dragover', handleDragover, false);
									drop.addEventListener('drop', handleDrop, false);
								}
								
								
								var xlf = document.getElementById('xlf');
								function handleFile(e) {
									rABS = 0;
									use_worker = 0;
									var files = e.target.files;
									var i,f;
									for (i = 0, f = files[i]; i != files.length; ++i) {
										var reader = new FileReader();
										var name = f.name;
										reader.onload = function(e) {
											if(typeof console !== 'undefined') console.log("onload", new Date(), rABS, use_worker);
											var data = e.target.result;
											if(use_worker) {
												xlsxworker(data, process_wb);
											} else {
												var wb;
												if(rABS) {
													wb = XLSX.read(data, {type: 'binary'});
												} else {
												var arr = fixdata(data);
													wb = XLSX.read(btoa(arr), {type: 'base64'});
												}
												process_wb(wb);
											}
										};
										if(rABS) reader.readAsBinaryString(f);
										else reader.readAsArrayBuffer(f);
									}
								}
								
								if(xlf.addEventListener) xlf.addEventListener('change', handleFile, false);
							</script>
                   
                </div>
            </div>
        </div>     
        
       </div>  