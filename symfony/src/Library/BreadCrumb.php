<?php
namespace App\Library;


use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;


/**
 * Class BreadCrumb
 * @package App\Library
 */
class BreadCrumb
{

    /**
     * @var array
     */
    private $items = [];


    /**
     * @var string
     */
    protected $separator = ' / ';


    /**
     * @var string
     */
    protected $template;


    /**
     * @var string
     */
    protected $domain = '';


    /* @var Environment */
    protected $environment;


    /**
     * BreadCrumb constructor.
     * @param array $items
     * @param Environment|null $environment
    */
    public function __construct(array $items = [], Environment $environment = null)
    {
        if($items)
        {
            $this->setItems($items);
        }

        if($environment)
        {
            $this->setTwigEnvironment($environment);
        }
    }


    /**
     * @param string $separator
     * @return BreadCrumb
    */
    public function setSeparator(string $separator): BreadCrumb
    {
        $this->separator = $separator;

        return $this;
    }


    /**
     * @param array $items
     * @return BreadCrumb
     */
    public function setItems(array $items): BreadCrumb
    {
        $this->items = array_merge($this->items, $items);

        return $this;
    }


    /**
     * @param Environment $environment
     * @return BreadCrumb
    */
    public function setTwigEnvironment(Environment $environment)
    {
        $this->environment = $environment;

        return $this;
    }


    /**
     * @param string $template
     * @return BreadCrumb
    */
    public function setTemplate(string $template): BreadCrumb
    {
        $this->template = $template;

        return $this;
    }


    /**
     * @param string $domain
     * @return BreadCrumb
    */
    public function setDomain(string $domain): BreadCrumb
    {
        $this->domain = $domain;

        return $this;
    }


    /**
     * @param string $title
     * @param string $link
     * @return BreadCrumb
     */
    public function add(string $title, string $link): BreadCrumb
    {
        $this->items[$title] = $link;

        return $this;
    }


    /**
     * @return string
     */
    public function build()
    {
        $count = 0;
        $breadCrumbHtml = '';

        foreach ($this->items as $title => $link)
        {
            $breadCrumbHtml .= $this->renderHtml($this->domain, $title, $link);
            $count++;

            if($count !== count($this->items))
            {
                $breadCrumbHtml .= $this->separator;
            }
        }

        echo $breadCrumbHtml;
    }


    /**
     * @param string $domain
     * @param string $title
     * @param string $link
     * @return false|string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
    */
    public function renderHtml(string $domain, string $title, string $link)
    {
        if($this->environment instanceof Environment)
        {
            return $this->environment->render($this->template, compact('domain', 'title', 'link'));
        }

        ob_start();
        @require $this->template;
        return ob_get_clean();
    }
}
