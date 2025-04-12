<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;


class EventController extends Controller
{
    public function index(Request $request){

        $query = Event::with('user');

        //Filtrage par date
        if($request->has('date')){
            $date = $request->input('date');
            $query->whereDate('start_date', '', $date);
        }

        //Filtrage par lieu
        if($request->has('location')){
            $location = $request->input('location');
            $query->where('location', 'like', "%{$location}%");
        }
        
        //Filtrage par category
        if($request->has('category')){
            $category = $request->input('category');
            $query->where('category', $category);
        }

        $events = $query->orderBy('start_date', 'asc')->get();

        return response()->json($events);

    }

    public function store(Request $request){

        //Verifier si l'utilisateur est admin
        if(!Auth::user()->isAdmin()){
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' =>'required|string',
            'category' => 'nullable|string',
            'max_participants' => 'nullable|integer|min:1',
        ]);

        $event = Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'category' => $request->category,
            'max_participants' => $request->max_participants,
            'user_id' => Auth::id(),
        ]);

        return response()->json($event, 201);

    }

    public function show(Event $event){

        //Charger les relations
        $event->load('user', 'participants');

        return response()->json($event);
    }

    public function update(Request $request, Event $event){

        //Verification si l'utilisateur est admin ou le createur de l'evenement
        if(!Auth::user()->isAdmin() && Auth::id() !== $event->user_id){
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string',
            'category' => 'nullable|string',
            'max_participants' => 'nullable|integer|min:1',
        ]);

        $event->update($request->all());

        return response()->json($event);
    }

    public function destroy(Event $event){

        //Verifier si user est admin ou le createur de l'evenement
        if(Auth::user()->isAdmin() || Auth::id() !== $event->user_id){

            $event->delete();

            return response()->json(['message' => 'Evenement suprime avec success']);
        }
    }
}
