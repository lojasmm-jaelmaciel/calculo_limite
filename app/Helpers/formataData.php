<?php
// função recebe uma data no padrão pt-BR e retorna transformada para o padrão americano
function formataDataEn($data_form){
    $data_array = explode("/", $data_form);
    $data_array = array_reverse($data_array);
    $data_formatada = implode("-", $data_array);
    return $data_formatada;
}

function formataDataPtBr($data_db){
    $data_array = explode("-", $data_db);
    $data_array = array_reverse($data_array);
    $data_formatada = implode("/", $data_array);
    return $data_formatada;
}