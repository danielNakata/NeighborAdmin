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
      $sql2 = 'select ifnull((select max(idvisitor) from dbneigh_admin.tvisitors where idusr = '.$jsonParams->idusr.'),0) + 1 as maximo ';
      $resultado2 = $connex->query($sql2);
      $salida = '{"res": 0, "msg":"NO SE PUDO OBTENER EL SIGUIENTE ID PARA EL HOGAR DEL USUARIO"}';
      if(isset($resultado2)){
        $existe = 0;
        while($row = $resultado2->fetch_assoc()){
          $existe = $row["maximo"];
        }
        mysqli_free_result($resultado2);
        $sql3 = 'insert into dbneigh_admin.tvisitors(idvisitor, idusr, fsname, lsname, dtviststart, dtvisitend, tyvisit, reasonvisit, qrcode, dtqrstarts, dtqrends, stsvisitor, dreg) values ('
          .$existe.','.$jsonParams->idusr.',"'.$jsonParams->fsname.'","'.$jsonParams->lsname.'","'.$jsonParams->dtviststart.'","'.$jsonParams->dtvisitend.'",'
          .$jsonParams->tyvisit.',"'.$jsonParams->reasonvisit.'","'.$jsonParams->qrcode.'","'.$jsonParams->dtqrstarts.'","'.$jsonParams->dtqrends.'",1,current_timestamp)';
        $resultado4 = $connex->query($sql3);
        $filasact = $connex->affected_rows;
        if($filasact > 0){
          $salida = '{"res": 1, "msg":"VISIANTE PARA EL USUARIO REGISTRADO ('.$filasact.')"}';
        }else{
          $salida = '{"res": 0, "msg":"NO SE PUDO REGISTRAR AL VISITANTE PARA EL USUARIO"}';
        }
      }
    }
    $connex->close();
  }
}
header('Content-Type: application/json; charset=utf-8');
echo ($salida);
?>
