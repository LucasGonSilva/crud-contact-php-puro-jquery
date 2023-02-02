<?php
include 'connection.php';

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <title>Teste - Supremo CRM</title>
</head>

<body>
    <div class="container">
        <div class="row mt-4">
            <div class="col-lg-12 d-flex justify-content-between align-itens-center">
                <div>
                    <h4>Lista de Contatos</h4>
                </div>
                <div>
                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#cadContatoModal">
                        Cadastrar
                    </button>
                </div>
            </div>
        </div>
        <hr>
        <span id="msgAlerta"></span>
        <div class="row">
            <form class="row g-3 mb-3" id="searchFormContact" method="POST">
                <div class="col-md-4">
                    <label for="txtNome" class="form-label">Nome</label>
                    <input type="text" class="form-control" name="txtNomeSearch" id="txtNomeSearch" placeholder="Digite o Nome">
                </div>
                <div class="col-md-4">
                    <label for="txtTelefoneSearch" class="form-label">Telefone:</label>
                    <input type="text" class="form-control txtTelefone" name="txtTelefoneSearch" id="txtTelefoneSearch" placeholder="Digite o Telefone">
                </div>
                <div class="col-md-4">
                    <label for="txtCPFSearch" class="form-label">CPF:</label>
                    <input type="text" class="form-control txtCPF" name="txtCPFSearch" id="txtCPFSearch" placeholder="Digite o CPF">
                </div>
                <div class="col-12 text-center">
                    <button type="button" class="btn btn-secodary" onclick="cancelSearch();">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="searchContact();">Pesquisar</button>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <span class="list-contact"></span>
            </div>
        </div>
    </div>
    <div class="modal fade" id="cadContatoModal" tabindex="-1" aria-labelledby="cadContatoModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cadContatoModal">Cadastrar Contato</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="cadContatoForm" method="POST">
                        <span id="msgAlertaErrorCad"></span>
                        <div class="mb-3">
                            <label for="txtNome" class="col-form-label">Nome:</label>
                            <input type="text" class="form-control" name="txtNome" id="txtNome" placeholder="Digite o Nome">
                        </div>
                        <div class="mb-3">
                            <label for="txtTelefone" class="col-form-label">Telefone:</label>
                            <input type="text" class="form-control txtTelefone" name="txtTelefone" id="txtTelefone" placeholder="Digite o Telefone">
                        </div>
                        <div class="mb-3">
                            <label for="txtCPF" class="col-form-label">CPF:</label>
                            <input type="text" class="form-control txtCPF" name="txtCPF" id="txtCPF" onchange="validateCPF(this.value)" placeholder="Digite o CPF">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Fechar</button>
                            <input type="submit" class="btn btn-success btn-sm" id="cadContatoBtn" value="Cadastrar" />
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="visualizarContatoModal" tabindex="-1" aria-labelledby="visualizarContatoModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="visualizarContatoModal">Detalhes do Contato</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span id="msgAlertaErrorVisu"></span>
                    <dl class="row">
                        <dt class="col-sm-3">ID</dt>
                        <dd class="col-sm-9"><span id="idContato"></span></dd>
                        <dt class="col-sm-3">Nome</dt>
                        <dd class="col-sm-9"><span id="nomeContato"></span></dd>
                        <dt class="col-sm-3">Telefone</dt>
                        <dd class="col-sm-9"><span id="telefoneContato"></span></dd>
                        <dt class="col-sm-3">CPF</dt>
                        <dd class="col-sm-9"><span id="cpfContato"></span></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Editar Contato -->
    <div class="modal fade" id="editContatoModal" tabindex="-1" aria-labelledby="editContatoModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editContatoModalLabel">Editar Contato</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editContatoForm" method="post">
                        <span id="msgAlertaErrorEdit"></span>
                        <input type="hidden" class="form-control" name="con_id" id="editId" />
                        <div class="mb-3">
                            <label for="editNome" class="col-form-label">Nome:</label>
                            <input type="text" class="form-control" name="txtNome" id="editNome" placeholder="Digite o nome">
                        </div>
                        <div class="mb-3">
                            <label for="editTelefone" class="col-form-label">Telefone:</label>
                            <input type="text" class="form-control txtTelefone" name="txtTelefone" id="editTelefone" placeholder="Digite o seu Telefone">
                        </div>
                        <div class="mb-3">
                            <label for="editCPF" class="col-form-label">CPF:</label>
                            <input type="text" class="form-control txtCPF" name="txtCPF" id="editCPF" placeholder="Digite o seu CPF">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Fechar</button>
                            <input type="submit" class="btn btn-success btn-sm" id="editContatoBtn" value="Alterar" />
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-1.9.0.min.js"></script>
    <script src="assets/js/jquery.mask.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/validations.js"></script>
    <script>
        $(document).ready(function() {
            $('.txtCPF').mask('000.000.000-00', {
                reverse: true
            });
            $('.txtTelefone').mask("(99) 99999-9999")
                .focusout(function(event) {
                    var target, phone, element;
                    target = (event.currentTarget) ? event.currentTarget : event.srcElement;
                    phone = target.value.replace(/\D/g, '');
                    element = $(target);
                    element.unmask();
                    if (phone.length > 10) {
                        element.mask("(99) 99999-9999");
                    } else {
                        element.mask("(99) 9999-9999");
                    }
                });
        });
    </script>
</body>

</html>