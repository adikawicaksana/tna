<?php

namespace Config;

class Menu
{
    public static function getSidebar(): array
    {
        return [
            [
                'label' => 'Dashboards',
                'icon'  => 'ti tabler-smart-home',
                'active' => 'dashboard',
                'children' => [         // If menu has no children, do not need to define children key
                    [
                        'label' => 'Dashboard',
                        'url'   => base_url('dashboard'),
                        'active' => 'dashboard',
                    ],
                    [
                        'label' => 'Profil',
                        'url'   => route_to('profile'),
                        'active' => 'profile',
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
                ]
            ],
            [
                'label' => 'Survei',
                'icon'  => 'ti tabler-clipboard-text',
                'url' => route_to('survey.index'),
                'active' => 'survey.',
            ],
        ];
    }
}
