<?php
namespace Codeception\PHPUnit\Constraint;

use Codeception\Lib\Console\Message;

class Page extends \PHPUnit\Framework\Constraint\Constraint
{
    protected $uri;
    protected $string;

    public function __construct($string, $uri = '')
    {
        $this->string = $this->normalizeText((string)$string);
        $this->uri = $uri;
    }

    /**
     * Evaluates the constraint for parameter $other. Returns true if the
     * constraint is met, false otherwise.
     *
     * @param mixed $other Value or object to evaluate.
     *
     * @return bool
     */
    protected function matches($other) : bool
    {
        $other = $this->normalizeText($other);
        return mb_stripos($other, $this->string, null, 'UTF-8') !== false;
    }

    /**
     * @param $text
     * @return string
     */
    private function normalizeText($text)
    {
        $text = strtr($text, "\r\n", "  ");
        return trim(preg_replace('/\\s{2,}/', ' ', $text));
    }

    /**
     * Returns a string representation of the constraint.
     *
     * @return string
     */
    public function toString() : string
    {
        return sprintf(
            'contains "%s"',
            $this->string
        );
    }

    protected function failureDescription($pageContent) : string
    {
        $message = $this->uriMessage('on page');
        $message->append("\n--> ");
        $message->append(mb_substr($pageContent, 0, 300, 'UTF-8'));
        if (mb_strlen($pageContent, 'UTF-8') > 300) {
            $debugMessage = new Message(
                "[Content too long to display. See complete response in '" . codecept_output_dir() . "' directory]"
            );
            $message->append("\n")->append($debugMessage);
        }
        $message->append("\n--> ");
        return $message->getMessage() . $this->toString();
    }

    protected function uriMessage($onPage = "")
    {
        if (!$this->uri) {
            return new Message('');
        }
        $message = new Message($this->uri);
        $message->prepend(" $onPage ");
        return $message;
    }
}
