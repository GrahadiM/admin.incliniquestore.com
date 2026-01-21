<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MenuPortal extends Component
{
    public $menus;

    public function __construct($menus = null)
    {
        $this->menus = $menus ?? [
            ['title' => 'Users', 'icon' => 'fa-users', 'color' => 'blue', 'route' => 'super-admin.users.index'],
            ['title' => 'Branches', 'icon' => 'fa-store', 'color' => 'blue', 'route' => 'super-admin.branches.index'],
            ['title' => 'Levels', 'icon' => 'fa-layer-group', 'color' => 'blue', 'route' => 'super-admin.member-levels.index'],
            ['title' => 'Vouchers', 'icon' => 'fa-ticket-alt', 'color' => 'blue', 'route' => 'super-admin.vouchers.index'],
            ['title' => 'Categories', 'icon' => 'fa-tags', 'color' => 'blue', 'route' => 'super-admin.categories.index'],
            ['title' => 'Products', 'icon' => 'fa-box', 'color' => 'blue', 'route' => 'super-admin.products.index'],
            ['title' => 'News', 'icon' => 'fa-newspaper', 'color' => 'blue', 'route' => 'super-admin.news.index'],
        ];
    }

    public function render()
    {
        return view('components.menu-portal');
    }
}
