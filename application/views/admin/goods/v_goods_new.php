<div id="pages_list">
    <div id="pages_header">
        <h1><? print$page_title; ?></h1>
    </div>
    <div id="pages_dir">
        <?php $catalog_tree->show(); ?>        
    </div>
    <div id="pages_edit">
        <?php echo$catalog_line; ?>
        
        <?if($errors):?>
        <?foreach ($errors as $error):?>
        <div class="error"><?=$error?></div>
        <?endforeach?>
        <?endif?>
        
        <table width="100%" cellspacing="5">
            <?=Form::open('/admin/goods/new/'.$id)?>
            <tr>
                <td height="35">
                    <select name="ca_id" style="font-size: 14px;"><option value="0">Корень</option><?php echo$catalog_option?></select>
                    <?=Form::input('go_name', '', array('size' => 50, 'style' => 'font-size: 14px;'))?>
                    <?=Form::submit('submit', ' Создать ')?>                      
                </td>
            </tr>
            <tr>
                <td height="35">
                    <?php echo Form::select('br_id', $sel_brend, $sel_br, array('style' => 'font-size: 14px;')); ?>
                    <?=Form::label('name', 'Бренд')?>  
                </td>
            </tr>
            <tr>
                <td >
                    <?=Form::input('go_cost', '', array('size' => 10, 'style' => 'font-size: 14px;'))?>
                    Цена, грн.  
                </td>
            </tr>
            <?=Form::close()?> 
        </table>
        
        
        
        
        
        
    </div>
    <div id="pages_footer">
    </div>
</div>