<html>
    <head>
        <title>Estadisticas</title>
        <!-- external libs from cdnjs -->
         <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.css">
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
 
        <!-- PivotTable.js libs from ../dist -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js-pivot/dist/pivot.css">
        <script type="text/javascript" src="<?php echo base_url();?>assets/js-pivot/dist/pivot.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js-pivot/dist/c3_renderers.js"></script>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/jqyui/themes/redmond/jquery.ui.all.css">  
        <style>
            body {font-family: Verdana;}
        </style>
    </head>
    <body>
    <script type="text/javascript">
        
        $(document).ready(function () {
        	setControls();
        });
        
      
       setControls=function(){
       	    var d = new Date();
       		$( "#datepickerdesde" ).datepicker({
       	     dateFormat: "yy-mm-dd",
       	    
			});
			$( "#datepickerdesde" ).datepicker( "setDate", d );
	       	$( "#datepickerhasta" ).datepicker({
	       	    dateFormat: "yy-mm-dd",
	       	    
			});
			$( "#datepickerhasta" ).datepicker( "setDate", d );
			    var desdeDate = $( "#datepickerdesde" ).val();
	         	var hastaDate = $( "#datepickerhasta" ).val();
	         	pivotGrid(desdeDate,hastaDate);
			$( "#btConsultar" )
	         .button()
	         .click(function( event ) {
	         	var desdeDate = $( "#datepickerdesde" ).val();
	         	var hastaDate = $( "#datepickerhasta" ).val();
	         	pivotGrid(desdeDate,hastaDate);
	          
	        });
	        $( "#btImprimir" )
	         .button()
	         .click(function( event ) {
	         	
	         	PrintMe();
	         	
	             
	        });
       }
        
        
       pivotGrid= function(fecha_ini,fecha_fin){
       	 
       	 
       	  var arr_rows=["campana","asesor"];
       	  var arr_cols=["cita_estado"];
          var url= "<?php echo site_url("piv/estcita/ajax"); ?>"+"/"+fecha_ini+"/"+fecha_fin; 
      	  var derivers = $.pivotUtilities.derivers;
          var renderers = $.extend($.pivotUtilities.renderers, 
                    $.pivotUtilities.c3_renderers);     
           $.getJSON(url, function(data) {
          	        if (data.length==0){
          	        	$(".output").pivot( data, {
                    	renderers: renderers,
                        derivedAttributes: {
                        },
                        cols: arr_cols, 
                        rows: arr_rows,
                        
                       });
                    }else{
                    $(".output").pivotUI( data, {
                    	renderers: renderers,
                        derivedAttributes: {
                        },
                        cols: arr_cols, 
                        rows: arr_rows,
                        
                      });
                    }
                });
       }
       
       function PrintMe() {
       	var desdeDate = $( "#datepickerdesde" ).val();
	    var hastaDate = $( "#datepickerhasta" ).val();
		source = $('.pvtRendererArea')[0];
		var html;
		var disp_setting="toolbar=yes,location=no,";
		disp_setting+="directories=yes,menubar=yes,";
		disp_setting+="scrollbars=yes,width=650, height=600, left=100, top=25";
		   var content_vlue = source.innerHTML;
		  //var content_vlue=source;
		   var docprint=window.open("","",disp_setting);
		   docprint.document.open();
		    
		   html='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"';
		   html+='"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
		   html+='<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">';
		   html+='<head><title>Gestión de Citas</title>';
		   html+='<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js-pivot/dist/pivot.css">';
		   html+='<style type="text/css">body{ margin:0px;';
		   html+='font-family:verdana,Arial;color:#000;';
		   html+='font-family:Verdana, Geneva, sans-serif; font-size:12px;}';
		   html+='a{color:#000;text-decoration:none;} ';
		   html+='</style>';
		   html+='</head><body onLoad="self.print()"><center>';
		   html+='<div id="logo"><img src="<?php echo base_url();?>assets/img/log_titulo.png"></div>';
		   html+='<h1>Gestión de Citas</h1>';
		   html+='<h2>Del: '+desdeDate+'  Al: '+hastaDate+'  </h2>';
		   html+=content_vlue;
		   html+='</center></body></html>';
		   docprint.document.write(html);
		   docprint.document.close();
		   docprint.focus();
											
		}
       
        
       
    
       
        </script>
        <div align="center">
         <table>
		    <tr>
		        <td align="right">Desde:</td>
		        <td align="left"><input type="text" id="datepickerdesde"></div></td>
		        <td align="right">Hasta:</td>
		        <td align="left"><input type="text" id="datepickerhasta"></div></td>
		        <td align="right"><input id="btConsultar" type="submit" value="Consultar"></td>
		        <td align="right"><input id="btImprimir" type="submit" value="Imprimir"></td>
 		    </tr>
		 </table>
        
        <div class="output" style="margin: 5px;"></div>
        </div>
       
    </body>
</html>
