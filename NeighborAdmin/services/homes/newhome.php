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
      $sql1 = 'select count(*) as existe from dbneigh_admin.thomes a where iduser = '.$jsonParams->idusr.' and name like "%'.$jsonParams->name.'%" ';
      $resultado1 = $connex->query($sql1);
      $salida = '{"res": 0, "msg":"NO SE PUDO OBTENER INFORMACION DE LA BD"}';
      if(isset($resultado1)){
        while($row = $resultado1->fetch_assoc()){
          $existe = $row["existe"];
        }
        mysqli_free_result($resultado1);
        $salida = '{"res": 0, "msg":"EL HOGAR PARA EL USUARIO YA EXISTE VERIFIQUE SUS DATOS"}';
        if($existe == 0){
          $sql2 = 'select ifnull((select max(idhome) from dbneigh_admin.thomes where idusr = '.$jsonParams->idusr.'),0) + 1 as maximo ';
          $resultado2 = $connex->query($sql2);
          $salida = '{"res": 0, "msg":"NO SE PUDO OBTENER EL SIGUIENTE ID PARA EL HOGAR DEL USUARIO"}';
          if(isset($resultado2)){
            $existe = 0;
            while($row = $resultado2->fetch_assoc()){
              $existe = $row["maximo"];
            }
            mysqli_free_result($resultado2);
            $sql3 = 'insert into dbneigh_admin.thomes(idhome, idusr, name, desc, strt, numext, numint, zipc, suburb, entity, phne, tyhome, isact, dreg) values ('
              .$existe.','.$jsonParams->idusr.',"'.$jsonParams->name.'","'.$jsonParams->desc.'","'.$jsonParams->strt.'","'.$jsonParams->numext.'","'
              .$jsonParams->numint.'","'.$jsonParams->zipc.'","'.$jsonParams->entity.'","'.$jsonParams->phne.'",'.$jsonParams->tyhome.',1,current_timestamp)';
            $resultado4 = $connex->query($sql3);
            $filasact = $connex->affected_rows;
            if($filasact > 0){
              $salida = '{"res": 1, "msg":"HOGAR PARA EL USUARIO REGISTRADO ('.$filasact.')"}';
            }else{
              $salida = '{"res": 0, "msg":"NO SE PUDO REGISTRAR EL HOGAR PARA EL USUARIO"}';
            }
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
