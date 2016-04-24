<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cita extends DataMapper {
    var $extensions = array('json');
    var $table = 'citas';
    //var $has_many = array('cita_producto','cita_agenda');
	//var $has_one = array('contacto');
	
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	
	  //retorna total de registros en la base a mostrar en la bandeja de forma virtual
	function found_rows(){
		$sql="SELECT FOUND_ROWS() AS `found_rows`;";
		$query=$this->db->query($sql);
		if ($query->num_rows() > 0)
		{
		   foreach ($query->result() as $row)
		   {
		      $total= $row->found_rows;
		    
		   }
		} 
		return $total;
	}
	
	function bandejafilter($camp_id=null,$emp_id=null,$bandeja=null){
	$pagenum = $_POST['pagenum'];
	$pagesize = $_POST['pagesize'];
	//$pagenum = 0;
	//$pagesize = 100;
	$start=$pagenum*$pagesize;
           switch ($bandeja) {
           	 /*
			  * SQL módulo de validacion de citas
			  * */
		      case 'CN'://Citas nuevas
		            $sql="SELECT SQL_CALC_FOUND_ROWS cit.*, cit.id as cita_id, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
			        con.ciudad, 
			        (select telefono from llamadas where id=cit.llamada_id) as movil,  
				    con.direccion,
				    emp.ruc, emp.razon_social, cam.nombre as campana,  
				    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
				    FROM citas cit
				    LEFT JOIN contactos_campanas cc ON cit.contacto_campana_id = cc.id 
				    LEFT JOIN contactos con ON cit.contacto_id = con.id 
				    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
				    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
				    where (cit.padre_id is null or cit.padre_id is not null)
				    and not exists (select * from citas where padre_id=cit.id and estado='AC')
				    and cit.cita_estado='Nueva'
				    and cit.estado='AC'
					and cit.campana_id=".$camp_id."
					and cit.empleado_id=".$emp_id."";
			      break;
		      case 'CC': //Citas confirmadas
		           $sql="SELECT SQL_CALC_FOUND_ROWS cit.*, cit.id as cita_id, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
			        con.ciudad,
			         (select telefono from llamadas where id=cit.llamada_id) as movil,
			        con.direccion,
				    emp.ruc, emp.razon_social, cam.nombre as campana,
				    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
				    FROM citas cit
				    LEFT JOIN contactos_campanas cc ON cit.contacto_campana_id = cc.id 
				    LEFT JOIN contactos con ON cit.contacto_id = con.id 
				    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
				    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
				    where cit.padre_id is not null
				    and not exists (select * from citas where padre_id=cit.id and estado='AC')
					and cit.cita_estado='Cita confirmada'
					and cit.estado='AC'
					and cit.campana_id=".$camp_id."
					and cit.empleado_id=".$emp_id."";
		          break;
		      case 'CNC'://Citas no confirmadas
		           $sql="SELECT SQL_CALC_FOUND_ROWS cit.*, cit.id as cita_id, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
			        con.ciudad,
			         (select telefono from llamadas where id=cit.llamada_id) as movil,
			        con.direccion,
				    emp.ruc, emp.razon_social, cam.nombre as campana,
				    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
				    FROM citas cit
				    LEFT JOIN contactos_campanas cc ON cit.contacto_campana_id = cc.id 
				    LEFT JOIN contactos con ON cit.contacto_id = con.id 
				    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
				    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
				    where cit.padre_id is not null
				    and not exists (select * from citas where padre_id=cit.id and estado='AC')
					and cit.cita_estado='Cita no confirmada'
					and cit.estado='AC'
					and cit.campana_id=".$camp_id."
					and cit.empleado_id=".$emp_id."";
		          break;
		      case 'CMC'://Citas mal canalizadas
		         $sql="SELECT SQL_CALC_FOUND_ROWS cit.*, cit.id as cita_id, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
			        con.ciudad,
			         (select telefono from llamadas where id=cit.llamada_id) as movil,
			        con.direccion,
				    emp.ruc, emp.razon_social, cam.nombre as campana,
				    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
				    FROM citas cit
				    LEFT JOIN contactos_campanas cc ON cit.contacto_campana_id = cc.id 
				    LEFT JOIN contactos con ON cit.contacto_id = con.id 
				    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
				    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
				    where cit.padre_id is not null
				    and not exists (select * from citas where padre_id=cit.id and estado='AC')
					and cit.cita_estado='Mala cita'
					and cit.estado='AC'
					and cit.campana_id=".$camp_id."
					and cit.empleado_id=".$emp_id."";
		          break; 
		         
		       case 'CCA'://Citas canceladas
		            $sql="SELECT SQL_CALC_FOUND_ROWS cit.*,cit.id as cita_id, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
			        con.ciudad,
			         (select telefono from llamadas where id=cit.llamada_id) as movil,
			        con.direccion,
				    emp.ruc, emp.razon_social, cam.nombre as campana,
				    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
				    FROM citas cit
				    LEFT JOIN contactos_campanas cc ON cit.contacto_campana_id = cc.id 
				    LEFT JOIN contactos con ON cit.contacto_id = con.id 
				    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
				    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
				    where cit.padre_id is not null
				    and not exists (select * from citas where padre_id=cit.id and estado='AC')
					and cit.cita_estado='Cancelo cita'
					and cit.estado='AC'
					and cit.campana_id=".$camp_id."
					and cit.empleado_id=".$emp_id."";
		          break;
				   
				case 'CPO'://Citas postergadas
				    $sql="SELECT SQL_CALC_FOUND_ROWS cit.*, cit.id as cita_id, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
			        con.ciudad,
			         (select telefono from llamadas where id=cit.llamada_id) as movil,
			        con.direccion,
				    emp.ruc, emp.razon_social, cam.nombre as campana,
				    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
				    FROM citas cit
				    LEFT JOIN contactos_campanas cc ON cit.contacto_campana_id = cc.id 
				    LEFT JOIN contactos con ON cit.contacto_id = con.id 
				    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
				    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
				    where cit.padre_id is not null
				    and not exists (select * from citas where padre_id=cit.id and estado='AC')
					and cit.cita_estado='Postergo cita'
					and cit.estado='AC'
					and cit.campana_id=".$camp_id."
					and cit.empleado_id=".$emp_id."";
				 
		         break;
				 /*
				  * SQL módulo de gestión de citas
				  * */
				 case 'GCA'://Citas asignadas
					$sql="SELECT SQL_CALC_FOUND_ROWS cit.*, cit.id as cita_id, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
			        con.ciudad, con.direccion, lla.telefono as movil, 
				    emp.ruc, emp.razon_social, cam.nombre as campana,
	                CONCAT(ges.apellidos, ' ', ges.nombres) as gestor,
				    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
				    FROM citas cit
				    LEFT JOIN contactos_campanas cc ON cit.contacto_campana_id = cc.id 
				    LEFT JOIN llamadas lla ON cit.llamada_id = lla.id 
				    LEFT JOIN contactos con ON cit.contacto_id = con.id 
				    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
				    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
				    LEFT JOIN empleados col ON cit.empleado_id = col.id
				    LEFT JOIN empleados ges ON lla.empleado_id = ges.id
				    where cit.padre_id is not null
				    and cit.empleado_id=".$emp_id."
				    and cit.cita_estado='Cita Asignada'
				    and cit.estado='AC'
				    and not exists (select * from citas where padre_id=cit.id and estado='AC')";
				 break;
				 case 'GVC': //Ventas completadas
				    $sql="SELECT SQL_CALC_FOUND_ROWS cit.*,cit.id as cita_id, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
			        con.ciudad, con.direccion, lla.telefono as movil, 
				    emp.ruc, emp.razon_social, cam.nombre as campana,
	                CONCAT(ges.apellidos, ' ', ges.nombres) as gestor,
				    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
				    FROM citas cit
				    LEFT JOIN contactos_campanas cc ON cit.contacto_campana_id = cc.id 
				    LEFT JOIN llamadas lla ON cit.llamada_id = lla.id 
				    LEFT JOIN contactos con ON cit.contacto_id = con.id 
				    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
				    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
				    LEFT JOIN empleados col ON cit.empleado_id = col.id
				    LEFT JOIN empleados ges ON lla.empleado_id = ges.id
				    where cit.padre_id is not null
				    and cit.empleado_id=".$emp_id."
				    and cit.cita_estado='Venta Completa'
				    and cit.estado='AC'
				    and not exists (select * from citas where padre_id=cit.id and estado='AC')";
				 break;
			     case 'GVI': //Ventas incompletadas
				     $sql="SELECT SQL_CALC_FOUND_ROWS cit.*,cit.id as cita_id, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
			         con.ciudad, con.direccion, lla.telefono as movil, 
				     emp.ruc, emp.razon_social, cam.nombre as campana,
	                 CONCAT(ges.apellidos, ' ', ges.nombres) as gestor,
				     (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
				     FROM citas cit
				     LEFT JOIN contactos_campanas cc ON cit.contacto_campana_id = cc.id
				     LEFT JOIN llamadas lla ON cit.llamada_id = lla.id 
				     LEFT JOIN contactos con ON cit.contacto_id = con.id 
				     LEFT JOIN campanas cam ON cit.campana_id = cam.id 
				     LEFT JOIN empresas emp ON cit.empresa_id = emp.id
				     LEFT JOIN empleados col ON cit.empleado_id = col.id
				     LEFT JOIN empleados ges ON lla.empleado_id = ges.id
				     where cit.padre_id is not null
				     and cit.empleado_id=".$emp_id."
				     and cit.cita_estado='Venta Incompleta'
				     and cit.estado='AC'
				     and not exists (select * from citas where padre_id=cit.id and estado='AC')";
					 break;
			     case 'GVIN': //Ventas interesados
			        $sql="SELECT SQL_CALC_FOUND_ROWS cit.*,cit.id as cita_id, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
			        con.ciudad, con.direccion, lla.telefono as movil, 
				    emp.ruc, emp.razon_social, cam.nombre as campana,
	                CONCAT(ges.apellidos, ' ', ges.nombres) as gestor,
				    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
				    FROM citas cit
				    LEFT JOIN contactos_campanas cc ON cit.contacto_campana_id = cc.id
				    LEFT JOIN llamadas lla ON cit.llamada_id = lla.id 
				    LEFT JOIN contactos con ON cit.contacto_id = con.id 
				    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
				    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
				    LEFT JOIN empleados col ON cit.empleado_id = col.id
				    LEFT JOIN empleados ges ON lla.empleado_id = ges.id
				    where cit.padre_id is not null
				    and cit.empleado_id=".$emp_id."
				    and cit.cita_estado='Interesado'
				    and cit.estado='AC'
				    and not exists (select * from citas where padre_id=cit.id and estado='AC')";
					break;
			     case 'GVNI': //Ventas no interesados
			        $sql="SELECT SQL_CALC_FOUND_ROWS cit.*,cit.id as cita_id, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
			        con.ciudad, con.direccion, lla.telefono as movil, 
				    emp.ruc, emp.razon_social, cam.nombre as campana,
	                CONCAT(ges.apellidos, ' ', ges.nombres) as gestor,
				    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
				    FROM citas cit
				    LEFT JOIN contactos_campanas cc ON cit.contacto_campana_id = cc.id
				    LEFT JOIN llamadas lla ON cit.llamada_id = lla.id 
				    LEFT JOIN contactos con ON cit.contacto_id = con.id 
				    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
				    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
				    LEFT JOIN empleados col ON cit.empleado_id = col.id
				    LEFT JOIN empleados ges ON lla.empleado_id = ges.id
				    where cit.padre_id is not null
				    and cit.empleado_id=".$emp_id."
				    and cit.cita_estado='No Interesado'
				    and cit.estado='AC'
				    and not exists (select * from citas where padre_id=cit.id and estado='AC')";
				   break;
			     case 'GVCA': //Ventas canceladas
			        $sql="SELECT SQL_CALC_FOUND_ROWS cit.*,cit.id as cita_id, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
			        con.ciudad, con.direccion, lla.telefono as movil, 
				    emp.ruc, emp.razon_social, cam.nombre as campana,
	                CONCAT(ges.apellidos, ' ', ges.nombres) as gestor,
				    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
				    FROM citas cit
				    LEFT JOIN contactos_campanas cc ON cit.contacto_campana_id = cc.id
				    LEFT JOIN llamadas lla ON cit.llamada_id = lla.id 
				    LEFT JOIN contactos con ON cit.contacto_id = con.id 
				    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
				    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
				    LEFT JOIN empleados col ON cit.empleado_id = col.id
				    LEFT JOIN empleados ges ON lla.empleado_id = ges.id
				    where cit.padre_id is not null
				    and cit.empleado_id=".$emp_id."
				    and cit.cita_estado='Cita cancelada'
				    and cit.estado='AC'
				    and not exists (select * from citas where padre_id=cit.id and estado='AC')";
				   break;
			     case 'GVNV': //No visitados
				     $sql="SELECT SQL_CALC_FOUND_ROWS cit.*, cit.id as cita_id, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
				        con.ciudad, con.direccion, lla.telefono as movil, 
					    emp.ruc, emp.razon_social, cam.nombre as campana,
		                CONCAT(ges.apellidos, ' ', ges.nombres) as gestor,
					    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
					    FROM citas cit
					    LEFT JOIN contactos_campanas cc ON cit.contacto_campana_id = cc.id
					    LEFT JOIN llamadas lla ON cit.llamada_id = lla.id 
					    LEFT JOIN contactos con ON cit.contacto_id = con.id 
					    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
					    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
					    LEFT JOIN empleados col ON cit.empleado_id = col.id
					    LEFT JOIN empleados ges ON lla.empleado_id = ges.id
					    where cit.padre_id is not null
					    and cit.empleado_id=".$emp_id."
					    and cit.cita_estado='No visitado'
					    and cit.estado='AC'
					    and not exists (select * from citas where padre_id=cit.id and estado='AC')";
					 break;
					 
				 //Regestión
				 case 'RGVI': //regestion ventas incompletas
				     $sql="SELECT SQL_CALC_FOUND_ROWS cit.*, cit.id as cita_id, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
				        con.ciudad, con.direccion, lla.telefono as movil, 
					    emp.ruc, emp.razon_social, cam.nombre as campana,
		                (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
					    FROM citas cit
					    LEFT JOIN contactos_campanas cc ON cit.contacto_campana_id = cc.id
		                LEFT JOIN llamadas lla ON cit.llamada_id = lla.id 
					    LEFT JOIN contactos con ON cit.contacto_id = con.id 
					    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
					    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
					    LEFT JOIN empleados col ON cit.empleado_id = col.id
					    where cit.padre_id is not null
					    and cit.campana_id=".$camp_id."
		                and lla.empleado_id=".$emp_id."
					    and cit.cita_estado='Venta Incompleta'
					    and cit.estado='AC'
					    and not exists (select * from citas where padre_id=cit.id and estado='AC')";
					 break;
	             case 'RGVIN': //regestion interesados
			            $sql="SELECT SQL_CALC_FOUND_ROWS cit.*, cit.id as cita_id, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
				        con.ciudad, con.direccion, lla.telefono as movil, 
					    emp.ruc, emp.razon_social, cam.nombre as campana,
		                (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
					    FROM citas cit
					    LEFT JOIN contactos_campanas cc ON cit.contacto_campana_id = cc.id
		                LEFT JOIN llamadas lla ON cit.llamada_id = lla.id 
					    LEFT JOIN contactos con ON cit.contacto_id = con.id 
					    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
					    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
					    LEFT JOIN empleados col ON cit.empleado_id = col.id
					    where cit.padre_id is not null
					    and cit.campana_id=".$camp_id."
		                and lla.empleado_id=".$emp_id."
					    and cit.cita_estado='Interesado'
					    and cit.estado='AC'
					    and not exists (select * from citas where padre_id=cit.id and estado='AC')";
	            	 break;
				 case 'RGVNI': //regestion no interesados
				     $sql="SELECT SQL_CALC_FOUND_ROWS cit.*, cit.id as cita_id, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
				        con.ciudad, con.direccion, lla.telefono as movil, 
					    emp.ruc, emp.razon_social, cam.nombre as campana,
		                (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
					    FROM citas cit
					    LEFT JOIN contactos_campanas cc ON cit.contacto_campana_id = cc.id
		                LEFT JOIN llamadas lla ON cit.llamada_id = lla.id 
					    LEFT JOIN contactos con ON cit.contacto_id = con.id 
					    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
					    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
					    LEFT JOIN empleados col ON cit.empleado_id = col.id
					    where cit.padre_id is not null
					    and cit.campana_id=".$camp_id."
		                and lla.empleado_id=".$emp_id."
					    and cit.cita_estado='No Interesado'
					    and cit.estado='AC'
					    and not exists (select * from citas where padre_id=cit.id and estado='AC')";
					 break;
				 case 'RGVCA': //regestion ventas canceladas
						$sql="SELECT SQL_CALC_FOUND_ROWS cit.*,cit.id as cita_id, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
				        con.ciudad, con.direccion, lla.telefono as movil, 
					    emp.ruc, emp.razon_social, cam.nombre as campana,
		                (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
					    FROM citas cit
					    LEFT JOIN contactos_campanas cc ON cit.contacto_campana_id = cc.id
		                LEFT JOIN llamadas lla ON cit.llamada_id = lla.id 
					    LEFT JOIN contactos con ON cit.contacto_id = con.id 
					    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
					    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
					    LEFT JOIN empleados col ON cit.empleado_id = col.id
					    where cit.padre_id is not null
					    and cit.campana_id=".$camp_id."
		                and lla.empleado_id=".$emp_id."
					    and cit.cita_estado='Cita cancelada'
					    and cit.estado='AC'
					    and not exists (select * from citas where padre_id=cit.id and estado='AC')";
				     
					 break;
				 case 'RGVNV': //regestion no visitados
				      $sql="SELECT SQL_CALC_FOUND_ROWS cit.*,cit.id as cita_id, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
				        con.ciudad, con.direccion, lla.telefono as movil, 
					    emp.ruc, emp.razon_social, cam.nombre as campana,
		                (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
					    FROM citas cit
					    LEFT JOIN contactos_campanas cc ON cit.contacto_campana_id = cc.id
		                LEFT JOIN llamadas lla ON cit.llamada_id = lla.id 
					    LEFT JOIN contactos con ON cit.contacto_id = con.id 
					    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
					    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
					    LEFT JOIN empleados col ON cit.empleado_id = col.id
					    where cit.padre_id is not null
					    and cit.campana_id=".$camp_id."
		                and lla.empleado_id=".$emp_id."
					    and cit.cita_estado='No visitado'
					    and cit.estado='AC'
					    and not exists (select * from citas where padre_id=cit.id and estado='AC')";
					 break;	
				 
				 
		      default:
		         
		          break;
		  }
	       
         
    //and not exists (select * from llamadas where contacto_id=cc.contacto_id and campana_id=cc.campana_id
            	


    // filter data.
	if (isset($_POST['filterscount']))
	{
		$filterscount = $_POST['filterscount'];
		
		if ($filterscount > 0)
		{
			$where = " HAVING (";
			$tmpdatafield = "";
			$tmpfilteroperator = "";
			for ($i=0; $i < $filterscount; $i++)
		    {
				// get the filter's value.
				$filtervalue = $_POST["filtervalue" . $i];
				// get the filter's condition.
				$filtercondition = $_POST["filtercondition" . $i];
				// get the filter's column.
				$filterdatafield = $_POST["filterdatafield" . $i];
				$filterdatafield= $filterdatafield;
				// get the filter's operator.
				$filteroperator = $_POST["filteroperator" . $i];
				
				if ($tmpdatafield == "")
				{
					$tmpdatafield = $filterdatafield;			
				}
				else if ($tmpdatafield <> $filterdatafield)
				{
					$where .= ")AND(";
				}
				else if ($tmpdatafield == $filterdatafield)
				{
					if ($tmpfilteroperator == 0)
					{
						$where .= " AND ";
					}
					else $where .= " OR ";	
				}
				
				// build the "WHERE" clause depending on the filter's condition, value and datafield.
				switch($filtercondition)
				{
					case "CONTAINS":
						$where .= " " . $filterdatafield . " LIKE '%" . $filtervalue ."%'";
						break;
					case "DOES_NOT_CONTAIN":
						$where .= " " . $filterdatafield . " NOT LIKE '%" . $filtervalue ."%'";
						break;
					case "EQUAL":
						$where .= " " . $filterdatafield . " = '" . $filtervalue ."'";
						break;
					case "NOT_EQUAL":
						$where .= " " . $filterdatafield . " <> '" . $filtervalue ."'";
						break;
					case "GREATER_THAN":
						$where .= " " . $filterdatafield . " > '" . $filtervalue ."'";
						break;
					case "LESS_THAN":
						$where .= " " . $filterdatafield . " < '" . $filtervalue ."'";
						break;
					case "GREATER_THAN_OR_EQUAL":
						$where .= " " . $filterdatafield . " >= '" . $filtervalue ."'";
						break;
					case "LESS_THAN_OR_EQUAL":
						$where .= " " . $filterdatafield . " <= '" . $filtervalue ."'";
						break;
					case "STARTS_WITH":
						$where .= " " . $filterdatafield . " LIKE '" . $filtervalue ."%'";
						break;
					case "ENDS_WITH":
						$where .= " " . $filterdatafield . " LIKE '%" . $filtervalue ."'";
						break;
				}
								
				if ($i == $filterscount - 1)
				{
					$where .= ")";
				}
				
				$tmpfilteroperator = $filteroperator;
				$tmpdatafield = $filterdatafield;			
			}
			
			
			
			
			// build the query.
			$sql = $sql . $where;		
		}

	}
    //concatena filtra de ser el caso y pagina
	$sql=$sql." limit ".$start.",".$pagesize.";";
    //$query=$this->db->query($sql);
	//return $query;
	
	$query=$this->db->query($sql);
	$results=$query->result_array();
	$total=$this->found_rows();	
	
	$data[] = array(
	          'TotalRows' => $total,
		      'Rows' => $results
		    );
	return $data;
	
	}			
	
	//bandeja mejorada filtra y pagina
    function pageContatoCitas($conta_id){
	$pagenum = $_GET['pagenum'];
	$pagesize = $_GET['pagesize'];
	$start=$pagenum*$pagesize;
       
	        $sql ="select SQL_CALC_FOUND_ROWS @rownum:=@rownum+1 AS rownum, cc.*,ca.nombre as campana,
	        (select min(inicio) from citas_agendas where cita_id=cc.id and estado='AC') as fecha_hora, 
	        concat(em.apellidos,' ',em.nombres) as asesor
	        from (SELECT @rownum:=0) r, citas cc, campanas ca, empleados em
			where cc.campana_id=ca.id
			and cc.empleado_id=em.id
			and cc.estado='AC'
	        and cc.contacto_id = ".$conta_id."";
			

    // filter data.
	if (isset($_GET['filterscount']))
	{
		$filterscount = $_GET['filterscount'];
		
		if ($filterscount > 0)
		{
			$where = " AND (";
			$tmpdatafield = "";
			$tmpfilteroperator = "";
			for ($i=0; $i < $filterscount; $i++)
		    {
				// get the filter's value.
				$filtervalue = $_GET["filtervalue" . $i];
				// get the filter's condition.
				$filtercondition = $_GET["filtercondition" . $i];
				// get the filter's column.
				$filterdatafield = $_GET["filterdatafield" . $i];
				$filterdatafield='co.'.$filterdatafield;
				// get the filter's operator.
				$filteroperator = $_GET["filteroperator" . $i];
				
				if ($tmpdatafield == "")
				{
					$tmpdatafield = $filterdatafield;			
				}
				else if ($tmpdatafield <> $filterdatafield)
				{
					$where .= ")AND(";
				}
				else if ($tmpdatafield == $filterdatafield)
				{
					if ($tmpfilteroperator == 0)
					{
						$where .= " AND ";
					}
					else $where .= " OR ";	
				}
				
				// build the "WHERE" clause depending on the filter's condition, value and datafield.
				switch($filtercondition)
				{
					case "CONTAINS":
						$where .= " " . $filterdatafield . " LIKE '%" . $filtervalue ."%'";
						break;
					case "DOES_NOT_CONTAIN":
						$where .= " " . $filterdatafield . " NOT LIKE '%" . $filtervalue ."%'";
						break;
					case "EQUAL":
						$where .= " " . $filterdatafield . " = '" . $filtervalue ."'";
						break;
					case "NOT_EQUAL":
						$where .= " " . $filterdatafield . " <> '" . $filtervalue ."'";
						break;
					case "GREATER_THAN":
						$where .= " " . $filterdatafield . " > '" . $filtervalue ."'";
						break;
					case "LESS_THAN":
						$where .= " " . $filterdatafield . " < '" . $filtervalue ."'";
						break;
					case "GREATER_THAN_OR_EQUAL":
						$where .= " " . $filterdatafield . " >= '" . $filtervalue ."'";
						break;
					case "LESS_THAN_OR_EQUAL":
						$where .= " " . $filterdatafield . " <= '" . $filtervalue ."'";
						break;
					case "STARTS_WITH":
						$where .= " " . $filterdatafield . " LIKE '" . $filtervalue ."%'";
						break;
					case "ENDS_WITH":
						$where .= " " . $filterdatafield . " LIKE '%" . $filtervalue ."'";
						break;
				}
								
				if ($i == $filterscount - 1)
				{
					$where .= ")";
				}
				
				$tmpfilteroperator = $filteroperator;
				$tmpdatafield = $filterdatafield;			
			}
			
			
			
			
			// build the query.
			$sql = $sql . $where;		
		}

	}
    //concatena filtra de ser el caso y pagina
	$sql=$sql." limit ".$start.",".$pagesize.";";
    //$query=$this->db->query($sql);
	//return $query;
	
	$query=$this->db->query($sql);
	$results=$query->result_array();
	$total=$this->found_rows();	
	
	$data[] = array(
	          'TotalRows' => $total,
		      'Rows' => $results
		    );
	return $data;
	
	}
	
	/*
	function bandeja($estado = NULL,$camp_id=NULL,$emp_id=NULL){
    	  switch($estado){
            case 'Nuevo': 
                $sql="SELECT cit.*, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
		        con.ciudad, 
		        (select GROUP_CONCAT(valor) from contactos_campos where estado='AC' and contacto_id=con.id and campo_id in (1,4)) as movil, 
			    (select GROUP_CONCAT(valor) from contactos_campos where estado='AC' and contacto_id=con.id and campo_id in (2,4)) as convencional,
			    con.direccion,
			    emp.ruc, emp.razon_social, cam.nombre as campana,  
			    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
			    FROM citas cit
			    LEFT JOIN contactos con ON cit.contacto_id = con.id 
			    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
			    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
			    where padre_id is null
			    and not exists (select * from citas where padre_id=cit.id and estado='AC')
			    and cit.estado='AC'
				and cit.campana_id=?
				and cit.empleado_id=?;";
	    	    $params = array($camp_id,$emp_id);
			    $query=$this->db->query($sql,$params);
			    //$query=$this->db->query($sql);
				return $query;
                break;
       
			case 'Confirmada':
				$sql="SELECT cit.*, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
		        con.ciudad,
		        (select GROUP_CONCAT(valor) from contactos_campos where estado='AC' and contacto_id=con.id and campo_id in (1,4)) as movil, 
			    (select GROUP_CONCAT(valor) from contactos_campos where estado='AC' and contacto_id=con.id and campo_id in (2,4)) as convencional,
			    con.direccion,
			    emp.ruc, emp.razon_social, cam.nombre as campana,
			    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
			    FROM citas cit
			    LEFT JOIN contactos con ON cit.contacto_id = con.id 
			    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
			    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
			    where padre_id is not null
			    and not exists (select * from citas where padre_id=cit.id and estado='AC')
				and cita_estado='Cita confirmada'
				and cit.estado='AC'
				and cit.campana_id=?
				and cit.empleado_id=?;";
				$params = array($camp_id,$emp_id);
			    $query=$this->db->query($sql,$params);
				//$query=$this->db->query($sql);
				return $query;
                break;
                
             case 'Asignada':
				$sql="SELECT cit.*, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
		        con.ciudad, con.direccion,
			    emp.ruc, emp.razon_social, cam.nombre as campana,
			    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
			    FROM citas cit
			    LEFT JOIN contactos con ON cit.contacto_id = con.id 
			    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
			    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
			    where padre_id is not null
			    and not exists (select * from citas where padre_id=cit.id and estado='AC')
				and cit.estado='AC'
				and cita_estado='Cita Asignada';";
				$query=$this->db->query($sql);
				return $query;
                break;
                
         	 case 'No Confirmada':
				$sql="SELECT cit.*, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
		        con.ciudad,
		        (select GROUP_CONCAT(valor) from contactos_campos where estado='AC' and contacto_id=con.id and campo_id in (1,4)) as movil, 
			    (select GROUP_CONCAT(valor) from contactos_campos where estado='AC' and contacto_id=con.id and campo_id in (2,4)) as convencional,
			    con.direccion,
			    emp.ruc, emp.razon_social, cam.nombre as campana,
			    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
			    FROM citas cit
			    LEFT JOIN contactos con ON cit.contacto_id = con.id 
			    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
			    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
			    where padre_id is not null
			    and not exists (select * from citas where padre_id=cit.id and estado='AC')
				and cita_estado='Cita no confirmada'
				and cit.estado='AC'
				and cit.campana_id=?
				and cit.empleado_id=?;";
				$params = array($camp_id,$emp_id);
			    $query=$this->db->query($sql,$params);
				return $query;
				break;
                
			 case 'Mala Cita':
				$sql="SELECT cit.*, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
		        con.ciudad,
		        (select GROUP_CONCAT(valor) from contactos_campos where estado='AC' and contacto_id=con.id and campo_id in (1,4)) as movil, 
			    (select GROUP_CONCAT(valor) from contactos_campos where estado='AC' and contacto_id=con.id and campo_id in (2,4)) as convencional,
			    con.direccion,
			    emp.ruc, emp.razon_social, cam.nombre as campana,
			    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
			    FROM citas cit
			    LEFT JOIN contactos con ON cit.contacto_id = con.id 
			    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
			    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
			    where padre_id is not null
			    and not exists (select * from citas where padre_id=cit.id and estado='AC')
				and cita_estado='Mala cita'
				and cit.estado='AC'
				and cit.campana_id=?
				and cit.empleado_id=?;";
				$params = array($camp_id,$emp_id);
			    $query=$this->db->query($sql,$params);
				return $query;
				break;
                
			 case 'Cancelo Cita':
				$sql="SELECT cit.*, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
		        con.ciudad,
		        (select GROUP_CONCAT(valor) from contactos_campos where estado='AC' and contacto_id=con.id and campo_id in (1,4)) as movil, 
			    (select GROUP_CONCAT(valor) from contactos_campos where estado='AC' and contacto_id=con.id and campo_id in (2,4)) as convencional,
			    con.direccion,
			    emp.ruc, emp.razon_social, cam.nombre as campana,
			    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
			    FROM citas cit
			    LEFT JOIN contactos con ON cit.contacto_id = con.id 
			    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
			    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
			    where padre_id is not null
			    and not exists (select * from citas where padre_id=cit.id and estado='AC')
				and cita_estado='Cancelo cita'
				and cit.estado='AC'
				and cit.campana_id=?
				and cit.empleado_id=?;";
				$params = array($camp_id,$emp_id);
			    $query=$this->db->query($sql,$params);
				return $query;
				break;
                
			 case 'Postergo Cita':
				$sql="SELECT cit.*, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
		        con.ciudad,
		        (select GROUP_CONCAT(valor) from contactos_campos where estado='AC' and contacto_id=con.id and campo_id in (1,4)) as movil, 
			    (select GROUP_CONCAT(valor) from contactos_campos where estado='AC' and contacto_id=con.id and campo_id in (2,4)) as convencional,
			    con.direccion,
			    emp.ruc, emp.razon_social, cam.nombre as campana,
			    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
			    FROM citas cit
			    LEFT JOIN contactos con ON cit.contacto_id = con.id 
			    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
			    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
			    where padre_id is not null
			    and not exists (select * from citas where padre_id=cit.id and estado='AC')
				and cita_estado='Postergo cita'
				and cit.estado='AC'
				and cit.campana_id=?
				and cit.empleado_id=?;
				and cit.estado='AC'";
				$params = array($camp_id,$emp_id);
			    $query=$this->db->query($sql,$params);
				return $query;
				break;
		 
		  }	  
		} 
		
	function citas_asignadas($emp_id = NULL){
						
				$sql="SELECT cit.*, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
		        con.ciudad, con.direccion, con.telefono as movil, 
			    emp.ruc, emp.razon_social, cam.nombre as campana,
                CONCAT(ges.apellidos, ' ', ges.nombres) as gestor,
			    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
			    FROM citas cit
			    LEFT JOIN llamadas lla ON cit.llamada_id = lla.id 
			    LEFT JOIN contactos con ON cit.contacto_id = con.id 
			    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
			    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
			    LEFT JOIN empleados col ON cit.empleado_id = col.id
			    LEFT JOIN empleados ges ON lla.empleado_id = ges.id
			    where cit.padre_id is not null
			    and cit.empleado_id=?
			    and cit.cita_estado='Cita Asignada'
			    and cit.estado='AC'
			    and not exists (select * from citas where padre_id=cit.id and estado='AC');";
				
				$params = array($emp_id);
				$query=$this->db->query($sql,$params);
				return $query;
		}*/
	/*	
	function ventas_completadas($emp_id = NULL){
			
			    $sql="SELECT cit.*, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
		        con.ciudad, con.direccion, con.telefono as movil, 
			    emp.ruc, emp.razon_social, cam.nombre as campana,
                CONCAT(ges.apellidos, ' ', ges.nombres) as gestor,
			    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
			    FROM citas cit
			    LEFT JOIN llamadas lla ON cit.llamada_id = lla.id 
			    LEFT JOIN contactos con ON cit.contacto_id = con.id 
			    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
			    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
			    LEFT JOIN empleados col ON cit.empleado_id = col.id
			    LEFT JOIN empleados ges ON lla.empleado_id = ges.id
			    where cit.padre_id is not null
			    and cit.empleado_id=?
			    and cit.cita_estado='Venta Completa'
			    and cit.estado='AC'
			    and not exists (select * from citas where padre_id=cit.id and estado='AC');";
			    
			    
				$params = array($emp_id);
				$query=$this->db->query($sql,$params);
				return $query;
		}
		
	function ventas_incompletadas($emp_id = NULL){
		
		 	$sql="SELECT cit.*, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
		        con.ciudad, con.direccion, con.telefono as movil, 
			    emp.ruc, emp.razon_social, cam.nombre as campana,
                CONCAT(ges.apellidos, ' ', ges.nombres) as gestor,
			    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
			    FROM citas cit
			    LEFT JOIN llamadas lla ON cit.llamada_id = lla.id 
			    LEFT JOIN contactos con ON cit.contacto_id = con.id 
			    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
			    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
			    LEFT JOIN empleados col ON cit.empleado_id = col.id
			    LEFT JOIN empleados ges ON lla.empleado_id = ges.id
			    where cit.padre_id is not null
			    and cit.empleado_id=?
			    and cit.cita_estado='Venta Incompleta'
			    and cit.estado='AC'
			    and not exists (select * from citas where padre_id=cit.id and estado='AC');";
		 	 
				$params = array($emp_id);
				$query=$this->db->query($sql,$params);
				return $query;
		}
	*/
	function regestion_ventas_incompletadas($camp_id=NULL,$emp_id = NULL){
			$sql="SELECT cit.*, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
		        con.ciudad, con.direccion, con.telefono as movil, 
			    emp.ruc, emp.razon_social, cam.nombre as campana,
                (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
			    FROM citas cit
                LEFT JOIN llamadas lla ON cit.llamada_id = lla.id 
			    LEFT JOIN contactos con ON cit.contacto_id = con.id 
			    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
			    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
			    LEFT JOIN empleados col ON cit.empleado_id = col.id
			    where cit.padre_id is not null
			    and cit.campana_id=?
                and lla.empleado_id=?
			    and cit.cita_estado='Venta Incompleta'
			    and cit.estado='AC'
			    and not exists (select * from citas where padre_id=cit.id and estado='AC');";
				$params = array($camp_id,$emp_id);
				$query=$this->db->query($sql,$params);
				return $query;
		}
	/*	
	function interesados($emp_id = NULL){
				$sql="SELECT cit.*, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
		        con.ciudad, con.direccion, con.telefono as movil, 
			    emp.ruc, emp.razon_social, cam.nombre as campana,
                CONCAT(ges.apellidos, ' ', ges.nombres) as gestor,
			    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
			    FROM citas cit
			    LEFT JOIN llamadas lla ON cit.llamada_id = lla.id 
			    LEFT JOIN contactos con ON cit.contacto_id = con.id 
			    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
			    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
			    LEFT JOIN empleados col ON cit.empleado_id = col.id
			    LEFT JOIN empleados ges ON lla.empleado_id = ges.id
			    where cit.padre_id is not null
			    and cit.empleado_id=?
			    and cit.cita_estado='Interesado'
			    and cit.estado='AC'
			    and not exists (select * from citas where padre_id=cit.id and estado='AC');";
				$params = array($emp_id);
				$query=$this->db->query($sql,$params);
				return $query;
		}
	*/	
	function regestion_interesados($camp_id=NULL,$emp_id=NULL){
				$sql="SELECT cit.*, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
		        con.ciudad, con.direccion, con.telefono as movil, 
			    emp.ruc, emp.razon_social, cam.nombre as campana,
                (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
			    FROM citas cit
                LEFT JOIN llamadas lla ON cit.llamada_id = lla.id 
			    LEFT JOIN contactos con ON cit.contacto_id = con.id 
			    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
			    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
			    LEFT JOIN empleados col ON cit.empleado_id = col.id
			    where cit.padre_id is not null
			    and cit.campana_id=?
                and lla.empleado_id=?
			    and cit.cita_estado='Interesado'
			    and cit.estado='AC'
			    and not exists (select * from citas where padre_id=cit.id and estado='AC');";
				$params = array($camp_id,$emp_id);
				$query=$this->db->query($sql,$params);
				return $query;
		}
	/*	
	function nointeresados($emp_id = NULL){
		    
			$sql="SELECT cit.*, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
		        con.ciudad, con.direccion, con.telefono as movil, 
			    emp.ruc, emp.razon_social, cam.nombre as campana,
                CONCAT(ges.apellidos, ' ', ges.nombres) as gestor,
			    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
			    FROM citas cit
			    LEFT JOIN llamadas lla ON cit.llamada_id = lla.id 
			    LEFT JOIN contactos con ON cit.contacto_id = con.id 
			    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
			    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
			    LEFT JOIN empleados col ON cit.empleado_id = col.id
			    LEFT JOIN empleados ges ON lla.empleado_id = ges.id
			    where cit.padre_id is not null
			    and cit.empleado_id=?
			    and cit.cita_estado='No Interesado'
			    and cit.estado='AC'
			    and not exists (select * from citas where padre_id=cit.id and estado='AC');";
				
				$params = array($emp_id);
				$query=$this->db->query($sql,$params);
				return $query;
		}
	 */
	function regestion_nointeresados($camp_id=NULL,$emp_id=NULL){
		
		 $sql="SELECT cit.*, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
		        con.ciudad, con.direccion, con.telefono as movil, 
			    emp.ruc, emp.razon_social, cam.nombre as campana,
                (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
			    FROM citas cit
                LEFT JOIN llamadas lla ON cit.llamada_id = lla.id 
			    LEFT JOIN contactos con ON cit.contacto_id = con.id 
			    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
			    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
			    LEFT JOIN empleados col ON cit.empleado_id = col.id
			    where cit.padre_id is not null
			    and cit.campana_id=?
                and lla.empleado_id=?
			    and cit.cita_estado='No Interesado'
			    and cit.estado='AC'
			    and not exists (select * from citas where padre_id=cit.id and estado='AC');";
				$params = array($camp_id,$emp_id);
				$query=$this->db->query($sql,$params);
				return $query;
		}
		
	
		
	function citascanceladas($emp_id = NULL){
		
		  $sql="SELECT cit.*, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
		        con.ciudad, con.direccion, con.telefono as movil, 
			    emp.ruc, emp.razon_social, cam.nombre as campana,
                CONCAT(ges.apellidos, ' ', ges.nombres) as gestor,
			    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
			    FROM citas cit
			    LEFT JOIN llamadas lla ON cit.llamada_id = lla.id 
			    LEFT JOIN contactos con ON cit.contacto_id = con.id 
			    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
			    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
			    LEFT JOIN empleados col ON cit.empleado_id = col.id
			    LEFT JOIN empleados ges ON lla.empleado_id = ges.id
			    where cit.padre_id is not null
			    and cit.empleado_id=?
			    and cit.cita_estado='Cita cancelada'
			    and cit.estado='AC'
			    and not exists (select * from citas where padre_id=cit.id and estado='AC');";
				$params = array($emp_id);
				$query=$this->db->query($sql,$params);
				return $query;
		}
	function regestion_citascanceladas($camp_id=NULL,$emp_id=NULL){
			$sql="SELECT cit.*, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
		        con.ciudad, con.direccion, con.telefono as movil, 
			    emp.ruc, emp.razon_social, cam.nombre as campana,
                (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
			    FROM citas cit
                LEFT JOIN llamadas lla ON cit.llamada_id = lla.id 
			    LEFT JOIN contactos con ON cit.contacto_id = con.id 
			    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
			    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
			    LEFT JOIN empleados col ON cit.empleado_id = col.id
			    where cit.padre_id is not null
			    and cit.campana_id=?
                and lla.empleado_id=?
			    and cit.cita_estado='Cita cancelada'
			    and cit.estado='AC'
			    and not exists (select * from citas where padre_id=cit.id and estado='AC');";
				$params = array($camp_id,$emp_id);
				$query=$this->db->query($sql,$params);
				return $query;
		}
	
	function novisitados($emp_id = NULL){
		/*
			$sql="SELECT cit.*, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
		        con.ciudad, con.direccion, con.telefono as movil, 
			    emp.ruc, emp.razon_social, cam.nombre as campana,
			    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
			    FROM citas cit
			    LEFT JOIN contactos con ON cit.contacto_id = con.id 
			    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
			    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
			    LEFT JOIN empleados col ON cit.empleado_id = col.id
			    where padre_id is not null
			    and cit.empleado_id=?
			    and cit.cita_estado='No visitado'
			    and cit.estado='AC'
			    and not exists (select * from citas where padre_id=cit.id and estado='AC');";
		 */
		 $sql="SELECT cit.*, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
		        con.ciudad, con.direccion, con.telefono as movil, 
			    emp.ruc, emp.razon_social, cam.nombre as campana,
                CONCAT(ges.apellidos, ' ', ges.nombres) as gestor,
			    (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
			    FROM citas cit
			    LEFT JOIN llamadas lla ON cit.llamada_id = lla.id 
			    LEFT JOIN contactos con ON cit.contacto_id = con.id 
			    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
			    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
			    LEFT JOIN empleados col ON cit.empleado_id = col.id
			    LEFT JOIN empleados ges ON lla.empleado_id = ges.id
			    where cit.padre_id is not null
			    and cit.empleado_id=?
			    and cit.cita_estado='No visitado'
			    and cit.estado='AC'
			    and not exists (select * from citas where padre_id=cit.id and estado='AC');";
		 
				$params = array($emp_id);
				$query=$this->db->query($sql,$params);
				return $query;
		}
	
	function regestion_novisitados($camp_id=NULL,$emp_id=NULL){
			$sql="SELECT cit.*, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
		        con.ciudad, con.direccion, con.telefono as movil, 
			    emp.ruc, emp.razon_social, cam.nombre as campana,
                (select min(inicio) from citas_agendas where cita_id=cit.id and estado='AC') as fecha_hora 
			    FROM citas cit
                LEFT JOIN llamadas lla ON cit.llamada_id = lla.id 
			    LEFT JOIN contactos con ON cit.contacto_id = con.id 
			    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
			    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
			    LEFT JOIN empleados col ON cit.empleado_id = col.id
			    where cit.padre_id is not null
			    and cit.campana_id=?
                and lla.empleado_id=?
			    and cit.cita_estado='No visitado'
			    and cit.estado='AC'
			    and not exists (select * from citas where padre_id=cit.id and estado='AC');";
				$params = array($camp_id,$emp_id);
				$query=$this->db->query($sql,$params);
				return $query;
		}
		  
    function agenda_empleado($emp_id = NULL){
		  	
			$sql="SELECT age.id,
		        age.cita_id,
				DATE_FORMAT(age.inicio, '%Y-%m-%dT%T') as start,
				DATE_FORMAT(age.fin, '%Y-%m-%dT%T') as end,
				age.texto as title,
				age.estado,				
				con.identificacion as con_identificacion, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
		        con.ciudad, con.direccion,
			    emp.ruc, emp.razon_social, cam.nombre as campana, col.id as col_id, col.identificacion as col_identificacion, 
                CONCAT(col.apellidos, ' ', col.nombres) as colaborador
			    FROM citas_agendas age
                LEFT JOIN citas cit ON age.cita_id = cit.id 
			    LEFT JOIN contactos con ON cit.contacto_id = con.id 
			    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
			    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
                LEFT JOIN empleados col ON cit.empleado_id = col.id
			    where padre_id is not null
			    and col.id=?
			    and not exists (select * from citas where padre_id=cit.id and estado='AC')
			    and cit.estado='AC'
				and cita_estado='Cita asignada';";
				$params = array($emp_id);
				$query=$this->db->query($sql,$params);
				return $query;
                
		  	
		}
		   
		    
	
		
}