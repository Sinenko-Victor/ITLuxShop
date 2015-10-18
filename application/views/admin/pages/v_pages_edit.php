<div id="pages_list">
    <div id="pages_header">
        <h1><? print$page_title; ?></h1>
    </div>
    <div id="pages_dir">
        <?php $page_tree->show(); ?>        
    </div>
    <div id="pages_edit">
        <?if($errors):?>
        <?foreach ($errors as $error):?>
        <div class="error"><?=$error?></div>
        <?endforeach?>
        <?endif?>
               
        <?=Form::open($link.$id)?>
        <table width="100%" cellspacing="5">
            <tr>
                <td >
                    <?=Form::label('name', 'Название')?>:
                    <select name="pg_father"><option value="0">Корень</option><?=$pages_option?></select> /
                    <?=Form::input('pg_name', $page['pg_name'], array('size' => 35))?>
                    <?=Form::submit('submit', ' Сохранить ')?>
                    <?php 
                    if(@$page['pg_d']!='0' and @$page['pg_name']!='' )
                    {
                        ?>
                        <a href='/admin/pages/delete/<?=$id?>' title='Удалить страницу' onClick="return window.confirm('При нажатии &quot;ОК&quot; товар будут удалена! Удалить?');">
                        <img border='0' src='/media_admin/img/delete-16.png' align='absmiddle' /></a>
                        <?php  
                    }
                    ?>
                    
                    <br/><br/>
                    
                    <?=Form::label('alias', 'Алиас')?>:
                    <?=Form::input('pg_alias', $page['pg_alias'], array('size' => 60))?>
                    <br/><br/>
                                        
                    <?=Form::label('title', 'Титле')?>:
                    <?=Form::input('pg_title', $page['pg_title'], array('size' => 60))?>
                                                       
                    <br/><br/>
                </td>
            </tr>
            <tr>
                <td>
                    <?=Form::label('text', 'Содержание')?>: <br/>                    
                    <textarea class="ckeditor" cols="80" name="pg_text" rows="10"> <?=$page['pg_text']?></textarea>
                </td>
            </tr>
            <?=Form::close()?>
            <tr>
                <td align="left">
                    <br />
                    <?php 
                    echo Form::open('/admin/pages/addfoto/'.$id, array('name' => 'foto', 'method' => 'post', 'enctype' => 'multipart/form-data')); 
                    echo Form::file('userfile');
                    echo Form::submit('submit', ' Загрузить фото ');
                    echo Form::close();
                    ?>
                    <br />
                    <?php echo$foto?>
                    
                </td>
            </tr>
        </table>
    </div>
    <div id="pages_footer">
    </div>


</div>