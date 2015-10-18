<div id="pages_list">
    <div id="pages_header">
        <h1><? print$page_title; ?></h1>
    </div>
    <div id="pages_dir">
        <?php $catalog_tree->show(); ?>        
    </div>
    <div id="pages_edit">
        
        <br />
        <?if($errors):?>
        <?foreach ($errors as $error):?>
        <div class="error"><?=$error?></div>
        <?endforeach?>
        <?endif?>
               
        <?=Form::open('/admin/catalog/new')?>
        <table width="100%" cellspacing="5">
            <tr>
                <td >
                    <?=Form::label('name', 'Название')?>:
                    <select name="ca_father" style="font-size: 14px;"><option value="0">Корень</option><? echo$catalog_option?></select> /
                    <?=Form::input('ca_name', $catalog['ca_name'], array('size' => 30, 'style' => 'font-size: 14px;'))?>
                    <?=Form::submit('submit', ' Создать ')?>
                </td>
            </tr>
        </table>
        <?=Form::close()?>               
    </div>
    <div id="pages_footer">
    </div>
</div>