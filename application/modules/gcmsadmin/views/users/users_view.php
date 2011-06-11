<h2>Users Manager</h2>

<div>
		<a class="button" href="<?=base_url()?>gcmsadmin/users/add" >Add A New User/Admin </a>
	
	 </div>
<div class="clear"></div> 

<p><b>Note : </b> Only Super Admins can edit admins and users , Admins can only edit users records.</p>
	 
 <div id="user-list" class="lists">
 <?php
     if ($total > 0) {
       
 ?>
<table id="records" class="">
    <thead>
    <tr class="">
      <th>UID</td>
      <th>Full Name</th>
      <th>Username</th>
      <th>eMail</th>
      <th>User Group</th>
      <th>Status</th>
      <th>Registred</th>
      <th>Action</th>
    </tr>
  </thead>



  <tbody>
    <?php

  foreach($records as $p){

            ?>

      <tr id="<?=$p->username?>">
      <td><?=$p->id?></td>
      <td><?=$p->name ?></td>
      <td><?=$p->username ?></td>
      <td><?=$p->email ?></td>
      <td><?=$p->user_group_display ?></td>
      <td><?php echo ($p->activation  == 1 ? "<span class='ok'></span>" : "<span class='no'></span>"); ?></td>
      <td><?= date("m/d/Y", strtotime($p->register_date))  ?></td>
      <td>
         <?php if($this->session->userdata('group_id')> 0 && $p->group_id < 2){  ?>
        	 no edit
         <?php }else{ ?>
         	 <a class="updateBtn" href="<?php echo base_url().'gcmsadmin/users/update/'.$p->username; ?>"><img src="com_images/mini-icons/icon_update.png" /></a>
            <a class="deleteBtn" href="<?php echo base_url().'gcmsadmins/users/delete/'.$p->username; ?>"><img src="com_images/mini-icons/icon_delete.png" /></a>
			
       <?php  }   ?>
      </td>
    </tr>

 <?php
        }

 ?>
  </tbody>
</table>

        <?php      
 if ($total > $limit ) echo $page_links;
 ?>
 
 
 <?php
 
 }else{
  echo "<p class=\"error-box\">No Records Found!</p>";
        }
    ?>


   </div>