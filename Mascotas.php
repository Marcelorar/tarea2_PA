<?php
session_start();
include("ManejoDatos.php");
$conn = conectar("localhost","Mascotas","root","");
$persona = isset($_SESSION["idObjeto"])?$_SESSION["idObjeto"]:"";
$propietario = isset($_SESSION["propietario"])?$_SESSION["propietario"]:"";
if($persona=="") header('Location: hub.php');
$ck_n = 0;
$sql = "SELECT p.NOMBRE_PERSONA,p.APELLIDO_PERSONA,m.ID_MASCOTA,m.FOTO_MASCOTA,m.NOMBRE_MASCOTA,c.NOMBRE_CATEGORIA,m.DESCRIPCION_MASCOTA FROM mascota m INNER JOIN categoria_mascota c ON m.id_categoria = c.id_categoria INNER JOIN persona p ON p.Di_Persona = m.Di_Persona WHERE m.di_persona = $persona";
try
    {
        $cursor = $conn->query($sql);
        if($cursor->rowCount()>0){
            $temp = $cursor->fetch();
            $propietario =  $temp['NOMBRE_PERSONA']." ".$temp['APELLIDO_PERSONA'];
            $cursor = $conn->query($sql);
        }
?>

<html>
<body>
<font color = "darkblue" size = "6">
    <b>Mascotas de  <a href="Personas.php"><?echo($propietario);?></a>:</b></br>
</font>
<form  method="POST" action="AgregarMascota.php">
        <button name ="Agregar" type ="Submit">Agregar Mascota</button>
    </form>
<form method="POST" action="hub.php">

    <table border = "1" bgcolor = "yellow">
        <tr>
            <th>
                <font color = "gray">Foto Mascota</font>
            </th>
            <th>
                <font color = "gray">Nombre</font>
            </th>
            <th>
                <font color = "gray">Tipo de Animal</font>
            </th>
            <th>
                <font color = "gray">Descripci&oacute;n</font>
            </th>
            <th>
                <font color = "gray">Edici&oacute;n</font>
            </th>
            <th>
                <button type ="Submit" name="Destino" value="EliminarMascotas">Eliminar</button>
            </th>
        </tr>

        <?
                foreach($cursor as $registro){
                    $ck_n++;
        ?>
        <tr>
            <td>
                <figure>
                <img width="100" src = "<?echo("img/".$registro['FOTO_MASCOTA']);?>">
                <figcaption><?echo($registro['FOTO_MASCOTA']);?></figcaption>
                </figure>
            </td>
            <td>
                <?echo($registro['NOMBRE_MASCOTA']);?>
            </td>
            <td>
                <?echo($registro['NOMBRE_CATEGORIA']);?>
            </td>
            <td>
                <?echo($registro['DESCRIPCION_MASCOTA']);?>
            </td>
            <td>

                <button name ="Destino" type ="Submit" value="EditarMascota;<?echo($registro['ID_MASCOTA']);?>">Editar</button>

            </td>
            <td>
                <input type="checkbox" name="idMascotasE_<?echo($ck_n);?>" value="<?echo($registro['ID_MASCOTA']);?>">
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
        <input type="hidden" name="nMascotas" value="<?echo($ck_n);?>">
    </table>
</form>
</body>
</html>