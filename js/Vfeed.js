// var busca = document.getElementById("busca");
// var bpesquisar = document.getElementById("bpesquisar");

// bpesquisar.addEventListener('click', validar);
 


function toggleCurtir(button) {
  button.classList.toggle('curtido');
}

 // Adiciona evento de submit ao formulário para validar o campo de texto
 document.getElementById('ObjetoDeEstudo').addEventListener('submit', function(e) {
    var campoTexto = document.getElementById('Texto').value.trim();

    // Verifica se o campo de texto está vazio
    if (campoTexto === '') {
      e.preventDefault(); // Impede o envio do formulário
      exibirMensagemErro('Campo não pode ser vazio.');
    } else {
      // Aqui você pode adicionar outras validações conforme necessário
      // Por exemplo, verificar o comprimento mínimo, caracteres permitidos, etc.
      // Se estiver tudo correto, o formulário será enviado normalmente
    }
  });

  // Função para exibir mensagem de erro
  function exibirMensagemErro(mensagem) {
    var mensagemErro = document.getElementById('mensagemErro');
    mensagemErro.textContent = mensagem;
    mensagemErro.style.display = 'block';
  }

  document.getElementById('abrirtela').addEventListener('click', function() {
    document.getElementById('fundoModal').style.display = 'block';
  });

  document.getElementById('fecharFormulario').addEventListener('click', function() {
    document.getElementById('fundoModal').style.display = 'none';
  });

  //Abrir perfil
  document.getElementById('perfil').onclick = function() {
    window.location.href = 'perfilusuario.php';
  };
