<div>
<?php Message::show_flash(); ?>
<?php 
$form->create(array('attribute' => 'autocomplete="off"')); 
$form->input('user', array('placeholder'=>__('Your username'), 'label' => __('Username')));
$form->input('pass', array('placeholder'=>__('Your password'), 'label' => __('Password')));
$form->input('keep',array('type' => 'checkbox', 'label' => __('Keep me logged in'), 'value' => 1));
$form->input('link', array('attribute'=>'hidden', 'value' => CURRENT_URL));
$form->close(__('Login')); 
?>
</div>