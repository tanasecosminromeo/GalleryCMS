<h2>Users Manager</h2>


 <div id="user-list" class="lists">
 	
<table id="records" class="">
    <thead>
    <tr class="">
      <th>User ID</th>
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
    if (isset($err_message)) {
        echo "<p class=\"error-box\"><em>".$err_message."</em></p>";
        }else{

  foreach($records as $p){

            ?>

      <tr id="<?=$p->id?>">
      <td><?=$p->id?></td>
      <td><?=$p->name ?></td>
      <td><?=$p->username ?></td>
      <td><?=$p->email ?></td>
      <td><?=$p->user_group_display ?></td>
      <td><?php echo ($p->activation  == 1 ? "<span class='ok'></span>" : "<span class='no'></span>"); ?></td>
      <td><?= date("m/d/Y", strtotime($p->register_date))  ?></td>
      <td>
          <a class="updateBtn" href="<?php echo base_url().'gcmsadmin/users/update/'.$p->id; ?>"><img src="com_images/mini-icons/icon_update.png" /></a>
            <a class="deleteBtn" href="<?php echo base_url().'gcmsadmins/users/delete/'.$p->id; ?>"><img src="com_images/mini-icons/icon_delete.png" /></a>
      </td>
    </tr>

 <?php
        }
 }
 ?>
  </tbody>
</table>

        <?php      
 if ($total > $limit ) { echo $page_links; }
    ?>


   </div>