<?php

namespace Wiki\MainBundle\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Null;
use Wiki\MainBundle\Model\Wiki;
use Wiki\MainBundle\Model\WikiQuery;


/**
 * Форма "Добавить новую страницу
 *
 * Class PageType
 * @package Wiki\MainBunde\Type
 */
class PageType extends BaseAbstractType
{
    public function getName()
    {
        return 'page_form';
    }



    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $data = $builder->getData();
        //var_dump($data->getId());
        //die();
        $select_options = array(0 => 'без родительской статьи');


        foreach (WikiQuery::create()->find() as $page)
        {
            $select_options[$page->getId()] = $page->getTitle();
            if ($page->getParentId()) unset ($select_options[$page->getId()]);
            elseif($data && $data->getId() == $page->getId()) unset($select_options[$page->getId()]);

        }

        $builder
            ->add('title', 'text', array (
                'label'     => 'Заголовок страницы',
                'required'  => TRUE,
                'attr' => array(
                    'class' => 'form-control',
                ),
                'constraints' => array (
                    new NotBlank(array(
                        'message' => 'Поле обязательно для заполнения'
                    )),
                )
            ))
            ->add('text', 'textarea', array(
                'label' => 'Текст новой страницы',
                'required' => TRUE,
                'constraints' => array (
                    new NotBlank(array (
                        'message' => 'Поле обязательно для заполнения'
                    )),
                )
            ))
            ->add('alias', 'text', array (
                'label'     => 'Адрес новой страницы',
                'required'  => TRUE,
                'attr' => array(
                    'class' => 'form-control',
                ),
                'constraints' => array (
                    new NotBlank(array(
                        'message' => 'Поле обязательно для заполнения'
                    )),
                )
            ))
            ->add('parent_id', 'choice', array (

                'label'=> 'Родительская статья',
                'choices'=>$select_options,

            ));
    }

}