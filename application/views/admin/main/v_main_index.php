<div id="pages_list">
    <div id="pages_header">
        <h1><?=$page_title?></h1>
    </div>
    <div>

<br /><br />
<table width="500" border="0" class="tbl"  cellspacing="0" style="margin: 0px auto;">
    <thead>
        <tr height="30">
            <th>Название</th><th>Кол.</th>
        </tr>
    </thead>
    <tr bgcolor="#e4ecfd">
        <td ><a href="/admin/catalog">Категорий товара: </a></td>
        <td align="center"><?=$catalog_num?></td>
    </tr>
    <tr bgcolor="#e4ecfd">
        <td >Товаров: </td>
        <td align="center"><?=$goods_num?></td>
    </tr>
    <tr bgcolor="#e4ecfd">
        <td ><a href="/admin/goodsfoto/">Товаров с фото </a></td>
        <td align="center"><?=$gofoto_num?></td>
    </tr>
    <tr bgcolor="#e4ecfd">
        <td ><a href="/admin/brends" >Брендов: </a></td>
        <td align="center"><?=$brends_num?></td>
    </tr>
    <tr bgcolor="#e4ecfd">
        <td ><a href="/admin/users">Зарегистрированных покупателей: </a></td>
        <td align="center"><?=$users_num?></td>
    </tr>
    <tr bgcolor="#e4ecfd">
        <td ><a href="/admin/orders/index/0">Новые заказы: </a></td>
        <td align="center"><?=$order_num?></td>
    </tr>
</table>

   
    </div>
    <div id="pages_footer">
    </div>
</div>
