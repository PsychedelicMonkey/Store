<?php

namespace App\Enums;

enum PostStatus: string
{
    case Draft = 'draft';
    case Reviewing = 'reviewing';
    case Published = 'published';
    case Rejected = 'rejected';
}
