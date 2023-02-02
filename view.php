<?php

include 'connection.php';

$con_id = filter_input(INPUT_GET, "con_id", FILTER_SANITIZE_NUMBER_INT);

if (!empty($con_id)) {

    $query_contato = "SELECT con_id, con_nome, con_telefone, con_cpf FROM contatos WHERE con_id = :con_id LIMIT 1";
    $resultado = $conn->prepare($query_contato);
    $resultado->bindParam(':con_id', $con_id);
    $resultado->execute();

    $dados = $resultado->fetch(PDO::FETCH_ASSOC);

    $retorna = [
        'error' => false,
        'dados' => $dados
    ];

} else {
    echo "<div class='alert alert-danger' role='alert'>Nenhum contato encontrado!</div>";
    $retorna = [
        'error' => true,
        'msg' => '  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Error: Nenhum contato encontrado!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>'
    ];
}

echo json_encode($retorna);
