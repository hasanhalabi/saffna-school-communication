<?php

return [
    'auth' => [
        'already_authenticated' => 'You are already signed in.',
        'csrf_mismatch' => 'Your session token expired. Refresh the page and try again.',
        'forbidden' => 'You do not have permission to perform this action.',
        'invalid_credentials' => 'The email or password is incorrect.',
        'password_change_required' => 'Change your temporary password before continuing.',
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
        'current_password_invalid' => 'The current password is incorrect.',
        'current_password_required' => 'Current password is required.',
        'new_password_confirmation' => 'The new password confirmation does not match.',
        'new_password_different' => 'The new password must be different from the current password.',
        'new_password_policy' => 'Use at least 12 characters with uppercase and lowercase letters and a number.',
        'new_password_required' => 'New password is required.',
        'password_required' => 'Password is required.',
        'password_confirmation_required' => 'Confirm the new password.',
        'remember_invalid' => 'The remember-me value is invalid.',
    ],
];
