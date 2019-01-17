<?php

require(__DIR__ . '/env.php');

$result = json_decode(file_get_contents('php://input'));

if (isset($result->message->new_chat_members[0])) {
    foreach ($result->message->new_chat_members as $key => $member) {
        if ($key == 0) {
            kick_user($result->message->from->id, $result->message->chat->id);
        }
        if ($member->is_bot) {
            kick_user($member->id, $result->message->chat->id);
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