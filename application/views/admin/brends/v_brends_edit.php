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
        
        <table width="100%" cellspacing="5">
            <tr>
                <td >
                     <?=Form::open('/admin/brends/edit/'.$br->br_id)?>
                    <?=Form::label('name', 'Название')?>:
                    <?=Form::input('br_name', $br->br_name, array('size' => 17, 'style' => 'font-size: 14px;'))?>
                    <?=Form::submit('submit', ' Сохранить ')?>
                    <a href='/admin/brends/delete/<?=$br->br_id?>' title='Удалить бренд' onClick="return window.confirm('При нажатии &quot;ОК&quot; бренд будут удален! Удалить?');">
                    <img border='0' src='/media_admin/img/delete-16.png' align='absmiddle'></a>
                     <?=Form::close()?>   
                </td>
            </tr>
            <tr>
                <td>
                    <br />
                    <?php 
                    echo Form::open('/admin/brends/addfoto/'.$br->br_id, array('name' => 'foto', 'method' => 'post', 'enctype' => 'multipart/form-data')); 
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