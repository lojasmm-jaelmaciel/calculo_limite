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
        }/* if */

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

    var hiddenElement = document.createElement('a');
    hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
    hiddenElement.target = '_blank';
    hiddenElement.download = 'produtos.csv';
    hiddenElement.click();

}

// var produtos = [
//     {
//         codigo: '01',
//         nome: 'Pastilha freio uno',
//         descricao: 'Serve até ano 2000'
//     },
//     {
//         codigo: '02',
//         nome: 'Pastilha freio gol',
//         descricao: 'Server para 1ª 2ª e 3ª geração'
//     }];

// var _gerarCsv = function () {

//     var csv = 'codigo, nome, descricao\n';

//     produtos.forEach(function (row) {
//         csv += row.codigo;
//         csv += ',' + row.nome;
//         csv += ',' + row.descricao;
//         csv += '\n';
//     });

//     var hiddenElement = document.createElement('a');
//     hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
//     hiddenElement.target = '_blank';
//     hiddenElement.download = 'produtos.csv';
//     hiddenElement.click();
// };
//   _gerarCsv();
