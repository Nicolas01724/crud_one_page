<?php
class Database {
    private $connection = null;

    private $host = "localhost";
    private $user = "root";
    private $password = "root";
    private $dbname = "crud_nicolas";

    public function __construct() {
        $this->connection = new mysqli($host, $user, $password, $dbname);
    }

    static function close() {
        $this->connection->close();
    }

    static function query($raw) {
        mysqli_query($this->connection, $raw);
    }

}

$edit = false;

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud</title>
</head>
<body>
    <?php if ($edit = false) { ?>
        <form action="POST">
            <label for="name">Nome:</label>
            <input type="name" name="name" require>
            <label for="name_product">Nome do produto:</label>
            <input type="name" name="name_product" require>
            <label for="quantity">Pedido:</label>
            <input type="number" name="quantity" require>
            <label for="date">Data:</label>
            <input type="date" name="date" require>
        </form>

    <?php }  ?>
    
</body>
</html>