<?php

namespace Wiki\MainBundle\Type;


use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;


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
            ->add('text', 'text', array(
                'label' => 'Text',
                'required' => TRUE,
                'constraints' => array (
                    new NotBlank(array (
                        'message' => 'Поле обязательно для заполнения'
                    )),
                )
            ));


    }
}