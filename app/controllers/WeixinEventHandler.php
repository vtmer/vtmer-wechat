<?php

class WeixinEventHandler
{
    public function text()
    {
        $sender = WeixinInput::get('tousername');
        $receiver = WeixinInput::get('fromusername');
        $content = WeixinInput::get('content');

        if ($content[0] == 'v' || $content[0] == 'V') {
            $name = substr($content, 1);
            $user = Contact::where('name', '=', $name)->first();
            if ($user) {
                $response = "$user->name\n>>>>>\n";
                if ($user->phone_number) {
                    $response .= "长号: $user->phone_number\n";
                }
                if ($user->short_number) {
                    $response .= "短号: $user->short_number\n";
                }
                if ($user->qq) {
                    $response .= "QQ: $user->qq";
                }
            } else {
                $response = 'There is no this guy.';
            }
        } else {
            $response = 'hello, vtmer!';
        }
        $message = WeixinMessage::text($receiver, $sender, $response);

        return Response::xml($message);
    }

    public function defaultEvent() {
        $sender = WeixinInput::get('tousername');
        $receiver = WeixinInput::get('fromusername');

        $message = WeixinMessage::text($receiver, $sender, 'hello, vtmer!');

        return Response::xml($message);
    }
}
