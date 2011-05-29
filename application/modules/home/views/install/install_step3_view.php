<div id="bodycontent">
	
	<h1>Step1</h1>
	<h2>System Checkup</h2>
	<span class="ok">Your Server is ready for GalleryCMS install </span>
	  
	<h1>Step2</h1>
	<h2>License Agreement</h2>
	<span class="ok">License Agreement Accepted </span>
	
	<h1>Step3</h1>
	<h2>Gallery Informations</h2>


	<div id="generalinfo" class="iform">

	<?php
               $con = array('name' => 'generalform', 'id' => 'generalform');
               echo form_open( site_url("install/installgcms") , $con);
                 ?>
                 
                 <div class="results"> <?php echo validation_errors(); ?> </div>
                 
                 
		<strong>* Marked Fields are Required. </strong>

<fieldset>
		<legend>
			<h4>Website Informations</h4>
		</legend>
		<ul>

			<li>
				<?php echo form_label('Gallery Name: (*)', 'gname');?>
			</li>
			<li class="input_form">
				<?php
				$data_gname = array('name' => 'gname', 'id' => 'gname', 'value' => set_value('gname'), 'class' => 'required', );

				echo form_input($data_gname);
				?>
			</li>
			
			
			<li>
				<?php echo form_label('Gallery Title: (*)', 'gtitle');?>
			</li>
			<li class="input_form">
				<?php
				$data_gtitle = array('name' => 'gtitle', 'id' => 'gtitle', 'value' => set_value('gtitle'), 'class' => 'required', );

				echo form_input($data_gtitle);
				?>
			</li>
			
			<li>
				<?php echo form_label('Gallery URL: ', 'gurl');?>
			</li>
			<li class="input_form">
				<?php
				$data_gurl = array('name' => 'gurl', 'id' => 'gurl', 'value' => base_url(), 'class' => 'required', 'readonly'=>'readonly');

				echo form_input($data_gurl);
				?>
			</li>
			
				<li>
				<?php echo form_label('Gallery Administration URL: ', 'gaurl');?>
			</li>
			<li class="input_form">
				<?php
				$data_gaurl = array('name' => 'gaurl', 'id' => 'gaurl', 'value' => base_url().'gcmsadmin', 'class' => 'required', 'readonly'=>'readonly');

				echo form_input($data_gaurl);
				?>
			</li>
			
			</ul>
			</fieldset>
			
	
	<div class="clear"></div>
	
	<fieldset>
		<legend>
			<h4>Administrator Information</h4>
		</legend>
		<ul>

			<li>
				<?php echo form_label('Admin Full Name: (*)', 'ganame');?>
			</li>
			<li class="input_form">
				<?php
				$data_ganame = array('name' => 'ganame', 'id' => 'ganame', 'value' => set_value('ganame'), 'class' => 'required', );

				echo form_input($data_ganame);
				?>
			</li>
			
			
			<li>
				<?php echo form_label('Admin Username: (*)', 'gusername');?>
			</li>
			<li class="input_form">
				<?php
				$data_gausername = array('name' => 'gausername', 'id' => 'gausername', 'value' => set_value('gausername'), 'class' => 'required', );

				echo form_input($data_gausername);
				?>
			</li>
			
			<li>
				<?php echo form_label('Admin Password: (*)', 'gapass');?>
			</li>
			<li class="input_form">
				<?php
				$data_gapass = array('name' => 'gapass', 'id' => 'gapass', 'class' => 'required', );

				echo form_password($data_gapass);
				?>
			</li>
			
			<li>
				<?php echo form_label('Admin Password Confirmation: (*)', 'gapassconf');?>
			</li>
			<li class="input_form">
				<?php
				$data_gapassconf = array('name' => 'gapassconf', 'id' => 'gapassconf', 'class' => 'required', );

				echo form_password($data_gapassconf);
				?>
			</li>
			
			
				<li>
				<?php echo form_label('Admin eMail: (*)', 'gaemail');?>
			</li>
			<li class="input_form">
				<?php
				$data_gaemail = array('name' => 'gaemail', 'id' => 'gaemail', 'value' => set_value('gaemail'), 'class' => 'required');

				echo form_input($data_gaemail);
				?>
			</li>
				
			
			</ul>
			</fieldset>
			
					
			<fieldset>
		<legend>
			<h4>Albums & Photos Information</h4>
		</legend>
		<ul>

			<li>
				<?php echo form_label('Max. Number of albums per user : (*)', 'max_albums');?>
			</li>
			<li class="input_form">
				<?php
				$data_max_albums = array('name' => 'max_albums', 'id' => 'max_albums', 'value' => set_value('max_albums'), 'class' => 'required', );

				echo form_input($data_max_albums);
				?>
			</li>
			
			
			<li>
				<?php echo form_label('Max Number of Pictures Per Album : (*)', 'max_imgs');?>
			</li>
			<li class="input_form">
				<?php
				$data_imgs = array('name' => 'max_imgs', 'id' => 'max_imgs', 'value' => set_value('max_imgs'), 'class' => 'required', );

				echo form_input($data_imgs);
				?>
			</li>
			
			<li>
				<?php echo form_label('Can User Crop Image? : (*)', 'crop_imgs');?>
			</li>
			<li class="input_form">
				<?php
				
				$crop_data = array('1' => 'Yes', '0' => 'No');

				echo form_dropdown('crop_imgs', $crop_data, '1');
				?>
			</li>
				
			
			<li>
				<?php echo form_label('Thummbnails Width: (*)', 'thumb_width');?>
			</li>
			<li class="input_form">
				<?php
				$data_thumb_width = array('name' => 'thumb_width', 'id' => 'thumb_width', 'value' => set_value('thumb_width'), 'class' => 'required', );

				echo form_input($data_thumb_width);
				?>
			</li>
			
			
			<li>
				<?php echo form_label('Thummbnails Height: (*)', 'thumb_height');?>
			</li>
			<li class="input_form">
				<?php
				$data_thumb_height = array('name' => 'thumb_height', 'id' => 'thumb_height', 'value' => set_value('thumb_height'), 'class' => 'required');

				echo form_input($data_thumb_height);
				?>
			</li>
			</ul>
			</fieldset>
			
			
			
			
			<ul>
			<li>
					
				<?php		
                        $data_submit = array(
                              'name'        => 'create',
                              'id'          => 'submit',
                              'class'          => 'button',
                              'value'       => 'Install',
                             'type' => 'submit'
                            );

                        echo form_input($data_submit);
						
                  ?>  
			
		 	<a class="button" href="<?php echo base_url(); ?>install/step2"> Back to License Agreement Page</a>
		 	
			</li>
			
			</ul>
			<?php form_close(); ?>	
		<div class="clear"></div>
	</div>
</div>