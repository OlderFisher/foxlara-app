<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Class MonacoReport to operate with Monaco Races Report
 */
class MonacoReport
{
    private array $monacoRaceData = [];
    private const FOLDER_PATH = 'reportfiles';
    public const STARTS_FILE = 'start.log';
    public const ENDS_FILE = 'end.log';
    public const ABRREVIATIONS_FILE = 'abbreviations.txt';

    public function __construct()
    {
        $this->setRaceStartData();
        $this->setRaceEndData();
        $this->setPilotData();
    }

    /**
     * Function to fill Monaco Race Data array with start race data
     * @return void
     */
    private function setRaceStartData(): void
    {
        $startsFileContent = file_get_contents(self::FOLDER_PATH . '/' . self::STARTS_FILE);
        $starts = explode("\n", $startsFileContent);
        foreach ($starts as $start) {
            if (trim($start) && strlen($start) > 3) {
                $start = trim($start);
                $driver = substr($start, 0, 3);
                $stringWithoutDriver = str_replace($driver, '', $start);
                $dateTimeString = str_replace('_', ' ', $stringWithoutDriver);

                $this->monacoRaceData[$driver]['start_time'] = strtotime($dateTimeString);
            }
        }
    }

    /**
     * Function to fill Monaco Race Data array with finish race data
     * @return void
     */
    private function setRaceEndData(): void
    {
        $endsFileContent = file_get_contents(self::FOLDER_PATH . '/' . self::ENDS_FILE);
        $ends = explode("\n", $endsFileContent);
        foreach ($ends as $end) {
            if (trim($end)) {
                $end = trim($end);
                $driver = substr($end, 0, 3);
                $stringWithoutDriver = str_replace($driver, '', $end);
                $dateTimeString = str_replace('_', ' ', $stringWithoutDriver);

                $this->monacoRaceData[$driver]['end_time'] = strtotime($dateTimeString);
                  }
        }
    }

    /**
     * Function to fill Monaco Race Data array with pilots data
     * @return void
     */
    private function setPilotData(): void
    {
        $abbreviationsFileContent = file_get_contents(self::FOLDER_PATH . '/' . self::ABRREVIATIONS_FILE);
        $abbreviations = explode("\n", $abbreviationsFileContent);
        foreach ($abbreviations as $single) {
            if (trim($single)) {
                $pilotData = explode('_', trim($single));
                $driver = $pilotData[0];
                $pilotName = $pilotData[1];
                $pilotTeam = $pilotData[2];

                $this->monacoRaceData[$driver]['pilot_name'] = $pilotName;
                $this->monacoRaceData[$driver]['pilot_team'] = $pilotTeam;
                $this->monacoRaceData[$driver]['race_time'] =
                    $this->monacoRaceData[$driver]['end_time'] - $this->monacoRaceData[$driver]['start_time'];
            }
        }
    }

    /**
     * Function to fill race report in sort order
     * @param int $order
     * @return array
     */
    public function buildRaceReport(int $order = SORT_ASC): array
    {
        $sortedData = $this->raceResultsSort('race_time', $order);
        $reportData = array_map(function ($item) {
            $returnedItem = [];
            $returnedItem['pilot_name'] = $item['pilot_name'];
            $returnedItem['pilot_team'] = $item['pilot_team'];
            $returnedItem['race_time'] = date('G:i:s.ms', $item['race_time']);
            return $returnedItem;
        }, $sortedData);

        return $reportData;
    }

    /**
     * Function to output race report table in HTML format
     * @param array $raceReport
     * @return string
     */
    public function printRaceReportToHTML(array $raceReport): string
    {
        $topPilots = array_slice($raceReport, 0, 15);
        $slowPilots = array_slice($raceReport, 15, count($raceReport));

        $outputHtml = '
        <table>
          <thead>
             <tr>
                <td style="padding: 10px 15px; border-bottom:1px solid black">#</td>
                <td style="padding: 10px 15px; border-bottom:1px solid black">Pilot Name</td>
                <td style="padding: 10px 15px; border-bottom:1px solid black">Pilot Team</td>
                <td style="padding: 10px 15px; border-bottom:1px solid black">Race Time</td>
            </tr>
        </thead>';

        // Top race pilots mapping
        $index = 1;
        foreach ($topPilots as $key => $value) {
            $outputHtml .= '<tr>';
            $outputHtml .= '<td style="padding: 10px 15px">' . $index . '</td>';
            $outputHtml .= '<td style="padding: 10px 15px">' . $value['pilot_name'] . '</td>';
            $outputHtml .= '<td style="padding: 10px 15px">' . $value['pilot_team'] . '</td>';
            $outputHtml .= '<td style="padding: 10px 15px">' . $value['race_time'] . '</td>';
            $outputHtml .= '</tr>';
            $index++;
        }
        $outputHtml .= '<tr><td style="padding: 10px 15px; border-bottom:1px dashed black" colspan="4"></td></tr>';

        // Slow pilots mapping
        foreach ($slowPilots as $key => $value) {
            $outputHtml .= '<tr>';
            $outputHtml .= '<td style="padding: 10px 15px">' . $index . '</td>';
            $outputHtml .= '<td style="padding: 10px 15px">' . $value['pilot_name'] . '</td>';
            $outputHtml .= '<td style="padding: 10px 15px">' . $value['pilot_team'] . '</td>';
            $outputHtml .= '<td style="padding: 10px 15px">' . $value['race_time'] . '</td>';
            $outputHtml .= '</tr>';
            $index++;
        }
        $outputHtml .= '</table>';

        return $outputHtml;
    }

    /**
     * Function to sort Race results array by a specific key
     * @param string $on
     * @param int $order
     * @return array
     */
    private function raceResultsSort(string $on, int $order = SORT_ASC): array
    {
        $arrayToSort = $this->monacoRaceData;
        uasort($arrayToSort, function ($a, $b) use ($order) {
            if ($order === SORT_ASC) {
                return ($a['race_time'] <=> $b['race_time']);
            } else {
                return ($b['race_time'] <=> $a['race_time']);
            }
        });
        return $arrayToSort;
    }
}
