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
        <td width="50" align="center" bgcolor="#FFFFFF">
            Главное      
        </td>
        <th width="600">
            Дополнительные фото  (++ фото и превью)   
        </th>
        <th width="100">
              Фото в 1С 
        </th>                              
    </tr>
    
    <?php foreach ($goods as $good):?>
   
    <tr bgcolor="#E0EFDF" onmouseover=this.style.backgroundColor="#C3E0C2" onmouseout=this.style.backgroundColor="#E0EFDF" >
        <td width="80" align="center">
            <a href="/admin/goods/index/<?php echo$good->go_id; ?>" title="<?php echo$good->go_name; ?> | Цена: <?php echo$good->go_cost; ?> грн. ">
            <?php echo$good->go_id; ?></a>      
        </td>
        <td height="25" align="center" bgcolor="#FFFFFF">
            <a href="/media/foto/goods/<?php echo$good; ?>/<?php echo$mainfoto[$good->go_id]; ?>.jpg"><?php echo$mainfoto[$good->go_id]; ?> </a>     
        </td>
        <td> 
            <?php echo$additfoto[$good->go_id]; ?>      
        </td>
        <td> 
            <?php echo$foto_in[$good->go_id]; ?>      
        </td>                               
    </tr>
    
    <?php endforeach?>
    </table>
    
    
    
    
           
    </div>
    <div id="pages_footer">
    </div>
</div>