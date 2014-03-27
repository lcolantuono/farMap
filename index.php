
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="bootstrap/assets/ico/favicon.ico">

    <title>farMap - Hackathon Neuqu&eacute;n 2014</title>
    
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<script src="bootstrap/js/jquery-1.11.0.min.js"> </script>
<script src="bootstrap/js/bootstrap.min.js"></script>

<script	src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

<link rel="icon" 
      type="image/ico" 
      href="img/favicon.ico">
      
<script type="text/javascript">
function ajax(page1) {
	$.ajax({
		dataType : "json",
		url : "json.php",
		type : 'GET',
		data : {
			op : 'farmacia',
			latitud : lat,
			longitud : lng,
			pagina : page1
			
			<?php if (isset($_GET['id'])){
				echo " , id: ".$_GET['id'];}
 ?>
		},
		success : function(data) {
			$.each(data, function(index) {
				puntos[index] = data[index];
			})
			calculateDistances();
			calcRoute(0);
		}
	});
}
</script>

<script type="text/javascript" src="functions.js"></script>

     <!--Bootstrap core CSS -->
    
     <!--Custom styles for this template -->
    
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Navegaci&oacute;n</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php" style="margin-top: -10px;"><img width="40px" src="logo.png"></a>
          
        </div>
        
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="index.php">Home</a></li>
            <li><a href="qr.php" target="_blank">De Turno</a></li>
            <li><a href="#about">Nosotros</a></li>
            <li><a href="#contact">Contacto</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Farmacias</a></li>
                <li><a href="#">Hospitales</a></li>
                <li><a href="#">Emergencias</a></li>
                <!-- <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li> -->
              </ul>
            </li>
          </ul>
		
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron" >
      <div style="float: left; width: 65%;">
        <h1>FarMap App</h1>
        <p>La aplicaci&oacute;n Farmap naci&oacute; a ra&iacute;z del evento Hackaton Neuqu&eacute;n 2014 organizado por la provincia, 
        con la finalidad de utilizar informaci&oacute;n liberada de distintas entidades p&uacute;blicas. </p><p>La idea surgi&oacute; 
        de geolocalizar farmacias y entidades relacionadas a la salud, optimizando los recorridos 
        y utilizando filtros para saber si utilizan distintas obras sociales y si est&oacute;n de turno por las noches.</p>
      </div>
		<img src="logo.png" id="logoEnMapa" style="position: absolute; float: right; opacity: 0.8; top: 30px; right: 0px;">
      </div>

    </div> <!-- /container -->
    
    <div class="container" align="center">

      <!-- Three columns of text below the carousel -->
      <div class="row" <?php if (isset($_GET['id'])){
				echo "style='display: none;'";}
 		?> >
        <div class="col-lg-4">
          <a id="farma"><img class="img-circle" src="img/farma.png" alt="Generic placeholder image" width="150px"></a>
          <h2>Farmacias</h2>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img class="img-circle" src="img/hospi.png" alt="Generic placeholder image" width="150px">
          <h2>Hospitales</h2>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img class="img-circle" src="img/emerg.png" alt="Generic placeholder image" width="150px">
          <h2>Emergencias</h2>
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->

		<div class="row2">
	
			<div id="listado" <?php if (isset($_GET['id'])){
				echo "style='display: block;'";} ?>>
		
			<div class="btn-group" style="margin-top: 5px; width: 100%; text-align: center" > 
			<button type="button" class="btn btn-success dropdown-toggle" style="width: 95%;" data-toggle="dropdown">Farmacias Cercanas   <span class="caret"></span>    
			<span class="sr-only">Toggle Dropdown</span>  </button>	  
			<ul class="dropdown-menu" role="menu" style="width: 95%;">
		
			</ul></div>
		    </div>
		    
		    <div id="mapa" style="margin-top: 25px;"></div>
		    
		</div>

	</div>

    <!-- FOOTER 
    
    <div id="wrap" class="container" style="padding-top: 25px; text-align: center; background-color: black; color: white;">
    <img src="" width="50px">
    Hackathon Neuqu&eacute;n - 2014
    </div>
    
    END FOOTER -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    </body>
  <style>
  .jumbotron{
    position: relative;
    z-index:1;
    overflow:hidden; /*if you want to crop the image*/
	}
	.jumbotron:before{
	    z-index:-1;
	    position:absolute;
	    left:0;
	    top:0;
	    content: url('googleMapFarm.png');
	    opacity:0.2;
	}
	@media(max-width: 600px){
		.jumbotron{
			display: none;
		}
		.container .row{
			margin-top: 70px;
		}
		.img-circle{width: 100px;}
	}
	
	#listado{
		display: none;
		margin: 50px 0 5px 0;
	}
	html,body {
	height: 100%;
	margin: 0;
	padding: 0;
	}
	
	#mapa {
		width: 100%;
		height: 90%;
		position: absolute;
		left: 0px;
		margin-top: 0px;	
	}
	/* Fix Google Maps canvas
	 *
	 * Wrap your Google Maps embed in a `.google-map-canvas` to reset Bootstrap's
	 * global `box-sizing` changes. You may optionally need to reset the `max-width`
	 * on images in case you've applied that anywhere else. (That shouldn't be as
	 * necessary with Bootstrap 3 though as that behavior is relegated to the
	 * `.img-responsive` class.)
	 */
	
	.google-map-canvas,
	.google-map-canvas * { .box-sizing(content-box); }
	
	/* Optional responsive image override */
 img { max-width: none; }
 label { width: auto; display: inline;}
  </style>
  
  <script type="text/javascript">
  $ (document) .ready(function(){
		
	  $ ("#farma") .click(function () {

		  $('#mapa').fadeOut('slow', function(){
			  $("#mapa").css({display: "block", visibility: "visible", width: "100%", height: "90%"});
		  	});
			
		  $('.jumbotron').fadeOut('slow', function(){
				$(this).css('displaying','none');
		  	});
		  $('.container .row').fadeOut('slow', function(){
				$(this).css('displaying','none');
		  	});
		  
		  $ ("#listado") .each(function() {
	
			  displaying  = $(this).css('display');
		
			  if(displaying == 'block') {
		
			  	$(this).fadeOut('slow',function() {
		
			  	$(this).css('displaying','none');
		
			  	});
			  	

		
			  } else {
		
			  	$(this).fadeIn('slow',function() {
		
			  	$(this).css('display','block');
		
			  	});
		
			  }
		
			  });
	
		  });

	  });
  </script>
  
</html>