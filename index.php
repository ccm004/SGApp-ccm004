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
            // 1. Activar reporte de errores para ver qué pasa si falla
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        
            $dbUser = getenv('MYSQL_USER');
            $dbPass = getenv('MYSQL_PASSWORD');
            $dbName = "SG"; // O getenv('MYSQL_DB') si lo agregaste al yaml
            $cloudSqlName = getenv('CLOUD_SQL_CONNECTION_NAME');
            $dbHost = getenv('MYSQL_HOST'); // Solo si decides probar con IP localmente
        
            // 2. Lógica de conexión inteligente
            // Si existe la variable CLOUD_SQL_CONNECTION_NAME, usamos el Socket (Modo App Engine)
            if ($cloudSqlName) {
                // El socket siempre está en /cloudsql/NOMBRE_CONEXION
                $socketPath = "/cloudsql/" . $cloudSqlName;
                $conexion = mysqli_connect(null, $dbUser, $dbPass, $dbName, null, $socketPath);
            } else {
                // Si no, intentamos usar la IP (Modo Local o si dejaste la IP configurada)
                $conexion = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
            }
            
            // Verificación de conexión
            if (!$conexion) {
                // Imprimimos el error en rojo para que sea visible
                die("<tr><td colspan='7' style='color: red; font-weight: bold;'>
                    Conexión fallida: " . mysqli_connect_error() . " <br>
                    (Verifica que el Instance Connection Name en app.yaml sea correcto)
                    </td></tr>");
            }
        
            $cadenaSQL = "select * from s_customer";
            $resultado = mysqli_query($conexion, $cadenaSQL);
        
            if (!$resultado) {
                die("<tr><td colspan='7'>Error en la consulta: " . mysqli_error($conexion) . "</td></tr>");
            }
        
            // Verificar si hay 0 filas
            if (mysqli_num_rows($resultado) == 0) {
                 echo "<tr><td colspan='7'>Conexión exitosa, pero la tabla s_customer está vacía.</td></tr>";
            }
        
            while ($fila = mysqli_fetch_object($resultado)) {
                echo "<tr>";
                // Asegúrate que estos nombres coinciden EXACTAMENTE con tus columnas en la BD
                echo "<td>" . ($fila->name ?? 'N/A') . "</td>"; 
                echo "<td>" . ($fila->credit_rating ?? 'N/A') . "</td>";
                echo "<td>" . ($fila->address ?? 'N/A') . "</td>";
                echo "<td>" . ($fila->city ?? 'N/A') . "</td>";
                echo "<td>" . ($fila->state ?? 'N/A') . "</td>";
                echo "<td>" . ($fila->country ?? 'N/A') . "</td>";
                echo "<td>" . ($fila->zip_code ?? 'N/A') . "</td>"; 
                echo "</tr>";
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

