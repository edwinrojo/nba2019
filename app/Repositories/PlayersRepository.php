<?php
namespace App\Repositories;

require_once('App/Interfaces/PlayersInterface.php');

use App\Interfaces\PlayersInterface;

class PlayersRepository implements PlayersInterface{
    
    public function getStats($where) {
        $sql = "
            SELECT roster.name, player_totals.*
            FROM player_totals
                INNER JOIN roster ON (roster.id = player_totals.player_id)
            WHERE $where";
        return query($sql) ?: [];
    }

    public function getPlayers($where) {
        $sql = "
            SELECT roster.*
            FROM roster
            WHERE $where";
        return query($sql);
    }
}

?>