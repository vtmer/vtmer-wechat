<?php

class WeixinEventHandler
{
    /**
     * 发送者
     */
    private $sender;

    /**
     * 接受者
     */
    private $receiver;

    public function __construct()
    {
        $this->sender = WeixinInput::get('tousername');
        $this->receiver = WeixinInput::get('fromusername');
        $user = User::find($this->receiver);
        if (!$user) {
            $user = new User();
            $user->open_id = $this->receiver;
            $user->save();
        }
        $user->touch();
        $this->user = $user;
    }

    public function text()
    {
        $content = WeixinInput::get('content');

        if (!$this->user->is_in_group_by_name('vtmer')) {
            if ($this->join_vtmer($content)) {
                $response = Config::get('weixinText')['join_vtmer'];
                $message = WeixinMessage::text(
                    $this->receiver, $this->sender, $response);
                return Response::xml($message);
            }
        }

        if ($this->user->is_in_group_by_name('vtmer')) {
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
        } else {
            $response = 'hello, world';
        }
        $message = WeixinMessage::text(
            $this->receiver, $this->sender, $response);

        return Response::xml($message);
    }

    public function subscribe()
    {
        $this->user->join_group_by_name('subscriber');
        $response = Config::get('weixinText')['subscribe'];

        $message = WeixinMessage::text(
            $this->receiver, $this->sender, $response);

        return Response::xml($message);
    }

    public function defaultEvent() {
        $message = WeixinMessage::text($this->receiver, $this->sender, 'hello, vtmer!');

        return Response::xml($message);
    }

    private function join_vtmer($content)
    {
        $vtmer_code = Config::get('weixinText')['vtmer_code'];
        if ($content === $vtmer_code) {
            $this->user->join_group_by_name('vtmer');
            return true;
        } else {
            return false;
        }
    }
}
