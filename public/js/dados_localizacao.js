/**
 * Esste script executaServJson faz uma requisição GET em um servidor que retorna um JSON com dados da conexão, ip, latitude, longitude, entre
 * outras informações. Está disponível 3 servidores que se por algum motivo um deles estiver fora, outro pode retornar
 * as informações necessárias para o cadastro. Inclusive, cada um tem uma limitação de solicitações por dia
 * http://www.geoplugin.net/json.gp = 120 solicitações por minuto. 
 * https://ipapi.co/json/ = 1000 solicitações por dia
 * http://ip-api.com/json = 150 solicitações por minuto
 * https://www.jrossetto.com.br/tutoriais/jquery-javascript/funcao-javascript-para-detectar-ip-interno-ip-publico-e-ipv6/
 * 
 * A função executaServJson() é invocada pela função trocaServidor() que percorre o array servidor_json em busca dos dados
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

/**
 * A função trocaServidor() é uma função asyncrona que tem um temporizador de 5 segundos, que julgo 
 * ser necessário para receber o retorno do servidor. Caso não tenha um retorno a variável i
 * é incrementada e o próximo servidor é acionado na tentativa de pegar os dados.
 * O switch é necessário, já que cada servidor tem uma nomeclatura diferente para seus atributos.
 * Os input referente a estes dados estão no modo hidden e serão preencidos assim que o 1º servidor responder
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