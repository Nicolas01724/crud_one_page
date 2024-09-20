<?php
class Database {
    private $connection = null;

    public function __construct($host, $user, $password, $dbname) {
        $this->connection = new mysqli($host, $user, $password, $dbname);
    }

    public  function close() {
        $connection->close();
    }

    public function query($raw) {
        return mysqli_query($this->connection, $raw);
    }
}

class Control {


    static function create($name, $product, $quantity, $date) {
        $raw = "INSERT INTO pedidos (nome_cliente, nome_produto, quantidade, data_pedido) VALUES ('$name', '$product', '$quantity', '$date');";
        global $db;
        $db->query($raw);
    }

    static function show() {
        $raw = "SELECT * FROM pedidos;";
        global $db;
        $response = $db->query($raw);

        $data = [];
        
        while($row = $response->fetch_assoc()) {
            array_push($data, $row);
        }

        return $data;
    }

}

$db = new Database("localhost", "root", "root", "crud_nicolas");

$edit = false;

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if(isset($_POST["name"]) && isset($_POST["name_product"]) && (isset($_POST["quantity"])) && (isset($_POST["date"]))) {
        $name = $_POST["name"];
        $product = $_POST["name_product"];
        $quantity = $_POST["quantity"];
        $date = $_POST["date"];
    }

    Control::create($name, $product, $quantity, $date);
}

$response = Control::show();

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud</title>
</head>
<body>
    <?php if ($edit == false): ?>
        <form method="POST">
            <label for="name">Nome:</label>
            <input type="name" name="name" require>
            <label for="name_product">Nome do produto:</label>
            <input type="name" name="name_product" require>
            <label for="quantity">Quantidade:</label>
            <input type="number" name="quantity" require>
            <label for="date">Data:</label>
            <input type="date" name="date" require>
            <button type="submit">Criar</button>
        </form>

        <section>
            <?php foreach($response as $user): ?>
            <div>
                <p>Nome: <?= $user["nome_cliente"] ?> </p>
                <p>Produto: <?= $user["nome_produto"] ?> </p>
                <p>Quantidade: <?= $user["quantidade"] ?> </p>
                <p>Data: <?= $user["data_pedido"] ?> </p>
                <input name="id" value="<?= $user["id"] ?>" style="display: none">
                <button type="submit">Deletar</button>
                <br>
            </div>
            <?php endforeach ?>
        </section>

    <?php endif  ?>
    
</body>
</html>