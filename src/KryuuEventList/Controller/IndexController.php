<?php
namespace KryuuEventList\Controller;


/**
 * @encoding UTF-8
 * @note *
 * @todo *
 * @package PackageName
 * @author Anders Blenstrup-Pedersen - KatsuoRyuu <anders-github@drake-development.org>
 * @license *
 * The Ryuu Technology License
 *
 * Copyright 2014 Ryuu Technology by 
 * KatsuoRyuu <anders-github@drake-development.org>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * Ryuu Technology shall be visible and readable to anyone using the software 
 * and shall be written in one of the following ways: ?????????, Ryuu Technology 
 * or by using the company logo.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *

 * @version 20140506 
 * @link https://github.com/KatsuoRyuu/
 */

use Zend\View\Model\ViewModel;
use Zend\Form\Annotation\AnnotationBuilder;

class IndexController extends EntityUsingController
{
		
	/**
     * 
     * @return \Zend\View\Model\ViewModel
     */	
    public function indexAction(){
        /**
         * Setting the basic viewModel.
         */
        $viewModel = new ViewModel();
        $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $repository = $entityManager->getRepository('Admin\Entity\SystemUser');
        $adapter = new DoctrineAdapter(new ORMPaginator($repository->createQueryBuilder('user')));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);

        $page = (int) $this->params()->fromQuery('page');
        
        if($page) { 
            $paginator->setCurrentPageNumber($page);
        }

        $viewModel->setVariables(array(
            'paginator' => $paginator,
        ));
        return new ViewModel();
    }
    
    /**
     * getting the view for a single event 
     * can be used for child implementation.
     * @return \Zend\View\Model\ViewModel
     */
    public function nextEventAction(){
        /**
         * Setting the basic viewModel
         */
        $viewModel = new ViewModel();
        
        // getting the event
        $event = $this->getNextEvent();
        
        //setting variables
        $viewModel->setVariables(array(
           'event' => $event, 
        ));
        return $viewModel;
    }
    
    private function getNextEvent() {
        $maxResults = '1';
        # Starting the Query Builder.
        $qb = $this->entityManager()->createQueryBuilder();
        $qb->select('m.date')
                ->from('KryuuEventList\Entity\Event', 'm')
                ->where('m.date >= :date')
                //->orderBy('m.id','DESC')
                ->setMaxResults( $maxResults )
                //->setFirstResult( '?3' )
                ->setParameter('date',time())
                //->setParameter('max_result',$maxResults)
                //->setParameter(2,$itemsPerPage)
                //->setParameter(3,$offset)
                ->getQuery();
        
        return $qb->getQuery()->getArrayResult();
    }
}
