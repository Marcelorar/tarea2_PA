<?php
include("ManejoDatos.php");
$conn = conectar("localhost","Mascotas","root","");
$sql = "SELECT * FROM Persona ORDER BY Nombre_Persona ASC";
$ck_n = 0;
?>

<html>
<body>
<font color = "darkblue" size = "6">
    <b>Personas Registradas:</b></br>
</font>
<a href ="AgregarPersona.html"> + Agregar Persona</a>
<form method="POST" action="hub.php">

    <table border = "1" bgcolor = "yellow">
        <tr>
            <th>
                <font color = "gray">Documento de Identificaci&oacute;n</font>
            </th>
            <th>
                <font color = "gray">Nombre</font>
            </th>
            <th>
                <font color = "gray">Apellido</font>
            </th>
            <th>
                <font color = "gray">Fecha de nacimiento</font>
            </th>
            <th>
                <font color = "gray">Mascotas</font>
            </th>
            <th>
                <font color = "gray">Edici&oacute;n</font>
            </th>

            <th>
                <button type ="Submit" name="Destino" value="EliminarPersonas">Eliminar</button>
            </th>
        </tr>

        <?
            try
            {
                $cursor = $conn->query($sql);
                foreach($cursor as $registro){
                    $ck_n++;
        ?>
        <tr>
            <td>
                <?echo($registro['DI_PERSONA']);?>
            </td>
            <td>
                <?echo($registro['NOMBRE_PERSONA']);?>
            </td>
            <td>
                <?echo($registro['APELLIDO_PERSONA']);?>
            </td>
            <td>
                <?echo($registro['FECHA_NACIMIENTO_PERSONA']?date("d/m/Y", strtotime($registro['FECHA_NACIMIENTO_PERSONA'])):"---");?>
            </td>
            <td>
                    <button type ="Submit" name="Destino" value="Mascotas;<?echo($registro['DI_PERSONA']);?>;<?echo($registro['NOMBRE_PERSONA']);?> <?echo($registro['APELLIDO_PERSONA']);?>">Ir</button>
            </td>
            <td>
                    <button type ="Submit" name="Destino" value="EditarPersona;<?echo($registro['DI_PERSONA']);?>">Editar</button>
            </td>
            <td>
                <input type="checkbox" name="idPersonasE_<?echo($ck_n);?>" value="<?echo($registro['DI_PERSONA']);?>">
            </td>
        </tr>

        <?
                }
            }catch(PDOException $e)
            {
                echo("Error: ".$e->getMessage());
            } finally{
                $conn = null;
            }

        ?>
        <input type="hidden" name="nPersonas" value="<?echo($ck_n);?>">
    </table>
</form>
</body>
</html>