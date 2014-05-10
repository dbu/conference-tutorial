<?php

namespace Dbu\ConferenceBundle\Admin;

use Dbu\ConferenceBundle\Document\Room;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Cmf\Bundle\SimpleCmsBundle\Admin\PageAdmin;

class RoomAdmin extends PageAdmin
{
    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title', null, array('label' => 'label_room_title'))
            ->add('description')
        ;
    }

    public function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);

        $formMapper
            ->with('form.group_general')
                ->add('title', null, array('label' => 'label_room_title'))
                ->add('description')

                ->remove('parent')
                ->remove('label')
            ->end()
        ;
    }

    public function getNewInstance()
    {
        /** @var $new Room */
        $new = parent::getNewInstance();

        $new->setParentDocument($this->getModelManager()->getDocumentManager()->find(null, $this->getRootPath()));

        return $new;
    }
}
