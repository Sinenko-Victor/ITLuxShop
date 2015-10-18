<div id='formmain'>
<h1>Регистрация</h1>
<br/>
<?=Form::open('register')?>
<div id='form_in'>
    <p>
        <br />
        <?=Form::label('username', 'Логин')?>:<br/>
        <?=Form::input('username', $data['username'], array('size' => 30, 'placeholder' => 'Введите логин', 'required'))?>
        <span class="error"><?php echo Arr::get($errors, 'username') ?></span>   
    </p>
    <p>
        <?=Form::label('first_name', 'ФИО')?>:<br/>
        <?=Form::input('first_name', $data['first_name'], array('size' => 30, 'placeholder' => 'Введите Ваше Имя', 'required'))?>
        <span class="error"><?php echo Arr::get($errors, 'first_name') ?></span>
    </p>
    <p>
        <?=Form::label('tel', 'Телефон')?>:<br/>
        <?=Form::input('tel', $data['tel'], array('size' => 16, 'placeholder' => 'Введите телефон', 'required'))?>
        <span class="error"><?php echo Arr::get($errors, 'tel') ?></span>
    </p>
    <p>
        <?=Form::label('email', 'E-mail')?>:<br/>
        <?=Form::input('email', $data['email'], array('size' => 30, 'placeholder' => 'Введите Ваше E-mail', 'required'))?>
        <span class="error"><?php echo Arr::get($errors, 'email') ?></span>
    </p>
    <p>
        <?=Form::label('password', 'Пароль')?>:<br/>
        <?=Form::password('password', $data['password'], array('size' => 30, 'placeholder' => 'Введите пароль', 'required'))?>
        <span class="error"><?php echo Arr::path($errors, '_external.password') ?></span>
    </p>
    <p>
        <?=Form::label('password_confirm', 'Повторить пароль')?>:<br/>
        <?=Form::password('password_confirm', $data['password_confirm'], array('size' => 30, 'placeholder' => 'Повторитье пароль', 'required'))?>
        <span class="error"><?php echo Arr::path($errors, '_external.password_confirm') ?></span>
    </p> 
</div>
<br/>
<?=Form::submit('submit', ' Зарегистрироваться ', array('class' => 'form_in_submit'))?>
<?=Form::close()?>
</div>