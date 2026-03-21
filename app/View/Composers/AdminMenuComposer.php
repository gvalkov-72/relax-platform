<?php

namespace App\View\Composers;

use Illuminate\View\View;

class AdminMenuComposer
{
    public function compose(View $view)
    {
        $menu = [

            // SYSTEM
            [
                'text' => __('menu.dashboard'),
                'href' => route('admin.dashboard'),
                'icon' => 'fas fa-home',
                'class' => '',
                'active' => ['admin/dashboard'],
            ],
            [
                'text' => __('menu.users'),
                'href' => route('admin.users.index'),
                'icon' => 'fas fa-users',
                'can' => 'manage users',
                'active' => ['admin/users*'],
                'class' => '',
            ],
            [
                'text' => __('menu.roles'),
                'href' => route('admin.roles.index'),
                'icon' => 'fas fa-user-shield',
                'can' => 'manage roles',
                'active' => ['admin/roles*'],
                'class' => '',
            ],
            [
                'text' => __('menu.permissions'),
                'href' => route('admin.permissions.index'),
                'icon' => 'fas fa-key',
                'can' => 'manage permissions',
                'active' => ['admin/permissions*'],
                'class' => '',
            ],

            // CONTENT
            [
                'header' => __('menu.content_header')
            ],

            [
                'text' => __('menu.languages'),
                'href' => route('admin.languages.index'),
                'icon' => 'fas fa-language',
                'can' => 'manage languages',
                'active' => ['admin/languages*'],
                'class' => '',
            ],
            [
                'text' => __('menu.pages'),
                'href' => route('admin.pages.index'),
                'icon' => 'fas fa-file-alt',
                'can' => 'manage pages',
                'active' => ['admin/pages*'],
                'class' => '',
            ],
            [
                'text' => __('menu.sections'),
                'href' => route('admin.sections.index'),
                'icon' => 'fas fa-layer-group',
                'can' => 'manage sections',
                'active' => ['admin/sections*'],
                'class' => '',
            ],
            [
                'text' => __('menu.meditations'),
                'icon' => 'fas fa-brain',
                'can' => 'manage meditations',
                'class' => '',
                'submenu_class' => '',
                'submenu' => [
                    [
                        'text' => __('menu.all_meditations'),
                        'href' => route('admin.meditations.index'),
                        'icon' => 'fas fa-list',
                        'active' => ['admin/meditations*'],
                        'class' => '',
                    ],
                ],
            ],
            [
                'text' => __('menu.audio_files'),
                'href' => route('admin.audio.index'),
                'icon' => 'fas fa-music',
                'can' => 'manage audio',
                'active' => ['admin/audio*'],
                'class' => '',
            ],
            [
                'text' => __('menu.brainwave_presets'),
                'href' => route('admin.brainwaves.index'),
                'icon' => 'fas fa-wave-square',
                'can' => 'manage brainwaves',
                'active' => ['admin/brainwaves*'],
                'class' => '',
            ],
            [
                'text' => __('menu.ideas_and_documents'),
                'href' => route('admin.contents.index'),
                'icon' => 'fas fa-folder-open',
                'can' => 'manage contents',
                'active' => ['admin/contents*'],
                'class' => '',
            ],
            [
                'text' => __('menu.tags'),
                'href' => route('admin.tags.index'),
                'icon' => 'fas fa-tags',
                'can' => 'manage tags',
                'active' => ['admin/tags*'],
                'class' => '',
            ],
            [
                'text' => __('menu.ai_assistant'),
                'href' => route('admin.ai.assistant'),
                'icon' => 'fas fa-robot',
                'can' => 'manage ai',
                'active' => ['admin/ai-assistant*'],
                'class' => '',
            ],
        ];

        $view->with('adminlteMenu', $menu);
    }
}