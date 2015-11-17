<?php 

/** carga las preguntas para los deportes */
function cargar_preguntas()
{
require_once('conexion.php');

$objConnect = new ClassConexion();
$objConnect->MySQL();

$query = "	SELECT
            pregunta.pregunta,
            respuesta.respuesta,
            pregunta.id_preg,
            respuesta.id_resp
            FROM
            pregunta
            INNER JOIN respuesta_pregunta ON pregunta.id_preg = respuesta_pregunta.pregunta_id_preg
            INNER JOIN respuesta ON respuesta.id_resp = respuesta_pregunta.respuesta_id_resp";

$consulta = $objConnect->consulta($query);
		
if($objConnect->num_rows($consulta)>0){ 
	$conteo=0;
 	while($resultados = $objConnect->fetch_array($consulta)){ 
		  	$result[$conteo]['id_preg'] = $resultados['id_preg'];
		  	$result[$conteo]['pregunta'] = utf8_encode($resultados['pregunta']);
		  	$result[$conteo]['id_resp'] = $resultados['id_resp'];
		  	$result[$conteo]['respuesta'] = utf8_encode($resultados['respuesta']);
		  	//$result[$conteo]['pregunta_id_preg'] = $resultados['pregunta_id_preg'];
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

function Respuesta_entrega($estado, $mensaje, $data)
{
	header("HTTP/1.1 $estado, $mensaje");

	$respuesta['status'] = $estado;
	$respuesta['status_message'] = $mensaje;
	$respuesta['data'] = $data;

	$value_final = json_encode($respuesta);
	echo $value_final;
}

function xmlToArray($xml, $options = array()) {
    $defaults = array(
        'namespaceSeparator' => ':',//you may want this to be something other than a colon
        'attributePrefix' => '@',   //to distinguish between attributes and nodes with the same name
        'alwaysArray' => array(),   //array of xml tag names which should always become arrays
        'autoArray' => true,        //only create arrays for tags which appear more than once
        'textContent' => '$',       //key used for the text content of elements
        'autoText' => true,         //skip textContent key if node has no attributes or child nodes
        'keySearch' => false,       //optional search and replace on tag and attribute names
        'keyReplace' => false       //replace values for above search values (as passed to str_replace())
    );
    $options = array_merge($defaults, $options);
    $namespaces = $xml->getDocNamespaces();
    $namespaces[''] = null; //add base (empty) namespace
 
    //get attributes from all namespaces
    $attributesArray = array();
    foreach ($namespaces as $prefix => $namespace) {
        foreach ($xml->attributes($namespace) as $attributeName => $attribute) {
            //replace characters in attribute name
            if ($options['keySearch']) $attributeName =
                    str_replace($options['keySearch'], $options['keyReplace'], $attributeName);
            $attributeKey = $options['attributePrefix']
                    . ($prefix ? $prefix . $options['namespaceSeparator'] : '')
                    . $attributeName;
            $attributesArray[$attributeKey] = (string)$attribute;
        }
    }
 
    //get child nodes from all namespaces
    $tagsArray = array();
    foreach ($namespaces as $prefix => $namespace) {
        foreach ($xml->children($namespace) as $childXml) {
            //recurse into child nodes
            $childArray = xmlToArray($childXml, $options);
            list($childTagName, $childProperties) = each($childArray);
 
            //replace characters in tag name
            if ($options['keySearch']) $childTagName =
                    str_replace($options['keySearch'], $options['keyReplace'], $childTagName);
            //add namespace prefix, if any
            if ($prefix) $childTagName = $prefix . $options['namespaceSeparator'] . $childTagName;
 
            if (!isset($tagsArray[$childTagName])) {
                //only entry with this key
                //test if tags of this type should always be arrays, no matter the element count
                $tagsArray[$childTagName] =
                        in_array($childTagName, $options['alwaysArray']) || !$options['autoArray']
                        ? array($childProperties) : $childProperties;
            } elseif (
                is_array($tagsArray[$childTagName]) && array_keys($tagsArray[$childTagName])
                === range(0, count($tagsArray[$childTagName]) - 1)
            ) {
                //key already exists and is integer indexed array
                $tagsArray[$childTagName][] = $childProperties;
            } else {
                //key exists so convert to integer indexed array with previous value in position 0
                $tagsArray[$childTagName] = array($tagsArray[$childTagName], $childProperties);
            }
        }
    }
 
    //get text content of node
    $textContentArray = array();
    $plainText = trim((string)$xml);
    if ($plainText !== '') $textContentArray[$options['textContent']] = $plainText;
 
    //stick it all together
    $propertiesArray = !$options['autoText'] || $attributesArray || $tagsArray || ($plainText === '')
            ? array_merge($attributesArray, $tagsArray, $textContentArray) : $plainText;
 
    //return node as array
    return array(
        $xml->getName() => $propertiesArray
    );
}


function saveProyect($valores)
{
    require_once('conexion.php');

    $objConnect = new ClassConexion();
    $objConnect->MySQL();
    $query = "  INSERT INTO proyecto_pert (
                proyecto_pert.Nombre_Proyecto,
                proyecto_pert.Nombre_Gerente,
                proyecto_pert.Fecha_Inicio,
                proyecto_pert.Descripcion_Proyecto,
                proyecto_pert.Medida_Tiempo_Id,
                proyecto_pert.Complejidad_Proyecto_Id,
                proyecto_pert.id_device
            )
            VALUES
                ('".$valores['nombre']."',
                 '".$valores['gerente']."',
                 '".$valores['fecha']."',
                 '".$valores['objetivo']."',
                 '".$valores['medida']."',
                 '".$valores['complejidad']."',
                 '".$valores['dispositivo']."')";
    $objConnect->consulta($query); 
    $result = $objConnect->insert_id(); 


        return $result;
}

?>