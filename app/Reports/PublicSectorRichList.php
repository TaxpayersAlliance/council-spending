<?php

namespace App\Reports;

use App\Reports\Report;

use Illuminate\Database\Eloquent\Model;

class PublicSectorRichList extends Report
{
    public function scopeRequired ($query, $councilCode)
    {
        $query->where('council_code', $councilCode)
                                ->get(array(
                                    'employees100',
                                    'employees150',
                                    'employees200',
                                    'employees300'
                                ));
    }
    public function getName()
    {
    	return "Public Sector Rich List";
    }
    
    public function setContent($councils, $type, $data)
    {
        $concatenatedString = "In the 2015 Public Sector Rich List, ". $councils[$type]['council'] . " had " . $data['employees100'] . " employees on more than £100,000 and " . $data['employees150'] . " employees on more than £150,000 and " . $data['employees200'] . " employees on more than £200,000 and " . $data['employees300'] . " employees on more than £300,000";
        
        return $concatenatedString;
    }
}
