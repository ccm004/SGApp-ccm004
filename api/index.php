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
        // Inicializar la conexión mysqli
        $conexion = mysqli_init();
        
        if (!$conexion) {
            die('Error al inicializar mysqli');
        }
        
        // Rutas de los certificados SSL
        $ssl_ca = __DIR__ . '/server-ca.pem';
        $ssl_cert = __DIR__ . '/client-cert.pem';
        $ssl_key = __DIR__ . '/client-key.pem';
        
        // Verificar si existen los certificados
        if (file_exists($ssl_ca)) {
            // Configurar SSL
            // Desactivar verificación del nombre del certificado para permitir conexión por IP
            mysqli_options($conexion, MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, false);
            
            // Si existen certificados de cliente, usarlos
            if (file_exists($ssl_cert) && file_exists($ssl_key)) {
                // Conexión SSL completa con certificados de cliente
                mysqli_ssl_set(
                    $conexion,
                    $ssl_key,       // client-key.pem
                    $ssl_cert,      // client-cert.pem
                    $ssl_ca,        // server-ca.pem
                    NULL,           // capath
                    NULL            // cipher
                );
            } else {
                // Conexión SSL solo con certificado del servidor
                mysqli_ssl_set(
                    $conexion,
                    NULL,           // key
                    NULL,           // cert
                    $ssl_ca,        // server-ca.pem
                    NULL,           // capath
                    NULL            // cipher
                );
            }
            
            // Conectar a la base de datos con SSL
            $conectado = mysqli_real_connect(
                $conexion,
                getenv('MYSQL_HOST'),
                getenv('MYSQL_USER'),
                getenv('MYSQL_PASSWORD'),
                'SG',
                3306,
                NULL,
                MYSQLI_CLIENT_SSL
            );
        } else {
            // Si no existe el certificado, conectar sin SSL
            echo "<!-- Advertencia: Conectando sin SSL (certificado no encontrado) -->";
            $conectado = mysqli_real_connect(
                $conexion,
                getenv('MYSQL_HOST'),
                getenv('MYSQL_USER'),
                getenv('MYSQL_PASSWORD'),
                'SG',
                3306,
                NULL,
                0
            );
        }
        
        // Verificar la conexión
        if (!$conectado) {
            die("Error de conexión: " . mysqli_connect_error() . " (Código: " . mysqli_connect_errno() . ")");
        }

        // Consulta SQL
        $cadenaSQL = "SELECT * FROM s_customer";
        $resultado = mysqli_query($conexion, $cadenaSQL);
        
        if (!$resultado) {
            die("Error en la consulta: " . mysqli_error($conexion));
        }

        // Mostrar resultados
        while ($fila = mysqli_fetch_object($resultado)) {
         echo "<tr><td>" . htmlspecialchars($fila->name) . 
         "</td><td>" . htmlspecialchars($fila->credit_rating) .
         "</td><td>" . htmlspecialchars($fila->address) .
         "</td><td>" . htmlspecialchars($fila->city) .
         "</td><td>" . htmlspecialchars($fila->state) .
         "</td><td>" . htmlspecialchars($fila->country) .
         "</td><td>" . htmlspecialchars($fila->zip_code) .
         "</td></tr>";
       }
       
       // Cerrar la conexión
       mysqli_close($conexion);
       ?>
     </tbody>
   </table>
 </div>
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>
