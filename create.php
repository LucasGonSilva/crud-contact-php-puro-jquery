<?php

include_once "connection.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (empty($dados['txtNome'])) {
    $retorna = [
        'error' => true,
        'msg' => '  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Error: Necessário preencher o campo nome!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>'
    ];
} elseif (empty($dados['txtTelefone'])) {
    $retorna = [
        'error' => true,
        'msg' => '  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Error: Necessário preencher o campo telefone!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>'
    ];
} elseif (empty($dados['txtCPF'])) {
    $retorna = [
        'error' => true,
        'msg' => '  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Error: Necessário preencher o campo CPF!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>'
    ];
} else {
    $query_contato = "INSERT INTO contatos (con_nome, con_telefone, con_cpf) VALUES (:con_nome, :con_telefone, :con_cpf)";
    $cadContato = $conn->prepare($query_contato);
    $cadContato->bindParam(':con_nome', $dados['txtNome']);
    $cadContato->bindParam(':con_telefone', $dados['txtTelefone']);
    $cadContato->bindParam(':con_cpf', $dados['txtCPF']);

    $cadContato->execute();

    if ($cadContato->rowCount()) {
        $retorna = [
            'error' => false,
            'msg' => '  <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Contato cadastrado com sucesso!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>'
        ];
    } else {
        $retorna = [
            'error' => true,
            'msg' => '  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Error: Contato não cadastrado!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>'
            
        ];
    }
}

echo json_encode($retorna);
