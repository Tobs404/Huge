<div class="container">
    <h1>Request a password reset</h1>
    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <!-- request password reset form box -->
        <form method="post" action="<?php echo Config::get('URL'); ?>login/requestPasswordReset_action">
            <label for="user_name_or_email">
                Enter your username or email and you'll get a mail with instructions:
                <input type="text" name="user_name_or_email" required />
            </label>

            <div class="g-recaptcha" data-sitekey="<?php echo Config::get('GOOGLE_RECAPTCHA_SITE_KEY'); ?>"></div>
            <input type="submit" value="Send me a password-reset mail" />
        </form>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    </div>
</div>
<div class="container">
    <p style="display: block; font-size: 11px; color: #999;">
        This page now uses Google reCAPTCHA for bot protection. Make sure your
        <code>GOOGLE_RECAPTCHA_SITE_KEY</code> and <code>GOOGLE_RECAPTCHA_SECRET_KEY</code> are configured in <code>application/config/config.development.php</code>.
    </p>
</div>
