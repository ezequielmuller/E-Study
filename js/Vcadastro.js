var btv = document.getElementById('cadastrar');
var form = document.getElementById('form');
btv.addEventListener('click', validar);
form.addEventListener('submit', validar);

var subNome = document.getElementById("campoNome");
var subSobrenome = document.getElementById("campoSobrenome");
var subNomeDeUsu = document.getElementById("campoNomeUsuario");
var subTel = document.getElementById("campoTelefone");
var subEmail = document.getElementById("campoEmail");
var subSenha = document.getElementById("campoSenha");
var subCSenha = document.getElementById("campoCSenha");

function validar(e) {
    if (!validarNome() || !validarSobrenome() || !validarNomeUsuario() || !validarTelefone() || !validarEmail() || !validarSenha() || !confirmarSenha()) {
        e.preventDefault(); // Cancela a submissão do formulário
    }
}

//Nome
function validarNome() {
    var nm1 = document.getElementById('nome').value;

    subNome.innerHTML = '';
    subNome.classList.remove("erro");

    if (nm1 === '' || nm1.length < 1) {
        subNome.innerHTML = "Nome inválido (Campo não pode ser vazio)";
        subNome.classList.add("erro");
        return false;
    }
    return true;
}

//Sobrenome
function validarSobrenome() {
    var sobren = document.getElementById('sobrenome').value;

    subSobrenome.innerHTML = '';
    subSobrenome.classList.remove("erro");

    if (sobren === '' || sobren.length < 1) {
        subSobrenome.innerHTML = "Sobrenome inválido (Campo não pode ser vazio)";
        subSobrenome.classList.add("erro");
        return false;
    }
    if (!isNaN(sobren)) {
        subSobrenome.innerHTML = "Sobrenome não pode conter dígitos numéricos";
        subSobrenome.classList.add("erro");
        return false;
    }
    return true;
}

function validarNomeUsuario() {
    var nusuario = document.getElementById('nomeusuario').value;

    subNomeDeUsu.innerHTML = '';
    subNomeDeUsu.classList.remove('erro');

    if (nusuario === '' || nusuario.length < 5) {
        subNomeDeUsu.innerHTML = "Não pode estar vazio, e deve conter no mínimo 5 caracteres";
        subNomeDeUsu.classList.add("erro");
        return false;
    }

    var regex = /[^a-z0-9_]/g;
    if (regex.test(nusuario)) {
        subNomeDeUsu.innerHTML = "Nome de usuário pode conter apenas letras minúsculas, números e sublinhados";
        subNomeDeUsu.classList.add("erro");
        return false;
    }
    return true;
}

//Validação Telefone
function validarTelefone() {
    var telefone = document.getElementById("telefone").value.replace(/\D/g, ''); // Remover não numéricos

    subTel.innerHTML = '';
    subTel.classList.remove("erro");

    // Verificar se o telefone tem 11 dígitos após a formatação
    if (telefone.length !== 11) {
        subTel.innerHTML = "Telefone inválido, utilize um telefone válido de 11 dígitos ex: '54123456789'";
        subTel.classList.add("erro");
        return false;
    }
    return true;
}

// Evento input para formatar o número de telefone em tempo real
document.getElementById("telefone").addEventListener("input", function() {
    var telefone = this.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
    var formattedTelefone;

    if (telefone.length >= 2 && telefone.length <= 11) {
        // Formatar com DDD
        formattedTelefone = "(" + telefone.substring(0, 2) + ") ";

        // Adicionar o restante do número
        if (telefone.length > 2 && telefone.length <= 7) {
            formattedTelefone += telefone.substring(2, 7);
        } else if (telefone.length > 7) {
            formattedTelefone += telefone.substring(2, 7) + "-" + telefone.substring(7);
        }

        // Definir o valor do campo de telefone com a formatação
        this.value = formattedTelefone;
    } else {
        // Se o número for menor que 2 ou maior que 11, não aplicar formatação
        this.value = telefone;
    }
});

//E-mail
function validarEmail() {
    var email = document.getElementById('email').value;
    var partesEmail = email.split("@"); // Correção aqui

    subEmail.innerHTML = '';
    subEmail.classList.remove("erro");

    if (email.indexOf(".") === -1 || email.indexOf("@") === -1 || email.indexOf(" ") >= 0 || partesEmail.length !== 2 || partesEmail[0].length === 0 || partesEmail[1].length === 0) {
        subEmail.innerHTML = "Email inválido, utilize um email válido sem espaços, e certifique-se que contém caracteres antes e depois do @ e com pelo menos uma extensão no email '.', ex: 'xx.com'";
        subEmail.classList.add("erro");
        return false;
    }
    return true;
}

function validarSenha() {
    var senha = document.getElementById("senha").value;

    subSenha.innerHTML = '';
    subSenha.classList.remove("erro", "certo");

    var caractereEspecial = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;

    if (!caractereEspecial.test(senha) || senha.indexOf(" ") >= 0) {
        subSenha.innerHTML = "Senha inválida, é necessário ter um caractere especial para aumentar sua segurança.";
        subSenha.classList.add("erro");
        return false;
    } else {
        subSenha.innerHTML = "Senha Forte!";
        subSenha.classList.add("certo");
        return true;
    }
}

function confirmarSenha() {
    var senha = document.getElementById("senha").value;
    var confirmarSenha = document.getElementById("csenha").value;

    subCSenha.innerHTML = '';
    subCSenha.classList.remove("erro");

    if (senha !== confirmarSenha || confirmarSenha.indexOf(" ") >= 0) {
        subCSenha.innerHTML = "A confirmação de senha não coincide com a senha digitada.";
        subCSenha.classList.add("erro");
        return false;
    }
    return true;
}

// Adicionando evento de clique ao botão "Mostrar Senha"
document.getElementById("btnsenha").addEventListener("click", function() {
    var senhaInput = document.getElementById("senha");
    if (senhaInput.type === "password") {
        senhaInput.type = "text";
        this.textContent = "Ocultar Senha";
    } else {
        senhaInput.type = "password";
        this.textContent = "Mostrar Senha";
    }
});

document.getElementById("btnCsenha").addEventListener("click", function() {
    var senhaInput = document.getElementById("csenha");
    if (senhaInput.type === "password") {
        senhaInput.type = "text";
        this.textContent = "Ocultar Senha";
    } else {
        senhaInput.type = "password";
        this.textContent = "Mostrar Senha";
    }
});