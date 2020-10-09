<?php
error_reporting(E_ALL);
$path_img = './img/';

function Conectar($host,$db,$user,$psw){
    return new PDO("mysql:host=$host;dbname=$db",$user,$psw);
}

function InsertarPersona($idPersona, $nombrePersona,$apellidoPersona,$fecPersona){
    $conn = conectar("localhost","Mascotas","root","");
    try {
        $insert_sql="INSERT INTO persona (DI_PERSONA, NOMBRE_PERSONA,APELLIDO_PERSONA,FECHA_NACIMIENTO_PERSONA)".
        "VALUES (:dipersona,:nombre,:apellido,:fecha)";
        $cursor = $conn->prepare($insert_sql);
        $cursor->bindParam(':dipersona',$idPersona);
        $cursor->bindParam(':nombre',$nombrePersona);
        $cursor->bindParam(':apellido',$apellidoPersona);
        $cursor->bindParam(':fecha',$fecPersona);
        $cursor->execute();
    } catch (PDOEXception $e) {
        echo("Error:".$e->getMessage());
    } finally{
        $conn = null;
    }
}

function ActualizarPersona($idPersona, $nombrePersona,$apellidoPersona,$fecPersona){
    $conn = conectar("localhost","Mascotas","root","");
    try {
        $insert_sql="UPDATE persona SET NOMBRE_PERSONA = :nombre,APELLIDO_PERSONA= :apellido,FECHA_NACIMIENTO_PERSONA= :fecha".
        " WHERE DI_PERSONA = :dipersona";
        $cursor = $conn->prepare($insert_sql);
        $cursor->bindParam(':dipersona',$idPersona);
        $cursor->bindParam(':nombre',$nombrePersona);
        $cursor->bindParam(':apellido',$apellidoPersona);
        $cursor->bindParam(':fecha',$fecPersona);
        $cursor->execute();
    } catch (PDOEXception $e) {
        echo("Error:".$e->getMessage());
    } finally{
        $conn = null;
    }
}

function InsertarMascota($idPersona, $nombreMascota,$categoriaMascota,$descripcionMascota, $fotoMascota){
    $conn = conectar("localhost","Mascotas","root","");
    global $path_img;
    $nombreFoto = $fotoMascota['name'];
    $path = $fotoMascota['name'];
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $nombreFoto = $idPersona."_".$nombreMascota."_.".$ext;
    move_uploaded_file($fotoMascota["tmp_name"],$path_img.$nombreFoto);


    try {
        $insert_sql="INSERT INTO mascota (DI_PERSONA ,ID_CATEGORIA ,NOMBRE_MASCOTA ,DESCRIPCION_MASCOTA,FOTO_MASCOTA)".
        "VALUES (:dipersona,:idcategoria,:nombre,:descripcion,:foto)";
        $cursor = $conn->prepare($insert_sql);
        $cursor->bindParam(':dipersona',$idPersona);
        $cursor->bindParam(':idcategoria',$categoriaMascota);
        $cursor->bindParam(':nombre',$nombreMascota);
        $cursor->bindParam(':descripcion',$descripcionMascota);
        $cursor->bindParam(':foto',$nombreFoto);
        $cursor->execute();
    } catch (PDOEXception $e) {
        echo("Error:".$e->getMessage());
    } finally{
        $conn = null;
    }
}


function EliminarMascotas($idMascotas){
    $conn = conectar("localhost","Mascotas","root","");
    $strMascotas;
    foreach ($idMascotas as $mascota) {
        $strMascotas.= $mascota .', ';
    }
    $strMascotas.='0';
    $delete_sql="DELETE FROM mascota WHERE id_mascota IN ($strMascotas)";

    try{
        $cursor = $conn->query($delete_sql);
    } catch (PDOEXception $e) {
        echo("Error:".$e->getMessage());
    } finally{
        $conn = null;
    }
}

function EliminarPersonas($idPersonas){
    $conn = conectar("localhost","Mascotas","root","");
    $strPersonas;
    foreach ($idPersonas as $persona) {
        $strPersonas.= $persona .', ';
    }
    $strPersonas.='0';
    $delete_sql="DELETE FROM persona WHERE di_persona IN ($strPersonas)";

    try{
        $cursor = $conn->query($delete_sql);
    } catch (PDOEXception $e) {
        echo("Error:".$e->getMessage());
    } finally{
        $conn = null;
    }
}

function ActualizarMascota($idPersona,$idMascota, $nombreMascota,$categoriaMascota,$descripcionMascota, $fotoMascota){
    $conn = conectar("localhost","Mascotas","root","");
    global $path_img;
    $nombreFoto = $fotoMascota['name'];
    $path = $fotoMascota['name'];
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $nombreFoto = $idPersona."_".$nombreMascota."_.".$ext;
    move_uploaded_file($fotoMascota["tmp_name"],$path_img.$nombreFoto);
    $updt_sql;$cursor;
    if($fotoMascota['size']>0){
        $updt_sql="UPDATE mascota SET ID_CATEGORIA = :idcategoria,NOMBRE_MASCOTA =:nombre,DESCRIPCION_MASCOTA= :descripcion,FOTO_MASCOTA= :foto".
        " WHERE ID_MASCOTA = :idMascota";
        $cursor = $conn->prepare($updt_sql);
        $cursor->bindParam(':idcategoria',$categoriaMascota);
        $cursor->bindParam(':nombre',$nombreMascota);
        $cursor->bindParam(':descripcion',$descripcionMascota);
        $cursor->bindParam(':foto',$nombreFoto);
        $cursor->bindParam(':idMascota',$idMascota);

    } else {
        $updt_sql="UPDATE mascota SET ID_CATEGORIA = :idcategoria,NOMBRE_MASCOTA =:nombre,DESCRIPCION_MASCOTA= :descripcion".
        " WHERE ID_MASCOTA = :idMascota";
        $cursor = $conn->prepare($updt_sql);
        $cursor->bindParam(':idcategoria',$categoriaMascota);
        $cursor->bindParam(':nombre',$nombreMascota);
        $cursor->bindParam(':descripcion',$descripcionMascota);
        $cursor->bindParam(':idMascota',$idMascota);
    }
    try {
        $cursor->execute();
    } catch (PDOEXception $e) {
        echo("Error:".$e->getMessage());
    } finally{
        $conn = null;
    }
}
?>