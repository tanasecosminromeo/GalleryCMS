<div id="bodycontent">
	
	<h1>Step1</h1>
	<h2>System Checkup</h2>
	
	<?php 
	if( $this->session->userdata('system_checkup')){
		echo '<span class="ok">Your Server is ready for GalleryCMS install </span>';
	}else{
		echo '<span class="no">Your Server is not ready for GalleryCMS install</span>';
	}
	  ?>
	  
	<h1>Step2</h1>
	<h2>License Agreement</h2>


	<div id="agreementform" class="iform">
	
		 <?php
               $con = array('name' => 'licenseform', 'id' => 'licenseform');
               echo form_open( site_url("install/license_agree") , $con);
                 ?>
		
			<ul>
			<li>
				
				
				<?php
                           
                           $license_txt = read_file('./gallerycms_license.txt');
                           
                             $license_data = array(
                                'name'        => 'message',
                                'id'          => 'message',
                                'value'       => $license_txt,
                                'rows' => '10',
                                'cols'  => '60',
                                'readonly'  => 'readonly',
                                'class'       => 'required',
                              );
  
                          echo form_textarea($license_data);
                             
                              ?>
		
			</li>
			
			<li>
			<input type="checkbox" value="agreeCheck" name='agreeCheck' /> I Read and Agree to GalleryCMS License Agreement
			</li>
			
			
			
			<li>
					
				<?php		
                        $data_submit = array(
                              'name'        => 'agree',
                              'id'          => 'submit',
                              'class'          => 'button',
                              'value'       => 'I Agree.',
                             'type' => 'submit'
                            );

                        echo form_input($data_submit);
						
                  ?>  
			
		 	<a class="button" href="<?php echo base_url(); ?>install"> Back to System Checkup</a>
		 	
			</li>
			<li class="clear">
				
			<?php echo validation_errors(); ?>
			</li>
			
			</ul>
		
		 <?php form_close(); ?>	
		 
		 </div>
</div>