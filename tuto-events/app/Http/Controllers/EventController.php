<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\middleware;

class EventController extends Controller
{
    
    public function __construct() {

        $this->middleware('auth', ['only' => ['create', 'store']]);
    }
    
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::where('starts_at', '>=', now())
                        ->with(['user', 'tags'])
                        ->orderBy('starts_at', 'asc')
                        ->get();

        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $authed_user = auth()->user();
        $amount= 1500;

        if($request->filled('premium')) $amount += 500;

        $authed_user->charge($amount, $request->payment_method, [ 'return_url' => route('event.index')]);

        $event = $authed_user->events()->create([
             'title' => $request->title,
             'slug' => Str::slug($request->title),
             'content' => $request->content,
             'premium' => $request->filled('premium'),
             'starts_at' => $request->starts_at,
             'ends_at' => $request->ends_at
        ]);

        $tags = explode(',', $request->tags);

        foreach ($tags as $inputTag) {
            $inputTag = trim($inputTag);


            $tag = Tag::firstOrCreate([
                'slug' => Str::slug($inputTag)
            ], [
                'name' => $inputTag
            ]); 
            
            $event->tags()->attach($tag->id);//replace ->tag() by ->tags()

        }

        return redirect()->route('event.index');
            
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
