<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Citres extends MX_Controller
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
			$this->load->view('rep/citres_view');
			
			
	}
	
	function ajax(){
			
			 
    }
	
	function citasasignadas($emp_id){
        				
				 $obj = new Cita();
				 $query=$obj->citas_asignadas($emp_id);
				 $results=$query->result_array();
				 echo json_encode($results);	
				 
               	
	}
	
	function generar_pdfCita($id_empleado,$id_cliente,$empleado){
	
		
		$obj = new Citre();
		$query=$obj->citas_agendadas($id_cliente);
		$results=$query->result_array();
		
			
	    $this->load->library('tcpdf'); //tcpdf
		
		$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Israel Parra');
        $pdf->SetTitle('Reporte de llamadas con TCPDF');
        $pdf->SetSubject('Tutorial TCPDF');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
 
// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
        $pdf->SetHeaderData('logo.jpg', PDF_HEADER_LOGO_WIDTH, 'FORMULARIO DE GESTION DE CITAS ','', array(0, 64, 255), array(0, 64, 128));
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
        $pdf->SetFont('helvetica', '', 10, '', true);
        
		$pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0.3);
        //$pdf->SetFont('', 'B');
 
// A?adir una p?gina
// Este m?todo tiene varias opciones, consulta la documentaci?n para m?s informaci?n.
		//$pdf->setPrintHeader(false); //no imprime la cabecera ni la linea
		//$pdf->setPrintFooter(false); // imprime el pie ni la linea

        $pdf->AddPage();
 
//fijar efecto de sombra en el texto
       //$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
		
		
			 
        foreach ($results as $fila)
        {
            $tipo_gestion = $fila['tipo_gestion'];
		    $fecha_gestion = $fila['fecha_gestion'];
            $financiamiento = $fila['financiamiento'];
			$limite_credito = $fila['limite_credito'];
			$financiamiento_tc = $fila['financiamiento_tc'];
			$limite_credito_tc = $fila['limite_credito_tc'];
			$perfil = $fila['perfil'];
			$contacto_id = $fila['contacto_id'];
			$telefono = $fila['telefono'];
			$empresa_id = $fila['empresa_id'];
			$observacion = $fila['observacion'];
			$cita_estado = $fila['cita_estado'];
			$fecha_cita = $fila['fecha_cita'];
			$fecha_nueva_cita = $fila['fecha_nueva_cita'];
			$cita_id = $fila['id'];
			$codigo_preaprobacion = $fila['codigo_preaprobacion'];
			$estado_preaprobacion_id = $fila['estado_preaprobacion'];
			$forma_pago_id = $fila['forma_pago'];
			$institucion = $fila['institucion_financiera'];
			
			$obj1 = new Citre();
			$query=$obj1->contacto_citas_agendadas($id_cliente);
			$results1=$query->result_array();
			foreach ($results1 as $fila1)
			{
				$identificacion = $fila1['identificacion'];
				$nombres = $fila1['nombres'];
				$apellidos = $fila1['apellidos'];
				$ciudad = $fila1['ciudad'];
				$direccion = $fila1['direccion'];
				$email = $fila1['email'];
			}
			
			
			
			
			
			$obje = new Citre();
			$query=$obje->empresa_citas_agendadas($empresa_id);
			$resultse=$query->result_array();
			$ruc="";
			foreach ($resultse as $filae)
			{
				$ruc = $filae['ruc'];
			}
			
		
			$obj2 = new Citre();
			$query=$obj2->citas_productos($cita_id);
			$results2=$query->result_array();
			foreach ($results2 as $fila2)
			{
				
				$nombre_producto = $fila2['nombre'];
				$cantidad = $fila2['cantidad'];
				
			}
		
			$obj3 = new Citre();
			$query=$obj3->citas_parametricas($forma_pago_id,$estado_preaprobacion_id);
			$results3=$query->result_array();			
			foreach ($results3 as $fila3)
			{
				$forma_pago = $fila3['forma_pago'];
				$estado_preaprobacion = $fila3['estado_preaprobado'];
				
			}
		
			$obj4 = new Citre();
			$query=$obj4->citas_empleados($contacto_id);
			$results4=$query->result_array();
			foreach ($results4 as $fila4)
			{
				$gestor = $fila4['gestor'];
				
			}

            $obj5 = new Citre();
			$query=$obj5->citas_vendedor($id_empleado);
			$results5=$query->result_array();
			foreach ($results5 as $fila5)
			{
				$vendedor = $fila5['vendedor'];
				
			}
			
        } 
        //preparamos y maquetamos el contenido a crear
        $html = '';
        $html .= "<style type=text/css>";
        $html .= "th{color: #222; font-weight: bold; background-color: #AAC7E3}";
        $html .= "td{background-color: #fff; color: #222}";
        $html .= "</style>";
        $html .= "<table width='100%' >";
        $html .= "<tr><td></td><td></td></tr>
					<tr><td><b>FECHA DE GESTI&Oacute;N: </b>".$fecha_gestion."</td><td><b>GESTOR: </b>".$gestor."</td></tr>
					<tr><td><b>TIPO DE GESTI&Oacute;N: </b>".$tipo_gestion."</td><td><b>ESTADO DE LA CITA: </b>".$cita_estado."</td></tr>
					<tr><td></td><td></td></tr>
					<tr><td></td><td></td></tr>
					
					<tr><td><b>CEDULA: </b>".$identificacion."</td><td><b>RUC:</b>".$ruc."</td></tr>
		        	<tr><td><b>NOMBRES: </b>".$nombres."</td><td><b>CELULAR: </b>".$telefono."</td></tr>
        			<tr><td><b>APELLIDOS: </b>".$apellidos."</td><td><b>FECHA-HORA DE CITA: </b>".$fecha_cita."</td></tr>
					<tr><td><b>CIUDAD: </b>".$ciudad."</td><td><b>EMAIL: </b>".$email."</td></tr>
					<tr><td><b>DIRECCI&Oacute;N: </b>".$direccion."</td><td></td></tr>
					<tr><td></td><td></td></tr>
					<tr><td></td><td></td></tr>";
	    $html .= "</table>";
		
		
 
