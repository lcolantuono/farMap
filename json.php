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
    $sql = " SELECT  sqrt(
pow(    (cast(latitud as decimal(9,7))-($latitud) )    ,2) + 
pow(    (cast(longitud as decimal(9,7))-($longitud))  ,2)
) distancia,
 nombre,
direccion,
latitud,
longitud,
ciudades.descripcion ciudad,
provincias.descripcion provincia
FROM farmacias, provincias, ciudades
where farmacias.localidad=ciudades.id and farmacias.provincia=provincias.Id
order by distancia
limit 5
      ";
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