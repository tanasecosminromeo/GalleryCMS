<?php $this->load->view('install/header_view'); ?>
	<div id="login-box">
		
		
		 <?php
               $con = array('name' => 'installform1', 'id' => 'installform1');
               echo form_open( site_url("install/gentables") , $con);
                 ?>
		
			<h1>Create Account</h1>
			<div>
				<span><?php echo form_label('Username: (*)', 'username'); ?><br /></span>
				
				<?php
                         $data_username = array(
                                  'name'        => 'username',
                                  'id'          => 'username',
                                  'value'       => set_value('username'),
                                  'class'       => 'required',
                                );

                        echo form_input($data_username);
					?>
		
			</div>
			<div>
			
			<span><?php echo form_label('Password: (*)', 'password'); ?><br /></span>
				
				<?php
                         $data_password = array(
                                  'name'        => 'password',
                                  'id'          => 'password',
                                  'value'       => set_value('password'),
                                  'class'       => 'required',
                                );

                        echo form_password($data_password);
					?>
			
			
			</div>
			<div>
				
				<span><?php echo form_label('Password Confirmation: (*)', 'passconf'); ?><br /></span>
				
				<?php
                         $data_passconf = array(
                                  'name'        => 'passconf',
                                  'id'          => 'passconf',
                                  'value'       => set_value('passconf'),
                                  'class'       => 'required',
                                );

                        echo form_password($data_passconf);
					?>
				
			
			</div>
			<div>
				<?php		
                        $data_submit = array(
                              'name'        => 'send',
                              'id'          => 'submit',
                              'class'          => 'button',
                              'value'       => 'Register',
                             'type' => 'submit'
                            );

                        echo form_input($data_submit);
						
                  ?>  
				
			</div>
			<div><?php echo validation_errors(); ?></div>
		</div>
		
		 <?php form_close(); ?>
		 
<?php $this->load->view('install/footer_view'); ?>