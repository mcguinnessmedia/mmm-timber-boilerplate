<?php

namespace MMM\Models;

use Timber\Post as TimberPost;

class Post extends TimberPost
{
  public function acf(): ?array
  {
    return get_fields($this->ID);
  }
}