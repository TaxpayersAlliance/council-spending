<?php

namespace App\Reports;

use App\Reports\Report;

use Illuminate\Database\Eloquent\Model;

class TradeUnionFunding extends Report
{
    public function scopeRequired ($query, $councilCode)
    {
        $query->where('council_code', $councilCode)
                                ->get(array(
                                    'union_funding',
                                    'staff_fte'
                                ));
    }
    public function getName()
    {
    	return "Taxpayer Funded Trade Unions";
    }
    
    public function setContent($councils, $type, $data)
    {
        $concatenatedString = $councils[$type]["council"] . " paid £" . number_format($data['union_funding']) . " directly to unions and the equivalent of " . $data['staff_fte'] . " worked full time on union duties";
        
        return $concatenatedString;
    }
}

