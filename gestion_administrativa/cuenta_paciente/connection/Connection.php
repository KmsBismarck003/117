<?php
date_default_timezone_set('America/Guatemala');
    class Connection extends Mysqli {
        function __construct() {
            parent::__construct('localhost', 'u542863078_sima_edomun', 'Sim@T0ols2022', 'u542863078_edomun');
            $this->set_charset('utf8');
            $this->connect_error == NULL ? 'DB Conectada' : die('Error al conectarse a la base de datos') ;
        }//end __construct
    }//end class Connection
?>