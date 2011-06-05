<div id="login-bodycontent">
	
<div id='login-box'>

<?php 
 if (isset($err_message)) echo "<p class=\"error-box\">".$err_message."</p>";
echo validation_errors();
$hidden = array('user_id' => $user_id, 'reset_code'=>$retrival_code);
echo form_open(base_url().'gcmsadmin/login/password_change_go','', $hidden);
echo form_label('New Password: (*)', 'password');
echo form_password('password', set_value('password'), 'id="password_inp"');
echo form_label('New Password Confirmation: (*)', 'password2');
echo form_password('password2', set_value('password2'), 'id="password_inp2"');
echo form_submit('submit', 'Save', 'id="submit_button"');

?>

</div>



</div>