<?php
namespace App\Exports;

require_once('App/Exports/Outputs/XmlOutput.php');
require_once('App/Exports/Outputs/CVOutput.php');
require_once('App/Exports/Outputs/JsonOutput.php');
require_once('App/Exports/Outputs/HtmlOutput.php');

use App\Exports\Outputs\CVOutput;
use App\Exports\Outputs\HtmlOutput;
use App\Exports\Outputs\JsonOutput;
use App\Exports\Outputs\XmlOutput;

class Helpers {

    public function filterWhere($search) {
        $where = [];
        if ($search->has('playerId')) $where[] = "roster.id = '" . $search['playerId'] . "'";
        if ($search->has('player')) $where[] = "roster.name = '" . $search['player'] . "'";
        if ($search->has('team')) $where[] = "roster.team_code = '" . $search['team']. "'";
        if ($search->has('position')) $where[] = "roster.pos = '" . $search['position'] . "'";
        if ($search->has('country')) $where[] = "roster.nationality = '" . $search['country'] . "'";
        $where = implode(' AND ', $where);

        return $where;
    } 

    public function filterArgs($args) {
        $searchArgs = ['player', 'playerId', 'team', 'position', 'country'];
        return $args->filter(function($value, $key) use ($searchArgs) {
            return in_array($key, $searchArgs);
        });
    }

    public function getFormat($args) {
        $format = $args->pull('format');
        switch ($format) {
            case 'xml':
                return new XmlOutput();
                break;
            case 'cv':
                return new CVOutput();
                break;
            case 'json':
                return new JsonOutput();
                break;
            case 'html':
                return new HtmlOutput();
                break;
            default:
            return new HtmlOutput();
                break;
        }        
    }

    public function calculateTotals($stats) {
        foreach ($stats as &$row) {
            unset($row['player_id']);
            $row['total_points'] = ($row['3pt'] * 3) + ($row['2pt'] * 2) + $row['free_throws'];
            $row['field_goals_pct'] = $row['field_goals_attempted'] ? (round($row['field_goals'] / $row['field_goals_attempted'], 2) * 100) . '%' : 0;
            $row['3pt_pct'] = $row['3pt_attempted'] ? (round($row['3pt'] / $row['3pt_attempted'], 2) * 100) . '%' : 0;
            $row['2pt_pct'] = $row['2pt_attempted'] ? (round($row['2pt'] / $row['2pt_attempted'], 2) * 100) . '%' : 0;
            $row['free_throws_pct'] = $row['free_throws_attempted'] ? (round($row['free_throws'] / $row['free_throws_attempted'], 2) * 100) . '%' : 0;
            $row['total_rebounds'] = $row['offensive_rebounds'] + $row['defensive_rebounds'];
        }

        return collect($stats);
    }

    public function unsetPlayerIds($players) {
        return collect($players)
            ->map(function($item, $key) {
                unset($item['id']);
                return $item;
            });
    }
}
?>