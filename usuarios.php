<?php
header("Content-Type: application/json; charset=utf-8");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$host = "localhost";
$user = "root";
$pass = "";
$db = "api_video";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error){
    http_response_code(500);
    echo json_encode(["error" => "Falha na conexão: " . $conn->connect_error]);
    exit;

}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method){
    case 'GET':
        if (isset($_GET['pesquisa'])){
            $pesquisa = "%" . $_GET['pesquisa'] . "%";

            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE LOGIN LIKE ? NOME LIKE ?");

            $stmt->blind_param("ss",$pesquisa, $pesquisa);

            $stmt->execute();

            $resul = $stmt->get_result();

        }else{
            $resul = $conn->query("SELECT * FROM usuarios order by ID desc");

        }

        $retorno = [];

        while ($linha = $result->fetch_assoc()){
            $retorno[] = $linha;


        }

        echo json_encode($retorno);
        break;

        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);

            $stmt = $conn->prepare("INSERT INTO usuarios (LOGIN, NOME, EMAIL, SENHA, ATIVO) VALUES (?, ?, ?, ?, ?");

            $stmt->blind_param("ssssi", $data['LOGIN'], $data['NOME'], $data['EMAIL'], $data['SENHA'], $data['ATIVO']);

            $stmt->execute();

            echo json_encode(["status" => "ok", "insert_id"=> $stmt->insert_id]);
            break;

        case 'PUT':
            $data = json_decode(file_get_contents("php://input"), true);

            $stmt = $conn->prepare("UPDATE usuarios SET LOGIN=?, NOME=?, EMAIL=?, SENHA=?, ATIVO=? WHERE ID=?");

            $stmt->blind_param("ssssii",$data['LOGIN'], $data['NOME'], $data['EMAIL'], $data['SENHA'], $data['ATIVO'], $data['ID']);

            $stmt->execute();
            echo json_encode(["status"=>"ok"]);
            break;

        case 'DELETE':
            $id = $_GET['id'];
            $stmt = $conn->prepare("DELETE FROM usuarios WHERE ID=?");
            $stmt->blind_param("i", $id);
            $stmt->execute();
            echo json_encode(["status" => "ok"]);
            break;


}

$conn->close();