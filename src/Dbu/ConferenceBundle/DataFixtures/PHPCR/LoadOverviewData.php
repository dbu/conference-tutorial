<?php

namespace Sandbox\MainBundle\DataFixtures\PHPCR;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use PHPCR\Util\PathHelper;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\MenuNode;
use Symfony\Cmf\Bundle\SimpleCmsBundle\Doctrine\Phpcr\Page;
use Symfony\Component\DependencyInjection\ContainerAware;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ODM\PHPCR\DocumentManager;
use PHPCR\Util\NodeHelper;

class LoadOverviewData extends ContainerAware implements FixtureInterface, OrderedFixtureInterface
{
    public function getOrder()
    {
        return 10;
    }

    /**
     * @param DocumentManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $path = $this->container->getParameter('dbu_conference.home_path');
        $speakersPath = $this->container->getParameter('dbu_conference.speakers_path');

        $page = $manager->find(null, $path);
        $page->setOption('add_locale_pattern', true);
        $page->setTitle('Our lovely conference');
        $page->setBody('Welcome to the conference website.');
        $manager->bindTranslation($page, 'en');

        $page->setTitle('Unsere tolle Konferenz');
        $page->setBody('Willkommen auf der Konferenz-Webseite.');
        $manager->bindTranslation($page, 'de');

        $schedule = new Page();
        $schedule->setPosition($page, 'schedule');
        $schedule->setOption('add_locale_pattern', true);
        $schedule->setLabel('Schedule');
        $schedule->setTitle('Conference Schedule');
        $schedule->setBody('');
        $schedule->setDefault('type', 'schedule');
        $manager->persist($schedule);
        $manager->bindTranslation($schedule, 'en');

        $schedule->setLabel('Programm');
        $schedule->setTitle('Konferenzprogramm');
        $manager->bindTranslation($schedule, 'de');


        // as the speakersPath is configurable, we need to make sure it exists
        if (!$manager->find(null, PathHelper::getParentPath($speakersPath))) {
            NodeHelper::createPath($manager->getPhpcrSession(), PathHelper::getParentPath($speakersPath));
        }

        $schedule = new Page();
        $schedule->setId($speakersPath);
        $schedule->setOption('add_locale_pattern', true);
        $schedule->setLabel('Speakers');
        $schedule->setTitle('Your friendly speakers');
        $schedule->setBody('');
        $schedule->setDefault('_template', 'DbuConferenceBundle:Speaker:overview.html.twig');
        $manager->persist($schedule);
        $manager->bindTranslation($schedule, 'en');

        $schedule->setLocale('de');
        $schedule->setLabel('Vortragende');
        $schedule->setTitle('Unsere freundlichen Vortragenden');
        $manager->bindTranslation($schedule, 'de');

        // add menu entry for our application page
        $menu = new MenuNode();
        $menu->setPosition($page, 'subscribe');
        $menu->setLabel('Sign up');
        $menu->setRoute('dbu_conference_subscribe');
        $manager->persist($menu);
        $manager->bindTranslation($menu, 'en');

        $menu->setLocale('de');
        $menu->setLabel('Anmelden');
        $manager->bindTranslation($menu, 'de');

        $manager->flush();
    }
}
