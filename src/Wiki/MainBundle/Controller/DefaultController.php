<?php

namespace Wiki\MainBundle\Controller;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Wiki\MainBundle\Model\Wiki;
use Wiki\MainBundle\Model\Config;
use Wiki\MainBundle\Type\PageType;



class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('WikiMainBundle:Default:index.html.twig');
    }

    public function showAction(Request $request, $id)
    {

        return $this->render('WikiMainBundle:Default:show.html.twig', array('id' => $id));
    }

    public function addAction(Request $request)
    {
       $form = $this->createForm('page_form');
        $form->handleRequest($request);
        if ($form->isValid()) {
            try {
                $page = $this->addPage($form);
                $this->addFlash('success','Страница успешно создана' );
                //редирект на страницу просмотра Страницы
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
            ->save();
        return $page;
    }

    private function editPage(Request $request, $id)
    {
        $page = $this->getPage($id); //ищет проект
        $form = $this->createForm('page', $page);
        $form->handleRequest($request);
        if ($form->isValid()) {
            try {
                $page = $form->getData();
                $page->save();
                $this->addFlash('success', 'Страница успешно обновлена');
                //редирект на страницу просмотра Страницы
            return $this->redirect($this->generateUrl('add',array(
                'id' => $page->getId()
            )));
            } catch (\Exception $e) {
                $form->addError(new FormError($e->getMessage()));
            }
        }
        return $this->render('WikiMainBundle:Default:add.html.twig', [
            'form' => $form->createView(),
            'page' => $page
            ]);
    }
}