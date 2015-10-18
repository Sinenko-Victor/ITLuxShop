<div id='formmain'>
<h1>Востановление пароля</h1>
<br/>
<?=Form::open('/auth/repass')?>
<div id='form_in'>
    <p>
        <? if (isset($message)) echo '<span>'.$message."</span><hr />"; ?>
    </p>
    <p>
        <br />
        <?=Form::label('email', 'E-mail')?>:<br/>
        <?=Form::input('email', '', array('size' => 30, 'placeholder' => 'Введите E-mail', 'type' => 'email', 'required'))?>  
    </p>
</div>
<br/>
<p>
    <span class="link_4"><?=Html::anchor('register', ' Регистрация ')?> </span>
    <?=Form::submit('submit', ' Востановить пароль ', array('class' => 'form_in_submit'))?>
</p>
<?=Form::close()?>
</div>