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
        if ($raw == "SELECT * FROM pedidos;") {
        return mysqli_query($this->connection, $raw);
        } else {
        mysqli_query($this->connection, $raw);
        }
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

    static function delete($id) {
        global $db;
        $raw = "DELETE FROM pedidos WHERE id = $id;";
        $db->query($raw);
    }

    static function edit($name, $product, $quantity, $date, $id, $table) {
        global $db;
        $raw = "UPDATE $table SET nome_cliente = $name, nome_produto = $product, quantidade = $quantity, data_pedido = $date WHERE id = $id;";
        db->query($raw);
    }
}

$db = new Database("localhost", "root", "root", "crud_nicolas");

$edit = false;

if ($_SERVER["REQUEST_METHOD"] == 'POST' && !isset($_POST["delete"])) {
    if(isset($_POST["name"]) && isset($_POST["name_product"]) && (isset($_POST["quantity"])) && (isset($_POST["date"]))) {
        $name = $_POST["name"];
        $product = $_POST["name_product"];
        $quantity = $_POST["quantity"];
        $date = $_POST["date"];
        Control::create($name, $product, $quantity, $date);
    }

}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST["delete"])) {
    
    $id = $_POST["id"];
    Control::delete($id);
}

// if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST["edit"])) {
//     if(isset($_POST["name"]) && isset($_POST["name_product"]) && (isset($_POST["quantity"])) && (isset($_POST["date"]))) {
//         $name = $_POST["name"];
//         $product = $_POST["name_product"];
//         $quantity = $_POST["quantity"];
//         $date = $_POST["date"];
//         $table = "pedidos";
//         Control::edit($name, $product, $quantity, $date, $id, $table);
//     }    
//     $id = $_POST["id"];
//     Control::edit($id);
// }

$response = Control::show();

$form_values = [
    "name" => "asdadds",
    "name_product" => "",
    "quantity" => "",
    "date" => "",
];

if (isset($_POST["edit"])) {
    $response = $db->query($raw);

    $form_values = $response.fetch_assoc();
}

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud</title>
</head>
<body>
        <form method="POST">
            <label for="name">Nome:</label>
            <input type="name" name="name" value="<?= $form_values["name"] ?>" require>
            <label for="name_product">Nome do produto:</label>
            <input type="name" name="name_product" value="<?= $form_values["name_product"] ?>" require>
            <label for="quantity">Quantidade:</label>
            <input type="number" name="quantity" value="<?= $form_values["quantity"] ?>" require>
            <label for="date">Data:</label>
            <input type="date" name="date" value="<?= $form_values["date"] ?>" require>
            <button type="submit">Criar</button>
        </form>

        <section>
            <?php foreach($response as $user): ?>
                <form method="POST">
                    <div>
                        <p>Nome: <?= $user["nome_cliente"] ?> </p>
                        <p>Produto: <?= $user["nome_produto"] ?> </p>
                        <p>Quantidade: <?= $user["quantidade"] ?> </p>
                        <p>Data: <?= $user["data_pedido"] ?> </p>
                        <input name="id" value="<?= $user["id"] ?>" style="display: none">
                        <button type="submit">Deletar</button>
                        <input type="hidden" name="edit" value="edit">
                        <button type="submit">Editar</button>
                        <br>
                    </div>
                </form>
            <?php endforeach ?>
        </section>

    
</body>
</html>