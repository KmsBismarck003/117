<?php

class Curp {

    public function __construct() {
    }

    private function limpiarCadena($cadena) {
        $string = trim($cadena);
        $string = str_replace(array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $string);
        $string = str_replace(array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $string);
        $string = str_replace(array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $string);
        $string = str_replace(array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $string);
        $string = str_replace(array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $string);
        $string = str_replace(array('ñ', 'Ñ', 'ç', 'Ç'), array('X', 'X', 'c', 'C',), $string);
        $string = str_replace(array("\\", "¨", "º", "-", "~", "#", "@", "|", "!", "\"", "·", "$", "%", "&", "/", "(", ")", "?", "'", "¡",
            "¿", "[", "^", "<code>", "]", "+", "}", "{", "¨", "´", ">", "< ", ";", ",", ":", ".", " "), ' ', $string);
        $string = strtoupper($string);
        $string = str_replace(array('jose', 'JOSE', 'MARIA', 'maria', 'MARIANA', 'mariana', 'del', 'DEL', 'al', 'AL', 'de', 'DE', 'la', 'LA'), array('', ''), $string);
        return $string;
    }

    private function claveNombre($nombres, $apellido1, $apellido2) {
        $paterno = str_replace(' ', '', $this->limpiarCadena($apellido1));
        $materno = str_replace(' ', '', $this->limpiarCadena($apellido2));
        $names = str_replace(' ', '', $this->limpiarCadena($nombres));
        $long = strlen($paterno);
        for ($i = 1; $i < $long; $i++) {
            if (in_array($paterno[$i], ["A", "E", "I", "O", "U"])) {
                $primera_vocal = $paterno[$i];
                break;
            } else {
                $primera_vocal = "";
            }
        }
        $Apellido_paterno = $paterno[0] . $primera_vocal;
        $Apellido_materno = $materno[0];
        $Nombre = $names[0];
        $curp_name = $Apellido_paterno . $Apellido_materno . $Nombre;
        return $curp_name;
    }

    private function claveFechaNa($diase, $mes, $annio) {
        $year = $annio[2].$annio[3];
        $fechaa = $year . $mes . $diase;
        return $fechaa;
    }

    private function caveSexoEdo($sexo, $edo) {
        return $sexo . $edo;
    }

    private function claveConsonantesInternas($nombres, $apellido1, $apellido2) {
        $paterno = str_replace(' ', '', $this->limpiarCadena($apellido1));
        $materno = str_replace(' ', '', $this->limpiarCadena($apellido2));
        $nombre = str_replace(' ', '', $this->limpiarCadena($nombres));
        $long_ap = strlen($paterno);
        for ($i = 1; $i < $long_ap; $i++) {
            if (in_array($paterno[$i], ["A", "E", "I", "O", "U"])) {
                $consonantes_paterno = "";
            } else {
                $consonantes_paterno = $paterno[$i];
                break;
            }
        }
        $long_am = strlen($materno);
        for ($i = 1; $i < $long_am; $i++) {
            if (in_array($materno[$i], ["A", "E", "I", "O", "U"])) {
                $consonantes_materno = "";
            } else {
                $consonantes_materno = $materno[$i];
                break;
            }
        }
        $long_name = strlen($nombre);
        for ($i = 1; $i < $long_name; $i++) {
            if (in_array($nombre[$i], ["A", "E", "I", "O", "U"])) {
                $consonantes_nombre = "";
            } else {
                $consonantes_nombre = $nombre[$i];
                break;
            }
        }
        $consonantes = $consonantes_paterno . $consonantes_materno . $consonantes_nombre;
        return $consonantes;
    }

    private function claveHomonima($annio) {
        if ($annio <= 1999) {
            $homo_clave = "0";
        } else {
            $homo_clave = "A";
        }
        return $homo_clave;
    }

    private function claveVerificador($curp) {
        $tablaclave = array("0" => "0", "1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5",
            "6" => "6", "7" => "7", "8" => "8", "9" => "9", "A" => "10",
            "B" => "11", "C" => "12", "D" => "13", "E" => "14", "F" => "15",
            "G" => "16", "H" => "17", "I" => "18", "J" => "19", "K" => "20",
            "L" => "21", "M" => "22", "N" => "23", "Ñ" => "24", "O" => "25",
            "P" => "26", "Q" => "27", "R" => "28", "S" => "29", "T" => "30",
            "U" => "31", "V" => "32", "W" => "33", "X" => "34", "Y" => "35", "Z" => "36",);
        $position = 18;
        $long_curp = strlen($curp);
        $total = 0;
        for ($i = 0; $i < $long_curp; $i++) {
            $value = $tablaclave[$curp[$i]] * $position;
            $position--;
            $total = $total + $value;
        }
        $digito = abs(($total % 10) - 10);
        if ($digito == 10) {
            $digito = 0;
        }
        return $digito;
    }

    public function generarCURP($nombres, $apellido1, $apellido2, $diase, $mes, $annio, $sexo, $edo) {
        $nombre = $this->claveNombre($nombres, $apellido1, $apellido2);
        $fechaa = $this->claveFechaNa($diase, $mes, $annio);
        $sexoEdo = $this->caveSexoEdo($sexo, $edo);
        $consonantes = $this->claveConsonantesInternas($nombres, $apellido1, $apellido2);
        $homo = $this->claveHomonima($annio);
        $curp = $nombre . $fechaa . $sexoEdo . $consonantes . $homo;
        $dig_ver = $this->claveVerificador($curp);
        return $curp . $dig_ver;
    }

}
