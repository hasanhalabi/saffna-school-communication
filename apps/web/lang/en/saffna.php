<?php

return [
    'auth' => [
        'already_authenticated' => 'You are already signed in.',
        'csrf_mismatch' => 'Your session token expired. Refresh the page and try again.',
        'forbidden' => 'You do not have permission to perform this action.',
        'invalid_credentials' => 'The email or password is incorrect.',
        'throttled' => 'Too many login attempts. Please wait one minute and try again.',
        'unauthenticated' => 'Your session has expired. Please sign in again.',
    ],
    'api' => [
        'not_found' => 'The requested resource was not found.',
        'server_error' => 'An unexpected error occurred. Please try again.',
    ],
    'validation' => [
        'email_invalid' => 'Enter a valid email address.',
        'email_required' => 'Email is required.',
        'failed' => 'Please correct the highlighted fields.',
        'password_required' => 'Password is required.',
        'remember_invalid' => 'The remember-me value is invalid.',
    ],
];
