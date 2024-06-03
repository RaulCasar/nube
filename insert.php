<?php require "templates/header.php"; ?>

<div class="center-align">

    <?php
    // Mostrar errores de PHP para depuración
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (isset($_POST['submit'])) {
        require "database/config.php";

        // Establecer la conexión
        // Establecer la conexión sin SSL
        $conn = mysqli_connect($host, $username, $password, $db_name);

        if (!$conn) {
            die('Failed to connect to MySQL: ' . mysqli_connect_error());
        }

        echo "Conexión establecida correctamente.<br>";

        $res = mysqli_query($conn, "SHOW TABLES LIKE 'Products'");

        if (mysqli_num_rows($res) <= 0) {
            // Crear la tabla si no existe
            $sql = file_get_contents("database/schema.sql");
            if (!mysqli_query($conn, $sql)) {
                die('Table Creation Failed: ' . mysqli_error($conn));
            }
            echo "Tabla creada correctamente.<br>";
        }

        // Insertar datos del formulario
        $ProductName = mysqli_real_escape_string($conn, $_POST['ProductName']);
        $Price = mysqli_real_escape_string($conn, $_POST['Price']);

        // Validar los datos del formulario
        if (empty($ProductName) || !is_numeric($Price)) {
            echo "<h2>Por favor ingrese un nombre de producto válido y un precio numérico.</h2>";
        } else {
            if ($stmt = mysqli_prepare($conn, "INSERT INTO Products (ProductName, Price) VALUES (?, ?)")) {
                mysqli_stmt_bind_param($stmt, 'sd', $ProductName, $Price);
                mysqli_stmt_execute($stmt);
                if (mysqli_stmt_affected_rows($stmt) == 0) {
                    echo "<h2>Actualización de catálogo fallida</h2>";
                } else {
                    echo "<h2>El producto \"$ProductName\" ha sido añadido</h2>";
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "<h2>Error en la preparación de la declaración: " . mysqli_error($conn) . "</h2>";
            }
        }

        // Cerrar la conexión
        mysqli_close($conn);
        echo "Conexión cerrada.<br>";
    } else {
    ?>

    <h2>Agregar un producto</h2>
    <br>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <table>
            <tr>
                <td class="no-border"><label for="ProductName">Nombre del producto</label></td>
                <td class="no-border"><input type="text" name="ProductName" id="ProductName" required></td>
            </tr>
            <tr>
                <td class="no-border"><label for="Price">Precio (MXN)</label></td>
                <td class="no-border"><input type="text" name="Price" id="Price" required></td>
            </tr>
        </table>      
        <br><br>
        <input type="submit" name="submit" value="Enviar">
    </form>

    <?php
    }
    ?>

    <br><br><br>
    <table>
        <tr>
            <td><a href="insert.php">Agregar otro producto</a></td>
            <td><a href="read.php">Ver productos</a></td>
            <td><a href="index.php">Volver a página de inicio</a></td>
        </tr>
    </table>

</div>

<?php require "templates/footer.php"; ?>
