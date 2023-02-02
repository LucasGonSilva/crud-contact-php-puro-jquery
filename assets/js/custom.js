const tbody = document.querySelector(".list-contact");
const cadForm = document.getElementById("cadContatoForm");
const editForm = document.getElementById("editContatoForm");
const msgAlertaErrorCad = document.getElementById("msgAlertaErrorCad");
const msgAlertaErrorEdit = document.getElementById("msgAlertaErrorEdit");
const msgAlerta = document.getElementById("msgAlerta");
const searchForm = document.getElementById("searchFormContact");
const cadModal = new bootstrap.Modal(
  document.getElementById("cadContatoModal")
);

const listContacts = async (pagina) => {
  const dados = await fetch("../../list.php?pagina=" + pagina);
  const resposta = await dados.text();
  tbody.innerHTML = resposta;
};

listContacts(1);

cadForm.addEventListener("submit", async (e) => {
  e.preventDefault();

  document.getElementById("cadContatoBtn").value = "Salvando...";

  if (document.getElementById("txtNome").value == "") {
    msgAlertaErrorCad.innerHTML = ` <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        Error: Necessário preencher o campo nome!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>`;
  } else if (document.getElementById("txtTelefone").value == "") {
    msgAlertaErrorCad.innerHTML = ` <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        Error: Necessário preencher o campo telefone!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>`;
  } else if (document.getElementById("txtCPF").value == "") {
      "<div class='alert alert-danger' role='alert'>Error: Necessário preencher o campo nome!</div>";
    msgAlertaErrorCad.innerHTML = ` <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        Error: Necessário preencher o campo CPF!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>`;
  } else {
    const dadosForm = new FormData(cadForm);
    dadosForm.append("add", 1);

    const dados = await fetch("../../create.php", {
      method: "POST",
      body: dadosForm,
    });

    const resposta = await dados.json();
    if (resposta["error"]) {
      msgAlertaErrorCad.innerHTML = resposta["msg"];
    } else {
      msgAlerta.innerHTML = resposta["msg"];
      cadForm.reset();
      cadModal.hide();
      listContacts(1);
    }
  }

  document.getElementById("cadContatoBtn").value = "Cadastrar";
});

// Visualizar Contato
async function visualizarContato(con_id) {
  const dados = await fetch("../../view.php?con_id=" + con_id);
  const resposta = await dados.json();

  if (resposta["erro"]) {
    msgAlerta.innerHTML = resposta["msg"];
  } else {
    const visuModal = new bootstrap.Modal(
      document.getElementById("visualizarContatoModal")
    );
    visuModal.show();
    document.getElementById("idContato").innerHTML = resposta["dados"].con_id;
    document.getElementById("nomeContato").innerHTML =
      resposta["dados"].con_nome;
    document.getElementById("telefoneContato").innerHTML =
      resposta["dados"].con_telefone;
    document.getElementById("cpfContato").innerHTML = resposta["dados"].con_cpf;
  }
}

// Editar Contato
async function editarContatoDados(con_id) {
  msgAlertaErrorEdit.innerHTML = "";
  const dados = await fetch("../../view.php?con_id=" + con_id);

  const resposta = await dados.json();

  if (resposta["erro"]) {
    msgAlerta.innerHTML = resposta["msg"];
  } else {
    const editContatoModal = new bootstrap.Modal(
      document.getElementById("editContatoModal")
    );
    editContatoModal.show();

    document.getElementById("editId").value = resposta["dados"].con_id;
    document.getElementById("editNome").value = resposta["dados"].con_nome;
    document.getElementById("editTelefone").value =
      resposta["dados"].con_telefone;
    document.getElementById("editCPF").value = resposta["dados"].con_cpf;
  }
}
editForm.addEventListener("submit", async (e) => {
  e.preventDefault();

  document.getElementById("editContatoBtn").value = "Salvando...";

  const dadosForm = new FormData(editForm);

  const dados = await fetch("../../edit.php", {
    method: "POST",
    body: dadosForm,
  });

  const resposta = await dados.json();
  if (resposta["error"]) {
    msgAlertaErrorEdit.innerHTML = resposta["msg"];
  } else {
    msgAlertaErrorEdit.innerHTML = resposta["msg"];
    listContacts(1);
  }
  document.getElementById("editContatoBtn").value = "Salvar";
});

async function excluirContatoDados(con_id) {
  var confirmar = confirm("Tem certeza que deseja excluir o registro?");
  if (confirmar) {
    const dados = await fetch("../../delete.php?con_id=" + con_id);

    const resposta = await dados.json();

    if (resposta["error"]) {
      msgAlerta.innerHTML = resposta["msg"];
    } else {
      msgAlerta.innerHTML = resposta["msg"];
      listContacts(1);
    }
  }
}

async function cancelSearch() {
    searchForm.reset();
    listContacts(1);
}

async function searchContact() {
  msgAlerta.innerHTML = "";
  tbody.innerHTML = "";
  const dadosForm = new FormData(searchForm);
 
  const dados = await fetch("../../search.php", {
    method: "POST",
    body: dadosForm,
  });

  const resposta = await dados.text();
  tbody.innerHTML = resposta;
}