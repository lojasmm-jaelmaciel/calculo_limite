// executa a função load ao carrega a página
document.addEventListener("DOMContentLoaded", load);
// pega os botões de próximo e anterior
const prevBtns = document.querySelectorAll(".btn-prev");
const nextBtns = document.querySelectorAll(".btn-next");
// pega a foto-label progress onde vai aparecer a linha de progresso do form
const progress = document.getElementById("progress");
// pega as divs que contemém partes do form
const formPassos = document.querySelectorAll(".form-step");
// pega as divs onde vai aparecer as blinhas numeradas
const progressSteps = document.querySelectorAll(".progress-step");
// pega o botão salvar, que é o botão que fará o submit do formulário
const btn_salvar = document.getElementById('btn-salvar');

/* a função load tira o evento de submit do formulário. Pois os botões de próximo e anterior 
acabam fazendo o submit do formulário */
function load() {
  const formulario = document.getElementById('formulario');
  formulario.addEventListener("submit", (event) => event.preventDefault());
}

/** habilita o submit novamente quando precionado enter (código 13) ou ao clicar o mouse sobre o botão salvar */
btn_salvar.addEventListener('keydown', event => {
  if (event.key == 13) {
    formulario.submit()
  }
});
btn_salvar.addEventListener('click', () => formulario.submit());



// numero de passos para chegar no final "progress-step"
let formPassosNum = 0;

/**
 * nextBtns e prevBtns incrementam e decrementam os passos chamando as atualizações
 * da barra de progresso e de formulário
 */
nextBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    formPassosNum++;
    updateFormSteps();
    updateBarraProgresso();
  });
});

prevBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    formPassosNum--;
    updateFormSteps();
    updateBarraProgresso();
  });
});


// verifica se a div formStep tem a classe que lhe define como ativa, se sim, então ela é removida
// e a div formStep seguinte é adicionada a classe form-step-active para ser exibida
function updateFormSteps() {
  formPassos.forEach((formStep) => {
    formStep.classList.contains("form-step-active") &&
      formStep.classList.remove("form-step-active");
  });

  formPassos[formPassosNum].classList.add("form-step-active");
}

// adiciona ou remove a classe progress-setep-active nas divs que define a bolinha
// cinza ou vermelha conforme a valor de idx
function updateBarraProgresso() {
  progressSteps.forEach((progressStep, idx) => {
    if (idx < formPassosNum + 1) {
      progressStep.classList.add("progress-step-active");
    } else {
      progressStep.classList.remove("progress-step-active");
    }
  });

  const progressActive = document.querySelectorAll(".progress-step-active");
  // calcula a largura da barra de progresso e aplica os estilos de cor e altura da barra
  // var(--cor-vermelha) esse valor é definido dentro do CSS
  progress.style.width = ((progressActive.length - 1) / (progressSteps.length - 1)) * 100 + "%";
  progress.style.backgroundColor = "var(--cor-vermelha)";
  progress.style.height = "8px";
}

/**################################################################### */

/*
Essa função executaServJson faz uma requisição GET em um servidor que retorna um JSON com dados da conexão, latitude, longitude, entre
outras informações. Está disponível 3 servidores que se por algum motivo um deles estiver fora, outro pode retornar
as informações necessárias para o cadastro. Inclusive, cada um tem uma limitação de solicitações por dia
http://www.geoplugin.net/json.gp = 120 solicitações por minuto
https://ipapi.co/json/ = 1000 solicitações por dia
http://ip-api.com/json = 150 solicitações por minuto
https://www.jrossetto.com.br/tutoriais/jquery-javascript/funcao-javascript-para-detectar-ip-interno-ip-publico-e-ipv6/
*/

// ponteiro para percorrer o array servidor_json
var i = 0;
servidor_json = ["http://ip-api.com/json", "https://ipapi.co/json/", "http://www.geoplugin.net/json.gp"];
var retorno = null;

async function executaServJson() {

  var url = servidor_json[i];
  var xhttp = new XMLHttpRequest();
  xhttp.open("GET", url, true);

  //Função a ser chamada quando a requisição retornar do servidor
  xhttp.onreadystatechange = function () {

    //Verifica se o retorno do servidor deu certo
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      retorno = JSON.parse(xhttp.responseText);

      return false;

    }

  }; // xhttp function()

  xhttp.send();   //A execução do script CONTINUARÁ mesmo que a requisição não tenha retornado do servidor

}

/*
A função trocaServidor é uma função asyncrona que tem um temporizador de 5 segundos, que julgo
ser necessário para receber o retorno do servidor. Caso não tenha um retorno a variável i
é incrementada e o próximo servidor é acionado na tentativa de pegar os dados.
O switch é necessário, já que cada servidor tem uma nomeclatura diferente para seus atributos.
 */
async function trocaServidor() {
  var ip_endereco = document.getElementById('ip_endereco');
  var latitude = document.getElementById('latitude');
  var longitude = document.getElementById('longitude');
  while (retorno == null) {
    executaServJson();
    await new Promise(resolve => setTimeout(resolve, 5000));
    if (retorno == null) {
      i++;
    } else {
      switch (i) {
        case 0:
          // console.log(retorno.city);
          ip_endereco.value = retorno.query;
          latitude.value = retorno.lat;
          longitude.value = retorno.lon;
          break;
        case 1:
          // console.log(retorno.city);
          ip_endereco.value = retorno.ip;
          latitude.value = retorno.latitude;
          longitude.value = retorno.longitude;
          break;
        case 2:
          // console.log(retorno.geoplugin_city);
          ip_endereco.value = retorno.geoplugin_request;
          latitude.value = retorno.geoplugin_latitude;
          longitude.value = retorno.geoplugin_longitude;
          break;
      }
    }
  }
}

trocaServidor();


/*
Adiciona um EventListener no input da foto e fica aguardando uma mudança no input.
Quando a mudança acontecer, o script lê o arquivo e adiciona no src da tag img e em seguida
através do readAsDataURL evento loadend é disparado. Então o atributo result irá conter
a URL codificada em base64 do arquivo. 
Em seguida ele troca o atributo style das classes: foto-label-icone e foto-label-text para
que exibir uma e ocultar a outra.
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

function fecharModal(){
  var mensagem_modal = document.getElementById("mensagem-modal");
  mensagem_modal.style.display = "none";
}

