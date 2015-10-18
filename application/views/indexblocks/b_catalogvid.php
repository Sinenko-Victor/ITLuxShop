<?php //echo$id_ca; ?>

<?php
foreach ($catalogs as $key => $catalog):
?>
    
    <div class="catalog_plitka">
    <div class="catalog_plitka_decor">
    
        <a href="/ca/<?php echo$catalog->ca_id; ?>/<?php echo$catalog->ca_name; ?>">
        <div class="catalog_img">
            <?php echo$foto[$catalog->ca_id]; ?>
        </div>
        <div class="catalog_name">
            <?php echo$catalog->ca_name; ?>
        </div>
        </a>
        <?php echo$sab_catalogs[$catalog->ca_id] ?>

    </div>
    </div>

<?php endforeach?>