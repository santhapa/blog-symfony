<?php

namespace Common\Utility;

class Paginator
{
	//row per page
	private $rpp;

	//Base url link
	private $base_url;

	//Total number of records for the query
	private $total_page;

	public function __construct($config)
	{
		$this->rpp = $config['rpp'];
		$this->base_url = $config['base_url'];

		$this->total_page = $this->getTotalPages($config['total_count'], $this->rpp); 
	}

	public function getTotalPages($totalCount, $rpp)
	{
		return ceil($totalCount/$rpp);
	}

	public function getPages($curPage)
	{
		if($this->total_page == 1)
		{
			return false;
		}

		$page = '<div class="pagination">
					<ul>';
		if($curPage != 1)
		{
			$page .= '<li><a href="'. $this->base_url. '/' . ($curPage-1) .'"> &laquo; Prev</a></li>';
		}


		for($i=1; $i<=$this->total_page; $i++)
		{
			$page .= '<li><a href="'. $this->base_url. '/' . $i .'">'.$i.'</a></li>';
		}

		if($curPage != $this->total_page)
		{
			$page .= '<li><a href="'. $this->base_url. '/' . ($curPage+1) .'">Next  &raquo;</a></li>';
		}

		$page .= '</ul></div>';

		return $page;
	}

}

?>