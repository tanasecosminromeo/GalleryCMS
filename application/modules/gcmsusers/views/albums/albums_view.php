<h2>Albums Manager</h2>
<a href="<?php echo base_url(); ?>gcmsusers/albums/add">Add new</a>
<?php if (isset($rows)): ?>
  <?php foreach ($rows->result() as $album): ?>
<div class="album-list">
  <a href="<?php echo base_url(); ?>gcmsusers/albums/edit/<?php echo $album->id ?>">
    <?php echo $album->album; ?>
  </a>
</div>
  <?php endforeach; ?>
<?php endif; ?>
