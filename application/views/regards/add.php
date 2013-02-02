<div id = 'content'>
    <h2>Pievienot apsveikuma novēlējumu</h2>
    <div class ='form_settings'>
        <?php echo form_open('regards/takeadd'); ?>

        <p>
            <?php
            echo form_error('poem');
            echo '<span>' . form_label('Pantiņš', 'poem') . '</span>';


            $data = array(
                'name' => 'poem',
                'id' => 'poem',
                'maxlength' => '50000',
                'value' => $regard->poem
            );

            echo form_textarea($data);
            ?>
        </p>

        <p>
            <?php
            echo form_error('author');
            echo '<span>' . form_label('Autors', 'author') . '</span>';

            $data = array(
                'name' => 'author',
                'id' => 'author',
                'maxlength' => '20',
                'value' => $regard->author
            );

            echo form_input($data);
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
