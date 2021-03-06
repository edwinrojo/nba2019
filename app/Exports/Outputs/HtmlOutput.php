<?php
namespace App\Exports\Outputs;

require_once('App/Interfaces/PlayersExportInterface.php');

use App\Interfaces\PlayersExportInterface;

class HtmlOutput implements PlayersExportInterface {

    public function export($data) {
        if (!$data->count()) {
            $content = 'Sorry, no matching data was found';
        }
        
        // extract headings
        // replace underscores with space & ucfirst each word for a decent heading
        $headings = collect($data->get(0))->keys();
        $headings = $headings->map(function($item, $key) {
            return collect(explode('_', $item))
                ->map(function($item, $key) {
                    return ucfirst($item);
                })
                ->join(' ');
        });
        $headings = '<tr><th>' . $headings->join('</th><th>') . '</th></tr>';

        // output data
        $rows = [];
        foreach ($data as $dataRow) {
            $row = '<tr>';
            foreach ($dataRow as $key => $value) {
                $row .= '<td>' . $value . '</td>';
            }
            $row .= '</tr>';
            $rows[] = $row;
        }
        $rows = implode('', $rows);
        $content = '<table>' . $headings . $rows . '</table>';
        
        return '
        <html>
            <head>
            <style type="text/css">
                body {
                    font: 16px Roboto, Arial, Helvetica, Sans-serif;
                }
                td, th {
                    padding: 4px 8px;
                }
                th {
                    background: #eee;
                    font-weight: 500;
                }
                tr:nth-child(odd) {
                    background: #f4f4f4;
                }
            </style>
            </head>
            <body>
                ' . $content . '
            </body>
        </html>';
    }
}

?>