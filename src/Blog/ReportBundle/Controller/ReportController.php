<?php

namespace Blog\ReportBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Velvel\ReportBundle\Controller\ReportController as BaseController;
use Blog\ReportBundle\Entity\Report;
use Blog\ReportBundle\Form\Type\GenerateReportFormType;
use Blog\ReportBundle\Utility\Utility;

class ReportController extends BaseController
{
	 public function listAction()
    {
        $generator = $this->container->get('velvel.report.generator');
        $template  = $generator->getListTemplate();

        $reportRepo = $this->getDoctrine()->getManager()->getRepository('BlogReportBundle:Report');
        $reports = $reportRepo ->getReports();

        return $this->render($template, array('reports' => $reports, 'title'=> 'Created Reports'));
    }
    
    public function showAction(Request $request, $reportId)
    {
        $generator = $this->container->get('velvel.report.generator');
        $template  = $generator->getShowTemplate();

        $em = $this->getDoctrine()->getManager();

        $reportRepo = $em->getRepository('BlogReportBundle:Report');
        $reports = $reportRepo ->getReports();

        foreach ($reports as $value) {
            if($value->getSlug() === $reportId)
            {
            	$report = $value;
            	break;
            }
        }

        $util = $this->get('report_utility');

        $filters = $util->parseInlineFilters($report->getSqlQuery());
        $form = $this->generateForm($filters);

        $prepQuery = str_replace(array("\n", "\r\n", "\r"), ' ', $report->getSqlQuery());
        $query = $em->createQuery(preg_replace('/where.+/', '', trim($prepQuery)));

        $result = $query->getResult();        


        if ($request->getMethod() == 'POST') 
        {
            $form->bind($request);
            $query = $em->createQuery($report->getSqlQuery());
            $query->setParameters($form->getData());
            $result = $query->getResult();
        }

        return $this->render($template, array('form'   => $form->createView(),
                                              'result' => $result,
                                              'report' => $report));
    }

	public function generateReportAction(Request $request)
	{
		$data['sqlError'] = null;
		$report = new Report();
		$entityManager = $this->getDoctrine()->getEntityManager();
		$reportForm = $this->get('report_generator');

		$util = $this->get('report_utility');

		$form = $this->createForm($reportForm, $report);

		$form->setData($report);
		$form->handleRequest($request);

		if($form->isValid())
		{
			$report =$form->getData();
			$slug = strtolower(str_replace(" ", "-", $form->get('name')->getData()));
			
			$ret = $util->getSqlErrors($form->get('sqlQuery')->getData());

			if($ret)
			{
				$data['sqlError'] = $ret;
				goto end;
			}

			$sql = str_replace(';',' ' , $form->get('sqlQuery')->getData());
			$report->setSqlQuery($sql);

			$report->setSlug($slug);

			$entityManager->persist($report);
			$entityManager->flush();

			return $this->redirect($this->generateUrl('reportPage'));
		}
		end:
			$data['form'] = $form->createView();
			return $this->render('BlogReportBundle::Report/create_report.html.twig', $data);
	
	}

	public function editReportAction(Request $request, $reportId)
	{
		$data['sqlError'] = null;
		$util = $this->get('report_utility');

		$entityManager = $this->getDoctrine()->getEntityManager();
		$report = $entityManager->getRepository('BlogReportBundle:Report')
								->findOneBy(array('slug' => $reportId));

		$formClass = $this->get('report_generator');

		$form = $this->createForm($formClass, $report);

		$form->setData($report);
		$form->handleRequest($request);

		if($form->isValid())
		{
			$slug = strtolower(str_replace(" ", "-", $form->get('name')->getData()));
			
			$ret = $util->getSqlErrors($form->get('sqlQuery')->getData());

			if($ret)
			{
				$data['sqlError'] = $ret;
				goto end;
			}

			//remove ; if present
			$sql = preg_replace('/;+$/',' ' , $form->get('sqlQuery')->getData());

			$report->setSlug($slug);
			$report->setName($form->get('name')->getData());
			if($form->getData('description') != null)
				$report->setDescription($form->get('description')->getData());
			$report->setSqlQuery($sql);

			$entityManager->flush();

			return $this->redirect($this->generateUrl('reportPage'));
		}
		end:
			$data['title'] = "Edit ". ucfirst($report->getName());
			$data['reportId'] = $reportId;
			$data['form'] = $form->createView();
			return $this->render('BlogReportBundle::Report/edit_report.html.twig', $data);
	}

	public function deleteReportAction($reportId)
	{
		$entityManager = $this->getDoctrine()->getEntityManager();
		$report = $entityManager->getRepository('BlogReportBundle:Report')
								->findOneBy(array('slug' => $reportId));
		if(!$report)
		{
			throw $this->createNotFoundException('No report found named '.$reportId);
		}

		$entityManager->remove($report);
		$entityManager->flush();

		return $this->redirect($this->generateUrl('reportPage'));

	}

	public function generateForm($filters)
	{
		$builder = $this->createFormBuilder();
		foreach ($filters as $filter) {
			$f = explode("_", $filter);
			if($f[1] == 'date')
			{
				$data = new \DateTime ('now');
			}
			else
			{
				$data = '';
			}
			$builder -> add($filter, $f[1], array(
				'label' => $f[2],
				'data' => $data,
				'required' => false));
		}

		$form = $builder->getForm();

		return $form;
	}

}