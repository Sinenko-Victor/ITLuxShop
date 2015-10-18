<div id="cmsmenu">	
		<ul id="coolMenu">
            <li><a href="/admin">Главная</a></li>		
			<li><a href="/admin/catalog">Ксталог</a>
                <ul class="noJS" id="navmenu-v">
                    <li><a href="/admin/goodsfoto/">Фото товаров</a></li>
				</ul>
            </li>
            <li><a href="/admin/brends">Бренды</a></li>
            <li><a href="/admin/import">Импорт</a></li>
            <li><a href="/admin/orders" title="Все заказы">Заказы</a>
                <ul class="noJS" id="navmenu-v">
                    <?php
                    foreach ($orstat as $key => $stat)
                    {
                        echo'<li><a href="/admin/orders/index/'.$key.'">'.$stat.'</a></li>';
                    }
                    ?>                    
				</ul>
            </li>
            <li><a href="/admin/pages">Страници</a></li> 
            <li><a href="/admin/users">Покупатели</a></li>
            <li><a href="/admin/setings">Настройки</a></li>
            <li><a href="/">Магазин</a></li>
            <li><a href="/logout">Выход</a></li> 
		</ul>
</div>