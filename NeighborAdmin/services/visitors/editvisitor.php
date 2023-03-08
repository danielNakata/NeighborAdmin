<?php
include("../../classes/CBDConn.php");

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
      $sql1 = 'select count(*) as existe from dbneigh_admin.tvisitors where idusr = '.$jsonParams->idusr.' and idvisitor = '.$jsonParams->idvisitor.' ';
      $resultado1 = $connex->query($sql1);
      $salida = '{"res": 0, "msg":"NO SE PUDO OBTENER INFORMACION DE LA BD"}';
      if(isset($resultado1)){
        while($row = $resultado1->fetch_assoc()){
          $existe = $row["existe"];
        }
        mysqli_free_result($resultado1);
        $salida = '{"res": 0, "msg":"LA CASA DEL USUARIO NO EXISTE VERIFIQUE SUS DATOS"}';
        if($existe == 1){
          $sql3 = 'update dbneigh_admin.tvisitors set fsname = "'.$jsonParams->fsname
          .'", lsname = "'.$jsonParams->lsname
          .'", dtviststart = "'.$jsonParams->dtviststart
          .'", dtvisitend = "'.$jsonParams->dtvisitend
          .'", tyvisit = '.$jsonParams->tyvisit
          .', reasonvisit = "'.$jsonParams->reasonvisit
          .'", qrcode = "'.$jsonParams->qrcode
          .'", dtqrstarts = "'.$jsonParams->dtqrstarts
          .'", dtqrends = "'.$jsonParams->dtqrends
          .'", fupd = current_timestamp where idusr = '.$jsonParams->idusr.' and idvisitor = '.$jsonParams->idhome.'';
          $resultado4 = $connex->query($sql3);
          $filasact = $connex->affected_rows;
          if($filasact > 0){
            $salida = '{"res": 1, "msg":"VISITANTE ACTUALIZADO ('.$jsonParams->idusr.')"}';
          }else{
            $salida = '{"res": 0, "msg":"NO SE PUDO ACTUALIZAR AL VISITANTE"}';
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
