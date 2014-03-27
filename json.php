<!-- 
				FarmApp
Integrantes:
	- Nahuen Doffo
	- Pablo Kogan
	- Matias Levy
	- Matias Urrutia
	- Juli�n Salas
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
<?php

include 'ini.php';


/* parametros ***************** */
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    exit('error op');
}

/**
 * si se especifica id solo busca id
 */
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = " SELECT  
 nombre,
direccion,
latitud,
longitud,
ciudades.descripcion ciudad,
provincias.descripcion provincia
FROM farmacias, provincias, ciudades
where farmacias.id=$id and farmacias.localidad=ciudades.id and farmacias.provincia=provincias.Id 

      ";
} else {

    if (isset($_GET['latitud'])) {
        $latitud = $_GET['latitud'];
    } else {
        exit('error latitud');
    }
    if (isset($_GET['longitud'])) {
        $longitud = $_GET['longitud'];
    } else {
        exit('error longitud');
    }

    if (isset($_GET['pagina'])) {
        $pagina = $_GET['pagina'];
    } else {
        $pagina = 1;
    }
    /*
     * page
     * ver paginación
     */
    /*
     * 
      SELECT distinct
      concat( trim(prestador.razon_social)," ",trim(sucursal.descripcion)) nombre,
      trim(sucursal.direccion) direccion,
      sucursal.localidad,
      sucursal.provincia,
      sucursal.latitud,
      sucursal.longitud
      FROM `prestador` , consultorio,`sucursal`
      WHERE categoria =7 and prestador.nro_interno=consultorio.prestador and sucursal.id=consultorio.entidad


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
//    echo date("Y-m-d H:i:s D");
    $hora = date("H");
    $dia = date("D");
    if ($hora > 21 or $hora < 8 or $dia == "Sun" or ($dia == "Sat" and $hora > 12)) {
        /**
         * solo mostrar turno de hoy
         */
         $sql = " SELECT 
concat(nombre,if(farmaciaturno.id is null,\"\" ,\"-TURNO-\")) nombre,
direccion, latitud, longitud, ciudades.descripcion ciudad, provincias.descripcion provincia 
FROM farmacias inner join provincias on farmacias.provincia=provincias.Id 
inner join ciudades on farmacias.localidad=ciudades.id 
inner join farmaciaturno on farmaciaturno.idFarmacia=farmacias.id and farmaciaturno.Fecha=CURDATE()
      limit 5";
    } else {


        $sql = " SELECT  sqrt(
pow(    (cast(latitud as decimal(9,7))-($latitud) )    ,2) + 
pow(    (cast(longitud as decimal(9,7))-($longitud))  ,2)
) distancia,

concat(nombre,if(farmaciaturno.id is null,\"\" ,\"-TURNO-\")) nombre,
direccion, latitud, longitud, ciudades.descripcion ciudad, provincias.descripcion provincia 
FROM farmacias inner join provincias on farmacias.provincia=provincias.Id 
inner join ciudades on farmacias.localidad=ciudades.id 
left outer join farmaciaturno on farmaciaturno.idFarmacia=farmacias.id and farmaciaturno.Fecha=CURDATE() order by distancia 
      limit 5";
        //exit($sql);
    }
}
$result = mysqli_query($con, $sql);
if (!$result) {
    exit("Error en query: $sql " . mysqli_connect_error());
}
//print_r(mysqli_fetch_array($result));

$json = array();
$i = 0;
while ($row = mysqli_fetch_assoc($result)) {

    $json[] = $row; /* array('direccion' => trim($row['direccion']),
      'latitud' => $row['latitud'],
      'longitud' => $row['longitud']); */
}
header("Content-type: application/json");

if (isset($_GET['callback'])) { // Si es una petición cross-domain
    echo $_GET['callback'] . '(' . json_encode($json) . ')';
}
else // Si es una normal, respondemos de forma normal
    echo json_encode($json);
mysqli_close($con);