<?php

namespace App\Http\Controllers;

use App\Models\Lots;
use App\Models\Owner;
use App\Models\Pet;
use App\Models\Status;
use App\Models\Form;
use Illuminate\Http\Request;

class LotController extends Controller
{
    public function home(){
        $lots = Lots::all();

        return view('welcome', compact('lots'));
    }

    public function login(Request $request){
        session()->flush();

        $email = $request->email;
        $password = $request->password;

        $user = Owner::where('email', $email)->first();

        if($user){
            if($user->password == $password){
                session(['owner_id' => $user->id]);
                return redirect('/dashboard');
            }else{
                return redirect()->back()->with('password', 'Incorrect password!');
            }
        }else{
            return redirect()->back()->with('error', 'User is not registered yet!');
        }
    }

    public function index(){
        return view('login');
    }

    public function registration(){
        return view('register');
    }

    public function register(Request $request){
        $data = new Owner();

        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = $request->password;

        $image = $request->profile;

        if($image){
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $request->profile->move('profile', $imageName);

            $data->profile = $imageName;
        }

        $data->save();
        return redirect()->back()->with('success', 'Registered Successfully');
    }

    public function dashboard()
    {
        $owner_id = session('owner_id');
        $user = Owner::find($owner_id);
        $properties = Lots::where('owner_id', $owner_id)->get();
        $message = Form::all();

        $groupedMessages = $message->groupBy('name')
            ->map(function ($group) {
                return [
                    'name' => $group->first()->name,
                    'messages' => $group->pluck('message')->toArray(),
                    'image' => $group->first()->image
                ];
            });

        return view('dashboard', compact('user', 'properties', 'groupedMessages'));
    }

    public function addProperty(){
        $owner_id = session('owner_id');
        $user = Owner::find($owner_id);
        return view('addProperty', compact('user'));
    }

    public function add(Request $request){
        $property = new Lots();

        $property->title = $request->title;
        $property->type = $request->type;
        $property->area = $request->area;
        $property->size = $request->size;
        $property->slots = $request->slots;
        $property->price = $request->price;
        $property->marker = $request->marker;
        $property->description = $request->description;
        $property->status = $request->status;
        $property->owner_id = session('owner_id');

        $image = $request->image;

        if($image){
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('lots', $imageName);

            $property->image = $imageName;
        }

        $property->save();
        return redirect()->back()->with('success', 'Memorial Garden added successfully!');;
    }

    public function delete($id){
        Lots::find($id)->delete();

        return redirect()->back();
    }
    public function memorial(){
        $owner_id = session('owner_id');
        $user = Owner::find($owner_id);
        $message = Form::all();
        $pet = Pet::where('status', 'approved')->get();
        $lots = Lots::where('owner_id', $owner_id)->paginate(1);

        $groupedMessages = $message->groupBy('name')
            ->map(function ($group) {
                return [
                    'name' => $group->first()->name,
                    'messages' => $group->pluck('message')->toArray(),
                    'image' => $group->first()->image
                ];
            });

        return view('memorial',compact('user', 'lots', 'pet', 'groupedMessages'));
    }

    public function editLot($id){
        $owner_id = session('owner_id');
        $user = Owner::find($owner_id);
        $lot = Lots::find($id);
        $message = Form::all();
        $groupedMessages = $message->groupBy('name')
        ->map(function ($group) {
            return [
                'name' => $group->first()->name,
                'messages' => $group->pluck('message')->toArray(),
                'image' => $group->first()->image
            ];
        });

        return view('editPlot', compact('user', 'lot', 'groupedMessages'));

    }

    public function update(Request $request ,$id){
        $update = Lots::find($id);

        $update->title = $request->title;
        $update->type = $request->type;
        $update->area = $request->area;
        $update->size = $request->size;
        $update->slots = $request->slots;
        $update->price = $request->price;
        $update->marker = $request->marker;
        $update->description = $request->description;
        $update->status = $request->status;
        $update->owner_id = session('owner_id');

        $image = $request->image;

        if($image){
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('lots', $imageName);

            $update->image = $imageName;
        }

        $update->save();

        return redirect()->back()->with('success', 'Garden updated successfully!.');
    }

    // public function available($id){
    //     $active = Status::find($id);

    //     $active
    // }
}
