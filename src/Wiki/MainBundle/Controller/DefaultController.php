<?php

namespace Wiki\MainBundle\Controller;

use Propel\Generator\Behavior\NestedSet\NestedSetBehavior;
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
        return $this->render('WikiMainBundle:Default:index.html.twig', array('objects' => $objects));
    }


    public function showAction($alias)
    {
        $obj = WikiQuery::create()
            ->findOneByAlias($alias);

        if (!$obj  ) {
            throw $this->createNotFoundException('не найдено'.': '.$alias);
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
                return $this->redirect($this->generateUrl('show', array(
                    'alias'=> $page->getAlias()
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
            ->setParentId($data['parent_id'])
            ->save();

        return $page;
    }

    private function getPageDel($alias)
    {
        return WikiQuery::create()->findOneByAlias($alias);
    }

    // опишем метод удаления существующих страниц
    public function deleteAction(Request $request, $alias)
    {
        $page_del = $this->getPageDel($alias); //ищем страницу по ее алиасу
        $page_del->delete(); //удаляем страницу
        $this->addFlash('success','Проект успешно удалён');
        return $this->redirect($this->generateUrl('homepage')); //переходим в шаблон удаления
    }

    private function getPage($alias)
    {
        return WikiQuery::create()->findOneByAlias($alias);
    }


    // опишем метод редактирования существующих страниц
    public function editAction (Request $request, $alias)
    {
        $page = $this->getPage($alias);
        if (!is_null($page)) {
            $form = $this->createForm('page_form', $page);
            $form->handleRequest($request);
            if ($form->isValid()) {
                try {
                    $page = $form->getData();
                    $page->save();
                    $this->addFlash('success', 'Проект успешно обновлен');
                    return $this->redirect($this->generateUrl('show', array(
                        'alias' => $page->getAlias()
                    )));
                } catch (\Exception $e) {
                    $form->addError (new FormError($e->getMessage()));
                }
            }
            return $this->render('WikiMainBundle:Default:edit.html.twig', [
                'form'      => $form->createView(),
                'page'      => $page
            ]);

        }
        else {
            $this->addFlash('success', 'Oops! Страница еще не создана');
            return $this->redirect($this->generateUrl('add'));
        }

    }
}



