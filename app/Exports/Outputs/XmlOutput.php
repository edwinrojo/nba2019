<?php
namespace App\Exports\Outputs;

require_once('App/Interfaces/PlayersExportInterface.php');

use App\Interfaces\PlayersExportInterface;
use LSS\Array2XML;

class XmlOutput implements PlayersExportInterface {

    public function export($data) {
        header('Content-type: text/xml');
                
            // fix any keys starting with numbers
            $keyMap = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
            $xmlData = [];
            foreach ($data->all() as $row) {
                $xmlRow = [];
                foreach ($row as $key => $value) {
                    $key = preg_replace_callback('(\d)', function($matches) use ($keyMap) {
                        return $keyMap[$matches[0]] . '_';
                    }, $key);
                    $xmlRow[$key] = $value;
                }
                $xmlData[] = $xmlRow;
            }
            $xml = Array2XML::createXML('data', [
                'entry' => $xmlData
            ]);
            return $xml->saveXML();
    }
}

?>