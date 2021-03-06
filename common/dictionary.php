<?php

class dictionary implements Iterator
{
  private $words = array();

  public function __construct()
  {
    if(!file_exists(INCLUDE_PATH . "common/simple-dictionary.txt"))
      die("Could not find " . INCLUDE_PATH . "common/simple-dictionary.txt\n");

    $handle = fopen(INCLUDE_PATH . "common/simple-dictionary.txt", 'r');
    while(($line = fgets($handle)) !== false)
      $this->words[] = trim($line);

    fclose($handle);
  }

  public function matchingwords($str, $min_word_length = 0)
  {
    global $options;
    if($min_word_length == 0)
      $min_word_length = $options['match-length'];

    $str = strip_whitespace($str);
    $matches = array();

    for($i=0; $i<count($this->words); $i++)
      {
        if(CIPHERTEXT_CASE =="lowercase") $test = strtolower($this->words[$i]);
        else if(CIPHERTEXT_CASE =="uppercase") $test = strtoupper($this->words[$i]);
        else $test = $this->words[$i];

        if(strlen($test) >= $min_word_length && (strpos($str, $test) !== false))
          $matches[] = $test;
      }
    return $matches;
  }

  public function rewind() {
    reset($this->words);
  }

  public function current() {
    $var = current($this->words);
    return $var;
  }

  public function key() {
    $var = key($this->words);
    return $var;
  }

  public function next() {
    $var = next($this->words);
    return $var;
  }

  public function valid() {
    $var = $this->current() !== false;
    return $var;
  }
}