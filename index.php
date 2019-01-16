<?php

require(__DIR__ . '/env.php');

$result = json_decode(file_get_contents('php://input'));

if (isset($result->message->new_chat_members[0])) {
    foreach ($result->message->new_chat_members as $member) {
        if ($member->is_bot) {
            kick_user($member->id, $member->id);
        }
    }
}

function kick_user($user_id, $chat_id)
{
    $url = 'https://api.telegram.org/bot' . constant("TOKEN") . '/kickChatMember';

    $postfields["user_id"] = $user_id;
    $postfields["chat_id"] = $chat_id;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
    curl_exec($ch);
}

function send_message()
{
    $url = 'https://api.telegram.org/bot' . constant("TOKEN") . '/sendMessage';

    $postfields["chat_id"] = 71359656;
    $postfields["text"] = file_get_contents('php://input');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
    curl_exec($ch);
}