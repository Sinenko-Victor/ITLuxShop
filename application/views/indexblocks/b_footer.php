<span class='link_2'><a href='/'>Каталог товаров</a><span>
<?php foreach ($topmenu as $menu): ?>
 | <span class='link_2'><a href='/page/<?php echo$menu->pg_id; ?>/<?php echo$menu->pg_alias; ?>'><?php echo$menu->pg_name; ?></a>
<?php endforeach?>
