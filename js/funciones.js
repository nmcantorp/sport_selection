var preguntas = [];
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
    localStorage['preguntas'] = JSON.stringify(resultado.data.preguntas);
    console.log(preguntas);//return false;
    validar_respuestas(0);

  })
  .fail(function() {
    console.log("error");
  });
  
}

function validar_respuestas(id)
{
  preguntas = JSON.parse(localStorage['preguntas']);
  console.log(preguntas);
  if (id==0) {
    html_final = "<br>";
    for (var index = 0; index < 1; index++) {
      html_final += "<br>";
      html_final += preguntas[index]['pregunta'];
      html_final += "<br>";
      console.log(preguntas[index]['respuesta'].length);
      var cantidad = preguntas[index]['respuesta'].length;
      var respuesteas = preguntas[index]['respuesta']; console.log(respuesteas);
      for (var i = 0; i < respuesteas.length; i++) {
        var texto_respuesta = respuesteas[i]['respuesta'];
        var id_respuesta    = respuesteas[i]['id_resp'];
        var id_pregunta     = respuesteas[i]['pregunta_id_preg'];
        html_final += "<br>";
        html_final += "<label>"+ texto_respuesta;
        html_final += "<input type='radio' val='"+ id_respuesta +"' name='"+ id_pregunta +"' id='"+ id_respuesta +"'><br>";
        html_final += "</label>";
        //valida_preg = preguntas[index]['id_preg'];
      };     
      delete preguntas[index];
      preguntas.splice(0,1);
      console.log(preguntas);
      localStorage['preguntas'] = JSON.stringify(preguntas);
    }
    html_final += "<div onclick='validar_respuestas("+ id_pregunta +")'>Siguiente</div>";
    $('#content #left #texto_inicial').html(html_final);
  }else{
    seleccion = document.getElementsByName(id);//console.log(seleccion);
    continuar = false;
    var respuesta_sel;
    for (var i = 0; i < seleccion.length; i++) {
      if(seleccion[i].checked)
      {
        continuar     = true;
        respuesta_sel = seleccion[i].id;
      }
    };
    console.log(respuesta_sel);
    if (continuar) {
      html_final = "<br>";
      for (var index = 0; index < 1; index++) {
        html_final += "<br>";
        html_final += preguntas[index]['pregunta'];
        html_final += "<br>";
        console.log(preguntas[index]['respuesta'].length);
        var cantidad = preguntas[index]['respuesta'].length;
        var respuesteas = preguntas[index]['respuesta']; console.log(respuesteas);
        for (var i = 0; i < respuesteas.length; i++) {
          var texto_respuesta = respuesteas[i]['respuesta'];
          var id_respuesta    = respuesteas[i]['id_resp'];
          var id_pregunta     = respuesteas[i]['pregunta_id_preg'];
          html_final += "<br>";
          html_final += "<label>"+ texto_respuesta;
          html_final += "<input type='radio' val='"+ id_respuesta +"' name='"+ id_pregunta +"' id='"+ id_respuesta +"'><br>";
          html_final += "</label>";
          //valida_preg = preguntas[index]['id_preg'];
        };     
        delete preguntas[index];
      }
      html_final += "<div onclick='validar_respuestas("+ id_pregunta +")'>Siguiente</div>";
      $('#content #left #texto_inicial').html(html_final);
    }else{
      alert('Debe Seleccionar una respuesta para poder continuar.');
    };
/*    seleccion.each(function(index, el) {
      console.log($(this).is(":checked"));
    });*/
    console.log(seleccion);
  }
}


$(document).ready(function(){
	$('#inicio_test').click(function(){

    inicia_prueba();
        //$('#texto_inicial').html(null);
		
	});	
	
});
