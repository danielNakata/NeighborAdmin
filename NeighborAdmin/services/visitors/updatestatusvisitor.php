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
        $salida = '{"res": 0, "msg":"EL VISITANTE DEL USUARIO NO EXISTE VERIFIQUE SUS DATOS"}';
        if($existe == 1){
          $existe2 = 0;
          $sql51 = 'select ifnull((select max(idlog) from dbneigh_admin.tvisitors_statechange where idusr = '.$jsonParams->idusr.' and idvisitor = '.$jsonParams->idvisitor.'),0) + 1 as maximo ';
          $resultado51 = $connex->query($sql51);
          if(isset($resultado51)){
            while($row = $resultado51->fetch_assoc()){
              $existe2 = $row["maximo"];
            }
            mysqli_free_result($resultado51);
            $sql52 = 'insert into dbneigh_admin.tvisitors_statechange(idvisitor, idusr, idlog, prevsts, actsts, comment, isact, dreg) '.
            ' values ('.$jsonParams->idvisitor.','.$jsonParams->idusr.','.$existe2.','.$jsonParams->stsvisitor.','.$jsonParams->newstsvisitor.',"'.$jsonParams->comment.'", 1, current_timestamp) ';
            $resultado52 = $connex->query($sql52);
          }

          $sql3 = 'update dbneigh_admin.tvisitors set stsvisitor = '.$jsonParams->newstsvisitor
          .', fupd = current_timestamp where idusr = '.$jsonParams->idusr.' and idvisitor = '.$jsonParams->idhome.'';
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
