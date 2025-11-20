<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Customer Catalog</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" xintegrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
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
                // --- CONEXIÓN SSL A CLOUD SQL ---
                
                // Parámetros de conexión desde variables de entorno
                $db_host = getenv('MYSQL_HOST');
                $db_user = getenv('MYSQL_USER');
                $db_pass = getenv('MYSQL_PASSWORD');
                $db_name = "SG";
                
                // Ruta del certificado de CA de Google (Debe estar en la misma carpeta /api)
                $ssl_ca = __DIR__ . '/server-ca.pem'; 

                // Variables de estado
                $conexion = false;
                $error_msg = "";

                // 1. Inicializar la conexión
                $mysqli = mysqli_init();

                if ($mysqli) {
                    // 2. Configurar SSL con el certificado de CA de Google
                    if (mysqli_ssl_set($mysqli, NULL, NULL, $ssl_ca, NULL, NULL)) {
                        // 3. Establecer la conexión real (forzando SSL)
                        if (mysqli_real_connect($mysqli, $db_host, $db_user, $db_pass, $db_name, 3306, NULL, MYSQLI_CLIENT_SSL)) {
                            $conexion = $mysqli;
                        } else {
                            $error_msg = "Error de Conexión SSL/Credenciales: (" . mysqli_connect_errno() . ") " . mysqli_connect_error();
                        }
                    } else {
                        $error_msg = "Error al configurar SSL en MySQLi. Verifique la ruta del certificado.";
                    }
                } else {
                    $error_msg = "Error al inicializar MySQLi.";
                }

                // --- MANEJO DE ERRORES Y CONSULTA ---
                
                // Si la conexión falló, muestra un mensaje de error detallado
                if (!$conexion) {
                    echo '<tr><td colspan="7"><div class="alert alert-danger" role="alert">';
                    echo '<strong>ERROR FATAL:</strong> Falló la conexión segura a la base de datos.';
                    echo '<br><strong>Verifique:</strong> 1. Que SSL esté HABILITADO en Cloud SQL. 2. Que el archivo <code>server-ca.pem</code> esté en <code>api/</code>. 3. Variables de entorno.';
                    echo '<br>Detalles del error: ' . htmlspecialchars($error_msg);
                    echo '</div></td></tr>';
                    $resultado = false; // Asegura que el bucle no se ejecute
                } else {
                    // Si la conexión es exitosa, ejecuta la consulta
                    $cadenaSQL = "select * from s_customer";
                    $resultado = mysqli_query($conexion, $cadenaSQL);
                    
                    if (!$resultado) {
                        // Error de consulta
                        $error_msg = "Error de consulta: " . mysqli_error($conexion);
                        echo '<tr><td colspan="7"><div class="alert alert-warning" role="alert">';
                        echo '<strong>ERROR de BD:</strong> ' . htmlspecialchars($error_msg);
                        echo '</div></td></tr>';
                    }
                }
                
                // --- MOSTRAR RESULTADOS ---

                if ($resultado) {
                    while ($fila = mysqli_fetch_object($resultado)) {
                        echo "<tr><td> " . htmlspecialchars($fila->name) . 
                        "</td><td>" . htmlspecialchars($fila->credit_rating) .
                        "</td><td>" . htmlspecialchars($fila->address) .
                        "</td><td>" . htmlspecialchars($fila->city) .
                        "</td><td>" . htmlspecialchars($fila->state) .
                        "</td><td>" . htmlspecialchars($fila->country) .
                        "</td><td>" . htmlspecialchars($fila->zip_code) .
                        "</td></tr>";
                    }
                    // Cierre de la conexión
                    mysqli_close($conexion);
                }
                ?>
      </tbody>
   </table>
 </div>
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" xintegrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" xintegrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" xintegrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>
