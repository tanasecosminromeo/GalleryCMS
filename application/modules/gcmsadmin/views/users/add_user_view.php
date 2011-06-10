
	<h1>New User</h1>
	
	<span ><b>Note :</b> Only Super Admins Can Add admins and super admins.</span>
	  

	<div id="generalinfo" class="iform">

	<?php
               $con = array('name' => 'useraddform', 'id' => 'useraddform');
               echo form_open( site_url("gcmsadmin/process_new_user") , $con);
                 ?>
                 
                 <div class="results"> <?php echo validation_errors(); ?> </div>
                 
                 
		<strong>* Marked Fields are Required. </strong>

<fieldset>
		<legend>
			<h4>Personal Informations</h4>
		</legend>
		<ul>

			<li>
				<?php echo form_label('Full Name: (*)', 'fname');?>
			</li>
			<li class="input_form">
				<?php
				$data_fname = array('name' => 'fname', 'id' => 'fname', 'value' => set_value('fname'), 'class' => 'required', );

				echo form_input($data_fname);
				?>
			</li>
			
			
			<li>
				<?php echo form_label('Username: (*)', 'uname');?>
			</li>
			<li class="input_form">
				<?php
				$data_uname = array('name' => 'uname', 'id' => 'uname', 'value' => set_value('uname'), 'class' => 'required', );

				echo form_input($data_uname);
				?>
			</li>
			
				<li>
				<?php echo form_label('User eMail: (*)', 'uemail');?>
			</li>
			<li class="input_form">
				<?php
				$data_uemail = array('name' => 'uemail', 'id' => 'uemail', 'value' => set_value('uemail'), 'class' => 'required');

				echo form_input($data_uemail);
				?>
			</li>
			
			<li>
				<?php echo form_label('User Password: (*)', 'upass');?>
			</li>
			<li class="input_form">
				<?php
				$data_upass = array('name' => 'upass', 'id' => 'upass', 'class' => 'required', );

				echo form_password($data_upass);
				?>
			</li>
			
			<li>
				<?php echo form_label('Password Confirmation: (*)', 'upassconf');?>
			</li>
			<li class="input_form">
				<?php
				$data_upassconf = array('name' => 'upassconf', 'id' => 'upassconf', 'class' => 'required', );

				echo form_password($data_upassconf);
				?>
			</li>
			
			<li>
				<?php echo form_label('User Type : (*)', 'usertype');?>
			</li>
			<li class="input_form">
				<?php
				
				$usertype_data = array('0' => 'Super Admin', '1' => 'Admin', '2' =>'User');

				echo form_dropdown('usertype', $usertype_data, '2');
				?>
			</li>
			
		
			
			</ul>
			</fieldset>
			
	
	<div class="clear"></div>
	
			
			<fieldset>
		<legend>
			<h4>Albums & Photos Settings</h4>
		</legend>
		<ul>

			
	
			
			</ul>
			</fieldset>
			
			
			
			
			<ul>
			<li>
					
				<?php		
                        $data_submit = array(
                              'name'        => 'create',
                              'id'          => 'submit',
                              'class'          => 'button',
                              'value'       => 'Add New User',
                             'type' => 'submit'
                            );

                        echo form_input($data_submit);
						
                  ?>  
			
		 	<a class="button" href="<?php echo base_url(); ?>gcmsadmin/users"> Back</a>
		 	
			</li>
			
			</ul>
			<?php form_close(); ?>	
		
	</div>


