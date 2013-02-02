<div id = 'content'>
    <h2>Pievienot tostu</h2>
    <div class ='form_settings'>
        <?php echo form_open('toasts/takeadd'); ?>

        <p>
            <?php
            echo form_error('poem');
            echo '<span>' . form_label('Tosts', 'poem') . '</span>';


            $data = array(
                'name' => 'toast',
                'id' => 'toast',
                'maxlength' => '50000',
                'value' => $toast->toast
            );

            echo form_textarea($data);
            ?>
        </p>

       
        <h4>Kategorija</h4>
        <?php
        if ($yes_category == FALSE)
            echo 'Izvēlieties kategoriju';
        foreach ($categories as $category) {

            echo '<p><span>' . form_label($category->title, $category->category_ID) . '</span>';

            $data = array(
                'name' => 'category_' . $category->category_ID,
                'id' => $category->category_ID,
                'class' => 'checkbox',
                'value' => $category->category_ID,
                'checked' => $category->checked
            );
            echo form_checkbox($data) . '</p>';
        }
        ?>


        <?php
        $data = array(
            'name' => 'save',
            'class' => 'submit',
            'value' => 'pievienot',
        );

        echo form_submit($data);
        echo form_close();
        ?>
    </div>
</div>
