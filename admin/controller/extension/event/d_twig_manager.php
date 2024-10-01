<?php

class ControllerExtensionEventDTwigManager extends Controller
{
    protected $registry;
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->registry = $registry;
    }

    public function index(&$route, &$args) {
        // most likely this is an old twig that is in the library
        if (!class_exists('\Twig\Extension\AbstractExtension') && !class_exists('\Twig_Extension')) {
            $args['d_registry'] = $this->registry;
            return;
        }
		if (!$this->registry->has('d_twig_manager_extension') && file_exists(DIR_SYSTEM . 'library/template/Twig/Extension/DTwigManager.php')) {
            require_once(DIR_SYSTEM . 'library/template/Twig/Extension/DTwigManager.php');
            $this->registry->set('d_twig_manager_extension', new \Twig_Extension_DTwigManager($this->registry));
        }
        if ($this->registry->has('d_twig_manager_extension')) {
            $args['d_twig_manager'] = $this->registry->get('d_twig_manager_extension');
        }
	}
}
