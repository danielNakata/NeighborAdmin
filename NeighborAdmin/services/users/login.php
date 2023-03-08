<?php
  include("../../classes/CBDConn.php");

  $salida = '{"res": 0, "msg":"LOS PARAMETROS NO SE RECIBIERON CORRECTAMENTE"}';
  $params = $_POST["params"];

  if(isset($params)){
    $salida = '{"res": 0, "msg":"NO SE PUDO CONECTAR A LA BD"}';
    $conn = new CBDConn();
    $connex = $conn->createConnection();

    if(isset($connex)){
      $jsonParams = json_decode($params);
      $sql1 = "select count(*) as existe from dbneigh_admin.tusers a where (a.user = '".$jsonParams->login."' and a.psswd = password('".$jsonParams->psswd."'))
       xor (a.email = '".$jsonParams->login."' and a.psswd = password('".$jsonParams->psswd."')) xor (a.phne = '".$jsonParams->login."' and a.psswd = password('".$jsonParams->psswd."'))";
      $existe = 0;
      $resultado1 = $connex->query($sql1);
      $salida = '{"res": 0, "msg":"NO SE PUDO OBTENER INFORMACION DE LA BD"}';
      if(isset($resultado1)){
        while($row = $resultado1->fetch_assoc()){
          $existe = $row["existe"];
        }
        mysqli_free_result($resultado1);
        if($existe == 1){
          $sql2 = "select a.idusr, a.user, a.email, a.phne, a.fsname, a.lsname, a.dobth, a.tyusr, a.isact, a.dldtlog, a.dreg, a.dupd "
          .", b.typeuser, b.isadmin "
          ." from dbneigh_admin.tusers a "
          ." inner join dbneigh_admin.tusers_type b on a.tyusr = b.tyusr "
          ."where (a.user = '".$jsonParams->login."') xor (a.email = '".$jsonParams->login."') xor (a.phne = '".$jsonParams->login."') ";
          $resultado2 = $connex->query($sql2);
          $filas = "";
          while($row = $resultado2->fetch_assoc()){
            $aux = "";
            while($col = $resultado2->fetch_field()){
              $aux.= ',"'.$col->name.'":"'.$row[$col->name].'"';
            }
            $filas .= ",{".substr($aux,1)."}";
          }
          mysqli_free_result($resultado2);
          $filas = ',"datos": ['.substr($filas,1).']';
          $salida = '{"res": 1, "msg":"INICIO DE SESION CORRECTO"'.$filas.'}';
          $jsonSalida = json_decode($salida);
          $sql3 = "insert into dbneigh_admin. taccesslog(idusr, issuc, dreg) values (".$jsonSalida->datos[0]->idusr.", 1, current_timestamp)";
          $resultado3 = $connex->query($sql3);
          //mysqli_free_result($resultado3);
        }else{
          $salida = '{"res": 0, "msg":"USUARIO NO ENCONTRADO VERIFIQUE SU INFORMACION"}';
        }
      }
    }
    $connex->close();
  }
  header('Content-Type: application/json; charset=utf-8');
  echo ($salida);
?>
