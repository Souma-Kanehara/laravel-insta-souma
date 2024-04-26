<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function show($id) {
        $user = $this->user->findOrFail($id);
        return view('users.profile.show')->with('user', $user);
    }

    public function edit($id) {
        $user = $this->user->findOrFail(Auth::user()->id);
        return view('users.profile.edit')->with('user', $user);
    }

    public function update(Request $request) {
        # 1.Validate teh data
        $request->validate([
            'name' => 'required|min:1|max:50',
            'email' => 'required|email|max:50|unique:users,email,' . Auth::user()->id,
            'avatar' =>'mimes:jpeg,jpg,ong,gif|max:1048',
            'introduction' => 'max:100'
        ]);

        # Activity/Homework
        # 1. Add the error directives on the edit profile page
        # 2. Update the name, email, avatar and introduction
        # 3. Check if the user uploaded and avatar/image, if true then update the avatar
        # 4. Save. Save the update details
        # 5. Redirect to the Show Profile Page
        # Note: Don't forget to create a route

        // $user = $this->user->findOrFail($id);この場合はupdate functionに$idは必要となる
        $user = $this->user->findOrFail(Auth::user()->id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->introduction = $request->introduction;

        if($request->avatar) {
            $user->avatar = 'data:image/' . $request->avatar->extension() . ';base64,' . base64_encode(file_get_contents($request->avatar));
        }
        $user->save();

        // return redirect()->route('profile.show',$id);
        return redirect()->route('profile.show',Auth::user()->id);
        // Note: this " Auth::user()->id" is the id of the current logged-in user
        // セキュリティ面でAuthを使った方がいい
    }

    public function followers($id) {
        $user = $this->user->findOrFail($id);
        return view('users.profile.followers')->with('user', $user);
    }

    public function following($id){
        $user = $this->user->findOrFail($id);
        return view('users.profile.following')->with('user', $user);
    }

    public function passwordupdate(Request $request) {
        $request->validate([
            'new_password' => 'different:old_password|confirmed'
        ]);
        $user = $this->user->findOrFail(Auth::user()->id);
        if(!password_verify($request->old_password, $user->password)){
            return redirect()->back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }

        $user->password = password_hash($request->new_password, PASSWORD_DEFAULT);

        return redirect()->route('profile.show', Auth::user()->id);
    }

}
