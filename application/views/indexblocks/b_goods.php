<?=Form::open('/ca/'.$ca)?>
Производитель:<?php echo Form::select('brends', $sel_brend, $sel_br, array('onchange' => 'this.form.submit()')); ?>
 кол. товаров <?php echo$count_goods; ?> шт.
<?=Form::close()?>
<?php echo$pagin; ?>
<br />
<?php echo$good_show; ?>
<br />
<?php echo$pagin; ?>
<br />
