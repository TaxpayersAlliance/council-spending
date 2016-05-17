<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Council;
use Carbon\Carbon;
use App\Postcodes;
use App\ReportDetails;
use App\Reports\CouncilArt;
use App\Reports\CouncilAssets;
use App\Reports\TownHallRichList;
use App\Reports\CouncilTaxHistory;
use App\Reports\TradeUnionFunding;
use App\Reports\CouncilLiabilities;
use App\Reports\PublicSectorRichList;
use App\Reports\TradeUnionOfficeSpace;
use App\Reports\CouncillorsAllowances;
use App\Reports\CouncilCompensationClaims;


class APIController extends Controller
{
    protected $councilArt;
    protected $councilAssets;
    protected $townHallRichList;
    protected $tradeUnionFunding;
    protected $councilTaxHistory;
    protected $councilLiabilities;
    protected $publicSectorRichList;
    protected $councillorsAllowances;
    protected $tradeUnionOfficeSpace;
    protected $councilCompensationClaims;

    /**
     * injects the various report models as dependencies 
     * 
     * @param CouncilArt                $councilArt                [description]
     * @param CouncilAssets             $councilAssets             [description]
     * @param CouncilCompensationClaims $councilCompensationClaims [description]
     * @param CouncilLiabilities        $councilLiabilities        [description]
     * @param CouncillorsAllowances     $councillorsAllowances     [description]
     * @param CouncilTaxHistory         $councilTaxHistory         [description]
     * @param PublicSectorRichList      $publicSectorRichList      [description]
     * @param TownHallRichList          $townHallRichList          [description]
     * @param TradeUnionFunding         $tradeUnionFunding         [description]
     * @param TradeUnionOfficeSpace     $tradeUnionOfficeSpace     [description]
     */
    public function __construct(CouncilArt $councilArt, CouncilAssets $councilAssets, CouncilCompensationClaims $councilCompensationClaims, CouncilLiabilities $councilLiabilities, CouncillorsAllowances $councillorsAllowances, CouncilTaxHistory $councilTaxHistory, PublicSectorRichList $publicSectorRichList, TownHallRichList $townHallRichList, TradeUnionFunding $tradeUnionFunding, TradeUnionOfficeSpace $tradeUnionOfficeSpace)
    {
        $this->councilArt = $councilArt;
        $this->councilAssets = $councilAssets;
        $this->townHallRichList = $townHallRichList;
        $this->tradeUnionFunding = $tradeUnionFunding;
        $this->councilTaxHistory = $councilTaxHistory;
        $this->councilLiabilities = $councilLiabilities;
        $this->publicSectorRichList = $publicSectorRichList;
        $this->tradeUnionOfficeSpace = $tradeUnionOfficeSpace;
        $this->councillorsAllowances = $councillorsAllowances;
        $this->councilCompensationClaims = $councilCompensationClaims;

    }

