<?php

include_once "connection.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (empty($dados['con_id'])) {
    $retorna = [
        'error' => true,
        'msg' => '  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Error: Tente mais tarde!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>'
    ];
} elseif (empty($dados['txtNome'])) {
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
} 
else {
    $query_contato = "UPDATE contatos SET con_nome = :con_nome, con_telefone = :con_telefone, con_cpf = :con_cpf WHERE con_id = :con_id";
    $editContato = $conn->prepare($query_contato);
    $editContato->bindParam(':con_nome', $dados['txtNome']);
    $editContato->bindParam(':con_telefone', $dados['txtTelefone']);
    $editContato->bindParam(':con_cpf', $dados['txtCPF']);
    $editContato->bindParam(':con_id', $dados['con_id']);

    if ($editContato->execute()) {
        $retorna = [
            'error' => false,
            'msg' => '  <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Contato alterado com sucesso!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>'
        ];
    } else {
        $retorna = [
            'error' => true,
            'msg' => '  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Error: Contato não alterado com sucesso!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>'
        ];
    }
}

echo json_encode($retorna);
