<?php

namespace Dbu\ConferenceBundle\Admin;

use Dbu\ConferenceBundle\Document\Speaker;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Cmf\Bundle\SimpleCmsBundle\Admin\PageAdmin;

class SpeakerAdmin extends PageAdmin
{
    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('fullname')
            ->add('presentations')
            ->add('publishable', null, array('label' => 'label_confirmed'))
        ;
    }

    public function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);

        $formMapper
            ->with('form.group_general')
                ->add('title', null, array('label' => 'label_full_name'))
                ->add('portrait',
                    'cmf_media_image',
                    array(
                        'required' => false,
                    )
                )
                ->remove('parent')
                ->remove('label')
            ->end()

            ->with('form.group_publish_workflow')
                ->add('publishable', null, array('label' => 'label_confirmed', 'required' => false))
            ->end()
        ;
    }

    public function getNewInstance()
    {
        /** @var $new Speaker */
        $new = parent::getNewInstance();

        $new->setParentDocument($this->getModelManager()->getDocumentManager()->find(null, $this->getRootPath()));

        return $new;
    }
}
