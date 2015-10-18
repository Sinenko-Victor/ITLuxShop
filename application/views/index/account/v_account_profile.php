<div id="pages_dir">
    <?php echo$menuaccaunt; ?>   
</div>
    <div id="pages_edit">
        <div id='formmain'>
    
        
<h1>Профиль</h1>
<br/>
<?=Form::open('account/profile')?>
<span class="error"><?=$profok?></span>
<div id='form_in'>
    <p>
        <br/>
        <?=Form::label('username', 'Логин')?>:<br/>
        <?=Form::input('username', $user->username, array('size' => 30, 'placeholder' => 'Введите Логин', 'required'))?>
        <span class="error"><?php echo Arr::get($errors, 'username') ?></span>        
    </p>
    <p>
        <?=Form::label('first_name', 'Имя и фамилия')?>:<br/>
        <?=Form::input('first_name', $user->first_name, array('size' => 30, 'placeholder' => 'Введите Ваше Имя', 'required'))?>            
        <span class="error"><?php echo Arr::get($errors, 'first_name') ?></span>
    </p>
    <p>
        <?=Form::label('tel', 'Телефон')?>:<br/>
        <?=Form::input('tel', $user->tel, array('size' => 30, 'placeholder' => 'Введите телефон'))?>  
        <span class="error"><?php echo Arr::get($errors, 'tel') ?></span>
    </p>
    <p>
        <?=Form::label('email', 'E-mail')?>:<br/>
        <?=Form::input('email', $user->email, array('size' => 30, 'placeholder' => 'Введите Ваше E-mail', 'required'))?>  
        <span class="error"><?php echo Arr::get($errors, 'email') ?></span>
    </p>
    <p>
        <?=Form::label('city', 'Город')?>:<br/>
        <?=Form::input('city', $user->city, array('size' => 30, 'placeholder' => 'Введите город'))?>  
        <span class="error"><?php echo Arr::get($errors, 'city') ?></span>
    </p>
    <p>
        <?=Form::label('street', 'Улица')?>:<br/>
        <?=Form::input('street', $user->street, array('size' => 30, 'placeholder' => 'Введите улицу'))?>  
        <span class="error"><?php echo Arr::get($errors, 'street') ?></span>
    </p>
    <p>
        <?=Form::label('building', 'Номер дом')?>:<br/>
        <?=Form::input('building', $user->building, array('size' => 30, 'placeholder' => 'Введите номер дома'))?>  
        <span class="error"><?php echo Arr::get($errors, 'building') ?></span>
    </p>
    <p>
        <?=Form::label('office', 'Номер квартиры/офиса')?>:<br/>
        <?=Form::input('office', $user->office, array('size' => 30, 'placeholder' => 'Введите номер квартиры'))?>  
        <span class="error"><?php echo Arr::get($errors, 'office') ?></span>
    </p>
    <p>
        <?=Form::label('data', 'Дополнительная информация')?>:<br/>
        <?=Form::textarea('data', $user->data, array('size' => 200, 'rows' => '5', 'cols' => '33'))?> 
        <span class="error"><?php echo Arr::get($errors, 'data') ?></span>
    </p>
</div>
<br/>
<?=Form::submit('submit', ' Сохранить ', array('class' => 'form_in_submit'))?>
<?=Form::close()?>
              
    
        </div>
    </div>
<div id="pages_footer">
</div>
