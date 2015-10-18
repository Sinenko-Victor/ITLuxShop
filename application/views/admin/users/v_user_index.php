<div id="pages_list">
    <div id="pages_header">
        <h1>Покупатель</h1>
    </div>
    <div>
    
<br/>
<?=Form::open('/admin/users/edit/'.$user->id)?>
<?php
if($user->status == 1)
{$usstat='<img src="/media/img/ok-1-16.png" border="0"/>';}
else
{$usstat='Нет';}
?>      
<table width="500" border="1"  cellspacing="0" style="margin: 0px auto;">
    <tr>
        <td height="27" width="200" align="right">
            Имя&nbsp;
        </td>
        <td width="300" align="left" bgcolor="E0EFDF">
            <span class="error"><?php echo Arr::get($errors, 'first_name') ?></span>
            &nbsp;<?=Form::input('first_name', $user->first_name, array('size' => 35, 'placeholder' => 'Введите имя'))?>
        </td>
    </tr>
    <tr>
        <td height="27" align="right">
            Логин&nbsp;
        </td>
        <td width="300" align="left" bgcolor="E0EFDF">
            <span class="error"><?php echo Arr::get($errors, 'username') ?></span>
            &nbsp;<?=Form::input('username', $user->username, array('size' => 35, 'placeholder' => 'Введите логин'))?>
        </td>
    </tr>
    <tr>
        <td height="27" align="right">
            Город&nbsp;
        </td>
        <td width="300" align="left" bgcolor="E0EFDF">
            <span class="error"><?php echo Arr::get($errors, 'city') ?></span>
            &nbsp;<?=Form::input('city', $user->city, array('size' => 35, 'placeholder' => 'Введите Ваш город'))?>
        </td>
    </tr>
     <tr>
        <td height="27" align="right">
            Телефон&nbsp;
        </td>
        <td width="300" align="left" bgcolor="E0EFDF">
            <span class="error"><?php echo Arr::get($errors, 'tel') ?></span>
            &nbsp;<?=Form::input('tel', $user->tel, array('size' => 35, 'placeholder' => 'Введите телефон'))?>
        </td>
    </tr>
    <tr>
        <td height="27" align="right">
            E-mail&nbsp;
        </td>
        <td width="300" align="left" bgcolor="E0EFDF">
            <span class="error"><?php echo Arr::get($errors, 'email') ?></span>
            &nbsp;<?=Form::input('email', $user->email, array('size' => 35, 'placeholder' => 'Введите E-mail'))?>
        </td>
    </tr>
    <tr>
        <td height="27" align="right">
            Подтверждение E-mail
        </td>
        <td width="300" align="left" bgcolor="E0EFDF">
            &nbsp;<?=$usstat?>
        </td>
    </tr>
    <tr>
        <td height="27" align="right">
            Последний вход&nbsp;
        </td>
        <td width="300" align="left" bgcolor="E0EFDF">
            &nbsp;<?=date('d.m.Y G:i',$user->last_login)?>
        </td>
    </tr>
    <tr>
        <td height="27" align="right">
            Улица&nbsp;
        </td>
        <td width="300" align="left" bgcolor="E0EFDF">
            <span class="error"><?php echo Arr::get($errors, 'street') ?></span>
            &nbsp;<?=Form::input('street', $user->street, array('size' => 35, 'placeholder' => 'Введите улицу'))?>
        </td>
    </tr>
    <tr>
        <td height="27" align="right">
            Дом&nbsp;
        </td>
        <td width="300" align="left" bgcolor="E0EFDF">
            <span class="error"><?php echo Arr::get($errors, 'building') ?></span>
            &nbsp;<?=Form::input('building', $user->building, array('size' => 5))?>
        </td>
    </tr>
    <tr>
        <td height="27" align="right">
            Квартира/офис&nbsp;
        </td>
        <td width="300" align="left" bgcolor="E0EFDF">
            <span class="error"><?php echo Arr::get($errors, 'office') ?></span>
            &nbsp;<?=Form::input('office', $user->office, array('size' => 5))?>
        </td>
    </tr>
    <tr>
        <td height="27" align="right">
            Дополнительная информация&nbsp;
        </td>
        <td width="300" align="left" bgcolor="E0EFDF">
            <span class="error"><?php echo Arr::get($errors, 'data') ?></span>
            &nbsp;<?=Form::textarea('data', $user->data, array('size' => 200, 'rows' => '5', 'cols' => '35'))?>
        </td>
    </tr>
    <tr>
        <td height="27" align="right">
            <span class="link_4"><?=Html::anchor('/admin/users', 'Покупатели', array('title' => 'Все покупатели'))?></span>&nbsp;
        </td>
        <td width="300" align="left">
            <?=Form::submit('submit', ' Сохранить ')?> <span class="error"><?=$save_user?></span>
        </td>
    </tr>
</table>
<?=Form::close()?>  
    </div>
    <div id="pages_footer">
    </div>
</div>