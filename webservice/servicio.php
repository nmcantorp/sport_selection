<?php 
header("Content-Type:application/json");
header("'Access-Control-Allow-Methods:GET, POST, PUT, DELETE");
header("Access-Control-Max-Age:3628800");
header("Access-Control-Allow-Origin:*");
header("Content-Type:text/javascript; charset=utf8");


require_once('webservice/funciones.php');

switch ($_REQUEST['ac']) {
	case 'cargue_inicial':
		$resultado['preguntas']  = cargar_preguntas();
		$resultado['validacion'] = cargar_validaciones();
		
		Respuesta_entrega(200,"Information found", $resultado);
		//print_r($resultado_validacion);die();
		
	break;
	
	case 'abrir':
		$id_device = $_REQUEST['id'];
		//die($id_device);
		$resultado = findproject($id_device);

		$html = "<table class='table table-bordered'><thead><tr><th>Nombre Proyecto</th><th>Fecha Inicio</th><th></th></tr></thead><tbody>";
		for ($i=0; $i < count($resultado); $i++) { 
			$date = new DateTime($resultado[$i]['Fecha_Inicio']);
			//echo $date->format('Y-m-d');
			$html .= "<tr><td>".$resultado[$i]['Nombre_Proyecto']."</td><td>".$date->format('Y-m-d')."</td><td onclick='cargar_proyectos(".$resultado[$i]['id_complejidad'].", ".$resultado[$i]['Proyecto_Id'].")'><a href='javascript:void(0);'>Abrir</a></td></tr>";
		}
		
		$html .= "</tbody></table>";
		Respuesta_entrega(200,"Information found", $html);
		//echo $html;
		break;
	
	case 'detalle1':

		$id_proyecto = $_REQUEST['id'];

		$resultado = findproject(null, $id_proyecto);
		//echo json_encode($resultado);
		Respuesta_entrega(200,"Information found", $resultado);
		break;

	case 'detalle2':

		$id_proyecto = $_REQUEST['id'];
		$resultado = findactivities($id_proyecto);
		$actividad = -1;
		$tamano=0;
		for ($i=0; $i < count($resultado); $i++) { 

			if($actividad == $resultado[$i]['Actividad_Id'])
			{
				$predecesor .= ($resultado[$i]['Numero_Actividad'] != null) ? ",".$resultado[$i]['Numero_Actividad']:null;
			}else{
				$tamano++;
				$predecesor = ($resultado[$i]['Numero_Actividad'] != null) ? $resultado[$i]['Numero_Actividad']:null;

			}

			$ajuste[$resultado[$i]['Actividad_Id']]['Actividad_Id']=$resultado[$i]['Actividad_Id'];
			$ajuste[$resultado[$i]['Actividad_Id']]['Nombre_Actividad']=$resultado[$i]['Nombre_Actividad'];
			$ajuste[$resultado[$i]['Actividad_Id']]['Tpesimista_Actividad']=$resultado[$i]['Tpesimista_Actividad'];
			$ajuste[$resultado[$i]['Actividad_Id']]['Tprobable_Actividad']=$resultado[$i]['Tprobable_Actividad'];
			$ajuste[$resultado[$i]['Actividad_Id']]['Toptimista_Actividad']=$resultado[$i]['Toptimista_Actividad'];
			$ajuste[$resultado[$i]['Actividad_Id']]['Tesperado_Actividad']=$resultado[$i]['Tesperado_Actividad'];
			$ajuste[$resultado[$i]['Actividad_Id']]['Costo_Actividad']=$resultado[$i]['Costo_Actividad'];
			$ajuste[$resultado[$i]['Actividad_Id']]['Proyecto_Id']=$resultado[$i]['Proyecto_Id'];
			$ajuste[$resultado[$i]['Actividad_Id']]['Numero_Actividad'] = $predecesor;
			$ajuste[$resultado[$i]['Actividad_Id']]['id_predecesora'] = $resultado[$i]['id_predecesora'];
			$actividad = $resultado[$i]['Actividad_Id'];
		}
		$tamano=0;
		foreach ($ajuste as $key => $value) {
			$result[$tamano]['Actividad_Id'] = $value['Actividad_Id'];
			$result[$tamano]['Nombre_Actividad'] = $value['Nombre_Actividad'];
			$result[$tamano]['Tpesimista_Actividad'] = $value['Tpesimista_Actividad'];
			$result[$tamano]['Tprobable_Actividad'] = $value['Tprobable_Actividad'];
			$result[$tamano]['Toptimista_Actividad'] = $value['Toptimista_Actividad'];
			$result[$tamano]['Tesperado_Actividad'] = $value['Tesperado_Actividad'];
			$result[$tamano]['Costo_Actividad'] = $value['Costo_Actividad'];
			$result[$tamano]['Proyecto_Id'] = $value['Proyecto_Id'];
			$result[$tamano]['Numero_Actividad'] = $value['Numero_Actividad'];
			$result[$tamano]['id_predecesora'] = $value['id_predecesora'];
			$tamano++;
		}
		$result['total'] = $tamano;
		Respuesta_entrega(200,"Information found", $result);
		break;

	default:
		# code...
		break;
}

?>