<?php
include("../../classes/CBDConn.php");

$salida = '{"res": 0, "msg":"LOS PARAMETROS NO SE RECIBIERON CORRECTAMENTE"}';
if(isset($_GET["params"])){
  $filtro = $_GET["params"];
  $salida = '{"res": 0, "msg":"NO SE PUDO CONECTAR A LA BD"}';
  $conn = new CBDConn();
  $connex = $conn->createConnection();

  if(isset($connex)){
    $sql = "SELECT a.idhome, a.idusr, a.name, a.desc, a.strt, a.numext, a.numint, a.zipc, a.suburb, a.entity, a.phne, a.tyhome, a.isact, a.dreg, a.dupd ".
           " , b.typehome ".
           " , c.user, c.email, c.phne, c.fsname, c.lsname, c.dobt, c.tyusr, c.isact ".
           " , d.typeuser, d.isadmin ".
           " FROM dbneigh_admin.thomes a ".
           " INNER JOIN dbneigh_admin.thomes_type b ON b.tyhome = a.tyhome ".
           " INNER JOIN dbneigh_admin.tusers c ON c.idusr = a.idusr ".
           " INNER JOIN dbneigh_admin.tusers_type d ON c.tyusr = d.tyusr ".
           " ORDER BY a.idusr, a.idhome ASC ";
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
      $salida = '{"res": 1, "msg":"DATOS DE HOGARES OBTENIDOS"'.$filas.'}';
      $jsonSalida = json_decode($salida);
    }
  }
  $connex->close();
}
header('Content-Type: application/json; charset=utf-8');
echo ($salida);
?>
