<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Images extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ref_key',
        'title',
        'description',
        'img_path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the full URL for the image
     *
     * @return string|null
     */
    public function getImageUrlAttribute()
    {
        if (!$this->img_path) {
            return null;
        }

        // If it's already a full URL, return as is
        if (filter_var($this->img_path, FILTER_VALIDATE_URL)) {
            return $this->img_path;
        }

        // If it starts with http or https, return as is
        if (str_starts_with($this->img_path, 'http://') || str_starts_with($this->img_path, 'https://')) {
            return $this->img_path;
        }

        // Generate storage URL
        return asset('storage/' . $this->img_path);
    }

    /**
     * Get the file path for storage operations
     *
     * @return string|null
     */
    public function getFilePathAttribute()
    {
        return $this->img_path ? storage_path('app/public/' . $this->img_path) : null;
    }

    /**
     * Check if image file exists
     *
     * @return bool
     */
    public function imageExists()
    {
        if (!$this->img_path) {
            return false;
        }

        return Storage::disk('public')->exists($this->img_path);
    }

    /**
     * Delete image file from storage
     *
     * @return bool
     */
    public function deleteImageFile()
    {
        if ($this->img_path && $this->imageExists()) {
            return Storage::disk('public')->delete($this->img_path);
        }

        return true;
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Delete image file when model is deleted
        static::deleted(function ($image) {
            $image->deleteImageFile();
        });
    }

    /**
     * Scope to filter by ref_key
     */
    public function scopeByRefKey($query, $refKey)
    {
        return $query->where('ref_key', $refKey);
    }

    /**
     * Scope to filter by title
     */
    public function scopeByTitle($query, $title)
    {
        return $query->where('title', 'like', '%' . $title . '%');
    }

    /**
     * Create image from uploaded file
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string|null $refKey
     * @param string|null $title
     * @param string|null $description
     * @return static
     */
    public static function createFromFile($file, $refKey = null, $title = null, $description = null)
    {
        $path = $file->store('images', 'public');
        
        return static::create([
            'ref_key' => $refKey,
            'title' => $title ?: $file->getClientOriginalName(),
            'description' => $description,
            'img_path' => $path,
        ]);
    }

    /**
     * Update image file
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return bool
     */
    public function updateFile($file)
    {
        // Delete old file
        $this->deleteImageFile();
        
        // Store new file
        $path = $file->store('images', 'public');
        
        // Update model
        return $this->update([
            'img_path' => $path,
            'title' => $this->title ?: $file->getClientOriginalName(),
        ]);
    }
}