<?php 

/** carga las preguntas para los deportes */
function cargar_preguntas()
{
require_once('conexion.php');

$objConnect = new ClassConexion();
$objConnect->MySQL();

$query = "	SELECT
            pregunta.pregunta,
            pregunta.id_preg,
            pregunta.descripcion_preg,
            pregunta.imagen_preg
            FROM
            pregunta";

$consulta = $objConnect->consulta($query);
		
if($objConnect->num_rows($consulta)>0){ 
	$conteo=0;
 	while($resultados = $objConnect->fetch_array($consulta)){ 
		  	$result[$conteo]['id_preg'] = $resultados['id_preg'];
		  	$result[$conteo]['pregunta'] = utf8_encode($resultados['pregunta']);
		  	$result[$conteo]['imagen_preg'] = $resultados['imagen_preg'];
            $result[$conteo]['descripcion_preg'] = utf8_encode($resultados['descripcion_preg']);
		  	$result[$conteo]['respuesta'] = cargar_respuesta($resultados['id_preg']);
		  	//$result[$conteo]['pregunta_id_preg'] = $resultados['pregunta_id_preg'];
              $conteo++;
 	}
}else{
	$result = 0 ;
}

return $result;
}

/** Busca las respuestas por pregunta */
function cargar_respuesta($id_preg)
{
require_once('conexion.php');

$objConnect = new ClassConexion();
$objConnect->MySQL();

$query = "  SELECT
            respuesta.id_resp,
            respuesta.respuesta,
            respuesta_pregunta.pregunta_id_preg
            FROM
            respuesta
            INNER JOIN respuesta_pregunta ON respuesta_pregunta.respuesta_id_resp = respuesta.id_resp
            WHERE
            respuesta_pregunta.pregunta_id_preg = $id_preg";

$consulta = $objConnect->consulta($query);
        
if($objConnect->num_rows($consulta)>0){ 
    $conteo=0;
    while($resultados = $objConnect->fetch_array($consulta)){ 
            $result[$conteo]['id_resp'] = $resultados['id_resp'];
            $result[$conteo]['respuesta'] = utf8_encode($resultados['respuesta']);
            $result[$conteo]['pregunta_id_preg'] = $resultados['pregunta_id_preg'];           
            $conteo++;
    }
}else{
    $result = 0 ;
}
return $result;
}


/** Carga las validaciones para las respuestas */
function cargar_validaciones()
{
require_once('conexion.php');

$objConnect = new ClassConexion();
$objConnect->MySQL();

$query = "	SELECT
            decision.id_dec,
            decision.id_resp,
            decision.id_dep,
            decision.pregunta_id_preg
            FROM
            decision
            INNER JOIN deporte ON decision.id_dep = deporte.id_dep
            INNER JOIN pregunta ON decision.pregunta_id_preg = pregunta.id_preg
            INNER JOIN respuesta ON decision.id_resp = respuesta.id_resp";

$consulta = $objConnect->consulta($query);
		
if($objConnect->num_rows($consulta)>0){ 
	$conteo=0;
 	while($resultados = $objConnect->fetch_array($consulta)){ 
		  	$result[$conteo]['id_dec'] = $resultados['id_dec'];
		  	$result[$conteo]['id_resp'] = utf8_encode($resultados['id_resp']);
		  	$result[$conteo]['id_dep'] = $resultados['id_dep'];		  	
		  	$result[$conteo]['pregunta_id_preg'] = $resultados['pregunta_id_preg'];		  	
            $conteo++;
 	}
}else{
	$result = 0 ;
}
return $result;
}

/**Consulta el deporte a particar*/
function valida_deporte($id_respuesta, $id_pregunta)
{
require_once('conexion.php');

$objConnect = new ClassConexion();
$objConnect->MySQL();

$query = "	SELECT
            deporte.nom_dep
            FROM
            decision
            INNER JOIN deporte ON decision.id_dep = deporte.id_dep
            WHERE
            decision.pregunta_id_preg = $id_pregunta AND
            decision.id_resp = $id_respuesta";

$consulta = $objConnect->consulta($query);
		
if($objConnect->num_rows($consulta)>0){ 
	$conteo=0;
 	while($resultados = $objConnect->fetch_array($consulta)){ 
		  	$result[$conteo]['nom_dep'] = utf8_encode($resultados['nom_dep']);		  		  	
            $conteo++;
 	}
}else{
	$result = 0 ;
}
return $result;
}


function Respuesta_entrega($estado, $mensaje, $data)
{
	header("HTTP/1.1 $estado, $mensaje");

	$respuesta['status'] = $estado;
	$respuesta['status_message'] = $mensaje;
	$respuesta['data'] = $data;

	$value_final = json_encode($respuesta);
	echo $value_final;
}

?>