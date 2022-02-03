/**
 * Essa função é invocada quando o usuário clicar no botão Dowload Cadstros e ou Download CSV.
 * O script irá fazer uma conexão com o backend, mais precisamente com a roda json que irá fazer
 * a busca dos dados no DB e retornar um Json. Se a a operação xhttp.readyState for concluida (4)
 * e o xhttp.status (200) então o xhttp.responseText é atribuido na variável data.
 * Em seguida o cabeçalho do CSV é criado. Um forEach percorre data para formar as linhas da tabela.
 * Por fim o arquivo tipo CSV é criado e disponível para download.
 */
function gerarCSV() {

    const BASE_URL = 'http://127.0.0.1:8000/'
    var data;
    var url = BASE_URL + 'json';
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", url, false);

    //Função a ser chamada quando a requisição retornar do servidor
    xhttp.onreadystatechange = function () {
        //Verifica se o retorno do servidor deu certo
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            data = JSON.parse(xhttp.responseText);
            // extraido data de dentro de data 
            return false
        }

    } /* xhttp function() */
    xhttp.send();   //A execução do script CONTINUARÁ mesmo que a requisição não tenha retornado do servidor

    var i = 1;
    var csv = 'codigo, nome, data_nascimento, sexo, cpf, rg, rg_data_expedicao, '+ 
    'rg_orgao_expedicao, email, telefone, naturalidade_estado, naturalidade_cidade, '+
    'nacionalidade, estado_civil, nome_mae, rua, numero, bairro, cidade, estado, cep, '+
    'tipo_residencia, reside_desde, empresa, telefone, salario, data_admissao, cargo, '+ 
    'ramo_atividade, ip_endereco, latitude, longitude\n';

    data.forEach(function (row) {
        csv += i++;
        csv += ';' + row.nome;
        csv += ';' + row.data_nascimento;
        csv += ';' + row.sexo;
        csv += ';' + row.cpf;
        csv += ';' + row.rg;
        csv += ';' + row.rg_data_expedicao;
        csv += ';' + row.rg_orgao_expedicao;
        csv += ';' + row.email;
        csv += ';' + row.telefone;
        csv += ';' + row.naturalidade_estado;
        csv += ';' + row.naturalidade_cidade;
        csv += ';' + row.nacionalidade;
        csv += ';' + row.estado_civil;
        csv += ';' + row.nome_mae;
        csv += ';' + row.rua;
        csv += ';' + row.numero;
        csv += ';' + row.bairro;
        csv += ';' + row.cidade;
        csv += ';' + row.estado;
        csv += ';' + row.cep;
        csv += ';' + row.tipo_residencia;
        csv += ';' + row.reside_desde;
        csv += ';' + row.empresa;
        csv += ';' + row.telefone;
        csv += ';' + row.salario;
        csv += ';' + row.data_admissao;
        csv += ';' + row.cargo;
        csv += ';' + row.ramo_atividade;
        csv += ';' + row.ip_endereco;
        csv += ';' + row.latitude;
        csv += ';' + row.longitude;
        csv += '\n';
    });

    // processo de codificação dos dados para csv e criação do link para download
    var hiddenElement = document.createElement('a');
    hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
    hiddenElement.target = '_blank';
    hiddenElement.download = 'produtos.csv';
    hiddenElement.click();

}