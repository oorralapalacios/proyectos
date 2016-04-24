<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contacto_Campana extends DataMapper {
    var $extensions = array('json');
    var $table = 'contactos_campanas';
	var $has_one = array('contacto');

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	
	function import($sql){
		$query=$this->db->query($sql);
		return $query;
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
		      case 'GC'://Asignados y reasiganados gestion de contactos
		           $sql="select SQL_CALC_FOUND_ROWS cc.id, cc.id as contacto_campana_id, cc.contacto_id,cc.empleado_id,cc.observaciones,cc.campana_id, co.identificacion,
					co.nombres,co.apellidos,co.ciudad,co.direccion,
					cc.telefono as movil, cc.fecha_hora,
	                cc.fecha_ing,cc.fecha_mod,cc.estado, 
					CONCAT(em.nombres, '  ',em.apellidos) as empleado, ca.nombre as campana,
					CASE WHEN EXISTS (
					    SELECT * 
					     FROM citas
					     WHERE tipo_gestion IN ('GESTION','REGESTION')
					     and contacto_campana_id=cc.id
					  ) THEN 'REGESTION' ELSE 'GESTION' END AS tipo_gestion,
					(select id from citas where estado='AC' and contacto_campana_id=cc.id order by fecha_ing desc limit 1 )as cita_id,
					(select llamada_estado from llamadas where contacto_campana_id=cc.id and estado='AC' order by fecha_ing desc
					 limit 1)  as estado_llamada
					from contactos_campanas cc, campanas ca, contactos co, empleados em
					where cc.campana_id=ca.id
					and cc.contacto_id=co.id
					and cc.empleado_id=em.id
					and not exists (select * from llamadas where contacto_campana_id=cc.id and estado='AC'
	            	and respuesta_recibida not in ('Cancelada','No contestada','Fuera de servicio','Ninguna') )
					and cc.campana_id=".$camp_id."
					and cc.empleado_id=".$emp_id."
					and cc.estado in ('AC')
					and cc.bandeja='".$bandeja."'
					and cc.fecha_ing in (select max(fecha_ing) from contactos_campanas where contacto_id=co.id
					                 and telefono=cc.telefono 
				                     and campana_id=".$camp_id." and estado='AC'  )
					";
			      break;
			  case 'ST': //Asignados y reasiganados con seguimiento telefónico
		           $sql="select SQL_CALC_FOUND_ROWS cc.id, cc.id as contacto_campana_id, cc.contacto_id,cc.empleado_id,cc.observaciones,cc.campana_id, co.identificacion,
					co.nombres,co.apellidos,co.ciudad,co.direccion,
					cc.telefono as movil, cc.fecha_hora,
	                cc.fecha_ing,cc.fecha_mod,cc.estado, 
					CONCAT(em.nombres, '  ',em.apellidos) as empleado, ca.nombre as campana,
					CASE WHEN EXISTS (
					    SELECT * 
					     FROM citas
					     WHERE tipo_gestion IN ('GESTION','REGESTION')
					     and contacto_campana_id=cc.id
					  ) THEN 'REGESTION' ELSE 'GESTION' END AS tipo_gestion,
					(select id from citas where estado='AC' and contacto_campana_id=cc.id order by fecha_ing desc limit 1 )as cita_id,  
					(select llamada_estado from llamadas where contacto_campana_id=cc.id and estado='AC' order by fecha_ing desc
					 limit 1)  as estado_llamada
					from contactos_campanas cc, campanas ca, contactos co, empleados em
					where cc.campana_id=ca.id
					and cc.contacto_id=co.id
					and cc.empleado_id=em.id
					and not exists (select * from llamadas where contacto_campana_id=cc.id and estado='AC'
	            	and respuesta_recibida not in ('Cancelada','No contestada','Fuera de servicio','Ninguna') )
					and cc.campana_id=".$camp_id."
					and cc.empleado_id=".$emp_id."
					and cc.estado in ('AC')
					and cc.bandeja='ST'
					and cc.fecha_ing in (select max(fecha_ing) from contactos_campanas where contacto_id=co.id
					                 and telefono=cc.telefono 
				                     and campana_id=".$camp_id." and estado='AC'  )
								 
					";
		          break;    
			      
			      case 'IN': //Asignados y reasiganados con seguimiento telefónico
		           $sql="select SQL_CALC_FOUND_ROWS cc.id, cc.id as contacto_campana_id, cc.contacto_id,cc.empleado_id,cc.observaciones,cc.campana_id, co.identificacion,
					co.nombres,co.apellidos,co.ciudad,co.direccion,
					cc.telefono as movil, cc.fecha_hora,
	                cc.fecha_ing,cc.fecha_mod,cc.estado, 
					CONCAT(em.nombres, '  ',em.apellidos) as empleado, ca.nombre as campana,
					CASE WHEN EXISTS (
					    SELECT * 
					     FROM citas
					     WHERE tipo_gestion IN ('GESTION','REGESTION')
					     and contacto_campana_id=cc.id
					  ) THEN 'REGESTION' ELSE 'GESTION' END AS tipo_gestion,
					(select id from citas where estado='AC' and contacto_campana_id=cc.id order by fecha_ing desc limit 1 )as cita_id,  
					(select llamada_estado from llamadas where contacto_campana_id=cc.id and estado='AC' order by fecha_ing desc
					 limit 1)  as estado_llamada
					from contactos_campanas cc, campanas ca, contactos co, empleados em
					where cc.campana_id=ca.id
					and cc.contacto_id=co.id
					and cc.empleado_id=em.id
					and not exists (select * from llamadas where contacto_campana_id=cc.id and estado='AC'
	            	and respuesta_recibida not in ('Cancelada','No contestada','Fuera de servicio','Ninguna') )
					and cc.campana_id=".$camp_id."
					and cc.empleado_id=".$emp_id."
					and cc.estado in ('AC')
					and cc.bandeja='IN'
					and cc.fecha_ing in (select max(fecha_ing) from contactos_campanas where contacto_id=co.id
					                 and telefono=cc.telefono 
				                     and campana_id=".$camp_id." and estado='AC'  )
								 
					";
		          break;
			      
			      
		      case 'STA': //Asignados y reasiganados con seguimiento telefónico
		           $sql="select SQL_CALC_FOUND_ROWS cc.id, cc.id as contacto_campana_id, cc.contacto_id,cc.empleado_id,cc.observaciones,cc.campana_id, co.identificacion,
					co.nombres,co.apellidos,co.ciudad,co.direccion,
					cc.telefono as movil, cc.fecha_hora,
	                cc.fecha_ing,cc.fecha_mod,cc.estado, 
					CONCAT(em.nombres, '  ',em.apellidos) as empleado, ca.nombre as campana,
					CASE WHEN EXISTS (
					    SELECT * 
					     FROM citas
					     WHERE tipo_gestion IN ('GESTION','REGESTION')
					     and contacto_campana_id=cc.id
					  ) THEN 'REGESTION' ELSE 'GESTION' END AS tipo_gestion,
					(select id from citas where estado='AC' and contacto_campana_id=cc.id order by fecha_ing desc limit 1 )as cita_id,  
					(select llamada_estado from llamadas where contacto_campana_id=cc.id and estado='AC' order by fecha_ing desc
					 limit 1)  as estado_llamada
					from contactos_campanas cc, campanas ca, contactos co, empleados em
					where cc.campana_id=ca.id
					and cc.contacto_id=co.id
					and cc.empleado_id=em.id
					and not exists (select * from llamadas where contacto_campana_id=cc.id and estado='AC'
	            	and respuesta_recibida not in ('Cancelada','No contestada','Fuera de servicio','Ninguna') )
					and cc.campana_id=".$camp_id."
					and cc.empleado_id=".$emp_id."
					and cc.estado in ('AC')
					and cc.bandeja='ST'
					and cc.fecha_ing in (select max(fecha_ing) from contactos_campanas where contacto_id=co.id
					                 and telefono=cc.telefono 
				                     and campana_id=".$camp_id." and estado='AC'  )
					and (select llamada_estado from llamadas where contacto_campana_id=cc.id and estado='AC' order by fecha_ing desc
					 limit 1) IS NULL				 
					";
		          break;
		      case 'STR': //Asignados y reasiganados con seguimiento telefónico registro
		           $sql="select SQL_CALC_FOUND_ROWS cc.id, cc.id as contacto_campana_id, cc.contacto_id,cc.empleado_id,cc.observaciones,cc.campana_id, co.identificacion,
					co.nombres,co.apellidos,co.ciudad,co.direccion,
					cc.telefono as movil, cc.fecha_hora,
	                cc.fecha_ing,cc.fecha_mod,cc.estado, 
					CONCAT(em.nombres, '  ',em.apellidos) as empleado, ca.nombre as campana,
					CASE WHEN EXISTS (
					    SELECT * 
					     FROM citas
					     WHERE tipo_gestion IN ('GESTION','REGESTION')
					     and contacto_campana_id=cc.id
					  ) THEN 'REGESTION' ELSE 'GESTION' END AS tipo_gestion,
					(select id from citas where estado='AC' and contacto_campana_id=cc.id order by fecha_ing desc limit 1 )as cita_id,  
					(select llamada_estado from llamadas where contacto_campana_id=cc.id and estado='AC' order by fecha_ing desc
					 limit 1)  as estado_llamada
					from contactos_campanas cc, campanas ca, contactos co, empleados em
					where cc.campana_id=ca.id
					and cc.contacto_id=co.id
					and cc.empleado_id=em.id
					and not exists (select * from llamadas where contacto_campana_id=cc.id and estado='AC'
	            	and respuesta_recibida not in ('Cancelada','No contestada','Fuera de servicio','Ninguna') )
					and cc.campana_id=".$camp_id."
					and cc.empleado_id=".$emp_id."
					and cc.estado in ('AC')
					and cc.bandeja='ST'
					and cc.fecha_ing in (select max(fecha_ing) from contactos_campanas where contacto_id=co.id
					                 and telefono=cc.telefono 
				                     and campana_id=".$camp_id." and estado='AC'  )
					and (select llamada_estado from llamadas where contacto_campana_id=cc.id and estado='AC' order by fecha_ing desc
					 limit 1) IS NOT NULL
					";
		          break;   
		      case 'EQ'://Equivocados
		          $sql="select SQL_CALC_FOUND_ROWS * from(
	               select cc.id,cc.id as contacto_campana_id, cc.contacto_id,cc.empleado_id,cc.observaciones,cc.campana_id, co.identificacion,
					co.nombres,co.apellidos,co.ciudad,co.direccion,
					cc.telefono as movil, 
	                cc.fecha_ing,cc.fecha_mod,cc.estado, 
					CONCAT(em.nombres, '  ',em.apellidos) as empleado, ca.nombre as campana,
					CASE WHEN EXISTS (
					    SELECT * 
					     FROM citas
					     WHERE tipo_gestion IN ('GESTION','REGESTION')
					     and contacto_campana_id=cc.id
					  ) THEN 'REGESTION' ELSE 'GESTION' END AS tipo_gestion,
					 (select id from citas where estado='AC' and contacto_campana_id=cc.id order by fecha_ing desc limit 1 )as cita_id,
	                 (select max(fecha_ing) from llamadas where contacto_campana_id=cc.id
					 and respuesta_recibida not in ('Cancelada','No contestada','Fuera de servicio','Ninguna')) as fecha_hora,
	                 (select respuesta_recibida from llamadas where contacto_campana_id=cc.id
	                 and respuesta_recibida not in ('Cancelada','No contestada','Fuera de servicio','Ninguna')
	                 order by fecha_ing desc limit 1) respuesta_recibida
	     		    from contactos_campanas cc, campanas ca, contactos co, empleados em
					where cc.campana_id=ca.id
					and cc.contacto_id=co.id
					and cc.empleado_id=em.id
	                and exists (select * from llamadas where contacto_campana_id=cc.id)
					and not exists (select * from contactos_campanas where padre_id=cc.id and bandeja='ST')
                    and not exists (select * from citas where contacto_campana_id=cc.id)
	                and cc.campana_id=".$camp_id."
					and cc.empleado_id=".$emp_id."
					) as bandeja
	                where estado in ('AC')
	                and respuesta_recibida in ('Número equivocado')"; 
		          break;
		          
		      case 'NT'://No titulares
		      $sql="select SQL_CALC_FOUND_ROWS * from(
               select cc.id,cc.id as contacto_campana_id,cc.contacto_id,cc.empleado_id,cc.observaciones,cc.campana_id, co.identificacion,
				co.nombres,co.apellidos,co.ciudad,co.direccion,
				cc.telefono as movil, 
                cc.fecha_ing,cc.fecha_mod,cc.estado, 
				CONCAT(em.nombres, '  ',em.apellidos) as empleado, ca.nombre as campana,
				CASE WHEN EXISTS (
					    SELECT * 
					     FROM citas
					     WHERE tipo_gestion IN ('GESTION','REGESTION')
					     and contacto_campana_id=cc.id
					  ) THEN 'REGESTION' ELSE 'GESTION' END AS tipo_gestion,
			     (select id from citas where estado='AC' and contacto_campana_id=cc.id order by fecha_ing desc limit 1 )as cita_id,
				 (select max(fecha_ing) from llamadas where contacto_campana_id=cc.id
				 and respuesta_recibida not in ('Cancelada','No contestada','Fuera de servicio','Ninguna')) as fecha_hora,
                 (select respuesta_recibida from llamadas where contacto_campana_id=cc.id
                 and respuesta_recibida not in ('Cancelada','No contestada','Fuera de servicio','Ninguna')
                 order by fecha_ing desc limit 1) respuesta_recibida
     		    from contactos_campanas cc, campanas ca, contactos co, empleados em
				where cc.campana_id=ca.id
				and cc.contacto_id=co.id
				and cc.empleado_id=em.id
                and exists (select * from llamadas where contacto_campana_id=cc.id)
				and not exists (select * from contactos_campanas where padre_id=cc.id and bandeja='ST')
                and not exists (select * from citas where contacto_campana_id=cc.id)
                and cc.campana_id=".$camp_id."
				and cc.empleado_id=".$emp_id."
				) as bandeja
                where estado in ('AC')
                and respuesta_recibida in ('No es titular')";
		        break;
		        case 'NI': //No interesados
		        $sql="select SQL_CALC_FOUND_ROWS * from(
	                select cc.id, cc.id as contacto_campana_id, cc.contacto_id,cc.empleado_id,cc.observaciones,cc.campana_id, co.identificacion,
					co.nombres,co.apellidos,co.ciudad,co.direccion,
					cc.telefono as movil, 
	                cc.fecha_ing,cc.fecha_mod,cc.estado, 
					CONCAT(em.nombres, '  ',em.apellidos) as empleado, ca.nombre as campana,
					CASE WHEN EXISTS (
					    SELECT * 
					     FROM citas
					     WHERE tipo_gestion IN ('GESTION','REGESTION')
					     and contacto_campana_id=cc.id
					  ) THEN 'REGESTION' ELSE 'GESTION' END AS tipo_gestion,
					 (select id from citas where estado='AC' and contacto_campana_id=cc.id order by fecha_ing desc limit 1 )as cita_id,
					 (select llamada_estado from llamadas where contacto_campana_id=cc.id and estado='AC' order by fecha_ing desc
					 limit 1)  as actividad,
	                 (select max(fecha_ing) from llamadas where contacto_campana_id=cc.id
					 and respuesta_recibida not in ('Cancelada','No contestada','Fuera de servicio','Ninguna')) as fecha_hora,
	                 (select respuesta_recibida from llamadas where contacto_campana_id=cc.id
	                 and respuesta_recibida not in ('Cancelada','No contestada','Fuera de servicio','Ninguna')
	                 order by fecha_ing desc limit 1) respuesta_recibida
	     		    from contactos_campanas cc, campanas ca, contactos co, empleados em
					where cc.campana_id=ca.id
					and cc.contacto_id=co.id
					and cc.empleado_id=em.id
	                and exists (select * from llamadas where contacto_campana_id=cc.id)
	                and not exists (select * from contactos_campanas where padre_id=cc.id and bandeja='ST')
					and not exists (select * from citas where contacto_campana_id=cc.id)
	                and cc.campana_id=".$camp_id."
					and cc.empleado_id=".$emp_id."
					) as bandeja
	                where estado in ('AC')
					and respuesta_recibida in ('No interesado')";
		        
		         break; 
		         
		         case 'FC'://Fuera de cobertura
		         $sql="select SQL_CALC_FOUND_ROWS * from(
	                select cc.id, cc.id as contacto_campana_id, cc.contacto_id,cc.empleado_id,cc.observaciones,cc.campana_id, co.identificacion,
					co.nombres,co.apellidos,co.ciudad,co.direccion,
					cc.telefono as movil, 
	                cc.fecha_ing,cc.fecha_mod,cc.estado, 
					CONCAT(em.nombres, '  ',em.apellidos) as empleado, ca.nombre as campana,
					CASE WHEN EXISTS (
					    SELECT * 
					     FROM citas
					     WHERE tipo_gestion IN ('GESTION','REGESTION')
					     and contacto_campana_id=cc.id
					  ) THEN 'REGESTION' ELSE 'GESTION' END AS tipo_gestion,
					 (select id from citas where estado='AC' and contacto_campana_id=cc.id order by fecha_ing desc limit 1 )as cita_id,
					 (select max(fecha_ing) from llamadas where contacto_campana_id=cc.id
					 and respuesta_recibida not in ('Cancelada','No contestada','Fuera de servicio','Ninguna')) as fecha_hora,
	                 (select respuesta_recibida from llamadas where contacto_campana_id=cc.id
	                 and respuesta_recibida not in ('Cancelada','No contestada','Fuera de servicio','Ninguna')
	                 order by fecha_ing desc limit 1) respuesta_recibida
	     		    from contactos_campanas cc, campanas ca, contactos co, empleados em
					where cc.campana_id=ca.id
					and cc.contacto_id=co.id
					and cc.empleado_id=em.id
	                and exists (select * from llamadas where contacto_campana_id=cc.id)
	                and not exists (select * from contactos_campanas where padre_id=cc.id and bandeja='ST')
					and not exists (select * from citas where contacto_campana_id=cc.id)
	                and cc.campana_id=".$camp_id."
					and cc.empleado_id=".$emp_id."
					) as bandeja
	                where estado in ('AC')
	                and respuesta_recibida in ('Fuera de cobertura')";
		         
		         break;
				 case 'PD'://Pago directo
				  $sql="select SQL_CALC_FOUND_ROWS * from(
	                select cc.id, cc.id as contacto_campana_id, cc.contacto_id,cc.empleado_id,cc.observaciones,cc.campana_id, co.identificacion,
					co.nombres,co.apellidos,co.ciudad,co.direccion,
					cc.telefono as movil, 
	                cc.fecha_ing,cc.fecha_mod,cc.estado, 
					CONCAT(em.nombres, '  ',em.apellidos) as empleado, ca.nombre as campana,
					CASE WHEN EXISTS (
					    SELECT * 
					     FROM citas
					     WHERE tipo_gestion IN ('GESTION','REGESTION')
					     and contacto_campana_id=cc.id
					  ) THEN 'REGESTION' ELSE 'GESTION' END AS tipo_gestion,
					 (select id from citas where estado='AC' and contacto_campana_id=cc.id order by fecha_ing desc limit 1 )as cita_id,
					 (select max(fecha_ing) from llamadas where contacto_campana_id=cc.id
					 and respuesta_recibida not in ('Cancelada','No contestada','Fuera de servicio','Ninguna')) as fecha_hora,
	                 (select respuesta_recibida from llamadas where contacto_campana_id=cc.id
	                 and respuesta_recibida not in ('Cancelada','No contestada','Fuera de servicio','Ninguna')
	                 order by fecha_ing desc limit 1) respuesta_recibida
	     		    from contactos_campanas cc, campanas ca, contactos co, empleados em
					where cc.campana_id=ca.id
					and cc.contacto_id=co.id
					and cc.empleado_id=em.id
	                and exists (select * from llamadas where contacto_campana_id=cc.id)
	                and not exists (select * from contactos_campanas where padre_id=cc.id and bandeja='ST')
					and not exists (select * from citas where contacto_campana_id=cc.id)
	                and cc.campana_id=".$camp_id."
					and cc.empleado_id=".$emp_id."
					) as bandeja
	                where estado in ('AC')
	                and respuesta_recibida in ('Pago Directo')";
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
	
