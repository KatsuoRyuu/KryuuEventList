<?php
namespace EventList\Controller;

use Zend\View\Model\ViewModel;
use EventList\Controller\EntityUsingController,
    EventList\Entity\Event;

class IndexController extends EntityUsingController
{
	
	protected $ContactTable;
	
    public function addAction()
    {
   
        $builder    = new AnnotationBuilder();
        $event      = new Event();
        $form       = $builder->createForm($event);
        
        //$companyForm->get('about')->setValueOptions($mails);
        return new ViewModel('form'=>$form);
    }
    
}
