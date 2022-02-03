<?php
/**
 * Retira dodo e qualquer caracter que não seja um número inteiro
 * entre 0 e 9
 *
 * @param [string] $string
 * @return string
 */
function somenteNumeros($string){
    return preg_replace("/[^0-9]/", "", $string);
}