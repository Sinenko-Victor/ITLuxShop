<div id="pages_list">
    <div id="pages_header">
        <h1><? print$page_title; ?></h1>
    </div>
    <div id="pages_dir">
        <?php $catalog_tree->show(); ?>        
    </div>
    <div id="pages_edit">            
        
        <div id="catalog_list">
            <?php
            foreach ($catalogs as $key => $catalog):
            ?>
                <div id="catalog">
                    <span class="link_1"><a href="/admin/catalog/tab/<?php echo$catalog->ca_id; ?>">
                    <div id="ca_img">
                        <?php echo$foto[$catalog->ca_id]; ?>   
                    </div>
                    <div id="ca_name">
                        <?php echo$catalog->ca_name; ?>
                    </div>
                    </a></span>
                </div>
            <?php 
            endforeach?>
                <div id="catalog_new">
                    <span class="link_1"><a href="/admin/catalog/new" title="Создать новую группу">
                    <div id="ca_img">
                        <img src="/media/img/filder.png" width='140' height='110'/>    
                    </div>
                    <div id="ca_name">
                        [Создать]
                    </div>
                    </a></span>
                </div>
            <div id="floatend">
            </div> 
        </div>   
        
    </div>
    <div id="pages_footer">
    </div>
</div>

