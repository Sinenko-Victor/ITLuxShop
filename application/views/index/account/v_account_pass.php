<div id="pages_dir">
    <?php echo$menuaccaunt; ?>   
</div>
    <div id="pages_edit">
        <div id='formmain'>
    
        
<h1>Изменить пароль</h1>
<br/>
<?=Form::open('account/pass')?>
<span class="error"><?=$passok?></span>
<div id='form_in'>
    <p>
        <?=Form::label('password', 'Новый пароль')?>:<br/>
        <?=Form::password('password', '', array('size' => 30, 'placeholder' => 'Введите пароль', 'required'))?>
        <span class="error"><?php echo Arr::path($errors, '_external.password') ?></span>        
    </p>
    <p>
        <?=Form::label('password_confirm', 'Повторите новый пароль')?>:<br/>
        <?=Form::password('password_confirm', '', array('size' => 30, 'placeholder' => 'Введите пароль', 'required'))?>
        <span class="error"><?php echo Arr::path($errors, '_external.password_confirm') ?></span>
    </p> 
</div>
<br/>
<?=Form::submit('submit', ' Сохранить ', array('class' => 'form_in_submit'))?>
<?=Form::close()?>

              
    
        </div>
    </div>
<div id="pages_footer">
</div>