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
        $options = array ();

        foreach (WikiQuery::create()->find() as $page)
        {
            $options[$page->getId()]=$page->getTitle();
        }

        $builder
            ->add('title', 'text', array (
                'label'     => 'Title',
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
                'label' => 'Text',
                'required' => TRUE,
                'constraints' => array (
                    new NotBlank(array (
                        'message' => 'Поле обязательно для заполнения'
                    )),
                )
            ))
            ->add('alias', 'text', array (
                'label'     => 'Alias',
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
                'choices'=>$options
            ));


    }


}