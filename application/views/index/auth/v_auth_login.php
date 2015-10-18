<div id='formmain'>
<h1>Вход</h1>
<br/>
<?=Form::open('login')?>
<div id='form_in'>
    <p>
        <br />
        <?=Form::label('username', 'Логин')?>:<br/>
        <?=Form::input('username', $data['username'], array('size' => 30, 'placeholder' => 'Введите логин', 'required'))?>
        
        <?if($errors):?>
        <?foreach ($errors as $error):?>
        <span class="error"><?=$error?>!</span>
        <?endforeach?>
        <?endif?>   
    </p>
    <p>
        <?=Form::label('password', 'Пароль')?>:<br/>
        <?=Form::password('password', $data['password'], array('size' => 30, 'placeholder' => 'Введите пароль', 'required'))?> 
    </p>
    <p>
        <?=Form::checkbox('remember', 1, TRUE)?>
        <?=Form::label('remember', 'Запомнить')?> 
    </p> 
    </p> 
</div>
<br/>
<p>
    
    <?=Form::submit('submit', ' Войти ', array('class' => 'form_in_submit'))?>
</p>
<?=Form::close()?>
</div>