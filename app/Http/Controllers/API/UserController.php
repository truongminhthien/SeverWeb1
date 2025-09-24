<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Log;



/**
 * @OA\Info(
 *     title="Sever Web",
 *     version="1.0.0"
 * )
 */

class UserController extends Controller
{


    /**
     * @OA\Get(
     *     path="/api/users",
     *     tags={"User"},
     *     summary="Get all users",
     *     @OA\Response(
     *         response=200,
     *         description="List of all users",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="username", type="string"),
     *                     @OA\Property(property="email", type="string"),
     *                     @OA\Property(property="phone", type="string"),
     *                     @OA\Property(property="address", type="string"),
     *                     @OA\Property(property="role", type="integer"),
     *                     @OA\Property(property="created_at", type="string", format="date-time"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getAllUser()
    {
        $users = User::where('status', '!=', 'delete')->with('addresses')
            ->where('role', '!=', 2)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $users
        ], 200);
    }


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
     *             @OA\Property(property="phone", type="string", example=123456789),
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
     *                 @OA\Property(property="phone", type="string", example=123456789),
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
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
            'phone'    => 'required|string|max:10',
            'address'  => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'failed', 'message' => 'User registration failed', 'errors' => $validator->errors()], 400);
        } else {
            // Check if email already exists
            $user = User::where('email', $request->email)->first();
            if ($user && $user->role  !== 2) {
                return response()->json(['status' => 'failed', 'message' => 'Account exists'], 400);
            } elseif ($user && $user->status === 'banned') {
                return response()->json(['status' => 'failed', 'message' => 'Account is banned'], 403);
            } elseif ($user && $user->status === 'inactive') {
                return response()->json(['status' => 'failed', 'message' => 'Account is inactive'], 403);
            } elseif ($user && $user->role  === 2) {
                $request->merge(['username' => $request->firstname . ' ' . $request->lastname]);
                $user->update([
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'phone'    => $request->phone,
                    'address'  => $request->address,
                    'image'    => 'uploads/default-avatar-profile-icon-of-social-media-user-vector.jpg',
                    'status'   => 'active',
                    'role'     => 0,
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'User registered successfully',
                    'user' => $user
                ], 201);
            }

            $request->merge(['username' => $request->firstname . ' ' . $request->lastname]);
            $user = User::create([
                'username' => $request->username,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'image'    => 'uploads/default-avatar-profile-icon-of-social-media-user-vector.jpg',
                'role'     => 0,
            ]);
            if ($user) {
                $user->addresses()->create([
                    'recipient_name' => $request->username,
                    'phone' => $request->phone,
                    'address_line' => $request->address,
                    'status' => 'default',
                ]);
            }

            if (!$user) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'User registration failed',
                    'user' => $user
                ], 500);
            } else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'User registered successfully',
                    'user' => $user
                ], 201);
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
            return response()->json(['status' => 'failed', 'errors' => $validator->errors()], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Email or password is incorrect'
            ], 401);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'user' => [
                'id_user' => $user->id_user,
                'username' => $user->username,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
                'image' => url($user->image),
                'role' => $user->role,
                'status' => $user->status,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ]
        ], 200);
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
            return response()->json(['status' => 'failed', 'message' => 'Email does not exist'], 404);
        } else {
            $subject = 'Account Verification Code';
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $user->code = $code;
            if ($user->save()) {
                try {
                    Mail::to($user->email)->send(new OrderShipped($subject, $user->username ?? $user->name ?? '', $code));
                    return response()->json(['status' => 'success', 'message' => 'Verification code sent to your email successfully'], 200);
                } catch (\Exception $e) {
                    return response()->json(['status' => 'failed', 'message' => 'Failed to send verification code', 'error' => $e->getMessage()], 500);
                }
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Failed to save verification code'], 500);
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
     *             @OA\Property(property="message", type="integer", example="Invalid code")
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
            'code'  => 'required|string|digits:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'failed', 'errors' => $validator->errors()], 400);
        } else {
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
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Passwords do not match'
                ], 400);
            } else {
                $user->password = Hash::make($request->password);
                $user->save();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Password reset successfully'
                ], 200);
            }
        }
    }

    /**
     * @OA\Get(
     *     path="/api/order-history/{id}",
     *     tags={"User"},
     *     summary="Get order history of authenticated user",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order history list",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id_order", type="integer"),
     *                 @OA\Property(property="order_date", type="string", format="date-time"),
     *                 @OA\Property(property="status", type="string"),
     *                 @OA\Property(property="total", type="number"),
     *                 @OA\Property(property="items", type="array", @OA\Items(type="object"))
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function orderHistory($id)
    {
        $orders = Order::with(['orderDetails.product', 'voucher'])
            ->where('id_user', $id)
            ->orderBy('order_date', 'desc')
            ->get()
            ->map(function ($order) {
                return [
                    'id_order' => $order->id_order,
                    'id_user' => $order->id_user,
                    'total' => $order->total_amount,
                    'customer_name' => $order->customer_name,
                    'phone' => $order->phone,
                    'address' => $order->address,
                    'payment_method' => $order->payment_method,
                    'notes' => $order->notes,
                    'order_date' => $order->order_date,
                    'status' => $order->status,
                    'voucher' => $order->voucher, // Thêm thông tin voucher
                    'orderdatails' => $order->orderDetails->map(function ($detail) {
                        return [
                            'id_product' => $detail->id_product,
                            'quantity' => $detail->quantity,
                            'product' => $detail->product
                        ];
                    }),
                ];
            });

        if ($orders->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No orders found',
                'data' => []
            ], 200);
        } else {
            return response()->json([
                'status' => 'success',
                'data' => $orders
            ], 200);
        }
    }


    /**
     * @OA\Post(
     *     path="/api/users/{id}",
     *     tags={"User"},
     *     summary="Update user information (including avatar)",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="username", type="string", example="john_doe"),
     *                 @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *                 @OA\Property(property="phone", type="string", example="123456789"),
     *                 @OA\Property(property="address", type="string", example="123 Street Name"),
     *                 @OA\Property(property="avatar", type="string", format="binary", description="User avatar image")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="User updated successfully"),
     *     @OA\Response(response=400, description="Validation error"),
     *     @OA\Response(response=404, description="User not found")
     * )
     */

