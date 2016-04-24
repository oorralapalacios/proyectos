<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cittels extends MX_Controller
{
	function __construct()
	{
                parent::__construct();
                modules::run('login/autentificado');
				Datamapper::add_model_path( array( APPPATH.'modules/rep/' ) );
				Datamapper::add_model_path( array( APPPATH.'modules/mar/' ) );
	}

	function index()
	{
            $this->load->view('includes/header_panel');
			$this->load->view('rep/cittel_view');
			
			
	}
	
	function ajax(){
				 
    }
	
	function lista_teleoperador(){
        				
				 $obj = new Cittel();
				 $query=$obj->custom_query_empleado();
				 $results=$query->result_array();
				 echo json_encode($results);			 
               	
	}
	
	function generar_pdfTel($id_empleado,$fecha_ini,$fecha_fin,$empleado){
		$stamp_ini = strtotime($fecha_ini);
		$fecha_inicial = date("Y-m-d", $stamp_ini);
		
		//aumento un dia a la fecha fin para que incluya la fecha de fin seleccionada
		$idia=1;
	    $stamp_fin = strtotime ( '+'.$idia.' day' , strtotime ( $fecha_fin ) ) ;
		//$stamp_fin = strtotime($fecha_fin);
		$fecha_final = date("Y-m-d", $stamp_fin);
		
		/*$stamp_fin = strtotime($fecha_fin);
		$fecha_final = date("Y-m-d", $stamp_fin);*/
		
		if ($id_empleado=="0"){
			$result = new Cittel();
			$query=$result->citas_llamadas($fecha_inicial,$fecha_final);
			$obj=$query->result_array();
		
		$linea = "<h4></h4>";
		$teleoperador = "<th>Gestor</th>";
		}else{
			$result = new Cittel();
			$query=$result->citas_llamadas_empleados($id_empleado,$fecha_inicial,$fecha_final);
			$obj=$query->result_array();
		 $find = array('%20','%C3%AD','%C3%B3','%C3%A1','%C3%81','%C3%93','C3%A9z','%C3%8D','%C3%B1','�','�','�','�','�');
		 $repl = array(' ','&iacute;','&oacute;','&aacute;','&Aacute;','&Oacute;','&eacute;','&Iacute;','&ntilde;','u','a','o','c','n');
		// $url = str_replace($find, $repl, $url);
		$nombre = str_replace($find, $repl, $empleado);
		//$sr = str_replace("%C3%AD","&iacute;", $nombre);
		$teleoperador = "";
		
		$linea = "<h4>Teleoperador: ". $nombre."</h4>";
		}
			
	    $this->load->library('tcpdf'); //tcpdf
		
		$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', true);
		$pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Omar Orrala');
        $pdf->SetTitle('Reporte de citas con TCPDF');
        $pdf->SetSubject('Tutorial TCPDF');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
 
// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
        $pdf->SetHeaderData('logo.jpg', PDF_HEADER_LOGO_WIDTH, 'Listado de citas por teleoperador ', 'DESDE: '.$fecha_ini.' HASTA: '.$fecha_fin, array(0, 64, 255), array(0, 64, 128));
        //$pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));
 
// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 
// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 
// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
 
//relaci?n utilizada para ajustar la conversi?n de los p?xeles
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 
 
// ---------------------------------------------------------
// establecer el modo de fuente por defecto
        $pdf->setFontSubsetting(true);
 
// Establecer el tipo de letra
//Si tienes que imprimir car?cteres ASCII est?ndar, puede utilizar las fuentes b?sicas como
// Helvetica para reducir el tama?o del archivo.
        //$pdf->SetFont('dejavusans', '', 7, '', true);
        $pdf->SetFont('helvetica', '', 8, '', true);
        
 
// A?adir una p?gina
// Este m?todo tiene varias opciones, consulta la documentaci?n para m?s informaci?n.
		//$pdf->setPrintHeader(false); //no imprime la cabecera ni la linea
		//$pdf->setPrintFooter(false); // imprime el pie ni la linea

        $pdf->AddPage();
 
//fijar efecto de sombra en el texto
       //$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
		
		 
		 //$empleados=$query->result_array();
        //preparamos y maquetamos el contenido a crear
        $html = '';
        $html .= "<style type=text/css>";
        $html .= "th{color: #222; font-weight: bold; background-color: #AAC7E3}";
        
		$html .= "td{background-color: #fff; color: #222}";
        $html .= "</style>";
        $html .= $linea;
        $html .= "<table width='100%' >";
	    $html .= "<thead style='display: table-header-group'>";
        $html .= "<tr>".$teleoperador."<th>Cedula</th><th>Cliente</th><th>Direcci&oacute;n</th><th>Tel&eacute;fono</th><th>Fecha-Hora de Visita</th></tr>";
        $html .= "</thead>";
        //provincias es la respuesta de la funci?n getProvinciasSeleccionadas($provincia) del modelo
        foreach ($obj as $fila)
        {
            $cedula = $fila['identificacion'];
		    $cliente = $fila['nombres'].' '.$fila['apellidos'];
            $direccion = $fila['direccion'];
			$telefono = $fila['telefono'];
			$fecha_visita = $fila['fecha_visita'];
			$cita_estado = $fila['cita_estado'];
			if ($id_empleado=="0"){
			
			$teleoperador = $fila['teleoperador'];
            $html .= "<tr><td style='width:20px'>".$teleoperador."</td><td>".$cedula."</td><td>".$cliente."</td><td>".$direccion."</td>
						<td>" . $telefono . "</td><td>" . $fecha_visita . "</td></tr>";
			
			}else{
			$html .= "<tr><td style='width:50px'>" . $cedula . "</td><td>" . $cliente . "</td><td>" . $direccion . "</td><td>" . $telefono . "</td>
						<td>" . $fecha_visita . "</td></tr>";
			}
        }
        $html .= "</table>";
 
// Imprimimos el texto con writeHTMLCell()
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
 
// ---------------------------------------------------------
// Cerrar el documento PDF y preparamos la salida
// Este m?todo tiene varias opciones, consulte la documentaci?n para m?s informaci?n.
        $nombre_archivo = utf8_decode("Gestion de citas.pdf");
        $pdf->Output($nombre_archivo, 'I');
	}	
	
}
