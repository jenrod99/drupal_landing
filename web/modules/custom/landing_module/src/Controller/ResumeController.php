<?php

namespace Drupal\landing_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ResumeController extends ControllerBase
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

    public function resumePage()
    {
        $person = $this->session->get('person_info', []);

        return [
            '#theme' => 'resume_template',
            '#name' => $person[3],
            '#documentType' => $person[1],
            '#documentNumber' => $person[2],
            '#genre' => $person[5],
            '#age' => $person[4],
            '#vehicle_plate' => $person[0],
            '#attached' => [
                'library' => [
                    'landing_module/landing_module',
                ],
            ],
        ];
    }

    public function cityBg()
    {
        return [
            '#theme' => 'city_background_template',
            '#attached' => [
                'library' => [
                    'landing_module/landing_module',
                ],
            ],
        ];
    }

    public function footer()
    {

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
        $build[] = $this->resumePage();
        $build[] = $this->cityBg();
        $build[] = $this->footer();
        return $build;
    }
};
