<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Billing module by CumArchon69420
    |--------------------------------------------------------------------------
    | This file contains basic configuration options for the Cumming module,
    */

    'name' => 'Billing',
    'system_lang' => 'English',
    'author' => 'Xudong Zhong',
    'version' => '3.2.0',
    'theme' => 'Carbon',

    /*
    |--------------------------------------------------------------------------
    | Billing Settings
    |--------------------------------------------------------------------------
    */

    // This is the path the module is on, for example https://domain.com/billing
    'path' => 'billing',

    // This option is for those who ONLY want to use Billing system for the THEME
    // Settings this option to false will remove Billing links and only activate the theme.
    'billing' => true,

    // Enable or disable portal page
    'portal' => "true",

    // Do you wish to send users log emails when they purchase servers, delete servers etc?
    'emails' => true,

    // YouTube animation UUID on login & register page, UUID can be found in the URL of the YouTube video.
    'animation' => 'lRTtMcx6rSM',

    // Default Billing system language
    'language' => 'us',

    // Choose which providers to enable
    'socialite' => [
        'create_account' => true,
        'discord' => true,
        'google' => false,
        'github' => true,
    ],

    'affiliates' => [
        // Discord webhook to send cashout logs to, leave empty to disable
        'webhook' => '',

        // Minimum cashout amount, Units measured on currency
        'cashout' => 10,

        // The part that the creator receives for inviting user that purchases something
        // measured in percentage %; for Example if set to 5, the user will receive 5% of
        // what the invited user has spent 
        'conversion' => 5,

        // Default discount value measured in % that invited users receive
        // if set to 10, the invited user will receive a 10% discount
        'discount' => 10,
    ],



];
