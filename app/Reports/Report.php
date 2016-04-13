<?php

namespace App\Reports;

use Carbon\Carbon;
use App\ReportDetails;
use Illuminate\Database\Eloquent\Model;

abstract class Report extends Model
{
    /**
     * declares publication date to be a carbon instance
     * @var array
     */
    protected $dates = ['publication_date'];
    /**
     * formats all carbon instance dates
     * @var string
     */
    protected $dateFormat = "Y-m-d";
    /**
     * forces all child models to implement a set content function
     * @param [type] $councils [description]
     * @param [type] $type     [description]
     * @param [type] $data     [description]
     */
    protected abstract function setContent($council, $data);
    /**
     * forces all child models to implement a function to get a formatted name for the model
     * @return [type] [description]
     */
    protected abstract function getName();
        /**
     * get defined fields from model from a council with a given council code
     * @param  [type] $query       [description]
     * @param  [type] $councilCode [description]
     * @return [type]              [description]
     */
    public function scopeRequired ($query, $councilCode)
    {

        $query->where('council_code', $councilCode)->get();
    }
	 /**
     * get the details relating to a report
     * @param  [type] $reportName [description]
     * @return [type]             [description]
     */
    private function getReportDetails($reportName)
    {
        $reportData = ReportDetails::where('report_name', $reportName)->first();

        $reportDataFormatted = ['name' => $reportData['report_name'],
                                'URL' => $reportData['report_url'],
                                'publication_date' => $reportData['published_on']
                                ];
        return $reportDataFormatted;
    }
    /**
     * append data on a report to its data array
     * 
     * @param  [type] $reportDataArray [description]
     * @param  [type] $additionalData  [description]
     * @return [type]                  [description]
     */
    private function appendReportData($reportDataArray, $additionalData)
    {
        $reportDataArray['name'] = $additionalData['name'];
        $reportDataArray['URL'] = $additionalData['URL'];
        $reportDataArray['publication_date'] = $additionalData['publication_date'];

        return $reportDataArray;
    }
    /**
     * get the data for a story from a council's lookup code
     * 
     * @param  [type] $councilCode [description]
     * @return [type]              [description]
     */
    private function getDataFromCouncilCode($councilCode)
    {
        $storyData = $this->required($councilCode)->get();

        return $storyData;
    }
    /**
     * [getCouncilCode description]
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
     * remove unnecessary fields from array of story data
     * @param  [type] $array [description]
     * @return [type]        [description]
     */
     private function tidyArray($array)
    {
    	unset($array['created_at']);
    	unset($array['updated_at']);
    	unset($array['council_code']);
    	unset($array['council']);
    	unset($array['secondary_council_code']);
    	unset($array['id']);

    	return $array;
    }
    /**
     * generate an array of data for a story from a council
     * @param  [type] $councils [description]
     * @param  [type] $type     [description]
     * @return [type]           [description]
     */
    public function getStoryDataFromCouncil($council)
    {
        $councilCode = $this->getCouncilCode($council);

        $data = $this->getDataFromCouncilCode($councilCode);

        $data = $this->tidyArray($data[0]);

        $data = $this->appendReportData($data, $this->getReportDetails($this->getName()));
        
        $data['content'] = $this->setContent($council, $data);
        
        return $data;
    }
    /**
     * Check if a number is a plural
     * @param  [type] $number [description]
     * @return [type]         [description]
     */
    public function checkIfPlural($number)
    {
        if ($number == 1)
        {
            return false;
        }
        return true;
    }
    /**
     * return a string that is singular or plural dependent on the value
     * @param  [type] $value    [description]
     * @param  [type] $singular [description]
     * @param  [type] $plural   [description]
     * @return [type]           [description]
     */
    public function returnSingularOrPluralString($value, $singular, $plural)
    {
        if ($this->checkIfPlural($value) == false)
        {
            return $singular;
        }
        return $plural;
    }
}