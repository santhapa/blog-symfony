<?php

namespace Blog\ReportBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Blog\ReportBundle\Entity\Report;

class ReportRepository extends EntityRepository
{

	public function getReports()
	{
		return $this->getEntityManager()
					->createQuery('
						Select r from BlogReportBundle:Report r 
						order by r.id desc')
					->getResult();
	}

}

?>