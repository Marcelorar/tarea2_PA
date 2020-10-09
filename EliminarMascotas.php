<?php
session_start();
include("ManejoDatos.php");
$conn = conectar("localhost","Mascotas","root","");
$mascotas = isset($_SESSION["MascotasE"])?$_SESSION["MascotasE"]:"";
$strMascotas;
foreach ($mascotas as $mascota) {
    $strMascotas .= $mascota .', ';
}
$strMascotas .='0';
$sqlEdMascota = "SELECT NOMBRE_MASCOTA,NOMBRE_CATEGORIA FROM mascota m INNER JOIN categoria_mascota mt ON m.id_categoria = mt.id_categoria WHERE id_mascota IN ($strMascotas)";
$cursor = $conn->query($sqlEdMascota);
$mascotas = $cursor->fetchAll();
?>

<html>
    <body>
        <h2>¿Deseas eliminar estas mascotas?</h2>
        <table>
        <?
            foreach ($mascotas as $mascota) {
        ?>
            <tr>
                <td><b><?echo($mascota['NOMBRE_MASCOTA']);?></b></td>
                <td><b><?echo($mascota['NOMBRE_CATEGORIA']);?></b></td>
            </tr>
        <?
            }
        ?>
        </table>

        <form action="hub.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="Destino" value="BorrarMascota;">
             <button name ="Ingresar" type ="Submit">Si</button>
             <button name ="Cancelar" type="button" onclick="location.href = 'Mascotas.php';">No</button>

            </form>
    </body>

</html>