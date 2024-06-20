<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

// terminal 'php artisan make:controller Auth/UsersController (makes UsersControllers in a new folder 'Auth')

class UsersController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index(Request $request)
    {
        if ($request->search) {
            $all_users = $this->user->where('name', 'LIKE', '%' . $request->search . '%')->orderBy('name')->withTrashed()->paginate(10);
        } else {
        $all_users = $this->user->orderBy('name')->withTrashed()->paginate(10); //it adds additional pages every 10 users
        // paginate(n) - return records of a page with n items each
        // withTrashed - show records, including soft-deleted records
        }
        return view('admin.users.index')
            ->with('all_users', $all_users)
            ->with('search', $request->search);

    }

    public function deactivate($id)
    {
        $this->user->destroy($id);

        return redirect()->back();
    }

    public function activate($id)
    {
        //restore()
        $this->user->onlyTrashed()->findOrFail($id)->restore();

        return redirect()->back();
        //onlyTrashed() - only the soft-deleted records
    }
}
