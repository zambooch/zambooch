<?php

namespace Wiki\MainBundle\Controller;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Wiki\MainBundle\Model\Wiki;
use Wiki\MainBundle\Model\Config;
use Wiki\MainBundle\Model\WikiQuery;




class DefaultController extends Controller
{
    public function indexAction()
    {
        $objects = WikiQuery::create()->find();
        return $this->render('WikiMainBundle:Default:index.html.twig', array('objects'=>$objects));
    }

    public function showAction($alias)
    {
        $obj = WikiQuery::create()
            ->findOneByAlias($alias);
        if (!$obj) {
            throw $this->createNotFoundException('не найдено'.$alias);
        }
        return $this->render('WikiMainBundle:Default:show.html.twig', array('obj' => $obj));
    }

    public function addAction(Request $request)
    {
       $form = $this->createForm('page_form');
        $form->handleRequest($request);
        if ($form->isValid()) {
            try {
                $page = $this->addPage($form);
                $this->addFlash('success','Страница успешно создана' );
                //редирект на страницу просмотра
                return $this->redirect($this->generateUrl('homepage', array(
                    'id'=> $page->getId()
                )));
            } catch (\Exception $e) {
                $form->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render('WikiMainBundle:Default:add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function addPage($form)
    {
        $data = $form->getData();
        $page = new Wiki();
        $page
            ->setTitle($data['title'])
            ->setText($data['text'])
            ->setAlias($data['alias'])
            ->save();
        return $page;
    }

    private function getPage($id)
    {
        return WikiQuery::create()->findPK(intval($id));
    }

    public function editAction(Request $request, $id)
    {
        $page = $this->getPage($id); //ищет проект
        if(!is_null($page))
        {
            $form = $this->createForm('page_form', $page);
            $form->handleRequest($request);
            if ($request->getMethod() == 'POST')
            {
                $form->handleRequest($request);
                if ($form->isValid())
                {
                    try
                    {
                        $data = $form->getData();
                        $page
                            ->setTitle($data['title'])
                            ->setText($data['text'])
                            ->setAlias($data['alias'])
                            ->save();
                        $this->addFlash('success', 'Страница успешно обновлена');
                        //редирект на страницу просмотра Страницы
                        return $this->redirect($this->generateUrl('/wiki/{id}', array(
                            'id' => $page->getId()
                        )));
                    } catch (\Exception $e)
                    {
                        $form->addError(new FormError($e->getMessage()));
                    }
                }
            }
            return $this->render('WikiMainBundle:Default:edit.html.twig', [
                'form' => $form->createView(),

            ]);
        }
        else
        {
            $this->addFlash('success', 'Нет такой страницы');

            return $this->redirect($this->generateUrl('homepage'));
        }
    }
}