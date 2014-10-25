<?php

namespace Sandbox\MainBundle\DataFixtures\PHPCR;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr\StaticContent;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\Menu;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\MenuNode;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route;
use Symfony\Component\DependencyInjection\ContainerAware;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ODM\PHPCR\DocumentManager;
use PHPCR\Util\NodeHelper;


class LoadTranslatedUrlData extends ContainerAware implements FixtureInterface, OrderedFixtureInterface
{
    public function getOrder()
    {
        return 50;
    }

    /**
     * @param DocumentManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $cookies = new StaticContent();
        $cookies->setParent($manager->find(null, '/cms/content'));
        $cookies->setName('about');
        $cookies->setTitle('Information about the Symfony CMF');
        $cookies->setBody('This page explains what this is all about.');
        $manager->persist($cookies);
        $manager->bindTranslation($cookies, 'en');
        $cookies->setTitle('Informationen über das CMF');
        $cookies->setBody('Diese Seite erklärt worum es hier geht.');
        $manager->bindTranslation($cookies, 'de');

        NodeHelper::createPath($manager->getPhpcrSession(), '/cms/routes/en');
        $en = $manager->find(null, '/cms/routes/en');
        $route = new Route();
        $route->setPosition($en, 'about-us');
        $route->setContent($cookies);
        $manager->persist($route);

        NodeHelper::createPath($manager->getPhpcrSession(), '/cms/routes/de');
        $de = $manager->find(null, '/cms/routes/de');
        $route = new Route();
        $route->setPosition($de, 'ueber-uns');
        $route->setContent($cookies);
        $manager->persist($route);

        $basepath = $this->container->getParameter('cmf_menu.persistence.phpcr.menu_basepath');
        NodeHelper::createPath($manager->getPhpcrSession(), $basepath);
        $root = $manager->find(null, $basepath);
        $service = new Menu();
        $service->setPosition($root, 'service');
        $manager->persist($service);

        $entry = new MenuNode();
        $entry->setPosition($service, 'about');
        $entry->setContent($cookies);
        $entry->setLabel('About');
        $manager->persist($entry);
        $manager->bindTranslation($entry, 'en');
        $entry->setLabel('Über uns');
        $manager->bindTranslation($entry, 'de');

        $manager->flush();
    }
}
