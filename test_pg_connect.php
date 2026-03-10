<?php
$host = 'aws-0-us-west-2.pooler.supabase.com';
$port = 6543;
$dbname = 'postgres';
$user = 'postgres.zeukpybmnurnckiophdo';
$password = 'vfNQu!9TZy3!PHe';

echo "Intentando conectar con pg_connect...\n";
echo "Conexión string: host=$host port=$port dbname=$dbname user=$user\n\n";

// Intentar conexión
$connection_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
$conn = @pg_connect($connection_string);

if ($conn) {
    echo "✓ Conexión exitosa con pg_connect!\n";
    
    // Obtener información
    $result = pg_query($conn, "SELECT version();");
    if ($result) {
        $row = pg_fetch_row($result);
        echo "PostgreSQL: " . $row[0] . "\n";
    }
    
    pg_close($conn);
} else {
    echo "✗ Error con pg_connect: " . pg_last_error() . "\n";
    
    // Intentar sin especificar la contraseña
    echo "\nIntentando sin contraseña en el string...\n";
    $conn2 = @pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
    if ($conn2) {
        echo "✓ Funcionó sin password en connection_string\n";
        pg_close($conn2);
    } else {
        echo "✗ Tampoco funcionó\n";
    }
}
