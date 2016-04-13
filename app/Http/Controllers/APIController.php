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

        $results = $this->getDataFromCouncilLookupCode($data, $verbosity);

        return $results;
    }
    /**
     * Returns a complete list of lookup codes for a given postcode
     * 
     * @param  [type] $postcode [description]
     * @return [type]           [description]
     */
    private function getCouncilCodesFromPostcode($postcode)
    {
    	$data = Postcodes::where('postcode', $postcode)->first();
    	
    	return $data;

    }
    /**
     * Gets data relating to each council from the array of lookup codes
     * 
     * @param  [type] $data      [description]
     * @param  [type] $verbosity [description]
     * @return [type]            [description]
     */
    private function getDataFromCouncilLookupCode($data, $verbosity)
    {
    	$councilTypes = ['county', 'district'];

    	foreach ($councilTypes as $type) {
            $lookup_id = $type . '_lookup_id';
            $councils[$type] = $data[$lookup_id];
            if ($councils[$type] != null)
            {
                $councils[$type] = Council::where("council_code",$councils[$type])->get();
        		
        		$councils = $this->arrayFormat($councils, $type);

                $stories = $this->getStoriesFromCouncils($councils, $type, $verbosity);

                $this->appendStoriesToCouncils($stories, $councils, $type);
            }
    	}
    	return $councils;
    }
    /**
     * Gets stories for each council
     * 
     * @param  [type] $councils  [description]
     * @param  [type] $type      [description]
     * @param  [type] $verbosity [description]
     * @return [type]            [description]
     */
    private function getStoriesFromCouncils ($councils, $type, $verbosity)
    {
        $stories = [
            $this->councilArt->getStoryDataFromCouncil($councils, $type), 
            $this->councilAssets->getStoryDataFromCouncil($councils, $type), 
            $this->townHallRichList->getStoryDataFromCouncil($councils, $type),
            $this->councilTaxHistory->getStoryDataFromCouncil($councils, $type),  
            $this->tradeUnionFunding->getStoryDataFromCouncil($councils, $type),
            $this->councilLiabilities->getStoryDataFromCouncil($councils, $type),
            $this->publicSectorRichList->getStoryDataFromCouncil($councils, $type), 
            $this->tradeUnionOfficeSpace->getStoryDataFromCouncil($councils, $type), 
            $this->councillorsAllowances->getStoryDataFromCouncil($councils, $type),  
            $this->councilCompensationClaims->getStoryDataFromCouncil($councils, $type)

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
    private function appendStoriesToCouncils($stories, $councils, $type)
    {

        $councils[$type]['data'] = $stories;
        return $councils[$type];
    }
    /**
     * flattens the array heirachy slightly to make it easier to manage
     * 
     * @param  [type] $councils [description]
     * @param  [type] $type     [description]
     * @return [type]           [description]
     */
    private function arrayFormat ($councils, $type)
    {
    	$councils[$type] = $councils[$type][0];
    	return $councils;
    }
}
