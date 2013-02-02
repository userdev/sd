<?php

echo '<div id = \'content\'>';
echo '<h2>Pievienot jaunumu</h2>';
echo '<div class =\'form_settings\'>';
echo form_open('news/savenews');
echo '<p>';
$attributes = array(

);
echo '<span>' . form_label('Nosaukums', 'name', $attributes) . '</span>';

$data = array(
    'name' => 'name',
    'id' => 'name'
);

echo form_input($data);
echo '</p>';
echo '<p>';
$attributes = array(
);
echo '<span>' . form_label('Apraksts', 'decription', $attributes) . '</span>';

$data = array(
    'name' => 'decription',
    'id' => 'decription',
    'maxlength' => '1000'
);
echo form_textarea($data);

echo '</p>';
$data = array(
    'name' => 'save',
    'class' => 'submit',
    'value' => 'Pievienot',
);

echo form_submit($data);
echo form_close();
echo '</div>';
echo '</div>';
?>