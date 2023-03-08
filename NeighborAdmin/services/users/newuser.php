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
      $sql1 = 'select count(*) as existe from dbneigh_admin.tusers a where (a.user like "%'.$jsonParams->user.'%") or (a.email like "%'.$jsonParams->email.'%") or (a.phne like "%'.$jsonParams->phne.'%")';
      $resultado1 = $connex->query($sql1);
      $salida = '{"res": 0, "msg":"NO SE PUDO OBTENER INFORMACION DE LA BD"}';
      if(isset($resultado1)){
        while($row = $resultado1->fetch_assoc()){
          $existe = $row["existe"];
        }
        mysqli_free_result($resultado1);
        $salida = '{"res": 0, "msg":"EL USUARIO / EMAIL / TELEFONO YA EXISTE VERIFIQUE SUS DATOS"}';
        if($existe == 0){
          $sql2 = 'select ifnull((select max(idusr) from dbneigh_admin.tusers ),0) + 1 as maximo ';
          $resultado2 = $connex->query($sql2);
          $salida = '{"res": 0, "msg":"NO SE PUDO OBTENER EL SIGUIENTE ID PARA EL USUARIO"}';
          if(isset($resultado2)){
            $existe = 0;
            while($row = $resultado2->fetch_assoc()){
              $existe = $row["maximo"];
            }
            mysqli_free_result($resultado2);
            $sql3 = 'insert into dbneigh_admin.tusers(idusr, user, psswd, email, phne, fsname, lsname, dobth, tyusr, isact, dreg) values ('
              .$existe.',"'.$jsonParams->user.'",password("'.$jsonParams->psswd.'"),"'.$jsonParams->email.'","'.$jsonParams->phne.'","'
              .$jsonParams->fsname.'","'.$jsonParams->lsname.'","'.$jsonParams->dobth.'","'.$jsonParams->tyusr.'",1,current_timestamp)';
            //echo $sql3."<br />";
            $resultado4 = $connex->query($sql3);
            $filasact = $connex->affected_rows;
            if($filasact > 0){
              $salida = '{"res": 1, "msg":"USUARIO REGISTRADO ('.$filasact.')"}';
            }else{
              $salida = '{"res": 0, "msg":"NO SE PUDO REGISTRAR AL USUARIO"}';
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
