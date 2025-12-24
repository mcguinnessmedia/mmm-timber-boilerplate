<?php

namespace MMM\Models;

use Timber\Post as TimberPost;

class Post extends TimberPost
{
  public function excerpt(array $options = []): string
  {
    $length = $options['words'] ?? 20;

    return wp_trim_words($this->content(), $length);
  }

  public function readTime(): int
  {
    $wordCount = str_word_count(strip_tags($this->content()));
    return (int)ceil($wordCount / 200);
  }
}