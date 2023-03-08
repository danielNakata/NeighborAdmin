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
      $sql2 = 'select ifnull((select max(idpayment) from dbneigh_admin.tpayments where idusr = '.$jsonParams->idusr.'),0) + 1 as maximo ';
      $resultado2 = $connex->query($sql2);
      $salida = '{"res": 0, "msg":"NO SE PUDO OBTENER EL SIGUIENTE ID PARA EL NUEVO PAGO DEL USUARIO"}';
      if(isset($resultado2)){
        $existe = 0;
        while($row = $resultado2->fetch_assoc()){
          $existe = $row["maximo"];
        }
        mysqli_free_result($resultado2);
        $sql3 = 'insert into dbneigh_admin.tpayments(idpayment, idusr, typaymnt, idlapse, desc, dtpaymnt, amntpaymnt, tax1, tax2, totalamntpaymnt, iscmplt, pymntinvoice, pymntseries, dreg) values ('
          .$existe.','.$jsonParams->idusr.','.$jsonParams->typaymnt.','.$jsonParams->idlapse.',"'.$jsonParams->desc.'","'.$jsonParams->dtpaymnt.'",'.$jsonParams->amntpaymnt.','.$jsonParams->tax1.','.$jsonParams->tax2.','.$jsonParams->totalamntpaymnt.','.$jsonParams->iscmplt.',"'
          .$jsonParams->pymninvoice.'","'.$jsonParams->pymnseries.'",current_timestamp)';
        $resultado4 = $connex->query($sql3);
        $filasact = $connex->affected_rows;
        if($filasact > 0){
          $salida = '{"res": 1, "msg":"PAGO DEL USUARIO REGISTRADO ('.$filasact.')"}';
        }else{
          $salida = '{"res": 0, "msg":"NO SE PUDO REGISTRAR EL PAGO DEL USUARIO"}';
        }
      }
    }
    $connex->close();
  }
}
header('Content-Type: application/json; charset=utf-8');
echo ($salida);
?>
