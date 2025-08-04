<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Order;
use App\Models\Voucher;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderSuccessMail;
use Illuminate\Support\Facades\Validator;

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
        $cart->total_amount = $cart->orderDetails->sum(function ($detail) {
            return $detail->quantity * $detail->product->price;
        });
        $cart->save();
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
        $cart->total_amount = $cart->orderDetails->sum(function ($detail) {
            return $detail->quantity * $detail->product->price;
        });
        $orderDetail->save();
        $cart->save();

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
        // Cập nhật tổng tiền của cart
        $cart->total_amount = $cart->orderDetails->sum(function ($detail) {
            return $detail->quantity * $detail->product->price;
        });
        $cart->save();

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
        $cart->customer_name = $request->input('customer_name');
        $cart->phone = $request->input('phone');
        $cart->address = $request->input('address');
        $cart->payment_method = $request->input('payment_method'); // Mặc định là 'cod' nếu không có
        $cart->status = 'ordered'; // Đánh dấu đã đặt hàng
        $cart->order_date = now();
        $cart->save();

        if ($cart->id_voucher) {
            $voucher = Voucher::find($cart->id_voucher);
            if ($voucher) {
                $voucher->usage_limit -= 1;
                $voucher->save();
            }
        }

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

    // -----------------------------------------------------------------------
    //                         <- Apply Voucher to Cart ->
    // -----------------------------------------------------------------------

    /**
     * @OA\Post(
     *     path="/api/applyvoucher/{id_user}",
     *     tags={"Cart"},
     *     summary="Apply voucher to user's cart",
     *     @OA\Parameter(
     *         name="id_user",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"voucher_code"},
     *             @OA\Property(property="voucher_code", type="string", example="SALE50")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Voucher applied successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Voucher applied successfully"),
     *             @OA\Property(property="discount_amount", type="number", example=50000)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid voucher or cart"
     *     )
     * )
     */
    public function applyVoucher(Request $request, $id_user)
    {
        $voucherCode = $request->input('voucher_code');
        if (!$voucherCode) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Voucher code is required'
            ], 400);
        }

        // Tìm voucher
        $voucher = Voucher::where('code', $voucherCode)
            ->where('status', 'active')
            ->where('usage_limit', '>', 0)
            ->first();
        if ($voucher) {
            // Kiểm tra ngày hết hạn
            if ($voucher->end_date && $voucher->end_date < now()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Voucher has expired'
                ], 400);
            }

            // Kiểm tra ngày bắt đầu
            if ($voucher->start_date && $voucher->start_date > now()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Voucher is not yet valid'
                ], 400);
            }
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Voucher not found or inactive'
            ], 400);
        }

        if (!$voucher) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Voucher is invalid or expired'
            ], 400);
        }

        // Tìm cart của user
        $cart = Order::where('id_user', $id_user)
            ->where('status', 'cart')
            ->with('orderDetails.product')
            ->first();

        if (!$cart || $cart->orderDetails->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Cart is empty or not found'
            ], 400);
        }

        // Tính tổng tiền
        $total = $cart->orderDetails->sum(function ($detail) {
            return $detail->quantity * $detail->product->price;
        });

        // Kiểm tra tổng tiền có đủ điều kiện áp dụng voucher không
        if ($total < $voucher->min_order_amount) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Total amount does not meet the minimum order amount for this voucher'
            ], 400);
        }
        // Kiểm tra tổng tiền có vượt quá giới hạn giảm giá không
        if ($voucher->max_discount_amount && $total > $voucher->max_discount_amount) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Total amount exceeds the maximum discount limit for this voucher'
            ], 400);
        }



        // Tính giảm giá
        $discountAmount = 0;
        if ($voucher->type === 'percentage') {
            $discountAmount = round($total * ($voucher->discount_amount / 100));
        } else {
            $discountAmount = min($voucher->discount_amount, $total);
        }

        // Gán voucher vào cart
        $cart->id_voucher = $voucher->id_voucher;
        $cart->total_amount = $total - $discountAmount;
        $cart->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Voucher applied successfully',
            'type' => $voucher->type,
            'discount_amount' => $discountAmount,
            'total_after_discount' => $cart->total_amount,
        ], 200);
    }



    /**
     * @OA\Post(
     *     path="/api/vouchers",
     *     tags={"Voucher"},
     *     summary="Create a new voucher",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"code", "discount_amount", "min_order_amount", "type", "usage_limit", "start_date", "end_date"},
     *             @OA\Property(property="code", type="string", example="SALE50"),
     *             @OA\Property(property="discount_amount", type="number", example=50),
     *             @OA\Property(property="type", type="string", example="percentage", description="percentage or fixed"),
     *             @OA\Property(property="min_order_amount", type="string", example="1000000", description="Minimum order amount to apply the voucher"),
     *             @OA\Property(property="max_discount_amount", type="string", example="5000000", description="Maximum discount amount for the voucher"),
     *             @OA\Property(property="start_date", type="string", format="date", example="2025-07-01"),
     *             @OA\Property(property="end_date", type="string", format="date", example="2025-07-31"),
     *             @OA\Property(property="usage_limit", type="integer", example=100),
     *             @OA\Property(property="description", type="string", example="Get 50% off on your next purchase"),
     *             @OA\Property(property="note", type="string", example="Limited time offer"),
     *             @OA\Property(property="status", type="string", example="active")
     * 
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Voucher created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="voucher", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     )
     * )
     */
    public function createVoucher(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'           => 'required|string|unique:vouchers,code',
            'discount_amount' => 'required|numeric|min:1',
            'type'           => 'required|in:percentage,fixed',
            'min_order_amount' => 'required|numeric|min:0',
            'max_discount_amount' => 'required|numeric|min:0',
            'description'    => 'nullable|string|max:255',
            'note'           => 'nullable|string|max:255',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'usage_limit'    => 'required|integer|min:1',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'status'         => 'nullable|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $voucher = Voucher::create([
            'code'           => $request->code,
            'discount_amount' => $request->discount_amount,
            'type'           => $request->type,
            'min_order_amount' => $request->min_order_amount,
            'max_discount_amount' => $request->max_discount_amount,
            'description'    => $request->description,
            'note'           => $request->note,
            'usage_limit'    => $request->usage_limit,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
            'status'         => $request->status ?? 'active'
        ]);

        return response()->json([
            'status' => 'success',
            'voucher' => $voucher
        ], 201);
    }


    /**
     * @OA\Put(
     *     path="/api/vouchers/{id_voucher}",
     *     tags={"Voucher"},
     *     summary="Update voucher information",
     *     @OA\Parameter(
     *         name="id_voucher",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="code", type="string", example="SALE50"),
     *             @OA\Property(property="discount_amount", type="number", example=50),
     *             @OA\Property(property="type", type="string", example="percentage", description="percentage or fixed"),
     *             @OA\Property(property="min_order_amount", type="string", example="1000000"),
     *             @OA\Property(property="max_discount_amount", type="string", example="5000000"),
     *             @OA\Property(property="start_date", type="string", format="date", example="2025-07-01"),
     *             @OA\Property(property="end_date", type="string", format="date", example="2025-07-31"),
     *             @OA\Property(property="usage_limit", type="integer", example=100),
     *             @OA\Property(property="description", type="string", example="Get 50% off on your next purchase"),
     *             @OA\Property(property="note", type="string", example="Limited time offer"),
     *             @OA\Property(property="status", type="string", example="active")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Voucher updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="voucher", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Voucher not found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     )
     * )
     */
    public function updateVoucher(Request $request, $id_voucher)
    {
        $voucher = Voucher::find($id_voucher);
        if (!$voucher) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Voucher not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'code'           => 'sometimes|string|unique:vouchers,code,' . $id_voucher . ',id_voucher',
            'discount_amount' => 'sometimes|numeric|min:1',
            'type'           => 'sometimes|in:percentage,fixed',
            'min_order_amount' => 'sometimes|numeric|min:0',
            'max_discount_amount' => 'sometimes|min:0',
            'description'    => 'nullable|string|max:255',
            'note'           => 'nullable|string|max:255',
            'start_date'     => 'sometimes|date',
            'end_date'       => 'sometimes|date|after_or_equal:start_date',
            'usage_limit'    => 'sometimes|integer|min:1',
            'status'         => 'nullable|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $voucher->update($validator->validated());

        return response()->json([
            'status' => 'success',
            'voucher' => $voucher,
            'validation_errors' => $validator->validated()
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/vouchers",
     *     tags={"Voucher"},
     *     summary="Get all vouchers",
     *     @OA\Response(
     *         response=200,
     *         description="List of vouchers",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="vouchers",
     *                 type="array",
     *                 @OA\Items(type="object")
     *             )
     *         )
     *     )
     * )
     */
    public function getVouchers()
    {
        $vouchers = Voucher::all();

        return response()->json([
            'status' => 'success',
            'vouchers' => $vouchers
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/vouchers/{id_voucher}",
     *     tags={"Voucher"},
     *     summary="Delete a voucher by ID",
     *     @OA\Parameter(
     *         name="id_voucher",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Voucher deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Voucher deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Voucher not found"
     *     )
     * )
     */
    public function deleteVoucher($id_voucher)
    {
        $voucher = Voucher::find($id_voucher);
        if (!$voucher) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Voucher not found'
            ], 404);
        }

        $voucher->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Voucher deleted successfully'
        ], 200);
    }

    // -----------------------------------------------------------------------
    //                         <- order managerment ->
    // -----------------------------------------------------------------------


    /**
     * @OA\Get(
     *     path="/api/orders",
     *     tags={"Order"},
     *     summary="Get all orders",
     *     @OA\Response(
     *         response=200,
     *         description="List of all orders",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="orders",
     *                 type="array",
     *                 @OA\Items(type="object")
     *             )
     *         )
     *     )
     * )
     */
    public function getAllOrder()
    {
        $orders = Order::with(['orderDetails.product', 'user', 'voucher'])
            ->where('status', '!=', 'cart')

            ->orderByDesc('order_date')
            ->get();

        $orders = $orders->map(function ($order) {
            return [
                'id_order' => $order->id_order,
                'user' => $order->user ? [
                    'id_user' => $order->user->id_user,
                    'username' => $order->user->username,
                    'email' => $order->user->email,
                    'phone' => $order->user->phone,
                ] : null,
                'total' => $order->total_amount,
                'customer_name' => $order->customer_name,
                'phone' => $order->phone,
                'address' => $order->address,
                'payment_method' => $order->payment_method,
                'notes' => $order->notes,
                'order_date' => $order->order_date,
                'status' => $order->status,
                'voucher' => $order->voucher,
                'order_details' => $order->orderDetails->map(function ($detail) {
                    return [
                        'id_order_detail' => $detail->id_order_detail,
                        'id_product' => $detail->id_product,
                        'quantity' => $detail->quantity,
                        'name' => $detail->product->name ?? null,
                        'price' => $detail->product->price ?? null,
                        'image' => $detail->product ? url($detail->product->image) : null,
                    ];
                }),
            ];
        });

        return response()->json([
            'status' => 'success',
            'orders' => $orders
        ], 200);
    }



    /**
     * @OA\Get(
     *     path="/api/orders/{id_order}",
     *     tags={"Order"},
     *     summary="Get order detail by order ID",
     *     @OA\Parameter(
     *         name="id_order",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order detail",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="order", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found"
     *     )
     * )
     */
    public function getOrderById($id_order)
    {
        $order = Order::with(['orderDetails.product', 'user', 'voucher'])->find($id_order);

        if (!$order) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Order not found'
            ], 404);
        }

        $orderData = [
            'id_order' => $order->id_order,
            'total' => $order->total_amount,
            'customer_name' => $order->customer_name,
            'phone' => $order->phone,
            'address' => $order->address,
            'payment_method' => $order->payment_method,
            'notes' => $order->notes,
            'order_date' => $order->order_date,
            'status' => $order->status,
            'user' => $order->user,
            'voucher' => $order->voucher,
            'order_details' => $order->orderDetails,
        ];

        return response()->json([
            'status' => 'success',
            'order' => $orderData
        ], 200);
    }



    /**
     * @OA\Put(
     *     path="/api/orders/{id_order}/status",
     *     tags={"Order"},
     *     summary="Update order status",
     *     @OA\Parameter(
     *         name="id_order",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status"},
     *             @OA\Property(property="status", type="string", example="shipping", description="New status: cart, ordered, preparing, shipping, delivered")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order status updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="order", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     )
     * )
     */
    public function updateStatusOrder(Request $request, $id_order)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:cart,ordered,preparing,shipping,delivered'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        $order = Order::find($id_order);
        if (!$order) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Order not found'
            ], 404);
        }

        $order->status = $request->status;
        $order->save();

        return response()->json([
            'status' => 'success',
            'order' => $order
        ], 200);
    }
}
