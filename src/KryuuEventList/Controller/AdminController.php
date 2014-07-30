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
use KryuuEventList\Entity\Event;

class AdminController extends EntityUsingController
{ 
    public function indexAction() {
        /*
         * Basic Viewmodel
         */
        $viewModel = new ViewModel();
        
        $events = $this->entityManager()->getRepository(static::OBJ_EVENT)->findAll();
        
        $viewModel->setVariables(array(
            'events'    => $events,
            'addUrl'    => static::ROUTE_ADD,
            'deleteUrl' => static::ROUTE_DELETE,
            'editUrl'   => static::ROUTE_EDIT,
        ));
        
        return new ViewModel();
    }
    
    public function addAction() {
        
        $viewModel = $this->editAction();
        
        $viewModel->setVariable('headline', $this->translate('Add new event:'));
        
        return $viewModel;
    }
    
    public function editAction() {
        /**
         * Setting basic ViewModel
         */
        $viewModel = new ViewModel();
        
        $event = new Event();
        
        if($this->params('id') > 0){
            $event = $this->entityManager()->getRepository(static::OBJ_EVENT)->findOneBy(array('id'=>$this->params('id')));
        }
        
        $builder = new AnnotationBuilder();
        $form = $builder->createForm($event);
        $form->bind($event);
        
        $request = $this->getRequest();
        
        if ($request->isPost()){
            $form->bind($event);
            $form->setData($request->getPost());
            if ($form->isValid()){
                
                $event->__set($this->storeFile($request->getFiles()), 'image');
                $this->entityManager()->persist($event);
                $this->entityManager()->flush();
            }
        }
        
        $viewModel->setVariables(array(
            'form'      => $form,
            'url'       => static::ROUTE_ADD,
            'headline'  => $this->translate('Edit event:'),
        ));
        
        return $viewModel;
    }
   
    
    public function deleteAction(){
        // Initialize vars
        $event = null;
        
        // Method start:
        if ($this->params('id') > 0){
            $event = $this->entityManager()->getRepository();            
        }
        if ($event){
            $this->entityManager()->remove($event);
            $this->entityManager()->flush();
        }
    }
    
    /**
     * Private Functions
     * 
     * @param type $file
     * @return null
     */

    private function storeFile($file){

        if (!$this->configuration('fileupload')){
            return null;
        }

        $fileRepo = $this->getServiceLocator()->get('FileRepository');
        $file = $fileRepo->save($file['file']['tmp_name'],$file['file']['name']);
        return $file;
    }
    
}
