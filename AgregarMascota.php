<?php
session_start();
include("ManejoDatos.php");
$conn = conectar("localhost","Mascotas","root","");
$sql = "SELECT * FROM categoria_mascota ORDER BY Nombre_Categoria ASC";
$persona = isset($_SESSION["idObjeto"])?$_SESSION["idObjeto"]:"";
?>

   <html lang="es">
        <body>
            <font color="darkblue" size="5">Ingresar Mascota</font>

            <form action="hub.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="Destino" value="IngresarMascota;<?echo($persona);?>">
                <table>
                    <tr>
                        <td> Nombre:</td>
                        <td><input type="text" name="nombreMascota" ></td>
                    </tr>
                    <tr>
                        <td> Categoria:</td>
                        <td>
                            <select name="categoriaMascota">
                            <?
                                $cursor = $conn->query($sql);
                                foreach($cursor as $registro){
                                 echo("<option value=\"".$registro['ID_CATEGORIA']."\">".$registro['NOMBRE_CATEGORIA']."</option>");
                                }
                            ?>
                            </select>
                        </td>

                    </tr>
                    <tr>
                        <td> Descripci&oacute;n:</td>
                        <td> <textarea name="descripcionMascota" rows="10" cols="30"></textarea></td>
                    </tr>
                    <tr>
                        <td> Fotograf&iacute;a:</td>
                        <td><input name="fotoMascota" type="file"></td>
                    </tr>
                    <tr>
                        <td>
                        <button name ="Ingresar" type ="Submit">Ingresar</button>
                        </td>
                        <td>
                        <button name ="Cancelar" type="button" onclick="location.href = 'Mascotas.php';">Cancelar</button>
                        </td>
                    </tr>
                </table>
            </form>
        </body>
    </html>
