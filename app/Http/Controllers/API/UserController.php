<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderShipped;



/**
 * @OA\Info(
 *     title="Sever Web",
 *     version="1.0.0"
 * )
 */

class UserController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"User"},
     *     summary="Register a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"firstname","lastname", "email", "password", "phone", "address"},
     *             @OA\Property(property="firstname", type="string", example="Tuấn"),
     *             @OA\Property(property="lastname", type="string", example="Hiệp"),
     *             @OA\Property(property="email", type="string", format="email", example="hieptuan@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="secret123"),
     *             @OA\Property(property="phone", type="integer", example=123456789),
     *             @OA\Property(property="address", type="string", example="123 Street Name"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User registered successfully"),
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 @OA\Property(property="username", type="string", example="Tuấn Hiệp"),
     *                 @OA\Property(property="email", type="string", example="hieptuan@example.com"),
     *                 @OA\Property(property="phone", type="integer", example=123456789),
     *                 @OA\Property(property="address", type="string", example="123 Street Name"),
     *                 @OA\Property(property="role", type="integer", example=0),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-06-01T12:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-06-01T12:00:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User registration failed"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone'    => 'required|integer',
            'address'  => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'User registration failed', 'errors' => $validator->errors()], 400);
        } else {
            $request->merge(['username' => $request->firstname . ' ' . $request->lastname]);
            $request->merge(['role' => 0]);

            $user = User::create([
                'username' => $request->username,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'phone'    => $request->phone,
                'address'  => $request->address,
                'role'     => 0,
            ]);
            if (!$user) {
                return response()->json(['message' => 'User registration failed'], 500);
            } else {
                return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
            }
        }
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"User"},
     *     summary="Login user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="hieptuan@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="secret123"),
     *         )
     *     ),
     *     @OA\Response(response=200, description="Login successful"),
     *     @OA\Response(response=401, description="Invalid credentials")
     * )
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        } else {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Login failed',
                    'error' => 'Email hoặc mật khẩu không đúng'
                ], 401);
            }

            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
            ], 200);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/check-email-send-code",
     *     tags={"User"},
     *     summary="Check if email exists and send verification code",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string", format="email", example="hieptuan@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Email exist",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Email already exists")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Email does not exist",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Email does not exist")
     *         )
     *     )
     * )
     */
    public function checkEmailandsendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'Email does not exist'], 404);
        } else {
            $subject = 'Account Verification Code';
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $user->code = $code;
            if ($user->save()) {
                Mail::to($user->email)->send(new OrderShipped($subject, $user->username, $code));
                return response()->json(['message' => 'Verification code sent to your email successfully'], 200);
            } else {
                return response()->json(['message' => 'Failed to send verification code'], 500);
            }
        }
    }

    /**
     * @OA\Post(
     *     path="/api/check-code",
     *     tags={"User"},
     *     summary="Check verification code for user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "code"},
     *             @OA\Property(property="email", type="string", format="email", example="hieptuan@email.com"),
     *             @OA\Property(property="code", type="string", example="123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Code is valid",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 @OA\Property(property="username", type="string", example="Tuấn Hiệp"),
     *                 @OA\Property(property="email", type="string", example="hieptuan@example.com"),
     *                 @OA\Property(property="phone", type="integer", example=123456789),
     *                 @OA\Property(property="address", type="string", example="123 Street Name"),
     *                 @OA\Property(property="role", type="integer", example=0),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-06-01T12:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-06-01T12:00:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid code",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="failed"),
     *             @OA\Property(property="message", type="string", example="Invalid code")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="failed"),
     *             @OA\Property(property="message", type="string", example="User not found")
     *         )
     *     )
     * )
     */
    public function checkCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'code'  => 'required|int|digits:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['status' => 'failed', 'message' => 'User not found'], 404);
        } else {
            if ($user->code === $request->code) {
                return response()->json([
                    'status' => 'success',
                    'user' => $user
                ], 200);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Invalid code'], 400);
            }
        }
    }

    /**
     * @OA\Post(
     *     path="/api/reset-password",
     *     tags={"User"},
     *     summary="Reset password for user by email and code",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "code", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="hieptuan@email.com"),
     *             @OA\Property(property="password", type="string", format="password", example="newpassword123"),
     *             @OA\Property(property="confirm_password", type="string", format="password", example="newpassword123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password reset successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Password reset successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Password reset failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="failed"),
     *             @OA\Property(property="message", type="string", example="Password reset failed")
     *         )
     *     )
     * )
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['status' => 'failed', 'message' => 'User not found'], 404);
        } else {
            if ($request->password !== $request->confirm_password) {
                return response()->json(['status' => 'failed', 'message' => 'Passwords do not match'], 400);
            } else {
                $user->password = Hash::make($request->password);
                $user->save();
                return response()->json(['status' => 'success', 'message' => 'Password reset successfully'], 200);
            }
        }
    }


    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     tags={"User"},
     *     summary="Update user information",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="username", type="string", example="john_doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="secret123"),
     *             @OA\Property(property="phone", type="integer", example=123456789),
     *             @OA\Property(property="address", type="string", example="123 Street Name"),
     *             @OA\Property(property="role", type="integer", example=0)
     *         )
     *     ),
     *     @OA\Response(response=200, description="User updated successfully"),
     *     @OA\Response(response=400, description="Validation error"),
     *     @OA\Response(response=404, description="User not found")
     * )
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'sometimes|string|max:255',
            'email'    => 'sometimes|email|unique:users,email,' . $id . ',id_user',
            'password' => 'sometimes|string|min:6',
            'phone'    => 'sometimes|integer',
            'address'  => 'sometimes|string',
            'role'     => 'sometimes|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $data = $request->only(['username', 'email', 'phone', 'address', 'role']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     tags={"User"},
     *     summary="Delete user",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="User deleted successfully"),
     *     @OA\Response(response=404, description="User not found")
     * )
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
