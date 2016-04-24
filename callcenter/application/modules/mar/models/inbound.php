<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contacto extends DataMapper {
    var $extensions = array('json');
    var $table = 'contactos';
	var $has_many = array('contacto_campo','contacto_campana','contacto_empresa','cita');
   
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
    
	
	function bandejapage($campana_id){
		   $pagenum = $_GET['pagenum'];
	       $pagesize = $_GET['pagesize'];
		   $start=$pagenum*$pagesize;
		
		    //Retorna contenido
		    /*
			$sql="select SQL_CALC_FOUND_ROWS co.*, 
			(select GROUP_CONCAT(concat(emp.nombres,' ',emp.apellidos,' (',cam.nombre,')')) from contactos_campanas,empleados emp,campanas cam where contacto_id=co.id and empleado_id=emp.id and campana_id=cam.id and campana_id=".$campana_id.") as gestor,
		    (select GROUP_CONCAT(concat(respuesta_recibida,' (',cam.nombre,')')) from llamadas, campanas cam where contacto_id=co.id and campana_id=cam.id and campana_id=".$campana_id." and respuesta_recibida not in ('Ninguna') ) as proceso 
			from contactos co, contactos_campanas cc 
			where cc.contacto_id=co.id
            and co.estado IN ('AC')
			and cc.estado IN ('AC')
            and cc.campana_id=".$campana_id."
            limit ".$start.",".$pagesize.";";
			*/
			$sql="select SQL_CALC_FOUND_ROWS co.* 
			from contactos co, contactos_campanas cc 
			where cc.contacto_id=co.id
            and co.estado IN ('AC')
			and cc.estado IN ('AC')
            and cc.campana_id=".$campana_id."
            limit ".$start.",".$pagesize.";";
			
			$query=$this->db->query($sql);
	        $results=$query->result_array();
	        $total=$this->found_rows();	
			$data[] = array(
	          'TotalRows' => $total,
		      'Rows' => $results
		    );
		    return $data;
	}

    
	function bandejasort($campana_id){
		   $pagenum = $_GET['pagenum'];
	       $pagesize = $_GET['pagesize'];
		   $start=$pagenum*$pagesize;
		
		    //Retorna registros con limites especificados del grid sin ordenar
			$sql="select SQL_CALC_FOUND_ROWS co.*
			from contactos co, contactos_campanas cc 
			where cc.contacto_id=co.id
            and co.estado IN ('AC')
			and cc.estado IN ('AC')
            and cc.campana_id=".$campana_id."
            
            limit ".$start.",".$pagesize.";";
			
			
			if (isset($_GET['sortdatafield']))
			{
				$sortfield = $_GET['sortdatafield'];
				$sortorder = $_GET['sortorder'];
				/*procesa query*/			
				$query=$this->db->query($sql);
			    $results=$query->result_array();
				/*calcula total general de registros*/
			    $sql="SELECT FOUND_ROWS() AS `found_rows`;";
			    $query=$this->db->query($sql);
			    $total=$this->found_rows();
				
				if ($sortfield != NULL)
				{
					/*Orden descendente*/
					if ($sortorder == "desc")
					{
						$sql="select SQL_CALC_FOUND_ROWS co.*
						from contactos co, contactos_campanas cc 
						where cc.contacto_id=co.id
			            and co.estado IN ('AC')
						and cc.estado IN ('AC')
			            and cc.campana_id=".$campana_id."
						ORDER BY" . " " . $sortfield . " DESC 
						limit ".$start.",".$pagesize.";";
					}
					/*Orden ascendente*/
					else if ($sortorder == "asc")
					{
						$sql="select SQL_CALC_FOUND_ROWS co.*
						from contactos co, contactos_campanas cc 
						where cc.contacto_id=co.id
			            and co.estado IN ('AC')
						and cc.estado IN ('AC')
			            and cc.campana_id=".$campana_id."
						ORDER BY" . " " . $sortfield . " ASC 
						limit ".$start.",".$pagesize.";";
					}
					/*procesa query*/			
					$query=$this->db->query($sql);
			        $results=$query->result_array();
					$total=$this->found_rows();	
				}
				
				
			}
			else
			{
				$query=$this->db->query($sql);
			    $results=$query->result_array();
				$total=$this->found_rows();	
			}
			
			
			//retornar arreglos
			//return $query;
			$data[] = array(
	          'TotalRows' => $total,
		      'Rows' => $results
		    );
		    return $data;
	}
	
	

	//bandeja mejorada filtra y pagina
	function bandejafilterall(){
	$pagenum = $_GET['pagenum'];
	$pagesize = $_GET['pagesize'];
	//  $pagenum = 1;
	//  $pagesize = 1;
	$start=$pagenum*$pagesize;

	       
            
            $sql="select  SQL_CALC_FOUND_ROWS co.*, cc.valor as movil,co.id as contacto_id
                  from contactos co
                  left join  contactos_campos cc on cc.contacto_id=co.id 
		  where co.estado IN ('AC') 
                  and cc.campo_id=1";
			      




    // filter data.
	if (isset($_GET['filterscount']))
	{
		$filterscount = $_GET['filterscount'];
		
		if ($filterscount > 0)
		{
			$where = " HAVING(";
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
				$filterdatafield=$filterdatafield;
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
	
	
	//bandeja mejorada filtra y pagina
	function bandejafilter($campana_id){
	$pagenum = $_GET['pagenum'];
	$pagesize = $_GET['pagesize'];
	$start=$pagenum*$pagesize;

	       
            
            $sql="select SQL_CALC_FOUND_ROWS co.*, co.id as contacto_id
			from contactos co, contactos_campanas cc 
			where cc.contacto_id=co.id
            and co.estado IN ('AC')
			and cc.estado IN ('AC')
            and cc.campana_id=".$campana_id."";




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
	
	
	function bandejabajas($campana_id){
			//(select GROUP_CONCAT(concat(emp.nombres,' ',emp.apellidos,' (',cam.nombre,')')) from contactos_campanas,empleados emp,campanas cam where contacto_id=co.id and empleado_id=emp.id and campana_id=cam.id and campana_id=".$campana_id.") as gestor,
			//(select GROUP_CONCAT(concat(respuesta_recibida,' (',cam.nombre,')')) from llamadas,campanas cam where contacto_id=co.id and campana_id=cam.id and campana_id=".$campana_id." and respuesta_recibida not in ('Ninguna') ) as proceso 
			
			$sql="select co.*, 
			co.telefono
			from contactos co, contactos_campanas cc 
			where cc.contacto_id=co.id
            and co.estado IN ('AC')
			and cc.estado IN ('BA')
            and cc.campana_id=".$campana_id."
			limit 50;";
			$query=$this->db->query($sql);
			return $query;
	}
	
	function bandejasingestor($campana_id){
		
		   //(select GROUP_CONCAT(concat(emp.nombres,' ',emp.apellidos,' (',cam.nombre,')')) from contactos_campanas,empleados emp,campanas cam where contacto_id=co.id and empleado_id=emp.id and campana_id=cam.id and campana_id=cc.campana_id) as gestor,
		   //(select GROUP_CONCAT(concat(respuesta_recibida,' (',cam.nombre,')')) from llamadas,campanas cam where contacto_id=co.id and campana_id=cam.id and campana_id=cc.campana_id and respuesta_recibida not in ('Ninguna') ) as proceso 
		
			$sql="select co.*,  cc.empleado_id,
			co.telefono
			from contactos co, contactos_campanas cc 
			where cc.contacto_id=co.id
            and co.estado IN ('AC')
			and cc.campana_id=".$campana_id."
            and (select GROUP_CONCAT(concat(emp.nombres,' ',emp.apellidos,' (',cam.nombre,')')) from contactos_campanas,empleados emp,campanas cam where contacto_id=co.id and empleado_id=emp.id and campana_id=cam.id and campana_id=cc.campana_id) is null
            limit 50;";
			$query=$this->db->query($sql);
			return $query;
	}
	
	
	function bandejabusquedasingestor($campana_id,$campo,$valor){
		    //(select GROUP_CONCAT(concat(emp.nombres,' ',emp.apellidos,' (',cam.nombre,')')) from contactos_campanas,empleados emp,campanas cam where contacto_id=co.id and empleado_id=emp.id and campana_id=cam.id and campana_id=cc.campana_id) as gestor,
			//(select GROUP_CONCAT(concat(respuesta_recibida,' (',cam.nombre,')')) from llamadas,campanas cam where contacto_id=co.id and campana_id=cam.id and campana_id=cc.campana_id and respuesta_recibida not in ('Ninguna') ) as proceso 
			
			$sql="select co.*,  cc.empleado_id,
			co.telefono 
			from contactos co, contactos_campanas cc 
			where cc.contacto_id=co.id
            and co.estado IN ('AC')
			and cc.campana_id=".$campana_id."
			and co.".$campo." like "."'%".$valor."%'"."
            and (select GROUP_CONCAT(concat(emp.nombres,' ',emp.apellidos,' (',cam.nombre,')')) from contactos_campanas,empleados emp,campanas cam where contacto_id=co.id and empleado_id=emp.id and campana_id=cam.id and campana_id=cc.campana_id) is null
            limit 50;";
			$query=$this->db->query($sql);
			//$query=$this->db->limit(1, 10);
			return $query;
	}
	
	
	function bandejacongestor($campana_id,$empleado_id){
		   //(select GROUP_CONCAT(valor) from contactos_campos where contacto_id=co.id and campo_id in (2,4)) as convencional,
		   //(select GROUP_CONCAT(concat(emp.nombres,' ',emp.apellidos,' (',cam.nombre,')')) from contactos_campanas,empleados emp,campanas cam where contacto_id=co.id and empleado_id=emp.id and campana_id=cam.id and campana_id=cc.campana_id) as gestor,
		   //(select GROUP_CONCAT(concat(respuesta_recibida,' (',cam.nombre,')')) from llamadas,campanas cam where contacto_id=co.id and campana_id=cam.id and campana_id=cc.campana_id and respuesta_recibida not in ('Ninguna') ) as proceso 
		
			$sql="select co.*,  cc.empleado_id,
			co.telefono
			from contactos co, contactos_campanas cc 
			where cc.contacto_id=co.id
            and co.estado IN ('AC')
			and cc.campana_id=".$campana_id."
			and cc.empleado_id=".$empleado_id."
            and (select GROUP_CONCAT(concat(emp.nombres,' ',emp.apellidos,' (',cam.nombre,')')) from contactos_campanas,empleados emp,campanas cam where contacto_id=co.id and empleado_id=emp.id and campana_id=cam.id and campana_id=cc.campana_id) is not null
            and (select GROUP_CONCAT(concat(respuesta_recibida,' (',cam.nombre,')')) from llamadas,campanas cam where contacto_id=co.id and campana_id=cam.id and campana_id=cc.campana_id and respuesta_recibida not in ('Ninguna') ) is null
		    limit 50;";
			$query=$this->db->query($sql);
			return $query;
	}
	
	
	function bandejabusquedacongestor($campana_id,$empleado_id,$campo,$valor){
			//(select GROUP_CONCAT(valor) from contactos_campos where contacto_id=co.id and campo_id in (2,4)) as convencional,
			//(select GROUP_CONCAT(concat(emp.nombres,' ',emp.apellidos,' (',cam.nombre,')')) from contactos_campanas,empleados emp,campanas cam where contacto_id=co.id and empleado_id=emp.id and campana_id=cam.id and campana_id=cc.campana_id) as gestor,
			//(select GROUP_CONCAT(concat(respuesta_recibida,' (',cam.nombre,')')) from llamadas,campanas cam where contacto_id=co.id and campana_id=cam.id and campana_id=cc.campana_id and respuesta_recibida not in ('Ninguna') ) as proceso 
		
			$sql="select co.*,  cc.empleado_id,
			co.telefono
			from contactos co, contactos_campanas cc 
			where cc.contacto_id=co.id
            and co.estado IN ('AC')
			and cc.campana_id=".$campana_id."
			and cc.empleado_id=".$empleado_id."
			and co.".$campo." like "."'%".$valor."%'"."
            and (select GROUP_CONCAT(concat(emp.nombres,' ',emp.apellidos,' (',cam.nombre,')')) from contactos_campanas,empleados emp,campanas cam where contacto_id=co.id and empleado_id=emp.id and campana_id=cam.id and campana_id=cc.campana_id) is not null
            limit 50;";
			$query=$this->db->query($sql);
			return $query;
	}
	
	
	 function custom_query(){
    	 $this->db->select("contactos.*, CONCAT(empleados.nombre, '  ',empleados.apellido) as empleado, campanas.nombre as campana",false);
		 $this->db->join('empleados', 'contactos.empleado_id = empleados.id','left');
	  	 $this->db->join('campanas', 'contactos.campana_id = campanas.id','left');
	     $this->db->from('contactos');
		 return $this->db->get();
	}
	 
	function asigna_contactos($campana_id,$empleado_id,$cantidad,$usuario){
				
			
		
		/*	
		$sql="insert into contactos_campanas(contacto_id,telefono,campana_id,empleado_id, padre_id, proceso, fecha_ing,usuario_ing)
			SELECT con.id,con.telefono,".$campana_id.",".$empleado_id.", conca.id, 'Asignado',CURRENT_TIMESTAMP,".$usuario."
			FROM contactos con, contactos_campanas conca
			where  conca.contacto_id=con.id
			and conca.empleado_id is null
			and conca.padre_id is null
			and conca.campana_id=".$campana_id."
			and not exists (select * from contactos_campanas where contacto_id=con.id
			                 and campana_id=".$campana_id."
			                 and padre_id=conca.id
			                 and proceso='Asignado'
							 and estado='AC'
							 )
			and con.estado='AC'
			and conca.estado='AC'
			LIMIT ".$cantidad.";";
	       */
			
			/*$sql="insert into contactos_campanas(contacto_id,telefono,campana_id,empleado_id, observaciones, fecha_ing,usuario_ing)
			SELECT con.id,con.telefono,".$campana_id.",".$empleado_id.",'asignación',CURRENT_TIMESTAMP,".$usuario."
			FROM contactos_campanas con
			where con.padre_id is null
			and not exists (select * from contactos_campanas where padre_id=con.id
			                 and campana_id=".$campana_id."
							 and estado='AC')
			and con.estado='AC'
			LIMIT ".$cantidad.";";*/
			/*
			$sql="update contactos_campanas
				set empleado_id=".$empleado_id.",
				usuario_mod=".$usuario.",
				observaciones='asignación',
				fecha_mod=CURRENT_TIMESTAMP
				where empleado_id is null
				and campana_id=".$campana_id."
				and estado='AC'
				LIMIT ".$cantidad.";";
			 
			 */
			//$query=$this->db->query($sql);
			//return $query;
		
	}
	
	function reasigna_contactos($campana_id,$empleado1_id,$empleado2_id,$usuario){
		/*$sql="update contactos_campanas
				set empleado_id=".$empleado2_id.",
				usuario_mod=".$usuario.",
				observaciones='reasignación',
				fecha_mod=CURRENT_TIMESTAMP
				where empleado_id=".$empleado1_id."
				and campana_id=".$campana_id."
				and estado='AC';";*/
		
			/*	
			$sql="insert into contactos_campanas(contacto_id,telefono,campana_id,empleado_id, padre_id, proceso, fecha_ing,usuario_ing)
			SELECT con.id,conca.telefono,".$campana_id.",".$empleado2_id.", conca.id, 'Reasignado',CURRENT_TIMESTAMP,".$usuario."
			FROM contactos con, contactos_campanas conca
			where  conca.contacto_id=con.id
			and conca.empleado_id =".$empleado1_id."
			and conca.campana_id=".$campana_id."
			and conca.fecha_ing in (select max(fecha_ing) from contactos_campanas where contacto_id=con.id and empleado_id =".$empleado1_id." 
			                     and campana_id=".$campana_id." and estado='AC'  )
			and not exists (select * from contactos_campanas where contacto_id=con.id
			                 and campana_id=".$campana_id."
			                 and empleado_id=".$empleado2_id."
			                 and padre_id=conca.id
			                 and proceso in ('Reasignado')
							 and estado='AC'
							 )
			and con.estado='AC'
			and conca.estado='AC';";	
				*/
				
			//$query=$this->db->query($sql);
			//return $query;
			} 
		
	
	
	 
}