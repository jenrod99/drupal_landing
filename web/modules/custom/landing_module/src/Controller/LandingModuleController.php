<?php

namespace Drupal\landing_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LandingModuleController extends ControllerBase
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
            '#landingIsActive' => true,
            '#attached' => [
                'library' => [
                    'landing_module/landing_module',
                ],
            ],
        ];
    }

    public function welcomeInfo()
    {
        $vehicleForm = $this->formBuilder()->getForm('Drupal\landing_module\Form\VehicleForm');

        $comments = [];
        $comments[] = [
            'userIcon' => 'mapfre-men-icon',
            'userName' => 'Andrés García',
            'userStars' => [
                'starPath1' => 'modules/custom/landing_module/img/iconos/star-filled.svg',
                'starPath2' => 'modules/custom/landing_module/img/iconos/star-filled.svg',
                'starPath3' => 'modules/custom/landing_module/img/iconos/star-filled.svg',
                'starPath4' => 'modules/custom/landing_module/img/iconos/star-filled.svg',
                'starPath5' => 'modules/custom/landing_module/img/iconos/star.svg',
            ],
            'userComment' => 'Iba en mi vehículo y estallé la llanta a mitad de la noche con un hueco. Llamé y me enviaron una grúa, luego mi llanta fue reemplazada',
        ];
        $comments[] = [
            'userIcon' => 'mapfre-women-icon',
            'userName' => 'Natalia Martínez',
            'userStars' => [
                'starPath1' => 'modules/custom/landing_module/img/iconos/star-filled.svg',
                'starPath2' => 'modules/custom/landing_module/img/iconos/star-filled.svg',
                'starPath3' => 'modules/custom/landing_module/img/iconos/star-filled.svg',
                'starPath4' => 'modules/custom/landing_module/img/iconos/star-filled.svg',
                'starPath4' => 'modules/custom/landing_module/img/iconos/star-filled.svg',
                'starPath5' => 'modules/custom/landing_module/img/iconos/star-filled.svg',
            ],
            'userComment' => 'Al momento del choque tuve una respuesta rápida, luego me enviaron el abogado y momentos más tarde llegó el perito, mi carro fue arreglado en su totalidad sin mayor inconveniente.',
        ];
        $comments[] = [
            'userIcon' => 'mapfre-men-icon',
            'userName' => 'Esteban Gómez',
            'userStars' => [
                'starPath1' => 'modules/custom/landing_module/img/iconos/star-filled.svg',
                'starPath2' => 'modules/custom/landing_module/img/iconos/star-filled.svg',
                'starPath3' => 'modules/custom/landing_module/img/iconos/star-filled.svg',
                'starPath4' => 'modules/custom/landing_module/img/iconos/star.svg',
                'starPath5' => 'modules/custom/landing_module/img/iconos/star.svg',
            ],
            'userComment' => 'Llegando de viaje mi vehículo se varó, llame y aunque se demoró un poco la grúa llego a donde estaba.',
        ];

        $benefits = [];
        $benefits[] = [
            'icon' => 'mapfre-market-icon',
            'title' => 'Compra',
            'description' =>
            'Accede a la forma seguro de comprar tu seguro en línea y sin complicaciones',
        ];
        $benefits[] = [
            'icon' => 'mapfre-history-icon',
            'title' => 'Tiempo',
            'description' => 'Cotiza tu seguro todo riesgo al instante',
        ];
        $benefits[] = [
            'icon' => 'mapfre-network-icon',
            'title' => 'Online',
            'description' =>
            'Accede desde cualquier dispositivo móvil para adquirir tu seguro todo riesgo',
        ];
        $benefits[] = [
            'icon' => 'mapfre-headphone-icon',
            'title' => 'Asesoría Personalizada',
            'description' =>
            'No dudes en contactarnos, siempre estaremos dispuestos a ayudarte y responder todas las dudas que tengas',
        ];
        return [
            '#theme' => 'landing_module_template',
            '#form' => $vehicleForm,
            '#comments' => $comments,
            '#benefits' => $benefits,
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
        $build[] = $this->formBuilder()->getForm('Drupal\landing_module\Form\VehicleForm');;
        $build[] = $this->welcomeInfo();
        $build[] = $this->footer();
        return $build;
    }
};
