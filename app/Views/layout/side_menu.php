<?php

use Config\Menu;
use Config\Services;

$routeOptions = Services::router()->getMatchedRouteOptions();
$currentRoute = $routeOptions['as'] ?? null;

$menus = Menu::getSidebar();
?>

<style>
  .menu-vertical .menu-item .menu-link > div:not(.badge) {
    white-space: normal;
  }
</style>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->

      <aside id="layout-menu" class="layout-menu menu-vertical menu">
        <div class="app-brand demo">
          <a href="<?= base_url() ?>" class="app-brand-link">
            <span class="app-brand-logo demo">
              <span class="text-primary">
                <img src="<?= base_url('assets/img/front-pages/landing-page/logo_provinsi_jatim.png') ?>" height="40">
              </span>
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-3">Murnajati</span>
          </a>

          <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="icon-base ti menu-toggle-icon d-none d-xl-block"></i>
            <i class="icon-base ti tabler-x d-block d-xl-none"></i>
          </a>
        </div>

        <div class="menu-inner-shadow"></div>

        <ul class="menu-inner py-1">
          <?php foreach ($menus as $menu): ?>
            <?php
            $hasChildren = isset($menu['children']);
            $isParentActive = (strpos($currentRoute, $menu['active']) === 0);
            // Check if any child is active
            if ($hasChildren) {
              foreach ($menu['children'] as $child) {
                if ((strpos($currentRoute, $child['active']) === 0)) {
                  $isParentActive = true;
                  break;
                }
              }
            }
            // Set classname
            $parentClasses = 'menu-item';
            if ($isParentActive) $parentClasses .= ' active open';
            if ($hasChildren) $parentClasses .= ' has-sub';
            ?>

            <li class="<?= $parentClasses ?>">
              <a href="<?= $menu['url'] ?? 'javascript:void(0);' ?>" class="menu-link <?= $hasChildren ? 'menu-toggle' : '' ?>">
                <i class="menu-icon icon-base <?= esc($menu['icon']) ?>"></i>
                <div data-i18n="<?= esc($menu['label']) ?>"><?= esc($menu['label']) ?></div>
              </a>
              <?php if ($hasChildren): ?>
                <ul class="menu-sub">
                  <?php foreach ($menu['children'] as $child): ?>
                    <li class="menu-item <?= (strpos($currentRoute, $child['active']) === 0) ? 'active' : '' ?>">
                      <a href="<?= esc($child['url']) ?>" class="menu-link">
                        <div data-i18n="<?= esc($child['label']) ?>"><?= esc($child['label']) ?></div>
                      </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </aside>

      <div class="menu-mobile-toggler d-xl-none rounded-1">
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
          <i class="ti tabler-menu icon-base"></i>
          <i class="ti tabler-chevron-right icon-base"></i>
        </a>
      </div>
      <!-- / Menu -->