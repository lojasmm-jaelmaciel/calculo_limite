/**
 * Adiciona um EventListener no input da foto e fica aguardando uma mudança no input.
 * Quando a mudança acontecer, o script lê o arquivo e adiciona no src da tag img e em seguida
 * através do readAsDataURL evento loadend é disparado. Então o atributo result irá conter
 * a URL codificada em base64 do arquivo. 
 * Em seguida ele troca o atributo style das classes: foto-label-icone e foto-label-text para
 * que seja possível exibir uma e ocultar a outra.
 */
document.getElementById("foto-input").addEventListener("change", function () {
  if (this.files && this.files[0]) {
    var arquivo = new FileReader();
    // executa a função quado o arquivo estiver carregado em memória
    arquivo.onload = function (e) {
      var exibe_img = document.getElementById("exibe-img");
      exibe_img.classList.add("exibe-img");
      // adiciona o arquivo no src da tag img
      exibe_img.src = e.target.result;
      document.getElementById('foto-label-icone').style.display = "none";
      document.getElementById('foto-label-text').style.display = "block";
    };
    // dispara o evento loadend carregando o endereço do arquivo no src da tag img e exibindo na tela.
    arquivo.readAsDataURL(this.files[0]);

  }
});


/**
 * Função invocada no momento que o usuário clicar sobre o x da janela modal
 * então um atributo display de style/css recebe "none" e é fechado.
 */
function fecharModal(){
  var mensagem_modal = document.getElementById("mensagem-modal");
  mensagem_modal.style.display = "none";
}

