<?php
include("../../classes/CBDConn.php");

$salida = '{"res": 0, "msg":"LOS PARAMETROS NO SE RECIBIERON CORRECTAMENTE"}';
if(isset($_GET["params"])){
  $filtro = $_GET["params"];
  $salida = '{"res": 0, "msg":"NO SE PUDO CONECTAR A LA BD"}';
  $conn = new CBDConn();
  $connex = $conn->createConnection();

  if(isset($connex)){
    $jsonParams = json_decode($filtro);
    $sql = "SELECT a.idpayment, a.idusr, a.typaymnt, a.idlapse, a.desc, a.dtpaymnt, a.tax2, a.tax1, a.totalamntpaymnt, a.iscmplt ".
            " 	, a.pymntinvoice, a.pymntseries, a.dreg, a.dupd ".
            " 	, b.typepayment, b.amount, b.tax1, b.tax2, b.totalamount, b.idlapse, b.ismndty, b.isact AS paymntact ".
            " 	, c.lapse, c.lapseinyear, c.isact, c.isact AS lapseact ".
            " FROM dbneigh_admin.tpayments a ".
            " INNER JOIN dbneigh_admin.tpayments_types b ON a.typaymnt = b.typaymnt ".
            " INNER JOIN dbneigh_admin.tpayments_lapse c ON c.idlapse = a.idlapse ".
            " WHERE a.idusr = ".$jsonParams->idusr." ".
            " ORDER BY a.dtpaymnt ASC, a.idusr ASC, a.idpayment ";
    $resultado1 = $connex->query($sql);
    $salida = '{"res": 0, "msg":"NO SE PUDO OBTENER DATOS DE LA BD"}';
    if(isset($resultado1)){
      $filas = "";
      $aux = "";
      $rows = $resultado1->fetch_all(MYSQLI_ASSOC);
      $cols = $resultado1->fetch_fields();
      foreach($rows as $row){
        foreach($cols as $col){
          $aux.= ',"'.$col->name.'":"'.$row[$col->name].'"';
        }
        $filas .= ",{".substr($aux,1)."}";
      }
      mysqli_free_result($resultado1);
      $filas = ',"datos": ['.substr($filas,1).']';
      $salida = '{"res": 1, "msg":"DATOS DE VISITANTES OBTENIDOS"'.$filas.'}';
      $jsonSalida = json_decode($salida);
    }
  }
  $connex->close();
}
header('Content-Type: application/json; charset=utf-8');
echo ($salida);
?>
