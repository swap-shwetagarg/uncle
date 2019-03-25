<?php

return array(
    'uncleFitterMechdevIOS' => array(
        'environment' => 'development',
        'certificate' => config_path() . '/push-notification-certificates/ios/development/apns-unclefitter-mechanic.pem',
        'passPhrase' => 'zenSar@88',
        'service' => 'apns'
    ),
    'uncleFitterMechproIOS' => array(
        'environment' => 'production',
        'certificate' => config_path() . '/push-notification-certificates/ios/production/apns-unclefitter-mechanic.pem',
        'passPhrase' => 'zenSar@88',
        'service' => 'apns'
    ),
    'uncleFitterUserdevIOS' => array(
        'environment' => 'development',
        'certificate' => config_path() . '/push-notification-certificates/ios/development/apns-unclefitter-user.pem',
        'passPhrase' => 'zenSar@88',
        'service' => 'apns'
    ),
    'uncleFitterUserproIOS' => array(
        'environment' => 'production',
        'certificate' => config_path() . '/push-notification-certificates/ios/production/apns-unclefitter-user.pem',
        'passPhrase' => 'zenSar@88',
        'service' => 'apns'
    ),
    'uncleFitterUserproIOSP8' => array(
        'private_key_path' => config_path() . '/push-notification-certificates/ios/AuthKey_7F2ESGV4VL.p8',
        'key_id' => '7F2ESGV4VL', // The Key ID obtained from Apple developer account
        'team_id' => '6E629KV6S2', // The Team ID obtained from Apple developer account
        'app_bundle_id' => 'com.encoresky.unclefitter.user', // The bundle ID for app obtained from Apple developer account
        'private_key_secret' => null // Private key secret
    ),
    'uncleFitterMechproIOSP8' => array(
        'private_key_path' => config_path() . '/push-notification-certificates/ios/AuthKey_7F2ESGV4VL.p8',
        'key_id' => '7F2ESGV4VL', // The Key ID obtained from Apple developer account
        'team_id' => '6E629KV6S2', // The Team ID obtained from Apple developer account
        'app_bundle_id' => 'com.encoresky.unclefitter.mechanic', // The bundle ID for app obtained from Apple developer account
        'private_key_secret' => null // Private key secret
    ),
    'uncleFitterUserProductionIOSP8' => array(
        'private_key_path' => config_path() . '/push-notification-certificates/ios/AuthKey_MZ4B64Q79G.p8',
        'key_id' => 'MZ4B64Q79G', // The Key ID obtained from Apple developer account
        'team_id' => '45DNAU9QS3', // The Team ID obtained from Apple developer account
        'app_bundle_id' => 'com.unclefitter.user', // The bundle ID for app obtained from Apple developer account
        'private_key_secret' => null // Private key secret
    ),
    'uncleFitterMechProductionIOSP8' => array(
        'private_key_path' => config_path() . '/push-notification-certificates/ios/AuthKey_MZ4B64Q79G.p8',
        'key_id' => 'MZ4B64Q79G', // The Key ID obtained from Apple developer account
        'team_id' => '45DNAU9QS3', // The Team ID obtained from Apple developer account
        'app_bundle_id' => 'com.unclefitter.mechanic', // The bundle ID for app obtained from Apple developer account
        'private_key_secret' => null // Private key secret
    ),
    'uncleFitterMechdevAndroid'=>array(
		'environment' => 'development',
		'apiKey'      => 'AIzaSyDaJw0fOFaI_-fgdRlnx4HkZBs1eUTgkws',
		'service'     => 'gcm'
    ),
    'uncleFitterMechproAndroid'=>array(
		'environment' => 'production',
		'apiKey'      => 'AIzaSyDaJw0fOFaI_-fgdRlnx4HkZBs1eUTgkws',
		'service'     => 'gcm'
    ),
    'uncleFitterUserdevAndroid'=>array(
		'environment' => 'development',
		'apiKey'      => 'AIzaSyB7YUyqjnzd8ON8wkXecx_iRhDzdtLHHB4',
		'service'     => 'gcm'
    ),
    'uncleFitterUserproAndroid'=>array(
		'environment' => 'production',
		'apiKey'      => 'AIzaSyB7YUyqjnzd8ON8wkXecx_iRhDzdtLHHB4',
		'service'     => 'gcm'
    )
);