// Imprimimos el texto con writeHTMLCell()
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 1, $ln = 0, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        $pdf->Ln();
        //Arma tabla de detalles*/
      	// column titles
        $header = array('Producto/Servicio', 'Cantidad');
        // Colors, line width and bold font
       
        // Header
        $w = array(145, 35);
        $pdf->SetFont('', 'B');
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $pdf->Ln();
        // Color and font restoration
        //$pdf->SetFillColor(224, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
        // Data
        $fill = 0;
        foreach($results2 as $row) {
            $pdf->Cell($w[0], 6, $row['nombre'], 'LR', 0, 'L', $fill,'');
            $pdf->Cell($w[1], 6, number_format($row['cantidad']), 'LR', 0, 'R', $fill,'');
            $pdf->Ln();
            $fill=!$fill;
        }
        $pdf->Cell(array_sum($w), 0, '', 'T');
        $pdf->Ln();
	  
		$html1 = '';
		$html1 .= "<style type=text/css>";
        $html1 .= "th{color: #222; font-weight: bold; background-color: #AAC7E3}";
        $html1 .= "td{background-color: #fff; color: #222}";
        $html1 .= "</style>";
        $html1 .= "<table width='100%' >";
        $html1 .= "<tr><td><b>OBSERVACIONES GENERALES: </b> ".$observacion."</td><td></td></tr>
					<tr><td></td><td></td></tr>
					<tr><td></td><td></td></tr>
		
					<tr><td><b>FORMA DE PAGO: </b>".$forma_pago."</td><td><b>INSTITUCI&Oacute;N BANCARIA: </b>".$institucion."</td></tr>
					<tr><td><b>ESTADO DE PREAPROBACI&Oacute;N: </b>".$estado_preaprobacion."</td><td><b>ID DE APROBACI&Oacute;N: </b>".$codigo_preaprobacion."</td></tr>
					<tr><td><b>PERFIL: </b> ".$perfil."</td></tr>
					<tr><td><b>LIMITE DE CR&Eacute;DITO BANCO: </b> ".$limite_credito."</td>
					<td><b>LIMITE DE CR&Eacute;DITO TARJETA: </b> ".$limite_credito_tc."</td></tr>
					<tr><td><b>FINANCIAMIENTO BANCO: </b> ".$financiamiento."</td>
					<td><b>FINANCIAMIENTO TARJETA: </b> ".$financiamiento_tc."</td></tr>
					<tr><td></td><td></td></tr>
					<tr><td></td><td></td></tr>
		
					<tr><td colspan='2' align='center'><b>GESTI&Oacute;N DE CITAS</b></td></tr>
					<tr><td></td><td></td></tr>
					<tr><td><b>ESTADO DE GESTI&Oacute;N:</b></td><td></td></tr>
        			<tr><td><b>FECHA-HORA DE NUEVA VISITA:</b></td><td><b>ASESOR ASIGNADO:</b>".$vendedor."</td></tr>
					<tr><td><b>OBSERVACI&Oacute;N DE LA GESTI&Oacute;N:</b></td><td></td></tr>";
	    $html1 .= "</table>";
	    $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html1, $border = 1, $ln = 0, $fill = 0, $reseth = true, $align = '', $autopadding = true);
 
	   
 
// ---------------------------------------------------------
// Cerrar el documento PDF y preparamos la salida
// Este m?todo tiene varias opciones, consulte la documentaci?n para m?s informaci?n.
        $nombre_archivo = utf8_decode("Reporte de gestion de citas.pdf");
        $pdf->Output($nombre_archivo, 'I');
	}	
	
	 
}
