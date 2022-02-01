<?php
// função recebe uma string e retorna somente os números
function somenteNumeros($string){
    return preg_replace("/[^0-9]/", "", $string);
}