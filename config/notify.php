<?php

return [
    "user_id" => env("NOTIFY_USER_ID"),
    "api_key" => env("NOTIFY_API_KEY"),
    "sender_id" => env("NOTIFY_SENDER_ID") ?? "NotifyDEMO",
];
