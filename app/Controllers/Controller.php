<?php
namespace App\Controllers;

require_once('App/Exports/Exporter.php');
require_once('App/Repositories/PlayersRepository.php');
require_once('App/Exports/Helpers.php');

use App\Exports\Helpers;
use App\Repositories\PlayersRepository;
use App\Controllers\Exporter;

class Controller {

    public function __construct($args) {
        $this->args = $args;
    }

    public function export() {
        $data = [];
        $helpers = new Helpers();
        $exporter = new Exporter(new PlayersRepository(), $helpers);
        
        $type = $this->args->pull('type');
        if (!$type) {
            exit('Please specify a type');
        }

        switch ($type) {
            case 'playerstats':
                $data = $exporter->getPlayerStats($helpers->filterArgs($this->args));
                break;
            case 'players':
                $data = $exporter->getAllPlayers($helpers->filterArgs($this->args));
                break;
        }
        if (!$data) {
            exit("Error: No data found!");
        }
        return $exporter->format($data, $helpers->getFormat($this->args));
    }
}