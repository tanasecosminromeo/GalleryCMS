<div id="login-bodycontent">
	
<div id='login-box'>

<?php 
echo validation_errors('<p class="error-box">');
echo form_open('gcmsadmin/login/go');
//use email as username.
echo form_input('username', set_value('username', 'Email'), 'id="username_inp"');
echo form_password('password', set_value('password', 'Password'), 'id="password_inp"');
echo form_submit('submit', 'Login', 'id="submit_button"');
echo anchor('login/password_recovery', 'I forgot my password', 'id="button_link_anc"');

?>

</div>



</div>