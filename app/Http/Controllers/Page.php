<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class Page extends Controller
{

    public function clients(){

        if(auth()->user()->role !== 'super_admin' && auth()->user()->role !== 'manager'){
            return redirect('/');
        }


        $clients = User::where('role', 'client')->get();

        return view('clients', [
            'clients' => $clients
        ]);
    }

    public function clientsAdd(): View{


        return view('clients-add');
    }

    public function clientsStore(Request $request): RedirectResponse{


        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'adwords_id' => 'required|numeric'
        ]);


        $user_data = $request->all();
        $password = $user_data['password'];
        $user_data['password'] = Hash::make($password);
        $user_data['role'] = 'client';
        $user_data['client_services'] = json_encode([
            'credit' => 0,
            'mobile' => 0,
            'analytics' => 0,
            'conversions' => 0
        ]);
        unset($user_data['_token']);

        $user = User::firstOrCreate($user_data);

        if($user->wasRecentlyCreated){
            $user->notify(new PasswordReset($password));
            session()->flash('message', 'לקוח נוצר בהצלחה');
        }else{
            session()->flash('message', 'שגיאה');
        }

        return redirect()->route('page.clients')->with('message', 'לקוח נוצר בהצלחה');

    }

    public function clientsEdit($id): View{

        $user = User::where('id', $id)->first();


        return view('clients-edit', [
            'user' => $user
        ]);

    }

    public function clientsUpdate(Request $request): RedirectResponse{


        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'adwords_id' => 'required|numeric'
        ]);

        $user = User::where('id', $request->client_id)->first();

        if($user){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->adwords_id = $request->adwords_id;

            $user->save();
        }

        return redirect()->route('page.clients')->with('message', 'לקוח עודכן בהצלחה');

    }

    public function resetPassword(User $user){


        if(auth()->user()->role === 'super_admin' || auth()->user()->role === 'manager'){
            $newPassword = Str::random(10);
            $user->password = Hash::make($newPassword);
            $user->save();
            $user->notify(new PasswordReset($newPassword));
            return redirect()->route('page.clients')->with('message', 'נשלח מייל עם סיסמא חדשה ללקוח');
        }else{
            return redirect()->route('page.clients')->with('message', 'אין לך הרשאות לביצוע פעולה');
        }

    }
}
