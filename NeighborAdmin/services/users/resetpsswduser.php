<?php
include("../../classes/CBDConn.php");
include("../../classes/Randoms.php");

$salida = '{"res": 0, "msg":"LOS PARAMETROS NO SE RECIBIERON CORRECTAMENTE"}';
if(isset($_POST["params"])){
  $params = $_POST["params"];
  if(isset($params)){
    $salida = '{"res": 0, "msg":"NO SE PUDO CONECTAR A LA BD"}';
    $conn = new CBDConn();
    $connex = $conn->createConnection();
    if(isset($connex)){
      $jsonParams = json_decode($params);
      $existe = 0;
      $sql1 = 'select count(*) as existe from dbneigh_admin.tusers where idusr = '.$jsonParams->idusr.' ';
      $resultado1 = $connex->query($sql1);
      $salida = '{"res": 0, "msg":"NO SE PUDO OBTENER INFORMACION DE LA BD"}';
      if(isset($resultado1)){
        while($row = $resultado1->fetch_assoc()){
          $existe = $row["existe"];
        }
        mysqli_free_result($resultado1);
        $salida = '{"res": 0, "msg":"EL USUARIO NO EXISTE VERIFIQUE SUS DATOS"}';
        if($existe == 1){
          $random = new Randoms();
          $pass = $random->creaContrasena();
          $sql3 = 'update dbneigh_admin.tusers set psswd = password("'.$pass
          .'"), dupd = current_timestamp where idusr = '.$jsonParams->idusr.' ';
          $resultado4 = $connex->query($sql3);
          $filasact = $connex->affected_rows;
          if($filasact > 0){
            $salida = '{"res": 1, "msg":"NUEVA CONTRASENA DEL USUARIO ('.$pass.')"}';
          }else{
            $salida = '{"res": 0, "msg":"NO SE PUDO REESTABLECER LA CONTRASENA DEL USUARIO"}';
          }
        }
      }
    }
    $connex->close();
  }
}
header('Content-Type: application/json; charset=utf-8');
echo ($salida);
?>
