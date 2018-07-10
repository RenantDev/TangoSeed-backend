<?php

namespace App\Http\Controllers;

class UtilController extends Controller
{

    // Converte qualquer string em um slug
    public static function slug($string, $transform_space = '-') {
        $table = array(
            'Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z', 'ú' => 'u', 'û' => 'u',
            'ž' => 'z', 'Č' => 'C', 'č' => 'c', 'Ć' => 'C', 'ć' => 'c', 'ÿ' => 'y', 'Ŕ' => 'R',
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'ý' => 'y', 'ý' => 'y',
            'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'ï' => 'i', 'ð' => 'o',
            'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'ñ' => 'n', 'ò' => 'o',
            'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'ó' => 'o', 'ê' => 'e',
            'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'í' => 'i', 'î' => 'i',
            'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'ë' => 'e', 'ì' => 'i',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'ù' => 'u', 'þ' => 'b',
            'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
            'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ŕ' => 'r');
        // Traduz os caracteres em $string, baseado no vetor $table
        $tra_string = strtr($string, $table);
        // converte para minúsculo
        $con_string = strtolower($tra_string);
        // remove caracteres indesejáveis (que não estão no padrão)
        $rem_string = preg_replace("/[^a-z0-9_\s-]/", "", $con_string);
        // Remove múltiplas ocorrências de hífens ou espaços
        $reMul_string = preg_replace("/[\s-]+/", " ", $rem_string);
        $esp_string = trim($reMul_string);
        // Transforma espaços e underscores em hífens
        $result_string = preg_replace("/[\s_]/", $transform_space, $esp_string);
        // retorna a string
        return $result_string;
    }

    // Pega o IP do usuário
    public static function clientIP() {
        $REMOTE_ADDR = filter_input(INPUT_ENV, 'REMOTE_ADDR', FILTER_VALIDATE_IP);
        return $REMOTE_ADDR;
    }

}
