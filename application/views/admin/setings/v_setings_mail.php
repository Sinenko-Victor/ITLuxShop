<div id="pages_list">
    <div id="pages_header">
        <h1><?=$page_title?></h1>
    </div>
    <div id="pages_dir">
        <?=$menuset?>       
    </div>
    <div id="pages_edit">
        
<br/>
<?=Form::open('/admin/setings/mail')?>
<div id='form_in'>
    <p>
        <br/>
        <?=Form::label('email', $set_name[6])?>:
        <span class="error"><?php echo Arr::get($errors, 'email') ?></span><br/>
        <?=Form::input('email', $set_data[6], array('size' => 100, 'placeholder' => 'Введите название магазина', 'required'))?>                
    </p>
    <!--
    <p>
        <br/>
        <?=Form::label('nameout', $set_name[7])?>:
        <span class="error"><?php echo Arr::get($errors, 'nameout') ?></span><br/>
        <?=Form::input('nameout', $set_data[7], array('size' => 100, 'placeholder' => 'Введите название магазина', 'required'))?>                
    </p>
    <p>
        <br/>
        <?=Form::label('pass', $set_name[8])?>:
        <span class="error"><?php echo Arr::get($errors, 'pass') ?></span><br/>
        <?=Form::input('pass', $set_data[8], array('size' => 100, 'placeholder' => 'Введите название магазина', 'required'))?>                
    </p>
    <p>
        <br/>
        <?=Form::label('smtp', $set_name[9])?>:
        <span class="error"><?php echo Arr::get($errors, 'smtp') ?></span><br/>
        <?=Form::input('smtp', $set_data[9], array('size' => 100, 'placeholder' => 'Введите название магазина', 'required'))?>                
    </p>
    <p>
        <br/>
        <?=Form::label('port', $set_name[10])?>:
        <span class="error"><?php echo Arr::get($errors, 'port') ?></span><br/>
        <?=Form::input('port', $set_data[10], array('size' => 10, 'placeholder' => 'Введите название магазина', 'required'))?>                
    </p>
    --!>
    
</div>
<br/>
<?=Form::submit('submit', ' Сохранить ', array('class' => 'form_in_submit'))?>
<span class="error"><?php echo $profok; ?></span>
<?=Form::close()?>        
        
    </div>
    <div id="pages_footer">
    </div>
</div>