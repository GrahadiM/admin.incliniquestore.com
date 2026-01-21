<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Models\News;
use App\Models\NewsView;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::where('status', '!=', 'deleted')->latest()->get();
        return view('admin.news.index', [
            'news' => $news
        ]);
    }

    public function create()
    {
        return view('admin.news.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:news',
            'content' => 'required',
            'status' => 'required',
            'thumbnail' => 'image|nullable',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
        ]);

        $thumbnail = $request->hasFile('thumbnail') ? $request->file('thumbnail')->store('news', 'public') : null;

        News::create([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'slug' => Str::slug($request->slug),
            'thumbnail' => $thumbnail,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'is_featured' => $request->has('is_featured'),
            'status' => $request->status,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
        ]);

        return redirect()->route('super-admin.news.index')->with('success','Berita berhasil ditambahkan');
    }

    public function show(News $news, Request $request)
    {
        // $news->increment('views');
        $this->countView($news, $request);

        return view('admin.news.show', [
            'news' => $news
        ]);
    }

    public function preview($slug)
    {
        $news = News::where('slug', $slug)->firstOrFail();
        return view('admin.news.preview', compact('news'));
    }

    protected function countView(News $news, Request $request)
    {
        if ($this->isBot($request->userAgent())) return;

        $ip = $request->ip();
        $userId = auth()->id();
        $today = now()->toDateString();

        $exists = NewsView::where('news_id', $news->id)
            ->whereDate('view_date', $today)
            ->where(function($q) use ($ip, $userId) {
                if ($userId) $q->where('user_id', $userId);
                else $q->where('ip_address', $ip);
            })
            ->exists();

        if (!$exists) {
            NewsView::create([
                'news_id' => $news->id,
                'user_id' => $userId,
                'ip_address' => $ip,
                'user_agent' => request()->userAgent(),
                'view_date' => $today,
            ]);

            $news->increment('views');
        }
    }

    protected function isBot($userAgent)
    {
        if (!$userAgent) return true;
        $bots = ['bot','crawl','spider','slurp','facebook','whatsapp'];
        foreach ($bots as $bot) if (stripos($userAgent, $bot) !== false) return true;
        return false;
    }

    public function analytics(Request $request)
    {
        $startDate = $request->start_date ?? now()->subDays(30)->toDateString();
        $endDate = $request->end_date ?? now()->toDateString();

        $newsViews = News::withCount(['viewsLogs as views_count' => function($q) use ($startDate, $endDate) {
            $q->whereBetween('view_date', [$startDate, $endDate]);
        }])->orderByDesc('views_count')->get();

        $dailyViews = NewsView::select(DB::raw('view_date, COUNT(*) as total'))
            ->whereBetween('view_date', [$startDate, $endDate])
            ->groupBy('view_date')
            ->orderBy('view_date')
            ->get();

        $hourlyHeat = NewsView::select(DB::raw('HOUR(created_at) as hour, COUNT(*) as total'))
            ->whereBetween('view_date', [$startDate, $endDate])
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        return view('admin.news.analytics', compact('newsViews','dailyViews','hourlyHeat','startDate','endDate'));
    }

    public function edit(News $news)
    {
        return view('admin.news.form', [
            'news' => $news
        ]);
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:news,slug,' . $news->id,
            'content' => 'required',
            'status' => 'required',
            'thumbnail' => 'image|nullable',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($news->thumbnail) Storage::disk('public')->delete($news->thumbnail);
            $news->thumbnail = $request->file('thumbnail')->store('news', 'public');
        }

        $news->update([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'slug' => Str::slug($request->slug),
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'is_featured' => $request->has('is_featured'),
            'status' => $request->status,
        ]);

        return redirect()->route('super-admin.news.index')->with('success','Berita berhasil diperbarui');
    }

    public function destroy(News $news)
    {
        $news->update(['status' => 'deleted']);

        return redirect()->route('super-admin.news.index')->with('success','Berita berhasil dihapus');
    }
}
