<?php

namespace Config;

class Menu
{
    public static function getSidebar(): array
    {
        return [
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
                'url' => route_to('survey.index'),
                'active' => 'survey.',
            ],
            [
                'label' => 'Dinas',
                'icon'  => 'ti tabler-building-skyscraper',
                'active' => 'master',
                'children' => [
                    [
                        'label' => 'Kabupaten/Kota',
                        'url'   => route_to('question.index'),
                        'active' => 'question.',
                    ],
                    [
                        'label' => 'Provinsi',
                        'url'   => route_to('questionnaire.index'),
                        'active' => 'questionnaire.',
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
                    ],
                    [
                        'label' => 'Kuesioner',
                        'url'   => route_to('questionnaire.index'),
                        'active' => 'questionnaire.',
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
    }
}
