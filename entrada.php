<?php
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Language" content="es"/>
<meta name="description" content=".">




<title>Farmapp</title>

<link href="estilo.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"> </script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src = "js/bootstrap.min.js" > </script>


<script type="text/javascript" src="jquery-1.11.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function(xx){
	$(".btn").click(function(){
		$('#contenido').hide();
		})
});$(document).ready(function(xx){
	$(".btn").click(function(){
		$('#contenido').toggle();
		})
});
</script>
</head>



<body>

<nav class="navbar navbar-default" role="navigation">
  <!-- El logotipo y el icono que despliega el menú se agrupan
       para mostrarlos mejor en los dispositivos móviles -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse"
            data-target="navbar-ex1-collapse">
      <span class="sr-only">Desplegar navegación</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="#">Farmapp</a>
  </div>
  
  
 
  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
       otro elemento que se pueda ocultar al minimizar la barra -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav">
      <li class="dropdown">
      	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Farmacias<b class="caret"></b></a>
      	<ul class="dropdown-menu">
          <li><a href="#">Acción #1</a></li>
        </ul>
      </li>
      <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hospitales<b class="caret"></b></a>
      	<ul class="dropdown-menu">
          <li><a href="#">Acción #1</a></li>
        </ul>
      </li>
      <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Emergencias<b class="caret"></b></a>
      	<ul class="dropdown-menu">
          <li><a href="#">Acción #1</a></li>
        </ul>
      </li>
      
    </ul>
 
    <form class="navbar-form pull-right" role="search">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Buscar">
      </div>
      <button type="submit" class="btn btn-default">Enviar</button>
    </form>
 
    
  </div>
</nav>





<div id="botonera" class=" ">
<a href="#" class="btn btn-group-lg" id="farm"><button type="button" class="btn btn-success"><span class="glyphicon glyphicon-info-sign"></span> Farmacias</button></a>
<a href="#" class="btn btn-group-lg" id="hosp"><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> Hospitales</button></a>
<a href="#" class="btn btn-group-lg" id="emerg"><button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-warning-sign"></span> Emergencias</button></a>
</div>

<div id="contenido">
<p style="color:white;">hola mundo</p>
</div>
</body>