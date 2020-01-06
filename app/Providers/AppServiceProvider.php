<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use App\Providers\AuthServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Taak;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            if (Auth::check())
            {
                
                $event->menu->add([
                    'text' => Auth::user()->naam,
                    'url'  => 'profiel',
                    'icon'=> "fas fa-user-circle",
                    'topnav' => true,
                ]);
                $event->menu->add(['header' => 'USER RIGHTS MANAGEMENT']);

                $event->menu->add([
                    'text' => 'Mijn taken',
                    'url'  => 'taken',
                    'label' => count(Auth::user()->verantwoordelijkeTaken()->where('isCompleet',false)->get()),
                    'label_color' => 'success',
                    'icon' => 'fas fa-tasks',
                ]);
                $event->menu->add(['header' => 'GEBRUIKERSBEHEER','can' => "isPersoneelsdienst"]);
                $event->menu->add([
                    'text' => 'Nieuw in dienst',
                    'url'  => 'gebruikers/inDienst',
                    'icon' => 'fas fa-fw  fa-user-plus',
                    'can' => "isPersoneelsdienst",
                ]);
                $event->menu->add([
                    'text' => 'Uit dienst',
                    'url'  => 'gebruikers/uitDienst',
                    'icon' => 'fas fa-fw  fa-user-minus',
                    'can' => "isPersoneelsdienst",
                ]);
                $event->menu->add([
                    'text' => 'Overzicht',
                    'url'  => 'gebruikers/overzicht',
                    'icon' => 'fas fa-fw fa-users',
                    'can' => "isPersoneelsDienst",
                ]);
                $event->menu->add(['header' => 'INSTELLINGEN TOEPASSING','can' => "isAdministrator"]);
                $event->menu->add([
                    'text' => 'Gebruikers & Rollen',
                    'url'  => 'administrator/gebruikers',
                    'icon' => 'fas fa-fw fa-users-cog',
                    'can' => "isAdministrator",
                ]);
                $event->menu->add([
                    'text' => 'Gebruikersprofielen',
                    'url'  => 'administrator/gebruikersprofielen',
                    'icon' => 'fas fa-fw fa-id-badge',
                    'can' => "isAdministrator",
                ]);
                $event->menu->add([
                    'text' => 'Toepassingen',
                    'url'  => 'administrator/toepassingen',
                    'icon' => 'fas fa-fw fa-boxes',
                    'can' => "isAdministrator",
                ]);
                $event->menu->add([
                    'text' => 'Diensten & Teams',
                    'url'  => 'administrator/diensten',
                    'icon' => 'fas fa-fw fa-users',
                    'can' => "isAdministrator",
                ]);
                $event->menu->add([
                    'text' => 'Rapporten',
                    'url'  => 'administrator/rapporten',
                    'icon' => 'fas fa-fw fa-chart-bar',
                    'can' => "isAdministrator",
                ]);
                $event->menu->add(['header' => 'PERSOONLIJK']);
                $event->menu->add([
                    'text' => 'profiel',
                    'url'  => 'admin/settings',
                    'icon' => 'fas fa-fw fa-user-circle',
                ]);
                $event->menu->add([
                    'text'    => 'multilevel',
                    'icon'    => 'fas fa-fw fa-share',
                    'submenu' => [
                        [
                            'text' => 'level_one',
                            'url'  => '#',
                        ],
                        [
                            'text'    => 'level_one',
                            'url'     => '#',
                            'submenu' => [
                                [
                                    'text' => 'level_two',
                                    'url'  => '#',
                                ],
                                [
                                    'text'    => 'level_two',
                                    'url'     => '#',
                                    'submenu' => [
                                        [
                                            'text' => 'level_three',
                                            'url'  => '#',
                                        ],
                                        [
                                            'text' => 'level_three',
                                            'url'  => '#',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        [
                            'text' => 'level_one',
                            'url'  => '#',
                        ],
                    ],
                ]);
                
                $event->menu->add(['header' => 'labels']);
                $event->menu->add([
                    'text'       => 'important',
                    'icon_color' => 'red',
                ]);
                $event->menu->add([
                    'text'       => 'warning',
                    'icon_color' => 'yellow',
                ]);
                $event->menu->add([
                    'text'       => 'information',
                    'icon_color' => 'aqua',
                ]);
                $event->menu->add(['header' => 'PERSONEELSDIENST','can' => "isAdministrator"]);
                $event->menu->add([
                    'text' => 'Nieuw in dienst',
                    'url'  => 'gebruikers/inDienst',
                    'icon' => 'fas fa-fw fa-user-plus',
                    'can' => "isAdministrator",
                ]);
                $event->menu->add([
                    'text' => 'Uit dienst',
                    'url'  => 'gebruikers/uitDienst',
                    'icon' => 'fas fa-fw fa-user-minus',
                    'can' => "isAdministrator",
                ]);
                $event->menu->add([
                    'text' => 'Overzicht',
                    'url'  => 'gebruikers/overzicht',
                    'icon' => 'fas fa-fw fa-users',
                    'can' => "isAdministrator",
                ]);
            }
        });
    }
}