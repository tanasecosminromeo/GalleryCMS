
	<h1>Update User Info</h1>
	
	
	<div id="updategeneralinfo" class="iform">

	<?php
               $con = array('name' => 'userupdateform', 'id' => 'userupdateform');
               echo form_open( site_url("gcmsadmin/users/process_update_user") , $con);
                 ?>
                 
                 <div class="results"> <?php echo validation_errors(); ?> </div>
                 <?php
                 if (isset($err_message))   echo  $err_message ;
                 ?>
                 
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
				$data_fname = array('name' => 'fname', 'id' => 'fname', 'value'=> $name , 'class' => 'required', );

				echo form_input($data_fname);
				?>
			</li>
			
			
			<li>
				<?php echo form_label('Username: (*)', 'uname');?>
			</li>
			<li class="input_form">
				<?php
				$data_uname = array('name' => 'uname', 'id' => 'uname', 'value' => $username, 'class' => 'required', );

				echo form_input($data_uname);
				?>
			</li>
			
				<li>
				<?php echo form_label('User eMail: (*)', 'uemail');?>
			</li>
			<li class="input_form">
				<?php
				$data_uemail = array('name' => 'uemail', 'id' => 'uemail', 'value' => $email, 'class' => 'required');

				echo form_input($data_uemail);
				?>
			</li>
			
			<li>
				<?php echo form_label('User Type : (*)', 'usertype');?>
			</li>
			<li class="input_form">
				<?php
				if($this->session->userdata('group_id')> 0){
				$usertype_data = array('2' =>'User');	 
				}else{
				$usertype_data = array('0' => 'Super Admin', '1' => 'Admin', '2' =>'User');	
				}
				echo form_dropdown('usertype', $usertype_data, $usertype);
				?>
			</li>
			
		
			
			</ul>
			</fieldset>
			
			<fieldset>
				<legend>
			<h4>Other Informations</h4>
		</legend>
		<ul>

			<li>
			<b>Registred : </b> <?php echo mdate("%m/%d/%Y %h:%i:%a", strtotime($register_date) ); ?>
			</li>
			
			<li>
			<b>XML Feed URL base : </b>
			<?php 					$title = base_url().'gfeed/xml/'.$username;
                                   $segments = array( 'gfeed/xml', $username);
                                   echo anchor( $segments, $title, array('title' => $title) );     ?>
			
			
			 
			</li>
		
			<li>
			<b>JSON Feed URL base : </b>
			<?php 					$title = base_url().'gfeed/json/'.$username;
                                   $segments = array( 'gfeed/json', $username);
                                   echo anchor( $segments, $title, array('title' => $title) );     ?>
			
			</li>	
			
			
			<li>
			<b>Number of user feed(s) : </b>	<?= $feed_count ?>
				
			</li>
			<li>
			<b>Number of user Published feed(s) : </b>	<?= $pub_feed ?>
				
			</li>
	
			</fieldset>
	
	<div class="clear"></div>
	
	
			<ul>
			<li>
					
				<?php		
                        $data_submit = array(
                              'name'        => 'update',
                              'id'          => 'submit',
                              'class'          => 'button',
                              'value'       => 'Save',
                             'type' => 'submit'
                            );

                        echo form_input($data_submit);
						
                  ?>  
			
		 	<a class="button" href="<?php echo base_url(); ?>gcmsadmin/users"> Back</a>
		 	
			</li>
			
			</ul>
			<?php form_close(); ?>	
		
	</div>


