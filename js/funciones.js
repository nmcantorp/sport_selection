var preguntas = [];
$(document).on('ready',document, function(){
	var antec = document.getElementsByName("antec");
	var tiempos 	= $("[id^='tiempo']");
	var valida = false;
	var array_act = [];
	var array_tiempo = [];
	var cantidad_actividad = 0;
  
  var preguntas = [];
  var validaciones = [];


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
    localStorage['validacion'] = JSON.stringify(resultado.data.validacion);
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
  validaciones = JSON.parse(localStorage['validacion']);
  //console.log(preguntas);
  if (id==0) {
    html_final = "<br>";
    for (var index = 0; index < 1; index++) {
      html_final += "<br><h2>";
      html_final += preguntas[index]['pregunta'];
      html_final += "</h2><br>";
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
      //delete preguntas[index];
      //preguntas.splice(0,1);
      //console.log(preguntas);
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
    
    /** Busca en las reglas los deportes que contengan la misma respuesta y la almacena en un objeto */
    var element = [];
    for (var j = 0; j < validaciones.length; j++) {
       if(validaciones[j].pregunta_id_preg == id && validaciones[j].id_resp == respuesta_sel)
       {
         element[j] = validaciones[j].id_dep;
       }
    }
    
    for (var j = 0; j < validaciones.length; j++) {
      var valida=false;
      for (var k = 0; k < element.length; k++) {
        if(validaciones[j].id_dep == element[k])
        {
          valida = true; 
        }        
      }  
      if(!valida)
      {
        delete validaciones[j];
        //validaciones.splice(j,1);
      }           
    }
    var contar = 0;
    var validacion_temp = [];
    jQuery.each(validaciones, function (index, value) {
      if (this.id_dec){
        validacion_temp[contar] = this;
        contar++;
      }
    });
    
    validaciones=validacion_temp;
    
    var contar = 0;
    var validacion_temp = [];
    jQuery.each(validaciones, function (index, value) {
      var valida = true;
      for (var j = contar; j < preguntas.length; j++) { 
        if(preguntas[j].id_preg == this.pregunta_id_preg && valida==true){
           validacion_temp[preguntas[j].id_preg]=preguntas[j];
           valida=false;
            contar++;
        }
      }           
    });    
    contar = 0;
    var preguntas = [];
    jQuery.each(validacion_temp, function (index, value) {
      if(this.id_preg && this.id_preg != id){
        preguntas[contar]=this;
        contar++;
      }
    });
    localStorage['validacion'] = JSON.stringify(validaciones);
    localStorage['preguntas'] = JSON.stringify(preguntas);
    //console.log(validacion_temp);
    console.log(id);
    //console.log(validaciones);
    //console.log(preguntas);    
    
    if (continuar) {
      
      console.log(preguntas.length);
      
      if(preguntas.length == 0)
      {
        deporte = valida_deporte(respuesta_sel, id);
        console.log(valida_deporte(respuesta_sel, id));
        //resultado = console.log(valida_deporte(respuesta_sel, id));
        html_final = "<br>De acuerdo a las respuestas que ingreso, el deporte que va mejor con sus gustos es: <br><br><h2>"+deporte+"</h2><br><br>";
        html_final += "<div onclick='javascript:inicia_prueba();' style='width: 70% !important; border-radius: 26% !important;'>Para volver a Iniciar la prueba pulse <span>Aquí</span></div>";
        $('#content #left #texto_inicial').html(html_final);
        return false;
      }
      
      html_final = "<br>";
      for (var index = 0; index < 1; index++) {
        html_final += "<br><h2>";
        html_final += preguntas[index]['pregunta'];
        html_final += "</h2><br>";
        //console.log(preguntas[index]['respuesta'].length);
        var cantidad = preguntas[index]['respuesta'].length;
        var respuesteas = preguntas[index]['respuesta']; //console.log(respuesteas);
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
        //delete preguntas[index];
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

function valida_deporte(id_resp, id_pregun) {
  $.ajax({
    async: false,
    url: 'webservice/servicio.php',
    type: 'POST',
    dataType: 'json',
    data: {ac: 'consultar', resp: id_resp, preg:id_pregun},
  })
  .done(function(resultado) {
    deporte = resultado.data;
    //console.log(deporte);
    localStorage['deporte'] = deporte;
    return deporte;  

  })
  .fail(function(resultado,x,y) {
    console.log(resultado);
    console.log(x);
    console.log(y);
  });
}

$(document).ready(function(){
  
  localStorage['deporte'] = null;
	$('#inicio_test').click(function(){
    inicia_prueba();
        //$('#texto_inicial').html(null);
		
	});	
	
});
