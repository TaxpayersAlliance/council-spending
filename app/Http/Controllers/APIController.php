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
        $this->validatePostcode($postcode);

        $councilData = $this->getCouncilCodesFromPostcode($postcode);

        $results = $this->getDataFromCouncilLookupCode($councilData, $verbosity);

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

        if(($length < 5) || ($length > 10))
        {
            dd("error, not a valid postcode");
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
     * Gets data relating to each council from the array of lookup codes
     * 
     * @param  [type] $councilData      [description]
     * @param  [type] $verbosity [description]
     * @return [type]            [description]
     */
    private function getDataFromCouncilLookupCode($councilData, $verbosity)
    {
    	$councilTypes = ['county', 'district'];

        $councils = [
            $this->getDataForEachCouncil($councilData, $verbosity, 'district'),
            $this->getDataForEachCouncil($councilData, $verbosity, 'county')
        ];

    	// foreach ($councilTypes as $council => $type) {

     //        $councils['council'] = $this->getDataForEachCouncil($councilData, $verbosity, $type);
     //    }

    	return $councils;
    }
    private function getDataForEachCouncil($councilData, $verbosity, $type)
    {
    $lookup_id = $type . '_lookup_id';

        $councils['council'][$type] = $councilData[$lookup_id];

        if ($councils['council'] != null)
        {
            $councils['council'] = Council::where("council_code",$councils['council'])->get();

            $council = $councils['council'];

            $council = $this->arrayFormat($council);

            $council['type'] = $type;

            $stories = $this->getStoriesFromCouncil($council, $verbosity);      

            $council = $this->appendStoriesToCouncil($stories, $council);

            return $council;
        }
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
        $this->sortByPublicationDate($stories);

        if ($verbosity == "true")
        {
            return $this->formatVerboseOutput($stories);
        }
        return $stories;
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
    /**
     * sorts all reports by publication date
     * 
     * @param  [type] $stories [description]
     * @return [type]          [description]
     */
    private function sortByPublicationDate($stories)
    {
        $name = 'publication_date';

        usort($stories, function ($a, $b) use(&$name)
        {
            return $a[$name]->timestamp -  $b[$name]->timestamp;
        });

        return array_reverse($stories);
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
     * renames a key in an array
     * @param  [type] $array  [description]
     * @param  [type] $newKey [description]
     * @param  [type] $oldKey [description]
     * @return [type]         [description]
     */
    private function renameKey ($array, $newKey, $oldKey)
    {
        $array[$newKey] = $array[$oldKey];
        unset($array[$oldKey]);

        return $array;
    }
}
