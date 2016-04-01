<?php

namespace App\Reports;

use App\Reports\Report;

use Illuminate\Database\Eloquent\Model;

class CouncilTaxHistory extends Report
{
    public function scopeRequired ($query, $councilCode)
    {
        $query->where('council_code', $councilCode)
                                ->get(array(
                                    'real_terms_increase',
                                    'number_of_increases'
                                ));
    }
    public function getName()
    {
    	return "Council Tax History";
    }
    
    public function setContent($councils, $type, $data)
    {
        
         if ($data['real_terms_increase'] != "no data")
        { 
            $concatenatedString = "Council tax at " . $councils[$type]['council'] . " has risen by " . $data['real_terms_increase'] . " in real terms since 1996-97";
            
            return $concatenatedString;
        }

        $concatenatedString = "There is no available data for historic council tax rises in " . $councils[$type]['council'];
        
        return $concatenatedString;
    }
}

