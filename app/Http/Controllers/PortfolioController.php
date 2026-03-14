<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function home()
    {
        return view('home', [
            'featuredProjects' => Project::active()->featured()->ordered()->with('category')->limit(5)->get(),
            'categories' => Category::active()->get(),
            'services' => Service::active()->limit(6)->get(),
            'testimonials' => Testimonial::active()->limit(5)->get(),
        ]);
    }

    public function projects()
    {
        return view('projects', [
            'projects' => Project::active()->ordered()->with('category')->get(),
            'categories' => Category::active()->get(),
        ]);
    }

    public function project(Project $project)
    {
        abort_if(! $project->is_active, 404);
        $ordered = Project::active()->ordered()->pluck('id');
        $currentIndex = $ordered->search($project->id);

        return view('project', [
            'project' => $project->load('category'),
            'previous' => $currentIndex > 0 ? Project::find($ordered[$currentIndex - 1]) : null,
            'next' => $currentIndex < $ordered->count() - 1 ? Project::find($ordered[$currentIndex + 1]) : null,
        ]);
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function blog()
    {
        return view('blog', [
            'posts' => Post::published()->paginate(9),
            'categories' => Category::active()->get(),
        ]);
    }

    public function post(Post $post)
    {
        abort_if(! $post->is_published, 404);

        return view('post', ['post' => $post]);
    }

    public function sitemap()
    {
        $projects = Project::active()->ordered()->get();
        $posts = Post::published()->get();

        return response()->view('sitemap', compact('projects', 'posts'))
            ->header('Content-Type', 'application/xml');
    }
}
