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
            //             'url'   => url_to('profile'),
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
                'url' => url_to('institusi.index'),
                'active' => 'institusi',
                'access' => ['institusi', 'index'],
            ],
            [
                'label' => 'Dinas',
                'icon'  => 'ti tabler-building-skyscraper',
                'active' => 'master',
                'children' => [
                    [
                        'label' => 'Kabupaten/Kota',
                        'url'   => url_to('kabkota.index'),
                        'active' => 'kabkota',
                        'access' => ['kabkota', 'index'],
                    ],
                    [
                        'label' => 'Provinsi',
                        'url'   => url_to('provinsi.index'),
                        'active' => 'provinsi',
                        'access' => ['provinsi', 'index'],
                    ],
                ]
            ],
            [
                'label' => 'Laporan',
                'icon'  => 'ti tabler-report-search',
                'active' => 'report',
                'children' => [
                    [
                        'label' => 'Rekapitulasi Kebutuhan Pelatihan Fasyankes',
                        'url'   => url_to('report.trainingNeedsSummary'),
                        'active' => 'report.trainingNeedsSummary',
                        'access' => ['Report', 'trainingNeedsSummary'],
                    ],
                    [
                        'label' => 'Rekapitulasi Pelatihan atau Peningkatan Kompetensi yang Dibutuhkan Pegawai Fasyankes',
                        'url'   => url_to('report.trainingNeedsSummary2'),
                        'active' => 'report.trainingNeedsSummary2',
                        'access' => ['Report', 'trainingNeedsSummary2'],
                    ],
                    [
                        'label' => 'Rekapitulasi Kebutuhan Pelatihan di Kabupaten',
                        'url'   => url_to('report.trainingNeedsSummaryByRegency'),
                        'active' => 'report',
                        'access' => ['Report', 'trainingNeedsSummaryByRegency'],
                    ],
                ]
            ],
            [
                'label' => 'Master Data',
                'icon'  => 'ti tabler-database-cog',
                'active' => 'master',
                'children' => [
                    [
                        'label' => 'Pertanyaan',
                        'url'   => url_to('question.index'),
                        'active' => 'question.',
                        'access' => ['Question', 'index'],
                    ],
                    [
                        'label' => 'Kuesioner',
                        'url'   => url_to('questionnaire.index'),
                        'active' => 'questionnaire.',
                        'access' => ['Questionnaire', 'index'],
                    ],
                    [
                        'label' => 'Pelatihan',
                        'url'   => url_to('master-training.index'),
                        'active' => 'master-training.',
                    ],
                    [
                        'label' => 'Manajemen Pengguna',
                        'url'   => url_to('usersManager.index'),
                        'active' => 'usersManager.',
                        'access' => ['usersManager', 'index'],
                    ],
                ]
            ],
            [
                'label' => 'Assessment / Penilaian',
                'icon'  => 'ti tabler-clipboard-text',
                'url' => url_to('survey.index'),
                'active' => 'survey.',
            ],
            [
                'label' => 'Bantuan',
                'icon'  => 'ti tabler-question-circle',
                'url' => url_to('support'),
                'active' => 'support',
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
