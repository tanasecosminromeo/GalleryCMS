<?php

echo validation_errors();

$album = $album->row();

echo form_open(base_url().'gcmsusers/albums/edit/' . $album->id);
echo form_label('Album Title', 'title');
echo form_input(  
        array('name' => 'title',
              'id' => 'title',
              'maxlength' => '40',
              'value' => $album->album)
        );

echo form_label('Description', 'description');
echo form_textarea(  
        array('name' => 'description',
              'id' => 'description',
              'maxlength' => '255',
              'value' => $album->description)
        );

echo form_label('Album URL', 'url');
echo form_input(  
        array('name' => 'url',
              'id' => 'url',
              'maxlength' => '40',
              'value' => $album->aurl_title)
        );

echo form_submit('submit', 'Update Album', 'id="submit_button"');
echo form_close();

?>

<p><a href="<?php echo base_url(); ?>gcmsusers/albums/remove/<?php echo $album->id; ?>">Delete this album</a></p>