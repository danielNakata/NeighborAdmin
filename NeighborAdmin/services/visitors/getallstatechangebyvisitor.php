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
    $sql = "SELECT a.idvisitor, a.idusr, a.idlog, a.prevsts, a.actsts, a.comment, a.isact, a.dreg, a.dupd ".
           " , b.statevisitor as prevstatevisitor ".
           " , c.statevisitor as actstatevisitor ".
           " FROM dbneigh_admin.tvisitors_statechange a ".
           " INNER JOIN dbneigh_admin.tvisitors_state b ON b.stsvisitor = a.prevsts ".
           " INNER JOIN dbneigh_admin.tvisitors_state c ON c.stsvisitor = a.actsts ".
           " WHERE a.idvisitor = ".$jsonParams->idvisitor." and a.idusr = ".$jsonParams->idusr." "
           " ORDER BY a.idusr, a.idvisitor, a.idlog ASC ";
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
