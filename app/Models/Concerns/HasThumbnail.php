<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Storage;

trait HasThumbnail
{
    /**
     * Public URL of the uploaded thumbnail, or null when the file is not on disk.
     */
    public function getThumbUrlAttribute(): ?string
    {
        if (empty($this->thumbnail_img) || ! Storage::exists($this->thumbnail_img)) {
            return null;
        }

        return url('storage/' . $this->thumbnail_img);
    }
}
