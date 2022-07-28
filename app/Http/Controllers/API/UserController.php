<?php

namespace App\Http\Controllers\API;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use \Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

use App\Models\User;

class UserController extends Controller
{

    public function allUsers(Request $request)
    {
        $page = $request->input('page') ?:1;

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        $perPage = 3;
        
        $query = \DB::table('users');

        $paginate = [
            'page' => $query->count(),
            'per_page' => $perPage,
            'current_page' => (int)$page,
            'total_pages' => ceil($query->count() / $perPage)
            ];

        $count = $query->count();
        $total_pages = ceil($query->count() / $perPage);

        $users = $query
        ->skip($perPage * ($page - 1))
        ->take($perPage)
        ->get();

        return response()->json(['current_page' => (int)$page,
        'per_page' => $perPage,
        'total' => $count,
        'total_pages' => $total_pages, 
        "data" => $users], 200);

    
        // return $query;


    }

    public function singleUser(Request $request)
    {
        $user = User::find($request->input('id'));


        if(!$user)
        {
            $error['status'] = '404';
            $error['message'] = 'User not found';
            return response()->json(['error' => $error], 400);
        }

        $success['status'] = '200';
        $success['message'] = 'User found';
        $success['data'] = $user;
        return response()->json(['success' => $success]);
    }
        
}

