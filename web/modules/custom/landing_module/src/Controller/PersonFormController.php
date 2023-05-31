<?php

namespace Drupal\landing_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PersonFormController extends ControllerBase
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public static function create(ContainerInterface $container)
    {
        return new static(
            $container->get('session'),
        );
    }

    public function navBar()
    {
        return [
            '#theme' => 'nav_bar_template',
            '#value' => 'contacto@alseguros.co',
            '#landingIsActive' => false,
            '#attached' => [
                'library' => [
                    'landing_module/landing_module',
                ],
            ],
        ];
    }

    public function formInfo() {
        return [
            '#theme' => 'person_form_template',
            '#title' => '¡Buen día!',
            '#paragraph' => 'Registra tus datos de forma correcta para poder calcular tu seguro todo riesgo.',
            '#attached' => [
                'library' => [
                    'landing_module/landing_module',
                ],
            ],
        ];
    }

    public function cityBg() {
        return [
            '#theme' => 'city_background_template',
            '#attached' => [
                'library' => [
                    'landing_module/landing_module',
                ],
            ],
        ];
    }

    public function footer() {
        
        return [
            '#theme' => 'footer_template',
            '#attached' => [
                'library' => [
                    'landing_module/landing_module',
                ],
            ],
        ];
    }
   
    public function mapPageContent()
    {
        $build = [];
        $build[] = $this->navBar();
        $build[] = $this->formInfo();
        $build[] = $this->formBuilder()->getForm('Drupal\landing_module\Form\PersonForm');
        $build[] = $this->cityBg();
        $build[] = $this->footer();
        return $build;
    }
};
