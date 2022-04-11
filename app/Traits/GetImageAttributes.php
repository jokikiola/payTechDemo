<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

/**
 * Trait getImageAttributes
 */
trait GetImageAttributes
{
    /**
     * get Image Full Url
     * @param string|null $value
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\UrlGenerator|string|null
     */
    public function getImagePathAttribute(?string $value)
    {
        return (!$value || filter_var($value, FILTER_VALIDATE_URL)) ? $value : url(Storage::url($value));
    }
}
