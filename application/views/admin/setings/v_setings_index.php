<div id="pages_list">
    <div id="pages_header">
        <h1><?=$page_title?></h1>
    </div>
    <div id="pages_dir">
        <?=$menuset?>       
    </div>
    <div id="pages_edit">
        
<br/>
<?=Form::open('/admin/setings/index')?>
<div id='form_in'>
    <p>
        <br/>
        <?=Form::label('name', $set_name[1])?>:
        <span class="error"><?php echo Arr::get($errors, 'name') ?></span><br/>
        <?=Form::input('name', $set_data[1], array('size' => 100, 'placeholder' => 'Введите название магазина', 'required'))?>                
    </p>
    <p>
        <?=Form::label('description', $set_name[2])?>:
        <span class="error"><?php echo Arr::get($errors, 'description') ?></span><br/>
        <?=Form::textarea('description', $set_data[2], array('size' => 200, 'rows' => '4', 'cols' => '95'))?>          
    </p>
    <p>
        <?=Form::label('keywords', $set_name[3])?>:
        <span class="error"><?php echo Arr::get($errors, 'keywords') ?></span><br/>
        <?=Form::textarea('keywords', $set_data[3], array('size' => 200, 'rows' => '4', 'cols' => '95'))?>          
    </p>
    <p>
        <?=Form::label('tel', $set_name[4])?>:
        <span class="error"><?php echo Arr::get($errors, 'tel') ?></span><br/>
        <?=Form::textarea('tel', $set_data[4], array('size' => 200, 'rows' => '4', 'cols' => '95'))?>          
    </p>
    <p>
        <?=Form::label('rab', $set_name[5])?>:
        <span class="error"><?php echo Arr::get($errors, 'rab') ?></span><br/>
        <?=Form::textarea('rab', $set_data[5], array('size' => 200, 'rows' => '3', 'cols' => '95'))?>          
    </p>
</div>
<br/>
<?=Form::submit('submit', ' Сохранить ', array('class' => 'form_in_submit'))?>
<?php echo $profok; ?></span>
<?=Form::close()?>        
        
    </div>
    <div id="pages_footer">
    </div>
</div>