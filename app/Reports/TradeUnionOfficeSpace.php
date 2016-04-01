<?php

namespace App\Reports;

use App\Reports\Report;

use Illuminate\Database\Eloquent\Model;

class TradeUnionOfficeSpace extends Report
{
    public function scopeRequired ($query, $councilCode)
    {
        $query->where('council_code', $councilCode)
                                ->get(array(
                                    'floor_space',
                                    'valuation'
                                ));
    }
    public function getName()
    {
    	return "Trade Union Office Space";
    }
    
    public function setContent($councils, $type, $data)
    {
        $concatenatedString = "some string";
        
        return $concatenatedString;
    }
}

