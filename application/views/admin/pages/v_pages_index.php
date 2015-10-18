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
                    
                    <br/><br/>
                    
                    <?=Form::label('alias', 'Алиас')?>:
                    <?=Form::input('pg_alias', $page['pg_alias'], array('size' => 60))?>
                    <br/><br/>
                                        
                    <?=Form::label('title', 'Титле')?>:
                    <?=Form::input('pg_title', $page['pg_title'], array('size' => 60))?>
                                                       
                    <br/><br/>
                </td>
            </tr>
        </table>
        <?=Form::close()?>
    </div>
    <div id="pages_footer">
    </div>


</div>