<?php

namespace App\Reports;

use App\Reports\Report;
use Illuminate\Database\Eloquent\Model;

class CouncilAssets extends Report
{
    /**
     * [getName description]
     * @return [type] [description]
     */
    public function getName()
    {
    	return "Council Assets";
    }
    /**
     * 
     * @param [type] $councils [description]
     * @param [type] $type     [description]
     * @param [type] $data     [description]
     */
    public function setContent($council, $data)
    {
        $concatenatedString = "As of April 1st 2014 " . $council['council'] . " owned: " . 

        $this->setIndividualAssetStrings($data['golf_courses'], " golf course, ", " golf courses, ") . 

        $this->setIndividualAssetStrings($data['car_parks'], " car park, ", " car parks, ") . 

        $this->setIndividualAssetStrings($data['leisure_centres'], " leisure centre, ", " leisure centres, ") . 

        $this->setIndividualAssetStrings($data['farms'], " farm, ", " farms, ") . 

        $this->setIndividualAssetStrings($data['theatres'], " theatre, ", " theatres, ") . 

        $this->setIndividualAssetStrings($data['pubs'], " pub, ", " pubs, ") . 

        $this->setIndividualAssetStrings($data['restaurants'], " restaurant, ", " restaurants, ") . 

        $this->setIndividualAssetStrings($data['shopping_centres'], " shopping centre, ", " shopping centres, ") . 

        $this->setIndividualAssetStrings($data['shops'], " shop, and ", " shops, and ") . 

        $this->setIndividualAssetStrings($data['hotels'], " hotel ", " hotels") . ".";
        
        return $concatenatedString;
    }
    /**
     * sets individual parts of the long concatenated council assets string.
     * @param [type] $value    [description]
     * @param [type] $singular [description]
     * @param [type] $plural   [description]
     */
    private function setIndividualAssetStrings($value, $singular, $plural)
    {
        return $value . $this->returnSingularOrPluralString($value, $singular, $plural);
    }
}
