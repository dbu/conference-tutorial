<?php

namespace Dbu\ConferenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SubscribeController extends Controller
{
    public function subscribeAction(Request $request)
    {
        $defaultData = array();

        $form = $this->createFormBuilder($defaultData)
            ->add('name', 'text')
            ->add('email', 'email')
            ->add('Subscribe', 'submit', array(
                'translation_domain' => 'messages',
                'label' => 'subscribe',
                'attr' => array('class' => 'pure-button pure-button-primary'),
            ))
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $request->getSession()->getFlashBag()->add(
                'notice',
                sprintf('Thanks a lot for your subscription, %s <%s>', $data['name'], $data['email'])
            );

            // the cmf router can redirect to a route stored in the db.
            return $this->redirect($this->generateUrl('/cms/simple'));
        }

        $this->get('sonata.seo.page')->setTitle($this->get('translator')->trans('site.subscribe'));

        return $this->render('DbuConferenceBundle:Subscribe:form.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
