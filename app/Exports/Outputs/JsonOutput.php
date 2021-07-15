<?php
namespace App\Exports\Outputs;

require_once('App/Interfaces/PlayersExportInterface.php');

use App\Interfaces\PlayersExportInterface;

class JsonOutput implements PlayersExportInterface {

    public function export($data) {
        header('Content-type: application/json');
        return json_encode($data->all());
    }
}

?>