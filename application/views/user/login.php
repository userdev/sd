<div id = 'content'>
    <h2>Ienākt</h2>
    <div class ='form_settings'>
        <?php echo form_open('user/takelogin'); ?>

        <p>
            <?php
            echo form_error('username');
            echo '<span>' . form_label('Lietotājvards', 'username') . '</span>';


            $data = array(
                'name' => 'username',
                'id' => 'username',
                'maxlength' => '20',
                'value' => $user->username
            );

            echo form_input($data);
            ?>
        </p>

        <p>
            <?php
            echo form_error('password');
            echo '<span>' . form_label('Parole', 'password') . '</span>';

            $data = array(
                'name' => 'password',
                'id' => 'password',
                'maxlength' => '20',
                'type' => 'password'
            );

            echo form_input($data);
            ?>
        </p>
        <?php
        $data = array(
            'name' => 'save',
            'class' => 'submit',
            'value' => 'Ienākt!',
        );

        echo form_submit($data);
        echo form_close();
        ?>
    </div>
</div>
