<?php
namespace MyApp\Exception;

class DuplicateJournal extends \Exception{
    protected $message = '投稿済みの内容です';
}