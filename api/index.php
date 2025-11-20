
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Customer Catalog</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
</head>
<body>
  <div class = "container">
    <div class="jumbotron">
      <h1 class="display-4">Customer Catalog</h1>
      <p class="lead">Customer Catalog Sample Application</p>
      <hr class="my-4">
      <p>PHP sample application connected to a MySQL database to list a customer catalog</p>
    </div>
    <table class="table table-striped table-responsive">
      <thead>
        <tr>
          <th>Name</th>
          <th>Credit Rating</th>
          <th>Address</th>
          <th>City</th>
          <th>State</th>
          <th>Country</th>
          <th>Zip</th>
        </tr>
      </thead>
            
       <tbody>
          <?php
          // Prueba de Ejecución: Si esto no se muestra, el problema es enrutamiento.
          echo "<tr><td colspan='7'>Diagnóstico de Conexión. Host: " . getenv('MYSQL_HOST') . "</td></tr>"; 
          
          // @ suprime warnings para que podamos manejar el error con if/else
          $db_host = getenv('MYSQL_HOST'); // e.g., 136.113.69.174
          $db_user = getenv('MYSQL_USER');
          $db_password = getenv('MYSQL_PASSWORD');
          $db_name = getenv('MYSQL_DB');

// Cambiar la conexión para usar la IP y puerto (null)
$conexion = mysqli_connect($db_host, $db_user, $db_password, $db_name, 3306);
      
          // Revisar el Fallo de Conexión
          if (mysqli_connect_errno()) {
              $error_msg = mysqli_connect_error();
              
              // ** Aquí veremos el error real de la base de datos **
              echo "<tr><td colspan='7' style='color:red;'> 
                  ❌ ERROR DE CONEXIÓN: " . htmlspecialchars($error_msg) . "
              </td></tr>";
              die("Error en la aplicación: Fallo de DB."); 
              
          } else {
              // Conexión exitosa, ejecuta la consulta
              echo "<tr><td colspan='7' style='color:green;'>✅ Conexión a la base de datos exitosa.</td></tr>";
      
              $cadenaSQL = "select * from s_customer";
              $resultado = mysqli_query($conexion, $cadenaSQL);
      
              if ($resultado) {
                  while ($fila = mysqli_fetch_object($resultado)) {
                      echo "<tr><td> " .$fila->name . 
                      "</td><td>" . $fila->credit_rating .
                      "</td><td>" . $fila->address .
                      "</td><td>" . $fila->city .
                      "</td><td>" . $fila->state .
                      "</td><td>" . $fila->country .
                      "</td><td>" . $fila->zip_code .
                      "</td></tr>";
                  }
              } else {
                   echo "<tr><td colspan='7' style='color:orange;'>⚠️ Error en la consulta SQL: " . mysqli_error($conexion) . "</td></tr>";
              }
              mysqli_close($conexion);
          }
          ?>
      </tbody>
      
   </table>
 </div>
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>
