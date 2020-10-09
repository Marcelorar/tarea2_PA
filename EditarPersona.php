<?php
session_start();
include("ManejoDatos.php");
$conn = conectar("localhost","Mascotas","root","");
$persona = isset($_SESSION["idObjeto"])?$_SESSION["idObjeto"]:"";
$sqlEdPersona = "SELECT DI_PERSONA, NOMBRE_PERSONA,APELLIDO_PERSONA,FECHA_NACIMIENTO_PERSONA FROM persona WHERE DI_PERSONA = $persona";
$cursor = $conn->query($sqlEdPersona);
$persona = $cursor->fetch();
?>

<html lang="es">
        <body>
            <font color="darkblue" size="5">Editar Persona</font>
            <form action="hub.php" method="POST">
            <input type="hidden" name="Destino" value="ActualizarPersona;">
                <table>
                    <tr>
                        <td>Documento de Identificaci&oacute;n:</td>
                        <td><input type="number" name="idPersona" value ="<?echo($persona['DI_PERSONA']);?>" readonly></td>
                    </tr>
                    <tr>
                        <td> Nombre:</td>
                        <td><input type="text" name="nombrePersona" value ="<?echo($persona['NOMBRE_PERSONA']);?>" ></td>
                    </tr>
                    <tr>
                        <td> Apellido:</td>
                        <td><input type="text" name="apellidoPersona" value ="<?echo($persona['APELLIDO_PERSONA']);?>" ></td>
                    </tr>
                    <tr>
                        <td> Fecha de Nacimiento:</td>
                        <td><input type="date" name="fecPersona" value ="<?echo (date('Y-m-d', strtotime($persona['FECHA_NACIMIENTO_PERSONA'])))?>" ></td>
                    </tr>
                    <tr>
                        <td>
                        <button name ="Ingresar" type ="Submit">Guardar</button>
                        </td>
                        <td>
                        <button name ="Cancelar" type="button" onclick="location.href = 'Personas.php';">Cancelar</button>
                        </td>
                    </tr>
                </table>
            </form>
        </body>
    </html>
