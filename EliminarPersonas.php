<?php
session_start();
include("ManejoDatos.php");
$conn = conectar("localhost","Mascotas","root","");
$personas = isset($_SESSION["PersonasE"])?$_SESSION["PersonasE"]:"";
$strPersonas;
foreach ($personas as $persona) {
    $strPersonas .= $persona .', ';
}
$strPersonas .='0';

$sqlEdPersona = "SELECT NOMBRE_PERSONA, APELLIDO_PERSONA, DI_PERSONA FROM persona WHERE di_persona IN ($strPersonas)";
$cursor = $conn->query($sqlEdPersona);
$personas = $cursor->fetchAll();
?>

<html>
    <body>
        <h2>¿Deseas eliminar estas personas?</h2>
        <table>
        <?
            foreach ($personas as $persona) {
        ?>
            <tr>
                <td><b><?echo($persona['NOMBRE_PERSONA']." ".$persona['APELLIDO_PERSONA']);?></b></td>
                <td><b><?echo($persona['DI_PERSONA']);?></b></td>
            </tr>
        <?
            }
        ?>
        </table>

        <form action="hub.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="Destino" value="BorrarPersona;">
             <button name ="Ingresar" type ="Submit">Si</button>
             <button name ="Cancelar" type="button" onclick="location.href = 'Mascotas.php';">No</button>

            </form>
    </body>

</html>