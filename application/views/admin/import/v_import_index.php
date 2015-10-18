<div id="pages_list">
    <div id="pages_header">
        <h1><? print$page_title; ?></h1>
    </div>
    
    
<br/><br/><br/>
<?if($errors):?>
<?foreach ($errors as $error):?>
<div class="error"><?=$error?></div>
<?endforeach?>
<?endif?>
<?php 
echo Form::open('admin/import', array('name' => 'folder', 'method' => 'post', 'enctype' => 'multipart/form-data')); 
echo Form::file('userfile');
echo Form::submit('submit', 'Отправить');
echo Form::close();
?>
</br>
<table width="500" cellpadding="0" cellspacing="0" border="0" style="margin: 0px auto;">
    <tr bgcolor="#9DB4C3">	
        <th width="30" height="25" align="center" >
		  №
        </th>
        <th align="center" >
            Имя файла
        </th>
        <th width="80" align="center" >
        Размер
        </th>
        <th width="30" align="center" >
        </th>
        <th width="30" align="center" >
        </th>
        <th width="30" >
        </th>
    </tr>
    
<?if($num_file):?>
<?foreach ($num_file as $num):?>
<?php
echo"
    <tr ><td align='left'>".$num."</td>
        <td align='left'>".$filedats[$num]['name'].".xlsx</td>
        <td align='left'>".$filedats[$num]['size']."</td>
        <td>
            <a href='/admin/import/run/".$filedats[$num]['name']."' title='Импортировать из файла в базу даных'>
            <img border='0' src='/media_admin/img/db_comit_.png'></a>
        </td>
        <td align='center'>
            <a href='/media_admin/import/".$filedats[$num]['name'].".xlsx' title='Скачать файл'>
            <img border='0' src='/media_admin/img/download_manager.png'></a>
        </td>
        <td align='center'>
            <a href='/admin/import/del/".$filedats[$num]['name']."' title='Удалить файл' style='text-decoration: none'  ";?>onClick="return window.confirm('Удалить файл?');"><?php echo"
            <img border='0' src='/media_admin/img/delete.gif' width='14' height='14'></a>
        </td>
</tr>
";

?>
<?endforeach?>
<?endif?>    
        			  						
</table>

    
    
    
    <div id="pages_footer">
    </div>
</div>