<?php
session_start();
include("ManejoDatos.php");
$conn = conectar("localhost","Mascotas","root","");
$sql = "SELECT * FROM categoria_mascota ORDER BY Nombre_Categoria ASC";
$mascota = isset($_SESSION["idObjeto"])?$_SESSION["idObjeto"]:"";
$sqlEdMascota = "SELECT DI_PERSONA,ID_MASCOTA,NOMBRE_MASCOTA,ID_CATEGORIA,DESCRIPCION_MASCOTA,FOTO_MASCOTA FROM mascota WHERE id_mascota = $mascota";
$cursor = $conn->query($sqlEdMascota);
$mascota = $cursor->fetch();
?>

   <html lang="es">
        <body>
            <font color="darkblue" size="5">Editar Mascota</font>

            <form action="hub.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="Destino" value="ActualizarMascota;<?echo($mascota['ID_MASCOTA']);?>;<?echo($mascota['DI_PERSONA']);?>">
                <table>
                    <tr>
                        <td> Nombre:</td>
                        <td><input type="text" name="nombreMascota" value="<?echo($mascota['NOMBRE_MASCOTA']);?>"></td>
                    </tr>
                    <tr>
                        <td> Categoria:</td>
                        <td>
                            <select name="categoriaMascota">
                            <?
                                $cursor = $conn->query($sql);
                                foreach($cursor as $registro){
                                 echo("<option value=\"".$registro['ID_CATEGORIA']."\"".($registro['ID_CATEGORIA'] == $mascota['ID_CATEGORIA']?'selected':'').">".$registro['NOMBRE_CATEGORIA']."</option>");
                                }
                            ?>
                            </select>
                        </td>

                    </tr>
                    <tr>
                        <td> Descripci&oacute;n:</td>
                        <td> <textarea name="descripcionMascota" rows="10" cols="30"><?echo($mascota['DESCRIPCION_MASCOTA']);?></textarea></td>
                    </tr>
                    <tr>
                        <td> Fotograf&iacute;a:</td>
                        <td>
                        <figure>
                            <img width="100" src = "<?echo("img/".$mascota['FOTO_MASCOTA']);?>">
                            <figcaption><?echo($mascota['FOTO_MASCOTA']);?></figcaption>
                        </figure>
                            <input name="fotoMascota" type="file">
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <button name ="Ingresar" type ="Submit">Guardar</button>
                        </td>
                        <td>
                        <button name ="Cancelar" type="button" onclick="location.href = 'Mascotas.php';">Cancelar</button>
                        </td>
                    </tr>
                </table>
            </form>
        </body>
    </html>
