<div id = 'content'>
    <h2>Pievienot  aptauju</h2>
    <div class ='form_settings'>
        <?php echo form_open('polls/takeadd'); ?>

        <p>
            <?php
            echo form_error('question');
            echo '<span>' . form_label('Jautājums', 'question') . '</span>';


            $data = array(
                'name' => 'question',
                'id' => 'question',
                'maxlength' => '1000',
                'value' => $question
            );

            echo form_textarea($data);
            ?>
        </p>
        <h4>Atbilžu varianti</h4>
        <?php 
        if (isset($error_message)) echo "<h4>$error_message</h4>" //Kļudas paziņojums, ja nav aipildīti 2 atbilžu varinati
        ?>
        <p>

            <?php
            echo form_error('answer_1');
            $data = array(
                'name' => 'answer_1',
                'id' => 'answer_1',
                'maxlength' => '255',
                'class' => 'poll_answers',
                'value' => $answers->answer_1
            );
            echo form_input($data);
            ?>
        </p>
        <p>

            <?php
            echo form_error('answer_2');
            $data = array(
                'name' => 'answer_2',
                'id' => 'answer_2',
                'maxlength' => '255',
                'class' => 'poll_answers',
                'value' => $answers->answer_2
            );
            echo form_input($data);
            ?>
        </p><p>

            <?php
            echo form_error('answer_3');
            $data = array(
                'name' => 'answer_3',
                'id' => 'answer_3',
                'maxlength' => '255',
                'class' => 'poll_answers',
                'value' => $answers->answer_3
            );
            echo form_input($data);
            ?>
        </p><p>

            <?php
            echo form_error('answer_4');
            $data = array(
                'name' => 'answer_4',
                'id' => 'answer_4',
                'maxlength' => '255',
                'class' => 'poll_answers',
                'value' => $answers->answer_4
            );
            echo form_input($data);
            ?>
        </p><p>

            <?php
            echo form_error('answer_5');
            $data = array(
                'name' => 'answer_5',
                'id' => 'answer_5',
                'maxlength' => '255',
                'class' => 'poll_answers',
                'value' => $answers->answer_5
            );
            echo form_input($data);
            ?>
        </p><p>

            <?php
            echo form_error('answer_6');
            $data = array(
                'name' => 'answer_6',
                'id' => 'answer_6',
                'maxlength' => '255',
                'class' => 'poll_answers',
                'value' => $answers->answer_6
            );
            echo form_input($data);
            ?>
        </p><p>

            <?php
            echo form_error('answer_7');
            $data = array(
                'name' => 'answer_7',
                'id' => 'answer_7',
                'maxlength' => '255',
                'class' => 'poll_answers',
                'value' => $answers->answer_7
            );
            echo form_input($data);
            ?>
        </p>



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
