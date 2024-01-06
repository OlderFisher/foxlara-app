<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReportDb extends Model
{
    use HasFactory;

    public static function scopeReport(): array
    {
        $pilots     = DB::select(
            'SELECT * FROM pilots 
                    INNER JOIN teams ON pilots.pilot_team_id=teams.id
                    INNER JOIN results ON results.pilot_id=pilots.id
                    ORDER BY race_time ASC'
        );
        $raceReport = [];
        foreach ($pilots as $pilot) {
            $raceReport[$pilot->pilot_abbreviation] = [
                'pilot_name' => $pilot->pilot_name,
                'pilot_team' => $pilot->team_name,
                'start_time' => $pilot->start_time,
                'end_time'   => $pilot->end_time,
                'race_time'  => $pilot->race_time
            ];
        }

        return $raceReport;
    }
}
