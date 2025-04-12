<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Registrationn;
use Illuminate\Support\Facades\Auth;

class RegistrationnController extends Controller
{
    public function register(Request $request, Event $event){

        //Verifier si user est deja inscrit
        $existingRegistration = Registrationn::where('user_id', Auth::id())
        ->where('event_id', $event->id)
        ->first();

        if($existingRegistration){
            
            return response()->json(['message' => 'Vous etes deja inscrit à cet evenement'], 400);
        }

        //Verifie si l'evenement a atteint le nombre maximum de participants
        if($event->max_participants){

            $currentRegistration = Registrationn::where('event_id', $event->id)->count();
            if($currentRegistration >= $event->max_participants){
                return response()->json(['message' => 'Cet evenement a atteint sa limite de participants']);
            }
        }

        //Creer l'inscription
        $registration = Registrationn::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
        ]);

        return response()->json([
            'message' => 'Vous etes inscrit à l\'evenement',
            'registration' => $registration,
        ], 201);
    }

    public function cancel(Request $request, Event $event){

        $registration = Registrationn::where('user_id', Auth::id())
        ->where('event_id', $event->id)
        ->first();

        if(!$registration){
            return response()->json(['message' => 'Vous n\'etes pas inscrit à cet evenemnt'], 400);
        }

        $registration->delete();

        return response()->json(['message' => 'Evenement supprime avec success']);

    }

    public function getUserRegistration(){

        $registration = Auth::user()->registeredEvents()->with('user')->get();

        return response()->json($registration);
    }

    public function getEventParticipants(Event $event){

        //Verifier si user est admin ou le createur de l'evenement
        if(!Auth::user()->isAdmin() && Auth::id() !== $event->user_id){
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $participants = $event->participants()->get();

        return response()->json($participants);
    }
}
