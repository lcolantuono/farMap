<!-- 
				FarmApp
Integrantes:
	- Nahuen Doffo
	- Pablo Kogan
	- Matias Levy
	- Matias Urrutia
	- Julián Salas
	- Lucas Colantuono

Copyright (C) <year> <copyright holders>


Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"),
 to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, 
 sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following 
 conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF 
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE 
FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION 
WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

 -->
<link rel="shortcut icon" href="bootstrap/assets/ico/favicon.ico">
<?php
include 'ini.php';
date_default_timezone_set("Europe/Madrid");
setlocale(LC_TIME, "spanish");

/* parametros ***************** */

/*
 * page
 * ver paginaciÃ³n
 */
/*
 * 
  insert into farmacias(nombre,direccion,localidad,provincia,latitud,longitud,prestador,
  entidad,
  sucursal)
  SELECT distinct
  concat( trim(prestador.razon_social)," ",trim(sucursal.descripcion)) nombre,
  trim(sucursal.direccion) direccion,
  sucursal.localidad,
  sucursal.provincia,
  sucursal.latitud,
  sucursal.longitud,
  consultorio.prestador,
  consultorio.entidad,
  consultorio.sucursal
  FROM `prestador` , consultorio,`sucursal`
  WHERE categoria =7 and prestador.nro_interno=consultorio.prestador and sucursal.id=consultorio.entidad and sucursal.sucursal=consultorio.sucursal


  UPDATE `farmaciaturno` f SET `idFarmacia`=(select farmacias.id from farmacias WHERE farmacias.id_entidad=f.entidad and farmacias.sucursal=f.id_suc)

 */


// query vinculados SELECT * FROM `prestador` , consultorio, sucursal  WHERE categoria =7 and prestador.nro_interno=consultorio.prestador and sucursal.id=consultorio.entidad

/* $sql = " SELECT distinct sqrt(
  pow(    (cast(latitud as decimal(9,7))-($latitud) )    ,2) +
  pow(    (cast(longitud as decimal(9,7))-($longitud))  ,2)
  ) distancia,
  concat( prestador.razon_social,sucursal.descripcion) nombre,
  sucursal.direccion,
  sucursal.latitud,
  sucursal.longitud
  FROM `prestador` , consultorio,`sucursal`
  WHERE categoria =7 and prestador.nro_interno=consultorio.prestador and sucursal.id=consultorio.entidad
  order by distancia
  limit 10
  ";

 */
$sql = " SELECT t.fecha,
    farmacias.id id, 
 nombre,
direccion,
ciudades.descripcion ciudad,
provincias.descripcion provincia
FROM farmaciaturno t, farmacias, provincias, ciudades
where t.idFarmacia=farmacias.id and farmacias.localidad=ciudades.id and farmacias.provincia=provincias.Id
order by fecha
";

$result = mysqli_query($con, $sql);
if (!$result) {
    exit("Error en query: $sql " . mysqli_connect_error());
}
//print_r(mysqli_fetch_array($result));

$json = array();
$i = 0;
?>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
   </head>

  <body onload="print()">

<?php
echo "<table><tr>";
echo "<td><h1>Farmacias de Turno</h1><td>";
echo "<td><img src='logo.png' width='200px' style='position: absolute; top: 10px; right: 10px; opacity: 0.2;'><td>";
echo "</table>";
echo "<h2>subsecretaria de salud de la provincia de neuquen</h2>";
echo "<h2>Los turnos comienzan desde las 8:30 dia cartelera hasta las 8:30 dia siguiente</h2><hr/>";
echo '<table class="table table-striped">';
while ($row = mysqli_fetch_assoc($result)):
    ?>

<tr><td><?php echo strftime ("%a, %d de %B",strtotime($row['fecha'])).'</td><td> <h2>'.$row['nombre'].'</h2> <p>'.$row['direccion'] ?></p></td><td><img alt="qr" src="qr2/qr.php?data=<?php echo $row['id'];?>"></td></tr>
    <?php
endwhile;
echo '</table>';
mysqli_close($con);