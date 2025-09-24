<?php

namespace Config;

use App\Helpers\CommonHelper;

class Menu
{
    public static function getSidebar(): array
    {
        $menu = [
            // [
            //     'label' => 'Dashboards',
            //     'icon'  => 'ti tabler-smart-home',
            //     'active' => 'dashboard',
            //     'children' => [         // If menu has no children, do not need to define children key
            //         [
            //             'label' => 'Dashboard',
            //             'url'   => base_url('dashboard'),
            //             'active' => 'dashboard',
            //         ],
            //         [
            //             'label' => 'Profil',
            //             'url'   => route_to('profile'),
            //             'active' => 'profile',
            //         ],
            //     ]
            // ],
            [
                'label' => 'Dashboards',
                'icon'  => 'ti tabler-smart-home',
                'url'   => base_url('dashboard'),
                'active' => 'dashboard',
            ],
            [
                'label' => 'Institusi',
                'icon'  => 'ti tabler-building',
                'url' => route_to('institusi.index'),
                'active' => 'institusi',
                'access' => ['Institusi', 'index'],
            ],
            [
                'label' => 'Dinas',
                'icon'  => 'ti tabler-building-skyscraper',
                'active' => 'master',
                'children' => [
                    [
                        'label' => 'Kabupaten/Kota',
                        'url'   => route_to('kabkota.index'),
                        'active' => 'kabkota',
                        'access' => ['Kabkota', 'index'],
                    ],
                    [
                        'label' => 'Provinsi',
                        'url'   => route_to('provinsi.index'),
                       'active' => 'provinsi',
                        'access' => ['Provinsi', 'index'],
                    ],
                ]
            ],
            [
                'label' => 'Master',
                'icon'  => 'ti tabler-database-cog',
                'active' => 'master',
                'children' => [
                    [
                        'label' => 'Pertanyaan',
                        'url'   => route_to('question.index'),
                        'active' => 'question.',
                        'access' => ['Question', 'index'],
                    ],
                    [
                        'label' => 'Kuesioner',
                        'url'   => route_to('questionnaire.index'),
                        'active' => 'questionnaire.',
                        'access' => ['Questionnaire', 'index'],
                    ],
                    [
                        'label' => 'Pelatihan',
                        'url'   => route_to('master-training.index'),
                        'active' => 'master-training.',
                    ],
                ]
            ],
            [
                'label' => 'Assessment / Penilaian',
                'icon'  => 'ti tabler-clipboard-text',
                'url' => route_to('survey.index'),
                'active' => 'survey.',
            ],
        ];

        return self::filterSidebarAccess($menu);
    }

    protected static function filterSidebarAccess(array $menus): array
    {
        $filtered = [];

        foreach ($menus as $menu) {
            if (isset($menu['children'])) {
                $menu['children'] = self::filterSidebarAccess($menu['children']);
                if (!empty($menu['children'])) {
                    $filtered[] = $menu;
                }
            } else {
                if (!isset($menu['access']) || CommonHelper::hasAccess($menu['access'][0], $menu['access'][1])) {
                    $filtered[] = $menu;
                }
            }
        }

        return $filtered;
    }
}
