<?php
$action = \WPLMixTheme\AdminPost\ContactFormSubmissionHandler::get_instance()->get_admin_post_url();
?>

<div class="Contact Section">
    <div class="Contact__inner Section__inner">

        <h2 class="Section__title">Contact Us</h2>
        <div class="Section__sub-title">
            <?php the_content() ?>
        </div>

        <?php
            if (isset($_GET['status'])){
                if ($_GET['status'] == 'success'){?>
                <div class="Contact__success">
                    <?php the_field( 'thank_you_message' ) ?>
                </div>
                <?php
                } else {?>
                <div class="Contact__fails">
                    <?php the_field( 'message_not_sent' ) ?>
                </div>
                <?php
                }
            }            
        ?>

        <form class="Contact__form" action="<?= $action ?>" method="post">

            <p class="Contact__form-field">
                <label for="name">Name</label>
                <input id="name" name="name" type="text" required>
            </p>

            <p class="Contact__form-field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" required>
            </p>

            <p class="Contact__form-field">
                <label for="message">Message</label>
                <textarea name="message" id="message" required></textarea>
            </p>

            <p class="Contact__form-field -ta-center">
                <input type="submit" value="Submit" class="Button Button--dark">
            </p>

        </form>

    </div>
</div>