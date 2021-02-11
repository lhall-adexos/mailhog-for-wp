<?php
/**
 * Plugin Name: Mailhog for WordPress
 * Description: This plugin routes your emails to MailHog for development purpose.
 * Plugin URI: https://tareq.co
 * Author: Tareq Hasan
 * Author URI: https://tareq.co
 * Version: 1.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

defined('ABSPATH') || exit;

use function Env\env;

/**
 * WP MailHog
 */
class WP_MailHog
{

    function __construct()
    {
        $this->init_phpmailer();
    }

    /**
     * Define constants
     *
     * @return false
     */
    public function check_constants()
    {

        if (! env('WP_MAILHOG_HOST')) {
            return false;
        }

        if (! env('WP_MAILHOG_PORT')) {
            return false;
        }
        return true;
    }

    /**
     * Override the PHPMailer SMTP options
     *
     * @return void
     */
    public function init_phpmailer()
    {
        add_action('phpmailer_init', function ($phpmailer) {
            if ($this->check_constants()) {
                $phpmailer->Host     = env('WP_MAILHOG_HOST');
                $phpmailer->Port     = env('WP_MAILHOG_PORT');
                $phpmailer->SMTPAuth = false;
                $phpmailer->isSMTP();
            }
        });
    }
}

new WP_MailHog();
