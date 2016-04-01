<?php

namespace App\Reports;

use App\Reports\Report;

use Illuminate\Database\Eloquent\Model;

class TownHallRichList extends Report
{
    public function scopeRequired ($query, $councilCode)
    {
        $query->where('council_code', $councilCode)
                                ->get(array(
                                    'employees100',
                                    'employees150'
                                ));
    }
    public function getName()
    {
    	return "Town Hall Rich List";
    }
    
    public function setContent($councils, $type, $data)
    {
        $concatenatedString = "In the 2014 Town Hall Rich List, ". $councils[$type]['council'] . " had " . $data['employees100'] . " employees earning more than £100,000 and " . $data['employees150'] . " employees earning more than £150,000";
        
        return $concatenatedString;
    }
}
