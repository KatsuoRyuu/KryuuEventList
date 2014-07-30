<?php

namespace KryuuEventList;

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
 * and shall be written in one of the following ways: Ryuu Technology 
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

 * @version 20140730 
 * @link https://github.com/KatsuoRyuu/
 */
return array(
    'routes' => array(
        /*
         * Base route
         */
        'kryuu-event' => array(
            'type'    => 'literal',
            'options' => array(
                'route' => '/event',
                'constraints' => array(
                    'page' => '[0-9]+',
                ),
                'defaults' => array(
                    'controller'    => 'KryuuEventList\Controller\Index',
                    'action'        => 'index',
                    'page'          => '10',
                ),
            ),
            'may_terminate' => true,
            'child_routes' => array(
                /*
                 * Administration of the module.
                 */
                'admin' => array(
                    'type'    => 'literal',
                    'options' => array(
                        'route' => '/admin',
                        'defaults' => array(
                            'controller'    => 'KryuuEventList\Controller\Admin',
                            'action'        => 'index',
                        ),
                    ),
                ),
                'add' => array(
                    'type'    => 'literal',
                    'options' => array(
                        'route' => '/add',
                        'defaults' => array(
                            'controller'    => 'KryuuEventList\Controller\Admin',
                            'action'        => 'add',
                        ),
                    ),
                ),
                'edit' => array(
                    'type'    => 'segment',
                    'options' => array(
                        'route' => '/edit[/][:id]',
                        'constraints' => array(
                            'id'=>'[0-9]+',
                        ),
                        'defaults' => array(
                            'controller'    => 'KryuuEventList\Controller\Admin',
                            'action'        => 'edit',
                        ),
                    ),
                ),
                'delete' => array(
                    'type'    => 'segment',
                    'options' => array(
                        'route' => '/delete[/:id]',
                        'constraints' => array(
                            'id'=>'[0-9]+',
                        ),
                        'defaults' => array(
                            'controller'    => 'KryuuEventList\Controller\Admin',
                            'action'        => 'delete',
                        ),
                    ),
                ),
                /*
                 * Main routes.
                 */
                'next-event' => array(
                    'type'    => 'literal',
                    'options' => array(
                        'route' => '/next',
                        'defaults' => array(
                            'controller'    => 'KryuuEventList\Controller\Index',
                            'action'        => 'nextEvent',
                        ),
                    ),
                ),
            ),
        ),
    ),
);
