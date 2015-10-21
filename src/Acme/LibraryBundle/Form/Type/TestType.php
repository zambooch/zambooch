<?php

namespace Acme\LibraryBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TestType extends BaseAbstractType
{
    protected $options = array(
        'data_class' => 'Wiki\MainBundle\Model\Test',
        'name'       => 'test',
    );

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title');
        $builder->add('text');
    }
}
