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
      $sql2 = 'select ifnull((select max(idcomplaint) from dbneigh_admin.tcomplaints where idusr = '.$jsonParams->idusr.'),0) + 1 as maximo ';
      $resultado2 = $connex->query($sql2);
      $salida = '{"res": 0, "msg":"NO SE PUDO OBTENER EL SIGUIENTE ID PARA LA NUEVA QUEJA DEL USUARIO"}';
      if(isset($resultado2)){
        $existe = 0;
        while($row = $resultado2->fetch_assoc()){
          $existe = $row["maximo"];
        }
        mysqli_free_result($resultado2);
        $sql3 = 'insert into dbneigh_admin.tcomplaints(idcomplaint, idusr, tycomplaint, desc, dtcomplaint, idusrchk, isvalid, isresolved, dreg) values ('
          .$existe.','.$jsonParams->idusr.','.$jsonParams->tycomplaint.',"'.$jsonParams->desc.'","'.$jsonParams->dtcomplaint.'",0,0,0,current_timestamp)';
        $resultado4 = $connex->query($sql3);
        $filasact = $connex->affected_rows;
        if($filasact > 0){
          $salida = '{"res": 1, "msg":"QUEJA DEL USUARIO REGISTRADA ('.$filasact.')"}';
        }else{
          $salida = '{"res": 0, "msg":"NO SE PUDO REGISTRAR LA QUEJA DEL USUARIO"}';
        }
      }
    }
    $connex->close();
  }
}
header('Content-Type: application/json; charset=utf-8');
echo ($salida);
?>
