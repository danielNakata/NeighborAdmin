<?php
include("../../classes/CBDConn.php");

$salida = '{"res": 0, "msg":"LOS PARAMETROS NO SE RECIBIERON CORRECTAMENTE"}';
if(isset($_GET["params"])){
  $filtro = $_GET["params"];
  $salida = '{"res": 0, "msg":"NO SE PUDO CONECTAR A LA BD"}';
  $conn = new CBDConn();
  $connex = $conn->createConnection();

  if(isset($connex)){
    $sql = "SSELECT a.idcomplaint, a.idusr, a.tycomplaint, a.desc, a.dtcomplaint, a.idusrchk, a.isvalid, a.isresolved, a.dreg, a.dupd ".
            " 	, b.complaint, b.isact ".
            " FROM dbneigh_admin.tcomplaints a ".
            " INNER JOIN dbneigh_admin.tcomplaints_type b ".
            " ORDER BY a.dtcomplaint ASC, a.idusr ASC, a.idcomplaint ASC ";
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
      $salida = '{"res": 1, "msg":"DATOS DE QUEJAS OBTENIDOS"'.$filas.'}';
      $jsonSalida = json_decode($salida);
    }
  }
  $connex->close();
}
header('Content-Type: application/json; charset=utf-8');
echo ($salida);
?>
