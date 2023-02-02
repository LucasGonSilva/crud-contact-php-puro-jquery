<?php

include 'connection.php';

$con_id = filter_input(INPUT_GET, "con_id", FILTER_SANITIZE_NUMBER_INT);

if (!empty($con_id)) {

    $query_contato = "DELETE FROM contatos WHERE con_id = :con_id";
    $resultado = $conn->prepare($query_contato);
    $resultado->bindParam(':con_id', $con_id);
    
    if($resultado->execute()){
        $retorna = [
            'error' => false,
            'msg' => '  <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Contato excluido com sucesso!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>'
        ];
    } else {
        $retorna = [
            'error' => true,
            'msg' => '  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Error: Contato não excluido!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>'
        ];
    }
} else {
    $retorna = [
        'error' => true,
        'msg' => '  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Error: Nenhum contato encontrado!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>'
    ];
}

echo json_encode($retorna);
