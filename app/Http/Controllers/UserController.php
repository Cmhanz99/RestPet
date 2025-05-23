<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lots;
use App\Models\Payment;
use App\Models\Pet;
use App\Models\Reply;
use App\Models\Status;
use App\Models\Owner;
use App\Models\Form;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class UserController extends Controller
{
    public function index($id){
        $data = Lots::findOrFail($id);
        return view('book', compact('data'));
    }
    public function pets(Request $request, $id){
        try {
            // Validate booking session
            if (!session('booking_id')) {
                return redirect()->back()->with('error', 'Booking session not found. Please login again.');
            }

            // Get the lot by its ID
            $lot = Lots::findOrFail($id);
            // Create new pet record
            $pet = new Pet();
            $pet->name = $request->name;
            $pet->type = $request->type;
            $pet->description = $request->description;
            $pet->death_year = $request->death_year;
            $pet->birth_year = $request->birth_year;
            $pet->booking_id = session('booking_id');
            $pet->lots_id = $lot->id;
            $pet->date = $request->date;

            // Handle image upload
            if($request->hasFile('image')){
                $image = $request->file('image');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $image->move('pets', $imageName);
                $pet->image = $imageName;
            }

            // Save pet first to get its id
            if (!$pet->save()) {
                throw new \Exception('Failed to save pet record');
            }

            // Create payment record linked to pet
            $payment = new Payment();
            $payment->payment = $lot->price;
            $payment->pet_id = $pet->id;
            if (!$payment->save()) {
                throw new \Exception('Failed to save payment record');
            }

            $status = Status::where('lots_id', $lot->id)->first();
            if(!$status){
                $status = new Status();
                $status->lots_id = $lot->id;
                $status->status_acitve = 'available';
                if (!$status->save()) {
                    throw new \Exception('Failed to save status record');
                }
            }

            return redirect()->back()->with('success', 'Pet and payment has waiting for the owners approval!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to save: ' . $e->getMessage());
        }
    }

    public function contact(){
        return view('contact');
    }

    public function reservation(){
        $owner_id = session('owner_id');
        $user = Owner::find($owner_id);
        $message = Form::all();
        $ownerLotIds = Lots::where('owner_id', $owner_id)->pluck('id')->toArray();
        $pets = Pet::whereIn('lots_id', $ownerLotIds)
               ->whereIn('status', ['pending', 'approved', 'rejected'])
               ->get();

        $groupedMessages = $message->groupBy('name')
        ->map(function ($group) {
            return [
                'name' => $group->first()->name,
                'messages' => $group->pluck('message')->toArray(),
                'image' => $group->first()->image
            ];
        });

        return view('reservation', compact('pets', 'user', 'groupedMessages'));
    }

    public function settings(){
        $owner_id = session('owner_id');
        $user = Owner::find($owner_id);
        $message = Form::all();
        $groupedMessages = $message->groupBy('name')
        ->map(function ($group) {
            return [
                'name' => $group->first()->name,
                'messages' => $group->pluck('message')->toArray(),
                'image' => $group->first()->image
            ];
        });
        return view('settings', compact('user', 'groupedMessages'));
    }

    public function approve($id){
        $pet = Pet::find($id);
        $status = Status::where('lots_id', $pet->lots_id)->first();

        $status->status_acitve = 'Occupied';
        $pet->status = 'approved';

        $pet->save();
        $status->save();

        return redirect()->back();
    }

    public function reject($id){
        $pet = Pet::find($id);
        $status = Status::where('lots_id', $pet->lots_id)->first();

        $status->status_acitve = 'Available';

        $pet->status = 'rejected';
        $pet->save();
        $status->save();

        return redirect()->back();
    }

    public function analytics(){
        $owner_id = session('owner_id');
        $user = Owner::find($owner_id);

        return view('analytics', compact('user'));
    }

    public function loginUser(){
        return view('loginUser');
    }

    public function loggedIn(Request $request){
        session()->flush();

        $email = $request->email;
        $password = $request->password;

        $user = Booking::where('email', $email)->first();

        if($user){
            if($user->password == $password){
                session(['booking_id' => $user->id]);
                return redirect('/user');
            }else{
                return redirect()->back()->withInput()->with('password', 'Incorrect password!');
            }
        }else{
            return redirect()->back()->with('error', 'User is cannot found!');
        }
    }

    public function registrationUser(){
        return view('registerUser');
    }
    public function registerUser(Request $request){
        $data = new Booking();

        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = $request->password;

        $image = $request->image;

        if($image){
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('user-profile', $imageName);

            $data->image = $imageName;
        }

        $data->save();
        return redirect()->back()->with('success', 'Registered Successfully');
    }

    public function userHome(){
        $user_id = session('booking_id');
        $user = Booking::find($user_id);
        $lots = Lots::all();

        return view('user', compact('user', 'lots'));
    }

    public function bookingHistory(){
        $user_id = session('booking_id');
        $user = Booking::find($user_id);

        $pets = Pet::where('booking_id', $user_id)->get();
        return view('bookingHistory', compact('user', 'pets'));
    }

    public function userProfile(){
        $user_id = session('booking_id');
        $user = Booking::find($user_id);

        return view('userProfile', compact('user'));
    }

    public function favorites(){
        $user_id = session('booking_id');
        $user = Booking::find($user_id);
        $lots = Lots::all();

        return view('favorite', compact('user', 'lots'));
    }

    public function form(Request $request){
        $form = new Form();
        $user_id = session('booking_id');
        $user = Booking::find($user_id);

        $form->name = $request->name;
        $form->email = $request->email;
        $form->phone = $request->phone;
        $form->message = $request->message;
        $form->image = $user->image;
        $form->form_id = $user_id;

        $form->save();
        return redirect()->back()->with('success', 'Send Successfully');
    }

    public function updatePet(Request $request, $id){
        $pet = Pet::find($id);

        $pet->name = $request->name;
        $pet->type = $request->type;
        $pet->description = $request->description;
        $pet->date = $request->date;

        $image = $request->image;

        if($image){
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('pets', $imageName);

            $pet->image = $imageName;
        }

        $pet->save();
        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function deletePet($id){
        Pet::find($id)->delete();

        return redirect()->back()->with('message', 'Deleted Successfully');
    }

    public function reply(Request $request, $id) {
        $reply = new Reply();
        $owner_id = session('owner_id');
        $user = Owner::find($owner_id);

        $reply->name = $user->name;
        $reply->reply = $request->reply;
        $reply->form_id = $id;
        $reply->user_id = $owner_id;

        $reply->save();

        return redirect()->back()->with('success', 'Reply sent!');
    }

    public function message(){
        $userID = session('booking_id');
        $reply = Reply::where('form_id', $userID)->get();
        $user = Booking::find($userID);

        $recent = Reply::orderBy('reply', 'desc')->first();
        $forms = Form::where('form_id', $userID)->get();

        $owner = Owner::find(  $reply->first()->user_id);

        // Combine both messages into one collection
        $messages = collect();

        foreach ($forms as $form) {
            $messages->push([
                'type' => 'outgoing',
                'text' => $form->message,
                'time' => $form->created_at
            ]);
        }

        foreach ($reply as $replies) {
            $messages->push([
                'type' => 'incoming',
                'text' => $replies->reply,
                'time' => $replies->created_at
            ]);
        }

        // Sort messages by time
        $messages = $messages->sortBy('time');

        // Pass $messages to the view
        return view('message', compact('messages', 'user', 'owner', 'recent'));
    }
    public function ownermessage($id){
        $user = Booking::find($id);
        $reply = Reply::where('form_id', $id)->get();
        $recent = Form::where('form_id',$id)->orderBy('message', 'desc')->first();
        $forms = Form::where('form_id', $id)->get();

        // Combine both messages into one collection
        $messages = collect();

        foreach ($forms as $form) {
            $messages->push([
                'type' => 'incoming',
                'text' => $form->message,
                'time' => $form->created_at
            ]);
        }

        foreach ($reply as $replies) {
            $messages->push([
                'type' => 'outgoing',
                'text' => $replies->reply,
                'time' => $replies->created_at
            ]);
        }

        // Sort messages by time
        $messages = $messages->sortBy('time');

        // Pass $messages to the view
        return view('ownermessage', compact('messages', 'user', 'recent'));
    }

}
