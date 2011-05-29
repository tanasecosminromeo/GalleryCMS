
<div id="bodycontent">

	<h1>Step1</h1>
	<h2>System Checkup</h2>
	<ul>
		<li><strong>PHP version </strong> <?=$phpver?> </li>
		<li><strong>PHP API version  </strong><?=$php_api_ver?></li>
		<li><strong>PHP Safe Mode  </strong>  <?=$php_safe_mode_status?></li>
		<li><strong>PHP Register Globals :</strong><?=$php_register_global_status?></li>
		<li><strong>PHP set_time_limit</strong> (max execution time) : <?=$php_set_time_limit?></li>
		<li><strong>PHP Disabled Functions </strong>= <?=$php_disabled_functions?></li>
		<li><strong>PHP open_basedir  </strong><?=$php_open_basedir?></li>
		<li><strong>PHP Sessions Support </strong><?=$php_sessions_support?></li>
		<li><strong>PHP session.auto_start  </strong> <?=$php_session_auto_start?></li>
		<li><strong>PHP session.use_trans_sid  </strong><?=$php_session_use_trans_sid?></li>
		<li><strong>PHP session.save_path  </strong><?=$php_session_save_path?></li>
		<li><strong>PHP Magic_Quotes_Runtime  </strong><?=$php_magic_quotes?></li>
		<li><strong>PHP Output Buffering (gzip)  </strong> <?=$php_gzip?></li>
		<li><strong>PHP GD Support  </strong> <?=$php_gd?></li>
		<li><strong>PHP ImageMagic Support  </strong> <?=$php_image_magic?></li>
		<li><strong>PHP ZLIB Support  </strong><?=$php_zlib?></li>
		<li><strong>PHP OpenSSL Support  </strong><?=$php_openssl?></li>
		<li><strong>PHP CURL Support  </strong><?=$php_curl?></li>
		<li><strong>PHP File Uploads  </strong><?=$php_file_uploads?></li>
		<li><strong>PHP File Upload Max Size  </strong><?=$php_upload_max_filesize?></li>
		<li><strong>PHP Post Max Size  </strong><?=$php_post_max_size?></li>
		<li><strong>PHP File Upload TMP Dir  </strong><?=$php_upload_tmp_dir?></li>
		<li><strong>PHP XML Support  </strong><?=$php_xml_support?></li>
		<li><strong>PHP FTP Support  </strong><?=$php_ftp_support?></li>
		<li><strong>PHP PFPRO Support  </strong><?=$php_pfpro_support?></li>
		<li><strong>PHP Sendmail_FROM  </strong><?=$php_sendmail_from?></li>
		<li><strong>PHP Sendmail_PATH </strong><?=$php_sendmail_path?></li>
		<li><strong>PHP SMTP Settings  </strong> <?=$php_smtp_settings?></li>
		<li><strong>PHP include_path  </strong><?=$php_include_path?></li>
		</ul>
		
		
		<h2>System Folder Checkup</h2>
		<ul>
			<?php
			foreach($folders_status  as $key=>$value){
			echo "<li><strong>".$key." : </strong>".$value." </li>";	
				
			}
			
 				?>
		</ul>
		<span class="info-box">
			To proceed with the install you need to correct all errors in this page. when done you can then go to the next step. proceeding with errors may result in incorrect install and a malfunction of your CMS.
		</span>
		
	<?php if($checkup_status){ ?>	
	<div>
		<a class="button" href="<?=base_url()?>install/step2" >System Checkup >> License Agreement </a>
	
	 </div>
	<?php }?>
	<div class="clear"></div>
</div>
