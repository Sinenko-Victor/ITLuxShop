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
        <div id="brend_list">
            <?php
            foreach ($brends as $key => $brend):
            ?>
                <div id="brend">
                    <span class="link_1"><a href="/admin/brends/edit/<?php echo$key; ?>" title="Товары '<?php echo$brend; ?>'">
                    <div id="br_img">
                        <img src="/imgbrend/<?php echo$key; ?>/110/110" />    
                    </div>
                    <div id="br_name">
                        <?php echo$brend; ?>
                    </div>
                    </a></span>
                </div>
            <?php 
            endforeach?>
                <div id="brend_new">
                    <span class="link_1"><a href="/admin/brends/new/" title="Создать новый бренд">
                    <div id="br_img">
                        <img src="/media/img/filder.png" width='110' height='110'/>    
                    </div>
                    <div id="br_name">
                        [Создать]
                    </div>
                    </a></span>
                </div>
            <div id="floatend">
            </div> 
        </div>
        
    </div>
    <div id="pages_footer">
    </div>
</div>