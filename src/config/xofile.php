<?php

return [
    'xoallowed_file_types' => env('XOALLOWED_FILE_TYPES', 'png,jpg,jpeg'),
    'xostorage_folder' => env('XOSTORAGE_FOLDER', '\upload'),
    'xostorage_otp_length' => env('XOSTORAGE_OTP_LENGTH', 4),
    'sms_message_otp' => env('SMS_MESSAGE_OTP', 'Your OTP for login is {{1}} for Golfer\'s Shot
    Powered by Xoxoday'),
];