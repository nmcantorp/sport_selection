$(document).on('ready',document, function(){
	var antec = document.getElementsByName("antec");
	var tiempos 	= $("[id^='tiempo']");
	var valida = false;
	var array_act = [];
	var array_tiempo = [];
	var cantidad_actividad = 0;
  
  var preguntas = [];


	/*$( "#dialog-message" ).dialog({
      	modal: true,
    	buttons: {
        Aceptar: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $( "#dialog-message" ).dialog("close");

    $( "#dialog_message_concept" ).dialog({
      	modal: true,
    	buttons: {
        Aceptar: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $( "#dialog_message_concept" ).dialog("close");*/
});

function inicia_prueba()
{
  $.ajax({
    url: 'webservice/servicio.php',
    type: 'POST',
    dataType: 'json',
    data: {ac: 'cargue_inicial'},
  })
  .done(function(resultado) {
    var html_final = "";
    var valida_preg= -1;
    preguntas = resultado.data.preguntas;
    
    html_final = "<br>";
    for (var index = 0; index < 2; index++) {
      if(valida_preg != preguntas[index]['id_preg'])
      {
        html_final += "<br>";
        html_final += preguntas[index]['pregunta'];
        html_final += "<br>";
      }     
      html_final += "<br>";
      html_final += "<label>"+ preguntas[index]['respuesta'];
      html_final += "<input type='radio' val='"+ preguntas[index]['id_preg'] +"' name='"+ preguntas[index]['id_preg'] +"' id='"+ preguntas[index]['id_preg'] +"'><br>";
      html_final += "</label>";
      valida_preg = preguntas[index]['id_preg'];
      delete preguntas[index];
    }
    html_final += "<div onclick='continuar()'>Siguiente</div>";
    $('#content #left #texto_inicial').append(html_final);
    
    console.log(preguntas);
    
    console.log("success");
  })
  .fail(function() {
    console.log("error");
  })
  .always(function() {
    console.log("complete");
  });
  
}

$(document).ready(function(){
	$('#inicio_test').click(function(){
    inicia_prueba();
        //$('#texto_inicial').html(null);
		
	});	
	
});
