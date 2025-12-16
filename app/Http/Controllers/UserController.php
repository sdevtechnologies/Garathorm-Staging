<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        $search ="";
        // Searching
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        }


        $users = $query->orderBy('created_at','desc')->sortable()->paginate(15);
        return view('user.index', compact('users','search'));
    }
    public function create(){

        return view('user.create');
    }

   
    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        $user->role = $user->roles->pluck('id')[0];
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Code to update the User

        // Validate the incoming request data

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => 'required',
        ]);
        
         // Create a new instance of the User model
         $user = User::findOrFail($id);
         if ($user){
             // Set the attributes on the model instance
            $user->name = $request->name;
            $user->email = $request->email;
            if (trim($request->password)!==''){  
            $user->password = Hash::make($request->password);
            }
    
            // update the User to the database
            $user->save();
            $user->syncRoles([]);
            $user->roles()->attach($request->role);
            return redirect()->route('user.index')->with('success', 'User updated successfully.');
        }else{
            return redirect()->route('user.index')->with('error', 'User maybe updated or deleted, please try again.');
        }

        
    }



    public function deleteSelected(Request $request)
    {
        try {
            $selectedIds = $request->input('selectedIds');
            if (!empty($selectedIds)) {
                User::whereIn('id', explode(',', $selectedIds))->delete();
                return redirect()->route('user.index')->with('success', 'Selected Users deleted successfully.');
            } else {
                return redirect()->route('user.index')->with('error', 'No User selected for deletion.');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function copySelected(Request $request)
    {
        try {
            $selectedIds = $request->input('selectedCopyIds');
            if (!empty($selectedIds)) {
                $Users = User::whereIn('id', explode(',', $selectedIds))->get();
                foreach($Users as $key => $User){
                    $newUser = $User->replicate();
                    $newUser->created_at = Carbon::now();
                    $newUser->save();
                }
                return redirect()->route('user.index')->with('success', 'Selected Users copied successfully.');
            } else {
                return redirect()->route('user.index')->with('error', 'No User selected for copy.');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }


}
