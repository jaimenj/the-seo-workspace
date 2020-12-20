<?php

defined('ABSPATH') or die('No no no');
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

include_once 'the-seo-workspace.php';

TheSeoWorkspace::get_instance()->uninstall();
