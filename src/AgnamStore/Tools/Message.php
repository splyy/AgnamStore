<?php
namespace AgnamStore\Tools;

class Message {
    private $message;
    private $class;
    
    public function getMessage() {
        return $this->message;
    }

    public function getClass() {
        return $this->class;
    }

    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    public function setClass($class) {
        $this->class = $class;
        return $this;
    }

    public function __construct($message, $class) {
        $this->message = $message;
        $this->class   = $class;
    }

}
