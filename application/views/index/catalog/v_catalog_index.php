    
    <div id="pages_dir">
        <?php $catalog_tree->show(); ?>     
    </div>
    <div id="pages_edit">
        
        <div id="ca_line">
            <span class="cadirlink"><?php echo$ca_line; ?></span>
        </div>
        <div id="sel_vid">
            <span class="cadirlink">
            <?=HTML::anchor('/ca_run/0/2/1', 'плитка')?> | <?=HTML::anchor('/ca_run/0/2/2', 'список')?>
            </span>
        </div>
        
        <div id="catalog_list">
            <?php echo$catalogvid; ?> 
        </div>
        <?php echo$cagoods; ?>
               
    </div>
    <div id="pages_footer">
    </div>