<div id="login-bodycontent">
	
<div id='login-box'>

<?php 
 if (isset($err_message)) echo "<p class=\"error-box\">".$err_message."</p>";
echo validation_errors();

echo form_open(base_url().'gcmsadmin/login/password_recovery_go');
echo form_input('email', set_value('email', 'email'), 'id="email_inp"');
echo form_submit('submit', 'Send', 'id="submit_button"');
echo anchor(base_url().'gcmsadmin/login', 'Back to Login', 'id="button_link_anc"');

?>



<p><strong>Note: </strong> enter your email and click send to receive the password reset code in the email we have in records.</p>

</div>

</div>