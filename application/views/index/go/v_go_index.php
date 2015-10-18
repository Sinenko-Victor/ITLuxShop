
    <div id="pages_dir">
        <?php $catalog_tree->show(); ?>      
    </div>
    <div id="pages_edit">
        <span class="cadirlink"><?php echo$ca_line; ?></span>
        <br /><br />
        



<div id="pad_go">
    <div id="go_name">
        <h1><?php echo$name; ?></h1>
    </div>
    <div id="main_foto">
        <?php echo$foto[$good->go_id]; ?>
    </div>
    <div id="right_info">
        
        <div id="floatend">
        </div>
        <div id="kod">
            <div class="go_kod">Код: <span><?php echo$good->go_id; ?></span></div>
        </div>
        <div id="brend">
            <div class="go_brend"><?php echo$brend; ?></div> 
        </div> 
        
        <div id="cost">
            <?php echo$cost; ?>
        </div>
        <div id="go_cart">
            <div id="cart">
                <input type="text" id="num" size="1"  value="1" /> шт. 
                <a data-id="<?php echo$good->go_id; ?>" title="Добавить в корзину">
                <img src="/media/img/cart-80.png" border="0"/></a>
            </div>
        </div>               
    </div> 
    <div id="go_info">
        <p><?php echo$text; ?></p>
    </div>
    <div id="fotos">      
        <?php echo$fotos; ?>
    </div>
</div>

<br /><br />
               
        <?php //echo$calist; ?>  
    </div>
    <div id="pages_footer">
    </div>