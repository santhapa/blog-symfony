<?php

namespace Blog\ReportBundle\Utility;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/* This class contains the custom functions for 
*Dynamic DQL Report generation
*/

class Utility 
{
	private $sqlErrors = null;
	private $resultFilters = array();

	public function parseInlineFilters($query)
	{
		preg_match_all('/filter_[a-z]+_[a-zA-Z0-9]+/s', $query, $filters, PREG_OFFSET_CAPTURE, TRUE);

		if(count($filters[0]) > 0){
			foreach($filters[0] as $f)
			{
				$name = $f[0];
				$this->resultFilters[] = $name;
			}
		}	

		return $this->resultFilters;
	}

	public function generateForm($filters)
	{
		$builder = $this->createFormBuilder();
		
		foreach ($filters as $filter) 
		{
			$f = explode("_", $filter);
			$builder -> add($filter, $f[1], array(
				'label' => $f[2],
				'required' => false));
		}

		return $builder->getForm();
	}

	public function getSqlErrors($sql)
	{
		$ret = $this->isValidQuery($sql);

		if(!$ret)
		{
			return $this->sqlErrors;
		}

		return false;
	}

	public function isValidQuery($query)
	{
		if (!preg_match("/^select (.*)/i", trim($query)) > 0) 
		{
			$this->sqlErrors = 'Report Generator Query must contain valid SELECT statements only';
			return FALSE;
		}

		$prep_query = str_replace(array("\n", "\r\n", "\r"), ' ', $query);
		$prep_query = preg_replace('!\s+!', ' ', $prep_query);
	
		if ((strtolower(substr($prep_query, 0, 8))=='select *') or strstr($prep_query,'.*')!==FALSE) 
		{
			$this->sqlErrors ='Report Generator Query may not contain WILD selector [ * ]';
			return FALSE;
		}

		$delimeter_position = strpos(trim($prep_query), ';');
	
		if ($delimeter_position===FALSE) {
		} else {
				
			if ($delimeter_position+1 != strlen(trim($prep_query))) {
	
				$this->sqlErrors ='Report Generator Query may not contain MULTIPLE statements delimited by semicolon ( ; )';
				return FALSE;
			}
		}

		return TRUE;
	}

}

?>