function ultima_fecha_seguimiento_empleado($emp_id=null){
		$sql="select  cc.fecha_hora
				from contactos_campanas cc
				where cc.empleado_id=".$emp_id."
				and cc.estado in ('AC')
				and fecha_ing in (select max(fecha_ing) from contactos_campanas where empleado_id =".$emp_id." 
			                      and estado='AC'  )
                order by cc.fecha_hora desc
                limit 1;";
	    	//$params = array($emp_id);
			//$query=$this->db->query($sql,$params);
			$query=$this->db->query($sql);
			return $query;
		
	}	

	
	
 //bandeja mejorada filtra y pagina
 function pageContatoCampanas($conta_id){
	$pagenum = $_GET['pagenum'];
	$pagesize = $_GET['pagesize'];
	$start=$pagenum*$pagesize;
       
	        $sql ="select SQL_CALC_FOUND_ROWS @rownum:=@rownum+1 AS rownum, cc.*,ca.nombre as campana,
	        concat(em.apellidos,' ',em.nombres) as gestor
	        from (SELECT @rownum:=0) r, contactos_campanas cc, campanas ca, empleados em
			where cc.campana_id=ca.id
			and cc.empleado_id=em.id
			and cc.estado='AC'
	        and cc.contacto_id = ".$conta_id."";
			/*
			$sql ="SELECT SQL_CALC_FOUND_ROWS *
	        FROM (llamadas, campanas)
	        WHERE llamadas.campana_id=campanas.id
	        and llamadas.estado='AC'
	        and llamadas.contacto_id = ".$conta_id."";*/

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
				$filterdatafield= $filterdatafield;
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
		
	
}