<?php

return [
    'xoallowed_mime_ext' => env('XOALLOWED_MIME_EXT', 'png,jpg,jpeg'),
    'xoallowed_mime_type' => env('XOALLOWED_MIME_TYPE', 'image'),
    'xostorage_folder' => env('XOSTORAGE_FOLDER', '\upload'),
    'xostorage_otp_length' => env('XOSTORAGE_OTP_LENGTH', 4),
    'xomobile_country_code' => env('XOMOBILE_COUNTRY_CODE','91'),
    'xofile_log_name' => env('XOFILE_LOG_NAME', 'sql_log'),
    'sms_message_otp' => env('SMS_MESSAGE_OTP', 'Your OTP for login is {{1}} for Golfer\'s Shot
    Powered by Xoxoday'),

    'xodigital_ocean_space_key' => env('XODIGITAL_OCEAN_SPACES_KEY', ''),
    'xodigital_ocean_space_secret' => env('XODIGITAL_OCEAN_SPACES_SECRET', ''),
    'xodigital_ocean_space_endpoint' => env('XODIGITAL_OCEAN_SPACES_ENDPOINT', ''),
    'xodigital_ocean_space_region' => env('XODIGITAL_OCEAN_SPACES_REGION', ''),
    'xodigital_ocean_space_bucket' => env('XODIGITAL_OCEAN_SPACES_BUCKET', ''),
];