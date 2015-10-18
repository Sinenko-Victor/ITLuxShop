<div id="pages_list">
    <div id="pages_header">
        <h1><? print$page_title; ?></h1>
    </div>
    <div id="pages_dir">
        <div id="tabmenu">
        <table width="230">
            <tr bgcolor="#cccccc" align="center">
                <td width="30" height="20">
                    ID
                </td>
                <td width="200" align="center">
                    Название
                </td>
            </tr>
            <tr>
                <td height="20">
                </td>
                <td>
                    &nbsp; <a href="/admin/brends/new/">[Создать]</a>
                </td>
            </tr>
             <?php foreach ($brends as $key => $brend): ?>
            <tr bgcolor="#99CCFF" onmouseover=this.style.backgroundColor="#3399FF" onmouseout=this.style.backgroundColor="#99CCFF">
                <td height="20">
                    &nbsp;<? print$key; ?>
                </td>
                <td>
                    &nbsp; <a href="/admin/brends/edit/<? print$key; ?>"><? print$brend; ?></a>
                </td>
            </tr>
            <?php endforeach ?> 
        </table>
    </div>     
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
                     <?=Form::open('/admin/brends/new/')?>
                    <?=Form::label('name', 'Название')?>:
                    <?=Form::input('br_name', '', array('size' => 17, 'style' => 'font-size: 14px;'))?>
                    <?=Form::submit('submit', ' Сохранить ')?>
                     <?=Form::close()?>   
                </td>
            </tr>
        </table>
        
    </div>
    <div id="pages_footer">
    </div>
</div>