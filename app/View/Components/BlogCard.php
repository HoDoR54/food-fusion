<?php

namespace App\View\Components;

use App\Models\Blog;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BlogCard extends Component
{
    public Blog $blog;

    /**
     * Create a new component instance.
     */
    public function __construct(Blog|array $blog)
    {
        // Handle both Blog model and array
        if (is_array($blog)) {
            // Create a Blog model from array data
            $this->blog = new Blog($blog);
            // Set the attributes that might not be fillable
            if (isset($blog['id'])) {
                $this->blog->id = $blog['id'];
            }
            if (isset($blog['created_at'])) {
                $this->blog->created_at = $blog['created_at'];
            }
            if (isset($blog['updated_at'])) {
                $this->blog->updated_at = $blog['updated_at'];
            }
        } elseif ($blog instanceof Blog) {
            $this->blog = $blog;
        } else {
            throw new \InvalidArgumentException('Blog component expects a Blog model or valid array');
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.blog-card');
    }
}
