<div id='formmain'>
<h1>Оформить заказ</h1>
<?if($errors):?>
<?foreach ($errors as $error):?>
<span class="error"><?=$error?>!</span><br />
<?endforeach?>
<?endif?>
<br/>
<?=Form::open('/cart/order')?>

<div id='form_in'>
    <p>
        <br /><span class="text_5">Ваше имя фамилия и очество*</span><br/>
        <span class="text_4">(фамилия и очество нужны для отправки заказа почтой)</span><br />
        <?=Form::input('name', $data_order['or_name'], array('size' => 50, 'placeholder' => 'Введите Ваше имя', 'required'))?>    
    </p>
    <p>
        <span class="text_5">Телефон*</span><br/>
        <?=Form::input('tel', $data_order['or_tel'], array('size' => 50, 'placeholder' => 'Введите телефон', 'required'))?> 
    </p>
    <p>
        <span class="text_5">Доставка*</span><br/>
        <?php echo Form::select('send', $sends, $data_order['se_id'], array('style' => 'background: #f1f1f1; padding: 6px 5px; margin: 0 0 5px 0; border: 1px solid #336600;')); ?>    
    </p> 
    <p>
        <span class="text_5">Электронная почта</span><br/>
        <?=Form::input('email', $data_order['or_email'], array('size' => 30, 'placeholder' => 'Введите Ваше E-mail', 'type' => 'email'))?> 
    <p>
    <p>
        <span class="text_5">Ваша адрес</span><br/>
        <?=Form::input('city', $data_order['or_city'], array('size' => 50, 'placeholder' => 'Введите назваеие города'))?>
        <span class="text_5">город</span><br/>
    </p>
    <p>
        <?=Form::input('street', $data_order['or_street'], array('size' => 50, 'placeholder' => 'Введите назваеие улици'))?>
        <span class="text_5">улица</span><br/>
    </p>
    <p>
        <?=Form::input('building', $data_order['or_building'], array('size' => 10, 'placeholder' => 'Введите номер дома'))?>
        <span class="text_5">номер дом</span><br/>
    </p>
    <p>
        <?=Form::input('office', $data_order['or_office'], array('size' => 10, 'placeholder' => 'Введите номер квартиры или офис'))?>
        <span class="text_5">номер квартиры / офиса</span><br/>
    </p>
    <p>
        <span class="text_5">Дополнительная информация</span><br/>
        <span class="text_4">(особености проезда к вам, номер подъезда, код в подъезде, этаж, и т.д.)</span><br />
        <?=Form::textarea('data', $data_order['or_data'], array( 'rows' => '5', 'cols' => '60', 'v:shapes' => '_x0000_s1060', 'style' => 'font-family: Arial; font-size: 11pt; color: #666666'))?>
    </p>
    <p><span class="text_4">*Поля обязательные для заполнения</span></p>           
</div>
<br/>
<?=Form::submit('submit', ' Отправить ', array('class' => 'form_in_submit'))?> 
<?=Form::close()?>
</div>



