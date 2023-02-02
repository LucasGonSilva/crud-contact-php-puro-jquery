<?php

include 'connection.php';

$pagina = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_NUMBER_INT);

if (!empty($pagina)) {

    //Calcular o inicio visualização
    $qtd_result_pg = 5; // quantidade de registro por página

    $inicio = ($pagina * $qtd_result_pg) - $qtd_result_pg;

    $query_contacts = "SELECT con_id, con_nome, con_telefone, con_cpf FROM contatos ORDER BY con_id DESC LIMIT $inicio, $qtd_result_pg";
    $result_contacts = $conn->prepare($query_contacts);
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
    //Paginação - Somar a quantidade de contatos
    $query_pg = "SELECT COUNT(con_id) AS num_result FROM contatos";
    $result_pg = $conn->prepare($query_pg);
    $result_pg->execute();
    $row_pg = $result_pg->fetch(PDO::FETCH_ASSOC);

    //Quantidade de página
    $quantidade_pg = ceil($row_pg['num_result'] / $qtd_result_pg);
    $max_link = 2;


    $dados .= '<nav aria-label="Page navigation example"><ul class="pagination justify-content-center pagination-sm">';
    $dados .= '<li class="page-item"><a class="page-link" href="#" onclick="listContacts(1)">Primeira</a></li>';
    for ($pag_ant = $pagina - $max_link; $pag_ant <= $pagina - 1; $pag_ant++) {
        if ($pag_ant >= 1) {
            $dados .= '<li class="page-item"><a class="page-link" href="#" onclick="listContacts(' . $pag_ant . ')">' . $pag_ant . '</a></li>';
        }
    }
    $dados .= '<li class="page-item active"><a class="page-link" href="#">' . $pagina . '</a></li>';
    for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_link; $pag_dep++) {
        if ($pag_dep <= $quantidade_pg) {
            $dados .= '<li class="page-item"><a class="page-link" href="#" onclick="listContacts(' . $pag_dep . ')">' . $pag_dep . '</a></li>';
        }
    }
    $dados .= '<li class="page-item"><a class="page-link" href="#" onclick="listContacts(' . $quantidade_pg . ')">Última</a></li>';
    $dados .= '</ul></nav>';

    echo $dados;
} else {
    echo "<div class='alert alert-danger' role='alert'>Nenhum contato encontrado!</div>";
}
