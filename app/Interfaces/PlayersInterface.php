<?php
namespace App\Interfaces;

interface PlayersInterface {

    public function getStats($where);

    public function getPlayers($where);
}

?>