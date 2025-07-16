<?php
class Curp {
    private $state_codes = [
        1 => 'AS', 2 => 'BC', 3 => 'BS', 4 => 'CC', 5 => 'CL', 6 => 'CM', 7 => 'CS', 8 => 'CH',
        9 => 'DF', 10 => 'DG', 11 => 'GT', 12 => 'GR', 13 => 'HG', 14 => 'JC', 15 => 'MC',
        16 => 'MN', 17 => 'MS', 18 => 'NT', 19 => 'NL', 20 => 'OC', 21 => 'PL', 22 => 'QT',
        23 => 'QR', 24 => 'SP', 25 => 'SL', 26 => 'SR', 27 => 'TC', 28 => 'TS', 29 => 'TL',
        30 => 'VZ', 31 => 'YN', 32 => 'ZS', 99 => 'NE'
    ];

    private function limpiarCadena($cadena) {
        $cadena = strtoupper(trim($cadena));
        $cadena = strtr($cadena, [
            'Á'=>'A','É'=>'E','Í'=>'I','Ó'=>'O','Ú'=>'U','Ü'=>'U','Ñ'=>'N',
            'À'=>'A','È'=>'E','Ì'=>'I','Ò'=>'O','Ù'=>'U',
        ]);
        $cadena = preg_replace('/[^A-Z]/', '', $cadena);
        return $cadena;
    }

    private function quitarNombresComunes($nombre) {
        $excepciones = ['JOSE', 'MARIA', 'MA', 'J', 'DE', 'DEL', 'LA', 'LOS', 'LAS', 'Y'];
        $partes = explode(' ', $nombre);
        foreach ($partes as $parte) {
            if (!in_array($parte, $excepciones)) {
                return $parte;
            }
        }
        return $partes[0]; // fallback
    }

    private function primerVocalInterna($cadena) {
        for ($i = 1; $i < strlen($cadena); $i++) {
            if (in_array($cadena[$i], ['A', 'E', 'I', 'O', 'U'])) {
                return $cadena[$i];
            }
        }
        return 'X';
    }

    private function primeraConsonanteInterna($cadena) {
        for ($i = 1; $i < strlen($cadena); $i++) {
            if (!in_array($cadena[$i], ['A', 'E', 'I', 'O', 'U'])) {
                return $cadena[$i];
            }
        }
        return 'X';
    }

    private function claveVerificador($curp17) {
    $tabla = array_merge(
        array_combine(range('0','9'), range(0,9)),        // 0‑9
        array_combine(range('A','N'), range(10,23)),      // A‑N
        ['Ñ' => 24],                                      // Ñ
        array_combine(range('O','Z'), range(25,36))       // O‑Z  
    );

        $suma = 0;
        for ($i = 0; $i < 17; $i++) {
            $caracter = $curp17[$i];
            $valor = $tabla[$caracter] ?? 0;
            $suma += $valor * (18 - $i);
        }
        $digito = 10 - ($suma % 10);
        return ($digito == 10) ? '0' : (string)$digito;
    }


    public function generarCurp($apellidoP, $apellidoM, $nombres, $fechaNacimiento, $sexo, $estadoId) {
        $apellidoP = $this->limpiarCadena($apellidoP);
        $apellidoM = $this->limpiarCadena($apellidoM);
        $nombres = $this->limpiarCadena($nombres);
        $sexo = strtoupper($sexo);
        $estado = isset($this->state_codes[$estadoId]) ? $this->state_codes[$estadoId] : 'NE';

        // Nombres comunes
        $nombreProcesado = $this->quitarNombresComunes($nombres);

        // Fecha
        $fecha = DateTime::createFromFormat('Y-m-d', $fechaNacimiento);
        $fechaStr = $fecha->format('ymd');

        // Homonimia
        $homonimia = ((int)$fecha->format('Y') >= 2000) ? 'A' : '0';

        // CURP base (17 caracteres)
        $curp17 = substr($apellidoP, 0, 1)
                . $this->primerVocalInterna($apellidoP)
                . (isset($apellidoM[0]) ? $apellidoM[0] : 'X')
                . substr($nombreProcesado, 0, 1)
                . $fechaStr
                . $sexo
                . $estado
                . $this->primeraConsonanteInterna($apellidoP)
                . $this->primeraConsonanteInterna($apellidoM)
                . $this->primeraConsonanteInterna($nombreProcesado)
                . $homonimia;

        $verificador = $this->claveVerificador($curp17);

        return $curp17 . $verificador;
    }
}
?>