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
            <?=Form::open('/admin/goods/index/'.$id)?>
            <tr>
                <td height="35">
                    <select name="ca_id" style="font-size: 14px;"><option value="0">Корень</option><?php echo$catalog_option?></select>
                    <?=Form::input('go_name', $good->go_name, array('size' => 50, 'style' => 'font-size: 14px;'))?>
                    <?=Form::submit('submit', ' Сохранить ')?>
                    <a href="<?php echo$linkok; ?>" title="<?php echo$titleok; ?>"><img src="<?php echo$imgok; ?>" align="absmiddle" /></a>
                    <a href='/admin/goods/delete/<?=$id?>' title='Удалить товар' onClick="return window.confirm('При нажатии &quot;ОК&quot; товар будут удалена! Удалить?');">
                    <img border='0' src='/media_admin/img/delete-16.png' align='absmiddle' /></a>                      
                </td>
            </tr>
            <tr>
                <td height="35">
                    <?php echo Form::select('br_id', $sel_brend, $sel_br, array('style' => 'font-size: 14px;')); ?>
                    <?=Form::label('brend', 'Бренд')?>  
                </td>
            </tr>
            <tr>
                <td >
                    <?=Form::input('go_cost', $good->go_cost, array('size' => 10, 'style' => 'font-size: 14px;'))?>
                    Цена, грн.  
                </td>
            </tr>
            <tr>
                <td>
                    <br/>                    
                    <textarea class="ckeditor" cols="80"  name="go_text" rows="10"> <?=$good->go_text?></textarea>
                </td>
            </tr>
            <?=Form::close()?> 
            <tr>
                <td>
                    <br />
                    <?php 
                    echo Form::open('/admin/goods/addfoto/'.$id, array('name' => 'foto', 'method' => 'post', 'enctype' => 'multipart/form-data')); 
                    echo Form::file('userfile');
                    echo Form::submit('submit', ' Загрузить фото ');
                    echo Form::close();
                    ?>
                    <?php echo$mainfoto?>
                    <br />
                    <?php echo$foto?>
                </td>  
                </td>
            </tr>
        </table>
        
        
        
        
        
        
    </div>
    <div id="pages_footer">
    </div>
</div>