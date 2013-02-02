<div id = 'content'>
    <h2>Reģistrēšanās</h2>
    <div class ='form_settings'>
        <?php echo form_open('user/saveuser'); ?>

        <p>
            <?php
            echo form_error('username');
            if ($user->username==' '){
                echo '<div>Šāds lietotājvārds jau ir aiņemts</div>';
                $user->username='';
                }
            echo '<span>' . form_label('Lietotājvards', 'username') . '</span>';


            $data = array(
            'name' => 'username',
            'id' => 'username',
                'maxlength'=>'12',
            'value' => $user->username
            );

            echo form_input($data);
            ?>
        </p>
        <p>
            <?php
            if($user->email==' '){
                  echo '<div>Šāds epasts jau ir reģistrēts</div>';
                  $user->email='';                  
                  }
            echo form_error('email');
            echo '<span>' . form_label('E-pasts', 'email') . '</span>';

            $data = array(
                'name' => 'email',
                'id' => 'email',
                'maxlength'=>'256',
                'value' => $user->email
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
                'maxlength'=>'20',
                'type' => 'password'
            );

            echo form_input($data);
            ?>
        </p>
        <p>
            <?php
            echo form_error('password2');
            echo '<span>' . form_label('Vēlreiz parole', 'password2') . '</span>';

            $data = array(
                'name' => 'password2',
                'id' => 'password2',
                'maxlength'=>'20',
                'type' => 'password'
            );
            echo form_input($data);
            ?>
        </p>

        <p> <?php
            if ($user->gender == '')
                $user->gender = 'option';
            else if ($user->gender == 'option')
                echo '<div>Norādiet dzimumu</div>';
            echo form_error('gender');
            echo '<span>' . form_label('Dzimums', '') . '</span>';

            $options = array(
                'male' => 'Vīrietis',
                'female' => 'Sieviete',
                'option' => 'Dzimums'
            );

            echo form_dropdown('gender', $options, $user->gender);
            ?>
        </p>


        <?php
        $data = array(
            'name' => 'save',
            'class' => 'submit',
            'value' => 'Reģistrēties',
        );

        echo form_submit($data);
        echo form_close();
        ?>
    </div>
</div>
