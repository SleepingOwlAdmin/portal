<?php

namespace App\Services;

use App\User;

class MarkdownParser extends \ParsedownExtra
{
    /**
     * @param string $text
     *
     * @return array
     */
    public static function parseText($text)
    {
        $parser = new static();

        $pattern = "/<cut([\s]+)?(\/)?>(?<button_text>[a-zA-Zа-яА-Я\s]+)?(<([\s]+)?\/([\s]+)?cut>)?/si";
        preg_match($pattern, $text, $matches);

        $buttonText = '';
        $intro = '';

        if (! empty($matches)) {
            list($intro, $text) = preg_split($pattern, $text, 2); // split text to intro anx full text
            if (! empty($matches['button_text'])) {
                $buttonText = $matches['button_text'];
            }
        }

        if (! empty($intro)) {
            $intro = $parser->text($intro);
        }

        $text = $parser->text($text);

        return [
            'intro' => $intro,
            'text' => $text,
            'button_text' => $buttonText,
            'mentioned_users' => $parser->getMentionedUsers(),
        ];
    }

    /**
     * @param string $comment
     *
     * @return array
     */
    public static function parseComment($comment)
    {
        $parser = new static();

        foreach (['#', '-', ':', '=', '|'] as $item) {
            $parser->disableType($item);
        }

        $comment = $parser->text(
            $comment
        );

        return [
            'comment' => $comment,
            'mentioned_users' => $parser->getMentionedUsers(),
        ];
    }

    /**
     * @var array;
     */
    protected $mentionedUsers = [];

    public function __construct()
    {
        $this->InlineTypes['@'] = ['UserMention'];
        $this->inlineMarkerList .= '@';
    }

    /**
     * @return array
     */
    public function getMentionedUsers()
    {
        return $this->mentionedUsers;
    }

    /**
     * @param array $Excerpt
     *
     * @return array
     */
    protected function inlineUserMention($Excerpt)
    {
        if (preg_match('/@(?<username>[\w\.]+)/is', $Excerpt['text'], $matches)) {
            $username = $matches['username'];

            if (! empty($username)) {
                if ($user = User::where('name', $username)->first()) {
                    $this->mentionedUsers[] = $user;

                    return [
                        'extent' => strlen($matches[0]),
                        'element' => [
                            'name' => 'a',
                            'text' => $user->name,
                            'attributes' => [
                                'href' => $user->profile_link // Link to profile
                            ],
                        ],
                    ];
                }

                return [
                    'extent' => strlen($matches[0]),
                    'element' => [
                        'name' => 'span',
                        'text' => $username,
                        'attributes' => [
                            'class' => 'mentioned-user'
                        ],
                    ],
                ];
            }
        }
    }

    /**
     * @param string $item
     */
    protected function disableType($item)
    {
        unset($this->BlockTypes[$item]);
    }
}