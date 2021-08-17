<aside class="main-sidebar">

    <section class="sidebar">

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Магазины', 'icon' => 'file-code-o', 'url' => ['/store']],
                    ['label' => 'Ссылки', 'icon' => 'dashboard', 'url' => ['/link']],
                    ['label' => 'Выгрузка', 'icon' => 'download', 'url' => ['/']],
                ],
            ]
        ) ?>

    </section>

</aside>
