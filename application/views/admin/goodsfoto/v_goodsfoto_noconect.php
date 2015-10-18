<div id="pages_list">
    <div id="pages_header">
        <h1><?=$page_title?></h1>
    </div>
    <div id="pages_dir">
        <?=$menuset?>       
    </div>
    <div id="pages_edit">
    
                               
    <table width="830" border="0" class="tbl"  cellspacing="0">    
    <tr>
        <th width="80" height="25" align="center">
            Код      
        </th>
        <td width="40" align="center" bgcolor="#FFFFFF">
            Главное      
        </th>
        <th width="600">
            Дополнительные фото     
        </th>
        <th width="100">
            <a href="/admin/goodsfoto/deletefotos/" title ="Удалить все папки с фото" title='Удалить' onClick="return window.confirm('При нажатии &quot;ОК&quot; Все фото для которых нет товаров в базе будут удалены! Удалить?');">
            <img border="0" src="/media_admin/img/delete-16.png" align="absmiddle" />
            удалить все
            </a>   
        </th>                              
    </tr>
    <?php foreach ($goods as $good):?>
    <tr bgcolor="#E0EFDF" onmouseover=this.style.backgroundColor="#C3E0C2" onmouseout=this.style.backgroundColor="#E0EFDF" >
        <td height="25" align="center">
            <?php echo$good; ?>      
        </td>
        <td align="center" bgcolor="#FFFFFF">
            <?php echo$mainfoto[$good]; ?>      
        </td>
        <td>
            <?php echo$otherfoto[$good]; ?>      
        </td>
        <td>
            <?php echo$inbase[$good]; ?>     
        </td>                              
    </tr>
    <?php endforeach?>
    </table>

           
    </div>
    <div id="pages_footer">
    </div>
</div>