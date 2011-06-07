<?php

echo validation_errors();

echo form_open(base_url().'gcmsusers/albums/create');
echo form_label('Album Title', 'title');
echo form_input(  
        array('name' => 'title',
              'id' => 'title',
              'maxlength' => '40')
        );

echo form_label('Description', 'description');
echo form_textarea(  
        array('name' => 'description',
              'id' => 'description',
              'maxlength' => '255')
        );

echo form_label('Album URL', 'url');
echo form_input(  
        array('name' => 'url',
              'id' => 'url',
              'maxlength' => '40')
        );

echo form_submit('submit', 'Create Album', 'id="submit_button"');
echo form_close();

?>