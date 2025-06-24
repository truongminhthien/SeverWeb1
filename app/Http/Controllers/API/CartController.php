<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderSuccessMail;

class CartController extends Controller
{

    public function checkUserExists($id_user)
    {
        $exit = false;
        $user = User::where('id_user', $id_user)->first();
        if ($user) {
            $exit = true;
            return [
                'status' => $exit,
                'data' => $user
            ];
        } else {
            return [
                'status' => $exit,
            ];
        }
    }

    /**
     * @OA\Get(
     *     path="/api/cart/{id_user}",
     *     operationId="getCart",
     *     tags={"Cart"},
     *     summary="Get cart info for specified user",
     *     description="Returns the cart details of the specified user.",
     *     @OA\Parameter(
     *         name="id_user",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cart info",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
    public function indexCart(Request $request, $id_user)
    {
        // Kiểm tra người dùng có tồn tại không
        $userCheck = $this->checkUserExists($id_user);
        if (!$userCheck['status']) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found, please register now!'
            ], 404);
        } else {
            $user = $userCheck['data'];
        }

        $cart = Order::where('id_user', $user->id_user)
            ->where('status', 'cart')
            ->with('orderDetails.product')
            ->first();

        if ($cart) {
            return response()->json([
                'status' => 'success',
                'data' => $cart->orderDetails->map(function ($detail) {
                    return [
                        'id_order_detail' => $detail->id_order_detail,
                        'id_product' => $detail->id_product,
                        'quantity' => $detail->quantity,
                        'name' => $detail->product->name,
                        'price' => $detail->product->price,
                        'image' => url($detail->product->image),
                    ];
                }),
            ], 200);
        } else {
            $cart = Order::create([
                'id_user' => $id_user,
                'status' => 'cart',
            ]);
            return response()->json([
                'status' => 'success',
                'data' => []
            ], 200);
        }
    }



    /**
     * @OA\Post(
     *     path="/api/addtocart/{id_user}",
     *     operationId="addToCart",
     *     tags={"Cart"},
     *     summary="Add product to cart for specified user",
     *     @OA\Parameter(
     *         name="id_user",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_product", "quantity"},
     *             @OA\Property(property="id_product", type="integer", example=1),
     *             @OA\Property(property="quantity", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product added to cart",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Product added to cart successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
    public function addToCart(Request $request, $id_user)
    {

        // Kiểm tra người dùng có tồn tại không
        $userCheck = $this->checkUserExists($id_user);
        if (!$userCheck['status']) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found, please register now!'
            ], 404);
        } else {
            $user = $userCheck['data'];
        }

        $productId = $request->input('id_product');
        $quantity = $request->input('quantity', 1);

        // Tìm cart hiện tại hoặc tạo mới nếu chưa có
        $cart = Order::firstOrCreate(
            ['id_user' => $id_user, 'status' => 'cart'],
            ['id_user' => $id_user, 'status' => 'cart']
        );

        // Thêm hoặc cập nhật sản phẩm trong order_details
        $orderDetail = $cart->orderDetails()->where('id_product', $productId)->first();
        if ($orderDetail) {
            $orderDetail->quantity += $quantity;
            $orderDetail->save();
        } else {
            $cart->orderDetails()->create([
                'id_product' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Product added to cart successfully'
        ], 200);
    }


    /**
     * @OA\Put(
     *     path="/api/updatecart/{id_user}",
     *     operationId="updateCart",
     *     tags={"Cart"},
     *     summary="Update quantity of a product in cart for specified user",
     *     @OA\Parameter(
     *         name="id_user",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_product", "quantity"},
     *             @OA\Property(property="id_product", type="integer", example=1),
     *             @OA\Property(property="quantity", type="integer", example=5)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cart updated",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Cart updated successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cart or product not found"
     *     )
     * )
     */
    public function updateCart(Request $request, $id_user)
    {
        // Kiểm tra người dùng có tồn tại không
        $userCheck = $this->checkUserExists($id_user);
        if (!$userCheck['status']) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found, please register now!'
            ], 404);
        } else {
            $user = $userCheck['data'];
        }

        $productId = $request->input('id_product');
        $quantity = $request->input('quantity', 1);

        // Tìm cart hiện tại
        $cart = Order::where('id_user', $user->id_user)
            ->where('status', 'cart')
            ->first();

        if (!$cart) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Cart not found'
            ], 404);
        }

        // Tìm sản phẩm trong cart
        $orderDetail = $cart->orderDetails()->where('id_product', $productId)->first();
        if (!$orderDetail) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Product not found in cart'
            ], 404);
        }

        // Cập nhật số lượng
        $orderDetail->quantity = $quantity;
        $orderDetail->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Cart updated successfully'
        ], 200);
    }


    /**
     * @OA\Delete(
     *     path="/api/deletecartproduct/{id_user}",
     *     operationId="deleteProductFromCart",
     *     tags={"Cart"},
     *     summary="Delete a product from cart for specified user",
     *     @OA\Parameter(
     *         name="id_user",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_product"},
     *             @OA\Property(property="id_product", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product deleted from cart",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Product deleted from cart successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cart or product not found"
     *     )
     * )
     */
    public function deleteProductToCart(Request $request, $id_user)
    {

        // Kiểm tra người dùng có tồn tại không
        $userCheck = $this->checkUserExists($id_user);
        if (!$userCheck['status']) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found, please register now!'
            ], 404);
        } else {
            $user = $userCheck['data'];
        }

        $productId = $request->input('id_product');

        // Tìm cart hiện tại
        $cart = Order::where('id_user', $user->id_user)
            ->where('status', 'cart')
            ->first();

        if (!$cart) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Cart not found'
            ], 404);
        }

        // Tìm sản phẩm trong cart
        $orderDetail = $cart->orderDetails()->where('id_product', $productId)->first();
        if (!$orderDetail) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Product not found in cart'
            ], 404);
        }

        // Xóa sản phẩm khỏi cart
        $orderDetail->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted from cart successfully'
        ], 200);
    }


    /**
     * @OA\Post(
     *     path="/api/checkout/{id_user}",
     *     operationId="checkout",
     *     tags={"Cart"},
     *     summary="Place order for all products in cart for specified user",
     *     @OA\Parameter(
     *         name="id_user",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"customer_name", "phone", "address"},
     *             @OA\Property(property="customer_name", type="string", example="Nguyen Van A"),
     *             @OA\Property(property="phone", type="string", example="0123456789"),
     *             @OA\Property(property="address", type="string", example="123 Đường ABC, Quận 1, TP.HCM"),
     *             @OA\Property(property="payment_method", type="string", example="cod", description="Payment method, e.g., cod or bank_transfer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order placed successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Order placed successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cart not found"
     *     )
     * )
     */
    public function checkout(Request $request, $id_user)
    {

        // Kiểm tra người dùng có tồn tại không
        $userCheck = $this->checkUserExists($id_user);
        if (!$userCheck['status']) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found, please register now!'
            ], 404);
        } else {
            $user = $userCheck['data'];
        }

        $cart = Order::where('id_user', $user->id_user)
            ->where('status', 'cart')
            ->with('orderDetails')
            ->first();

        if (!$cart || $cart->orderDetails->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Cart is empty or not found'
            ], 404);
        }

        // Lấy thông tin người nhận từ request
        $cart->total_amount = $cart->orderDetails->sum(function ($detail) {
            return $detail->quantity * $detail->product->price;
        });
        $cart->customer_name = $request->input('customer_name');
        $cart->phone = $request->input('phone');
        $cart->address = $request->input('address');
        $cart->payment_method = $request->input('payment_method'); // Mặc định là 'cod' nếu không có
        $cart->status = 'ordered'; // Đánh dấu đã đặt hàng
        $cart->order_date = now(); // Nếu có cột này
        $cart->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Order placed successfully'
        ], 200);
    }

    public function createUserGuest($username, $email, $phone)
    {
        // Nếu có email, kiểm tra email đã tồn tại chưa
        $user = User::where('email', $email)->first();
        if ($user) {
            return [
                'status' => true,
                'message' => 'This email already has an account or has placed an order at our shop. If this is you, please create an account with this email to continue.'
            ];
        }
        // Nếu email chưa tồn tại, tạo user mới
        $user = User::create([
            'username' => $username,
            'password' => bcrypt(Str::random(6)),
            'email' => $email,
            'phone' => $phone,
            'role' => 2,
            'status' => 'active',
        ]);
        return [$user, false];
    }

    /**
     * @OA\Post(
     *     path="/api/guestcheckout",
     *     operationId="guestCheckout",
     *     tags={"Cart"},
     *     summary="Place order for guest (not logged in)",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"cart_items", "customer_name", "phone", "address"},
     *             @OA\Property(
     *                 property="cart_items",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id_product", type="integer", example=1),
     *                     @OA\Property(property="quantity", type="integer", example=2)
     *                 )
     *             ),
     *             @OA\Property(property="customer_name", type="string", example="Nguyen Van B"),
     *             @OA\Property(property="email", type="string", example="nguyenvanb@gmail.com"),
     *             @OA\Property(property="phone", type="string", example="0987654321"),
     *             @OA\Property(property="address", type="string", example="456 Đường XYZ, Quận 2, TP.HCM"),
     *             @OA\Property(property="payment_method", type="string", example="cod", description="Payment method, e.g., cod or bank_transfer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order placed successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Order placed successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid data"
     *     )
     * )
     */
    public function guestCheckout(Request $request)
    {
        $cartItems = $request->input('cart_items', []);
        $customerName = $request->input('customer_name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $address = $request->input('address');
        $paymentMethod = $request->input('payment_method', 'cod');

        if (empty($cartItems) || !$customerName || !$phone || !$address) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid data'
            ], 400);
        }

        // Tính tổng tiền
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $product = Product::find($item['id_product']);
            if (!$product) continue;
            $totalAmount += $product->price * $item['quantity'];
        }

        $userResult = $this->createUserGuest($customerName, $email, $phone);

        if (isset($userResult['status']) && $userResult['status'] == true) {
            return response()->json([
                'status' => 'failed',
                'message' => $userResult['message'] ?? ''
            ], 400);
        } elseif (isset($userResult[0]) && $userResult[0] instanceof User) {
            $user = $userResult[0];
        }
        $order = Order::create([
            'id_user' => $user->id_user,
            'total_amount' => $totalAmount,
            'customer_name' => $customerName,
            'phone' => $phone,
            'address' => $address,
            'payment_method' => $paymentMethod,
            'status' => 'ordered',
            'order_date' => now(),
        ]);

        // Thêm chi tiết đơn hàng
        foreach ($cartItems as $item) {
            $product = Product::find($item['id_product']);
            if (!$product) continue;
            $order->orderDetails()->create([
                'id_product' => $item['id_product'],
                'quantity' => $item['quantity'],
            ]);
        }

        $order = $order->load('orderDetails.product');
        $dataorder = [
            'id_order' => $order->id_order,
            'total_amount' => $order->total_amount,
            'customer_name' => $order->customer_name,
            'phone' => $order->phone,
            'address' => $order->address,
            'payment_method' => $order->payment_method,
            'status' => $order->status,
            'order_date' => $order->order_date,
            'order_detail' => $order->orderDetails->map(function ($detail) {
                return [
                    'id_order_detail' => $detail->id_order_detail,
                    'id_product' => $detail->id_product,
                    'quantity' => $detail->quantity,
                    'name' => $detail->product->name,
                    'price' => $detail->product->price,
                    'image' => url($detail->product->image),
                ];
            })->toArray()
        ];
        if ($order) {
            // Gửi email thông báo đặt hàng thành công
            try {
                Mail::to($email)->send(new OrderSuccessMail($dataorder));
                return response()->json([
                    'status' => 'success',
                    'message' => 'Order placed successfully. Please register an account with this email to track your order.',
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Order placed but failed to send confirmation email. Please try again later.',
                    'error' => $e->getMessage()
                ], 400);
            }
        }
    }
}