    /**
     * Get all stories from a given postcode
     *
     * entry point from routes - this is the 'main' function
     * 
     * @param  [type] $postcode  [description]
     * @param  [type] $verbosity [description]
     * @return [type]            [description]
     */
    public function getStories($postcode, $verbosity)
    {
        $postcode = strtolower($postcode);

        if ($this->validatePostcode($postcode) == true)
        {
            dd("ERROR: this does not appear to be a valid postcode");
        }

        $councilData = $this->getCouncilCodesFromPostcode($postcode);

        if ($councilData == null)
        {
            dd("ERROR: no data found for this postcode");
        }

        $results = $this->getDataFromCouncilLookupCode($councilData, $verbosity);

        $results = $this->removeNullFromArray($results);
        
        return $results;
    }
    /**
     * returns an error if anything but a valid postcode is submitted
     * 
     * @param  [type] $postcode [description]
     * @return [type]           [description]
     */
    private function validatePostcode($postcode)
    {
        $length = strlen($postcode);

        if($length < 5 || $length > 10)
        {
            return true;
        }
    }
    /**
     * Returns a complete list of lookup codes for a given postcode
     * 
     * @param  [type] $postcode [description]
     * @return [type]           [description]
     */
    private function getCouncilCodesFromPostcode($postcode)
    {
    	$councilData = Postcodes::where('postcode', $postcode)->first();
    	
    	return $councilData;

    }
    /**
     * Gets data from councils based on the lookup code
     * 
     * @param  [type] $councilData      [description]
     * @param  [type] $verbosity [description]
     * @return [type]            [description]
     */
    private function getDataFromCouncilLookupCode($councilData, $verbosity)
    {
        $councils = [
            $this->getDataForEachCouncil($councilData, $verbosity, 'district'),
            $this->getDataForEachCouncil($councilData, $verbosity, 'county')
        ];

    	return $councils;
    }
    /**
     * get the data for each council
     * 
     * @param  [type] $councilData [description]
     * @param  [type] $verbosity   [description]
     * @param  [type] $type        [description]
     * @return [type]              [description]
     */
    private function getDataForEachCouncil($councilData, $verbosity, $type)
    {
        $lookup_id = $type . '_lookup_id';

        $councils['council'][$type] = $councilData[$lookup_id];

        if ($councils['council'][$type] != null)
        {
            $councils['council'] = Council::where("council_code",$councils['council'])->get();

            $council = $councils['council'];

            $council = $this->arrayFormat($council);

            $councilCode = $this->getCouncilCode($council);

            if ($councilCode == null)
            {
                return;
            }

            $council['type'] = $type;

            $stories = $this->getStoriesFromCouncil($council, $verbosity);      

            $council = $this->appendStoriesToCouncil($stories, $council);

            return $council;
        }
        return;
    }
    /**
     * Gets stories for each council
     * 
     * @param  [type] $councils  [description]
     * @param  [type] $type      [description]
     * @param  [type] $verbosity [description]
     * @return [type]            [description]
     */
    private function getStoriesFromCouncil ($council, $verbosity)
    {
        $stories = [
            $this->councilArt->getStoryDataFromCouncil($council), 
            $this->councilAssets->getStoryDataFromCouncil($council), 
            $this->townHallRichList->getStoryDataFromCouncil($council),
            $this->councilTaxHistory->getStoryDataFromCouncil($council),  
            $this->tradeUnionFunding->getStoryDataFromCouncil($council),
            $this->councilLiabilities->getStoryDataFromCouncil($council),
            $this->publicSectorRichList->getStoryDataFromCouncil($council), 
            $this->tradeUnionOfficeSpace->getStoryDataFromCouncil($council), 
            $this->councillorsAllowances->getStoryDataFromCouncil($council),  
            $this->councilCompensationClaims->getStoryDataFromCouncil($council)

        ];
        $name = 'publication_date';

        usort($stories, array($this, "cmp"));

        if ($verbosity == "true")
        {
            return $this->formatVerboseOutput($stories);
        }
        return $stories;
    }
    /**
     * compares the publication dates (competion for usort)
     * @param  [type] $a [description]
     * @param  [type] $b [description]
     * @return [type]    [description]
     */
    private function cmp ($a, $b)
    {
        if ($a['publication_date']->timestamp == $b['publication_date']->timestamp)
            {
            return 0;
            }
        return ($a['publication_date']->timestamp > $b['publication_date']->timestamp) ? -1 : 1 ;
    }
    /**
     * gets the council code
     * 
     * @param  [type] $councils [description]
     * @param  [type] $type     [description]
     * @return [type]           [description]
     */
    private function getCouncilCode($council)
    {
        $councilCode = $council['council_code'];

        return $councilCode;
    }
    /**
     * Apends stories to each council
     * 
     * @param  [type] $stories  [description]
     * @param  [type] $councils [description]
     * @param  [type] $type     [description]
     * @return [type]           [description]
     */
    private function appendStoriesToCouncil($stories, $council)
    {

        $council['data'] = $stories;

        return $council;
    }

    //MARK: ARRAY FORMATTING FUNCTIONS
    
    /**
     * flattens the array heirachy slightly to make it easier to manage
     * 
     * @param  [type] $councils [description]
     * @param  [type] $type     [description]
     * @return [type]           [description]
     */
    private function arrayFormat ($council)
    {
    	$council = $council[0];
    	return $council;
    }
    /**
     * removes null elements from an array
     * 
     * @param  [type] $array [description]
     * @return [type]        [description]
     */
    private function removeNullFromArray($array)
    {
        foreach ($array as $i=>$row) {
            if ($row === null)
               unset($array[$i]);
        }
        return $array;
    }
    /**
     * Unset unnecessary data from the array in the verbose output
     * @param  [type] $stories [description]
     * @return [type]          [description]
     */
    private function formatVerboseOutput($stories)
    {
        foreach ($stories as $key => $story) 
        {
            $story = array_reverse(array_slice(array_reverse($story->toArray()),0,4));
            $stories[$key] = $story;
        }
        return $stories;
    }
}
