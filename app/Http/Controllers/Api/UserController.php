<?php

namespace App\Http\Controllers\Api;

use App\Enums\StatusCode;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Faker\Provider\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use function Termwind\renderUsing;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $user = User::join('departments', 'users.department_id', '=', 'departments.id')
            ->join('users_status', 'users.status_id', '=', 'users_status.id')->select(
                'users.*',
                'departments.name AS departments',
                'users_status.name AS status'
            )->get();

//        return User::get();
        return response()->json($user);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = DB::table("departments")->select(
            'id as value',
            'name as label'
        )->get();
        $users_status = DB::table("users_status")->select(
            'id as value',
            'name as label'
        )->get();

        if ($departments && $users_status) {
            return response()->json([
                'departments' => $departments,
                'users_status' => $users_status,
            ], StatusCode::OK);
        }

        return response()->json([
            'success' => false,
        ], StatusCode::BAD_REQUEST);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $validator = Validator::make($request->all(), [
//            "status_id" => "required",
//            "username" => "required",
//            "name" => "required",
//            "email" => "required|email",
//            "departments_id" => "required",
//            "password" => "required",
//            "password_old" => "required|same:password",
//
//        ], [
//            "status_id.required" => "Nh???p t??nh tr???ng",
//            "username.required" => "Nh???p t??n t??i kho???n",
//            "name.required" => "Nh???p h??? v?? t??n",
//            "email.required" => "Nh???p email",
//            "email.email" => "Email kh??ng h???p l???",
//            "departments_id.required" => "Nh???p ph??ng ban",
//            "password.required" => "Nh???p m???t kh???u",
//            "password_old.required" => "Nh???p x??c nh???n m???t kh???u",
//            "password_old.same" => "X??c nh???n m???t kh???u ch??a kh???p",
//
//        ]);
//        if ($validator->fails()) {
//            return response()->json([
//                'message' => array_combine($validator->errors()->keys(), $validator->errors()->all()),
//                'status_code' => StatusCode::BAD_REQUEST
//            ], StatusCode::OK);
//        }
//        $this->user->status_id = $request->status_id;
//        $this->user->department_id = $request->departments_id;
//        $this->user->name = $request->name;
        $request->validate([
            'fullname' => ['required', 'max:255'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $this->user->fullname = $request->fullname;
        $this->user->email = $request->email;
        $this->user->password = $request->password;
        if ($this->user->save()) {
            return response()->json([
                'success' => true,
            ], StatusCode::OK);
        }
        return response()->json([
            'success' => false,
        ], StatusCode::BAD_REQUEST);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        return response()->json([
            'user' => $user,
        ], StatusCode::OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $this->user->where('id', $id)->first();
        $user->status_id = $request->status_id;
        $user->department_id = $request->department_id;
        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        if ($user->save()) {
            return response()->json([
                'success' => true,
            ]);
        }
        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->user->where('id', $id)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
            ]);
        }
        if ($user->delete()) {
            return response()->json([
                'success' => true,
            ]);
        }
        return response()->json([
            'success' => false,
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'fullname' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $data = [];
        $data['fullname'] = $request->fullname;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);

        DB::table('users')->insert($data);
        return response()->json(['success' => 'true'], StatusCode::OK);
    }

    public function logout(Request $request)
    {
//        $validator = Validator::make($request->only('token'), [
//            'token' => 'required'
//        ]);
//        if ($validator->fails()) {
//            return response()->json(['error' => $validator->messages()], 200);
//        }

        $request->validate([
            'token' => 'required',
        ]);
        try {
//            auth()->logout();
            return response()->json([
                'success' => true,
                'message' => 'User has been logged out',
                'token' => $request->token,
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['message' => 'Successfully logged out']);
    }
}
