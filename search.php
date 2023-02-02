<?php

include 'connection.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (!empty($dados['txtNomeSearch'])) {
    $nome = '%' . $dados["txtNomeSearch"] . '%';
}
if (!empty($dados['txtTelefoneSearch'])) {
    $telefone = '%' . $dados["txtTelefoneSearch"] . '%';
}
if (!empty($dados['txtCPFSearch'])) {
    $cpf = '%' . $dados["txtCPFSearch"] . '%';
}

$query_contacts = "SELECT con_id, con_nome, con_telefone, con_cpf FROM contatos WHERE con_nome LIKE :con_nome OR con_telefone LIKE :con_telefone OR con_cpf LIKE :con_cpf";
$result_contacts = $conn->prepare($query_contacts);
$result_contacts->bindParam(':con_nome', $nome);
$result_contacts->bindParam(':con_telefone', $telefone);
$result_contacts->bindParam(':con_cpf', $cpf);
$result_contacts->execute();

$dados = "<div class='table-responsive'>
                <table class='table table-striped table-bordered'>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>CPF</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>";

while ($row_contact = $result_contacts->fetch(PDO::FETCH_ASSOC)) {
    extract($row_contact);
    $dados .= "<tr>
                        <td>$con_id</td>
                        <td>$con_nome</td>
                        <td>$con_telefone</td>
                        <td>$con_cpf</td>
                        <td>
                            <button id='$con_id' class='btn btn-primary btn-sm' onclick='visualizarContato($con_id)'>Visualizar</button>
                            <button id='$con_id' class='btn btn-warning btn-sm' onclick='editarContatoDados($con_id)'>Editar</button>
                            <button id='$con_id' class='btn btn-danger btn-sm' onclick='excluirContatoDados($con_id)'>Excluir</button>
                        </td>
                    </tr>";
}
$dados .= "</tbody>
        </table>
        </div>";

echo $dados;
