<?
session_start();
include("ManejoDatos.php");
//$persona = isset($_SESSION["idPersona"])?$_SESSION["idPersona"]:"";
$destino = isset($_POST["Destino"])?explode(";",$_POST["Destino"])[0]:"";
$_SESSION["propietario"] = explode(";",$_POST["Destino"])[2];
$_SESSION["idObjeto"] = intval(explode(";",$_POST["Destino"])[1]);

$idPersona = isset($_POST["idPersona"])?$_POST["idPersona"]:"";
$nombrePersona = isset($_POST["nombrePersona"])?$_POST["nombrePersona"]:"";
$apellidoPersona = isset($_POST["apellidoPersona"])?$_POST["apellidoPersona"]:"";
$fecPersona = isset($_POST["fecPersona"])?$_POST["fecPersona"]:"";


$nombreMascota = isset($_POST["nombreMascota"])?$_POST["nombreMascota"]:"";
$categoriaMascota = isset($_POST["categoriaMascota"])?$_POST["categoriaMascota"]:"";
$descripcionMascota = isset($_POST["descripcionMascota"])?$_POST["descripcionMascota"]:"";
$fotoMascota = isset($_FILES["fotoMascota"])?$_FILES["fotoMascota"]:"";


$nMascotas =  isset($_POST["nMascotas"])?$_POST["nMascotas"]:"";
$nPersonas =  isset($_POST["nPersonas"])?$_POST["nPersonas"]:"";

$idMascotasE = array();
for ($i=1; $i <= $nMascotas; $i++) {
    if(isset($_POST["idMascotasE_$i"]))
    array_push($idMascotasE,$_POST["idMascotasE_$i"]);
}
$idPersonasE = array();
for ($i=1; $i <= $nPersonas; $i++) {
    if(isset($_POST["idPersonasE_$i"]))
    array_push($idPersonasE,$_POST["idPersonasE_$i"]);
}
$_SESSION["MascotasE"]= isset($_POST["nMascotas"])?$idMascotasE:$_SESSION["MascotasE"];
$_SESSION["PersonasE"]= isset($_POST["nPersonas"])?$idPersonasE:$_SESSION["PersonasE"];

switch ($destino) {
    case 'Mascotas':
        header('Location: Mascotas.php');
        break;
    case 'EditarPersona':
        header('Location: EditarPersona.php');
        break;
    case 'ActualizarPersona':
        ActualizarPersona($idPersona, $nombrePersona,$apellidoPersona,$fecPersona);
        header('Location: Personas.php');
        break;
    case 'EliminarPersonas':
        header('Location: EliminarPersonas.php');
        break;
    case 'BorrarPersona':
        EliminarPersonas($_SESSION["PersonasE"]);
        header('Location: Personas.php');
        break;
    case 'EditarMascota':
        header('Location: EditarMascota.php');
        break;
    case 'BorrarMascota':
        EliminarMascotas($_SESSION["MascotasE"]);
        $_SESSION["idObjeto"] = $_SESSION["propietario"];
        header('Location: Mascotas.php');
        break;
    case 'ActualizarMascota':
        ActualizarMascota($_SESSION["propietario"],$_SESSION["idObjeto"], $nombreMascota,$categoriaMascota,$descripcionMascota, $fotoMascota);
        $_SESSION["idObjeto"] = $_SESSION["propietario"];
        header('Location: Mascotas.php');
        break;
    case 'EliminarMascotas':
        header('Location: EliminarMascotas.php');
        break;
    case 'IngresarPersona':
        InsertarPersona($idPersona, $nombrePersona,$apellidoPersona,$fecPersona);
        header('Location: Personas.php');
        break;
    case 'IngresarMascota':
        InsertarMascota($_SESSION["idObjeto"], $nombreMascota,$categoriaMascota,$descripcionMascota, $fotoMascota);
        header('Location: Mascotas.php');
        break;
    default:
        header('Location: Personas.php');
        break;
}
?>
