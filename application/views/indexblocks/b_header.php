<div id='headermenu'>        
    <nav>
	<ul>
        <li id='signup'>
            <a href='/'>Каталог товаров</a>
        </li>
    
        <?php foreach ($topmenu as $menu): ?>
        <li id='signup'>
            <a href='/page/<?php echo$menu->pg_id; ?>/<?php echo$menu->pg_alias; ?>'><?php echo$menu->pg_name; ?></a>
        </li>
        <?php endforeach?>
        
        <?php
        if(Auth::instance()->logged_in() and $user=='admin'):
        ?>
        <li id='signupbu'>
        <a href='/logout'>Выход</a>
        </li>
        <li id='login'>
            <a id='login-trigger' href='#'> Панель управления <span> &#x25BC;</span></a>
                <div id='login-content'>
                    <span class='usset'><a href='/admin/'>Главная</a></span><br />
                    <span class='usset'><a href='/admin/catalog'>Ксталог товаров</a></span><br />
                    <span class='usset'><a href='/admin/orders'>Заказы</a></span><br />
                    <span class='usset'><a href='/admin/pages'>Страници</a></span><br />
                    <span class='usset'><a href='/admin/users'>Покупатели</a></span><br />
                    <span class='usset'><a href='/admin/setings'>Настройки</a></span><br />
                </form>
                </div>
        </li>
        <?php 
        elseif(Auth::instance()->logged_in()):
        ?>
        <li id='signupbu'>
        <a href='/logout'>Выход</a>
        </li>
        <li id='login'>
            <a id='login-trigger' href='#'><?php echo$user; ?> <span>&#x25BC;</span></a>
                <div id='login-content'>
                    <span class='usset'><a href='/account/orders'>Заказы</a></span><br />
                    <span class='usset'><a href='/account/profile'>Мои данные</a></span><br />
                </form>
                </div>
        </li>
        <?php 
        else:
        ?>
        <li id='login'>
            <a id='login-trigger' href='#'>Войти <span>&#x25BC;</span></a>
            <div id='login-content'>
            <?=Form::open('login')?>
                <fieldset id='inputs'>
                    Логин<input id='username' name='username' placeholder='Ваш логин' required />   
                    Пароль<input id='password' type='password' name='password' placeholder='Пароль' required />
                </fieldset>
                <fieldset id='actions'>
                    <?=Form::submit('submit', ' Войти ', array('id' => 'submit'))?>
                    <span class='reg'><a href='/register'>Регистрация</a></span><br />
                    <span class='reg'><a href='/auth/repass'>Востановить пароль</a></span><br />
                    <?=Form::checkbox('remember', 1, TRUE)?>
                    <span class='reg'><?=Form::label('remember', 'Запомнить')?></span>
                </fieldset>
             <?=Form::close()?>
            </div>                     
        </li>
        <?php   
        endif
        ?>        
	   </ul>
    </nav>
</div>
 

<div id='header'>

<div id='logobox'>
    <div id='logo'>
        <a href="/" title="Главная страница">

        </a>
    </div>
    <div id='slogan'><?php echo$slogan; ?></div>
    <div id='telefon'><?php echo$tel; ?></div>

            <div id='cart_res'>            
                <div id='cart_top'>
                    <?php echo$products_cost; ?>
                </div>    
                    <?php echo$open_cart; ?></a>
                <div id='del_tov'>
                    <a href="/vcart/0/0/clear/" title="Очистить корзину" onClick="return window.confirm('Очистить корзину?');">
                    <?php echo$del_tov; ?></a>
                </div>
                <?php echo$run_oder; ?></a>
            </div>

    <form class="searchform" action="/search" method="post" action="javascript:insertTask();" accept-charset="utf-8">
        <input name="searchfield" id="searchq" type="text" class="searchfield" size="30" onkeyup="javascript:searchNameq()"  placeholder="Поиск..." />
        <input type="submit" id="submitSearch" class="searchbutton" value="Найти" onclick="javascript:searchNameq()" />
    </form>
    <div id='search'>
        <div id="search-result"></div> 
    </div>

</div>

</div>
    

 