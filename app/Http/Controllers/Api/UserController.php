<?php

namespace App\Http\Controllers\Api;

use App\Enums\StatusCode;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Faker\Provider\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
//        $validated = $request->validate([
//            "status_id" => "required",
//            "username" => "required",
//            "name" => "required",
//            "email" => "required|email",
//            "department_id" => "required",
//            "password" => "required|confirmed",
//        ],[
//            "status_id.required" => "Nhập tình trạng",
//            "username.required" => "Nhập tên tài khoản",
//            "name.required" => "Nhập họ và tên",
//            "email.required" => "Nhập email",
//            "email.email" => "Email không hợp lệ",
//            "department_id.required" => "Nhập phòng ban",
//            "password.required" => "Nhập mật khẩu",
//        ]);
//       return $request;
        $validator = Validator::make($request->all(), [
            "status_id" => "required",
            "username" => "required",
            "name" => "required",
            "email" => "required|email",
            "departments_id" => "required",
            "password" => "required",
            "password_old" => "required|same:password",

        ], [
            "status_id.required" => "Nhập tình trạng",
            "username.required" => "Nhập tên tài khoản",
            "name.required" => "Nhập họ và tên",
            "email.required" => "Nhập email",
            "email.email" => "Email không hợp lệ",
            "departments_id.required" => "Nhập phòng ban",
            "password.required" => "Nhập mật khẩu",
            "password_old.required" => "Nhập xác nhận mật khẩu",
            "password_old.same" => "Xác nhận mật khẩu chưa khớp",

        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => array_combine($validator->errors()->keys(), $validator->errors()->all()),
                'status_code' => StatusCode::BAD_REQUEST
            ], StatusCode::OK);
        }
        return $request;
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
