<?php
namespace App\Controllers;

require_once('App/Exports/Helpers.php');

use App\Exports\Helpers;
use App\Interfaces\PlayersExportInterface;
use App\Interfaces\PlayersInterface;

// retrieves & formats data from the database for export
class Exporter {

    private $playersInterface;
    private $queryHelpers;

    public function __construct(PlayersInterface $playersInterface, Helpers $queryHelpers) {
        $this->playersInterface = $playersInterface;
        $this->queryHelpers = $queryHelpers;
    }

    function getPlayerStats($search) {
        $stats = $this->playersInterface->getStats($this->queryHelpers->filterWhere($search));
        return $this->queryHelpers->calculateTotals($stats);
    }

    function getAllPlayers($search) {
        $players = $this->playersInterface->getPlayers($this->queryHelpers->filterWhere($search));
        return $this->queryHelpers->unsetPlayerIds($players);
    }

    public function format($data, PlayersExportInterface $format) {
       return $format->export($data);
    }
}

?>