<?php

/**
 * Class CaptchaModel
 *
 * This model class handles all the captcha stuff.
 * Currently this uses the excellent Captcha generator lib from https://github.com/Gregwar/Captcha
 * Have a look there for more options etc.
 */
class CaptchaModel
{
    /**
     * Generates the captcha, "returns" a real image, this is why there is header('Content-type: image/jpeg')
     * Note: This is a very special method, as this is echoes out binary data.
     */
    public static function generateAndShowCaptcha()
    {
        // create a captcha with the CaptchaBuilder lib (loaded via Composer)
        $captcha = new Gregwar\Captcha\CaptchaBuilder;
        $captcha->build(
            Config::get('CAPTCHA_WIDTH'),
            Config::get('CAPTCHA_HEIGHT')
        );

        // write the captcha character into session
        Session::set('captcha', $captcha->getPhrase());

        // render an image showing the characters (=the captcha)
        header('Content-type: image/jpeg');
        $captcha->output();
    }

    /**
     * Verify Google reCAPTCHA token via the Google API.
     * @param string $recaptchaResponse
     * @param string|null $expectedAction expected reCAPTCHA action name
     * @param float $minScore minimum acceptable score
     * @return bool success of recaptcha verification
     */
    public static function verifyReCaptcha($recaptchaResponse, $expectedAction = null, $minScore = 0.5)
    {
        if (empty($recaptchaResponse)) {
            return false;
        }

        $secret = Config::get('GOOGLE_RECAPTCHA_SECRET_KEY');
        if (empty($secret)) {
            return false;
        }

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = http_build_query(
            array(
                'secret' => $secret,
                'response' => $recaptchaResponse,
                'remoteip' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : ''
            )
        );

        $response = null;
        if (function_exists('curl_version')) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $response = curl_exec($ch);
            curl_close($ch);
        } elseif (ini_get('allow_url_fopen')) {
            $response = file_get_contents($url . '?' . $data);
        }

        if (!$response) {
            return false;
        }

        $result = json_decode($response, true);
        if (!isset($result['success']) || $result['success'] !== true) {
            return false;
        }

        if ($expectedAction !== null && isset($result['action']) && $result['action'] !== $expectedAction) {
            return false;
        }

        if (isset($result['score']) && $result['score'] < $minScore) {
            return false;
        }

        return true;
    }

    /**
     * Checks if the entered captcha is the same like the one from the rendered image which has been saved in session
     * @param $captcha string The captcha characters
     * @return bool success of captcha check
     */
    public static function checkCaptcha($captcha)
    {
        if (Session::get('captcha') && ($captcha == Session::get('captcha'))) {
            return true;
        }

        return false;
    }
}
