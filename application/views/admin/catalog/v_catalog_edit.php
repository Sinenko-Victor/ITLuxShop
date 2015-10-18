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
           
       
        <table width="100%" cellspacing="5">
            <tr>
                <td >
                     <?=Form::open($link.$id)?>
                    <?=Form::label('name', 'Название')?>:
                    <select name="ca_father" style="font-size: 14px;"><option value="0">Корень</option><?php echo$catalog_option?></select> /
                    <?=Form::input('ca_name', $catalog['ca_name'], array('size' => 30, 'style' => 'font-size: 14px;'))?>
                    <?=Form::submit('submit', ' Сохранить ')?>
                    <a href='/admin/catalog/delete/<?=$id?>' title='Удалить группу' onClick="return window.confirm('При нажатии &quot;ОК&quot; будут удалена эта группа и все ее подчиненые страници. Удалить?');">
                    <img border='0' src='/media_admin/img/delete-16.png' align='absmiddle'></a>
                     <?=Form::close()?>   
                </td>
            </tr>
            <tr>
                <td>
                    <br />
                    <?php 
                    echo Form::open('/admin/catalog/addfoto/'.$id, array('name' => 'foto', 'method' => 'post', 'enctype' => 'multipart/form-data')); 
                    echo Form::file('userfile');
                    echo Form::submit('submit', ' Загрузить фото ');
                    echo Form::close();
                    ?>
                    <br />
                    <?php echo$foto?>
                    <?php echo$deletefoto?>  
                </td>
            </tr>
        </table>
       
        
        
        
        
        
               
    </div>
    <div id="pages_footer">
    </div>
</div>