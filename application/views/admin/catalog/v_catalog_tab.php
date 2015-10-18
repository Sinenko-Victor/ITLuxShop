<div id="pages_list">
    <div id="pages_header">
        <h1><? print$page_title; ?></h1>
    </div>
    <div id="pages_dir">
        <?php $catalog_tree->show(); ?>        
    </div>
    <div id="pages_edit">
        <?php echo$catalog_line; ?>
        <?php echo$editlist; ?>
    </div>
    <div id="pages_footer">
    </div>
</div>

