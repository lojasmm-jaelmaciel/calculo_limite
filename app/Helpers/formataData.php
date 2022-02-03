<?php
/**
 * Funções transformam datas entre o padrão brasileiro e americano.
 * Do pt-br para americano quando a data vem do formulário HTML
 * Do americano para o pt-br quando a data vem do DB.
 * 
 * @param [string] $data_form
 * @param [date] $data_db
 * @return string
 */
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