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
		
    public function indexAction()
    {
        
        return new ViewModel();
    }
    
    public function addAction(){
        
        return $this->editAction();
        
    }
    
    public function editAction(){
        
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
                $event->__add($this->storeFile($request->getFiles()), 'file');
                $this->entityManager()->persist($event);
                $this->entityManager()->flush();
            }
        }
        
        
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
}
