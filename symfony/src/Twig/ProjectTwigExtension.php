<?php
namespace App\Twig;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;



/**
  * Class ProjectTwigExtension
 * @package App\Twig
*/
class ProjectTwigExtension extends AbstractExtension
{

    /** @var ContainerInterface  */
    protected $container;


    /**
     * ProjectTwigExtension constructor.
     * @param ContainerInterface $container
    */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * @return array|TwigFunction[]
    */
    public function getFunctions()
    {
        return [
            new TwigFunction('breadcrumbs', [$this, 'breadCrumbHtml'])
        ];
    }


    /**
     * @return mixed
    */
    public function breadCrumbHtml()
    {
        return $this->getBreadCrumb()->build();
    }


    /**
     * @return object|null
    */
    private function getBreadCrumb()
    {
        return $this->container->get('jan.breadcrumb');
    }
}