    public function updateUser(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'nullable|string|max:255',
            'email'    => 'nullable|email|unique:users,email,' . $id . ',id_user',
            'phone'    => 'nullable|string|max:10',
            'address'  => 'nullable|string',
            'avatar'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found'
            ], 404);
        }
        if (isset($request->username)) {
            $user->username = $request->username;
        }
        if (isset($request->email)) {
            $user->email = $request->email;
        }
        if (isset($request->phone)) {
            $user->phone = $request->phone;
        }
        if (isset($request->address)) {
            $user->address = $request->address;
        }

        if ($request->hasFile('avatar')) {

            $file = $request->file('avatar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/avatars'), $filename);
            // Do not delete default image
            $defaultImage = 'uploads/default-avatar-profile-icon-of-social-media-user-vector.jpg';
            if ($user->image && file_exists(public_path($user->image)) && $user->image !== $defaultImage) {
                @unlink(public_path($user->image));
            }
            $user->image = '/uploads/avatars/' . $filename;
        }

        if ($user->save()) {
            return response()->json(['status' => 'success', 'message' => 'User updated successfully', 'user' => $user], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Failed to update user'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     tags={"User"},
     *     summary="Create a new user with avatar and role",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"username", "email", "password", "phone", "role", "status"},
     *                 @OA\Property(property="username", type="string", example="john_doe"),
     *                 @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *                 @OA\Property(property="password", type="string", format="password", example="secret123"),
     *                 @OA\Property(property="phone", type="string", example="123456789"),
     *                 @OA\Property(property="address", type="string", example="123 Street Name"),
     *                 @OA\Property(property="status", type="string", example="active"),
     *                 @OA\Property(property="role", type="integer", example=0),
     *                 @OA\Property(property="avatar", type="string", format="binary", description="User avatar image")
     * 
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="User created successfully"),
     *     @OA\Response(response=400, description="Validation error")
     * )
     */
    public function createUserAtAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone'    => 'required|string|max:10',
            'address'  => 'nullable|string',
            'status'   => 'required|string|in:active,inactive,banned',
            'role'     => 'required|integer|in:0,1,2',
            'avatar'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        $imagePath = 'uploads/default-avatar-profile-icon-of-social-media-user-vector.jpg';
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/avatars'), $filename);
            $imagePath = 'uploads/avatars/' . $filename;
        }

        $user = User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'address'  => $request->address,
            'role'     => $request->role,
            'image'    => $imagePath,
            'status'   => $request->status,
        ]);

        if ($user) {
            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully',
                'user' => [
                    'id_user' => $user->id_user,
                    'username' => $user->username,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'address' => $user->address,
                    'image' => url($user->image),
                    'role' => (int) $user->role,
                    'status' => $user->status,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at
                ]
            ], 201);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to create user'
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     tags={"User"},
     *     summary="Delete a user by ID (soft delete)",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="User deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function deleteUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found'
            ], 404);
        }

        // Xóa mềm: chuyển status thành 'delete'
        $user->status = 'delete';
        $user->save();

        // Nếu muốn xóa cứng, dùng: $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully'
        ], 200);
    }



    /**
     * @OA\Put(
     *     path="/api/users/{id}/password",
     *     tags={"User"},
     *     summary="Update user password",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"old_password", "new_password", "confirm_password"},
     *             @OA\Property(property="old_password", type="string", format="password", example="oldpass123"),
     *             @OA\Property(property="new_password", type="string", format="password", example="newpass456"),
     *             @OA\Property(property="confirm_password", type="string", format="password", example="newpass456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Password updated successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function updatePassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:6',
            'confirm_password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found'
            ], 404);
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Old password is incorrect'
            ], 400);
        }

        if ($request->new_password !== $request->confirm_password) {
            return response()->json([
                'status' => 'failed',
                'message' => 'New passwords do not match'
            ], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Password updated successfully'
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}/addresses",
     *     tags={"User"},
     *     summary="Get all addresses by user ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of addresses for the user",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="addresses",
     *                 type="array",
     *                 @OA\Items(type="object")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function getAllByUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found'
            ], 404);
        }

        $addresses = $user->addresses()->get();

        return response()->json([
            'status' => 'success',
            'addresses' => $addresses
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/users/{id}/addresses",
     *     tags={"User"},
     *     summary="Create a new address for user",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"recipient_name", "phone", "address_line"},
     *             @OA\Property(property="recipient_name", type="string", example="Nguyễn Văn A"),
     *             @OA\Property(property="phone", type="string", example="0987654321"),
     *             @OA\Property(property="address_line", type="string", example="123 Đường ABC, Quận 1, TP.HCM"),
     *             @OA\Property(property="status", type="string", example="default")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Address created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="address", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function createNewAddress(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address_line' => 'required|string|max:255',
            'status' => 'nullable|string|in:default,non-default,other'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found'
            ], 404);
        }

        // If the new address is set as default, update other addresses to non-default
        if (($request->status ?? 'other') === 'default') {
            $user->addresses()->where('status', 'default')->update(['status' => 'non-default']);
        }

        $address = $user->addresses()->create([
            'recipient_name' => $request->recipient_name,
            'phone' => $request->phone,
            'address_line' => $request->address_line,
            'status' => $request->status ?? 'other',
        ]);

        return response()->json([
            'status' => 'success',
            'address' => $address
        ], 201);
    }


    /**
     * @OA\Put(
     *     path="/api/addresses/{address_id}",
     *     tags={"User"},
     *     summary="Update an address for user",
     *     @OA\Parameter(
     *         name="address_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="recipient_name", type="string", example="Nguyễn Văn B"),
     *             @OA\Property(property="phone", type="string", example="0912345678"),
     *             @OA\Property(property="address_line", type="string", example="456 Đường XYZ, Quận 2, TP.HCM"),
     *             @OA\Property(property="status", type="string", example="default")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Address updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="address", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User or address not found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     )
     * )
     */
    public function updateAddress(Request $request, $address_id)
    {
        $validator = Validator::make($request->all(), [
            'recipient_name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:15',
            'address_line' => 'sometimes|string|max:255',
            'status' => 'nullable|string|in:default,non-default,other'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }


        $address = Address::find($address_id);
        if (!$address) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Address not found'
            ], 404);
        }

        // Nếu cập nhật thành default, chuyển các địa chỉ khác về non-default
        if (($request->status ?? $address->status) === 'default') {
            $address->user->addresses()->where('id_address', '!=', $address_id)->update(['status' => 'non-default']);
        }

        $address->update($validator->validated());

        return response()->json([
            'status' => 'success',
            'address' => $address,
            'addresses' => $address->user->addresses()->get()


        ], 200);
    }


    /**
     * @OA\Delete(
     *     path="/api/addresses/{address_id}",
     *     tags={"User"},
     *     summary="Delete an address by ID",
     *     @OA\Parameter(
     *         name="address_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Address deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Address deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Address not found"
     *     )
     * )
     */
    public function deleteAddress($address_id)
    {
        $address = Address::find($address_id);
        if (!$address) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Address not found'
            ], 404);
        }
        if ($address->status === 'default') {
            return response()->json([
                'status' => 'failed',
                'message' => 'Cannot delete default address'
            ], 400);
        }

        $address->status = 'deleted';
        $address->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Address deleted successfully'
        ], 200);
    }
}
