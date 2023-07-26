<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class FrontController extends Controller
{
    public function index(Request $request)
    {
        $result['home_categories'] = DB::table('categories')
            ->where(['status' => 1])
            ->where(['is_home' => 1])
            ->get();


        foreach ($result['home_categories'] as $list) {
            $result['home_categories_product'][$list->id] =
                DB::table('products')
                ->where(['status' => 1])
                ->where(['category_id' => $list->id])
                ->get();

            foreach ($result['home_categories_product'][$list->id] as $list1) {
                $result['home_product_attr'][$list1->id] =
                    DB::table('products_attr')
                    ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
                    ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
                    ->where(['products_attr.products_id' => $list1->id])
                    ->get();
            }
        }

        $result['home_brand'] = DB::table('brands')
            ->where(['status' => 1])
            ->where(['is_home' => 1])
            ->get();


        $result['home_featured_product'][$list->id] =
            DB::table('products')
            ->where(['status' => 1])
            ->where(['is_featured' => 1])
            ->get();

        foreach ($result['home_featured_product'][$list->id] as $list1) {
            $result['home_featured_product_attr'][$list1->id] =
                DB::table('products_attr')
                ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
                ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
                ->where(['products_attr.products_id' => $list1->id])
                ->get();
        }

        $result['home_tranding_product'][$list->id] =
            DB::table('products')
            ->where(['status' => 1])
            ->where(['is_tranding' => 1])
            ->get();

        foreach ($result['home_tranding_product'][$list->id] as $list1) {
            $result['home_tranding_product_attr'][$list1->id] =
                DB::table('products_attr')
                ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
                ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
                ->where(['products_attr.products_id' => $list1->id])
                ->get();
        }

        $result['home_discounted_product'][$list->id] =
            DB::table('products')
            ->where(['status' => 1])
            ->where(['is_discounted' => 1])
            ->get();

        foreach ($result['home_discounted_product'][$list->id] as $list1) {
            $result['home_discounted_product_attr'][$list1->id] =
                DB::table('products_attr')
                ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
                ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
                ->where(['products_attr.products_id' => $list1->id])
                ->get();
        }

        $result['home_banner'] = DB::table('home_banners')
            ->where(['status' => 1])
            ->get();

        return view('front.index', $result);
    }

    public function category(Request $request, $slug)
    {
        $sort = "";
        $sort_txt = "";
        $filter_price_start = "";
        $filter_price_end = "";
        $color_filter = "";
        $colorFilterArr = [];
        if ($request->get('sort') !== null) {
            $sort = $request->get('sort');
        }

        $query = DB::table('products');
        $query = $query->leftJoin('categories', 'categories.id', '=', 'products.category_id');
        $query = $query->leftJoin('products_attr', 'products.id', '=', 'products_attr.products_id');
        $query = $query->where(['products.status' => 1]);
        $query = $query->where(['categories.category_slug' => $slug]);
        if ($sort == 'name') {
            $query = $query->orderBy('products.name', 'asc');
            $sort_txt = "Product Name";
        }
        if ($sort == 'date') {
            $query = $query->orderBy('products.id', 'desc');
            $sort_txt = "Date";
        }
        if ($sort == 'price_desc') {
            $query = $query->orderBy('products_attr.price', 'desc');
            $sort_txt = "Price - DESC";
        }
        if ($sort == 'price_asc') {
            $query = $query->orderBy('products_attr.price', 'asc');
            $sort_txt = "Price - ASC";
        }
        if ($request->get('filter_price_start') !== null && $request->get('filter_price_end') !== null) {
            $filter_price_start = $request->get('filter_price_start');
            $filter_price_end = $request->get('filter_price_end');

            if ($filter_price_start > 0 && $filter_price_end > 0) {
                $query = $query->whereBetween('products_attr.price', [$filter_price_start, $filter_price_end]);
            }
        }

        if ($request->get('color_filter') !== null) {
            $color_filter = $request->get('color_filter');
            $colorFilterArr = explode(":", $color_filter);
            $colorFilterArr = array_filter($colorFilterArr);

            $query = $query->where(['products_attr.color_id' => $request->get('color_filter')]);
        }

        $query = $query->distinct()->select('products.*');
        $query = $query->get();
        $result['product'] = $query;

        foreach ($result['product'] as $list1) {

            $query1 = DB::table('products_attr');
            $query1 = $query1->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id');
            $query1 = $query1->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id');
            $query1 = $query1->where(['products_attr.products_id' => $list1->id]);
            $query1 = $query1->get();
            $result['product_attr'][$list1->id] = $query1;
        }

        $result['colors'] = DB::table('colors')
            ->where(['status' => 1])
            ->get();


        $result['categories_left'] = DB::table('categories')
            ->where(['status' => 1])
            ->get();

        $result['slug'] = $slug;
        $result['sort'] = $sort;
        $result['sort_txt'] = $sort_txt;
        $result['filter_price_start'] = $filter_price_start;
        $result['filter_price_end'] = $filter_price_end;
        $result['color_filter'] = $color_filter;
        $result['colorFilterArr'] = $colorFilterArr;
        return view('front.category', $result);
    }
    public function product(Request $request, $slug)
    {
        $result['product'] =
            DB::table('products')
            ->where(['status' => 1])
            ->where(['slug' => $slug])
            ->get();

        foreach ($result['product'] as $list1) {
            $result['product_attr'][$list1->id] =
                DB::table('products_attr')
                ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
                ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
                ->where(['products_attr.products_id' => $list1->id])
                ->get();
        }

        foreach ($result['product'] as $list1) {
            $result['product_images'][$list1->id] =
                DB::table('product_images')
                ->where(['product_images.products_id' => $list1->id])
                ->get();
        }
        $result['related_product'] =
            DB::table('products')
            ->where(['status' => 1])
            ->where('slug', '!=', $slug)
            ->where(['category_id' => $result['product'][0]->category_id])
            ->get();
        foreach ($result['related_product'] as $list1) {
            $result['related_product_attr'][$list1->id] =
                DB::table('products_attr')
                ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
                ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
                ->where(['products_attr.products_id' => $list1->id])
                ->get();
        }

        return view('front.product', $result);
    }

    public function add_to_cart(Request $request)
    {
        if ($request->session()->has('FRONT_USER_LOGIN')) {
            $uid = $request->session()->get('FRONT_USER_LOGIN');
            $user_type = "Reg";
        } else {
            $uid = getUserTempId();
            $user_type = "Not-Reg";
        }

        $size_id = $request->post('size_id');
        $color_id = $request->post('color_id');
        $pqty = $request->post('pqty');
        $product_id = $request->post('product_id');

        $result = DB::table('products_attr')
            ->select('products_attr.id')
            ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
            ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
            ->where(['products_id' => $product_id])
            ->where(['sizes.size' => $size_id])
            ->where(['colors.color' => $color_id])
            ->get();
        $product_attr_id = $result[0]->id;


        $check = DB::table('cart')
            ->where(['user_id' => $uid])
            ->where(['user_type' => $user_type])
            ->where(['product_id' => $product_id])
            ->where(['product_attr_id' => $product_attr_id])
            ->get();
        if (isset($check[0])) {
            $update_id = $check[0]->id;
            if ($pqty == 0) {
                DB::table('cart')
                    ->where(['id' => $update_id])
                    ->delete();
                $msg = "removed";
            } else {
                DB::table('cart')
                    ->where(['id' => $update_id])
                    ->update(['qty' => $pqty]);
                $msg = "updated";
            }
        } else {
            $id = DB::table('cart')->insertGetId([
                'user_id' => $uid,
                'user_type' => $user_type,
                'product_id' => $product_id,
                'product_attr_id' => $product_attr_id,
                'qty' => $pqty,
                'added_on' => date('Y-m-d h:i:s')
            ]);
            $msg = "added";
        }
        $result = DB::table('cart')
            ->leftJoin('products', 'products.id', '=', 'cart.product_id')
            ->leftJoin('products_attr', 'products_attr.id', '=', 'cart.product_attr_id')
            ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
            ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
            ->where(['user_id' => $uid])
            ->where(['user_type' => $user_type])
            ->select('cart.qty', 'products.name', 'products.image', 'sizes.size', 'colors.color', 'products_attr.price', 'products.slug', 'products.id as pid', 'products_attr.id as attr_id')
            ->get();
        return response()->json(['msg' => $msg, 'data' => $result, 'totalItem' => count($result)]);
    }

    public function cart(Request $request)
    {
        if ($request->session()->has('FRONT_USER_LOGIN')) {
            $uid = $request->session()->get('FRONT_USER_LOGIN');
            $user_type = "Reg";
        } else {
            $uid = getUserTempId();
            $user_type = "Not-Reg";
        }
        $result['list'] = DB::table('cart')
            ->leftJoin('products', 'products.id', '=', 'cart.product_id')
            ->leftJoin('products_attr', 'products_attr.id', '=', 'cart.product_attr_id')
            ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
            ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
            ->where(['user_id' => $uid])
            ->where(['user_type' => $user_type])
            ->select('cart.qty', 'products.name', 'products.image', 'sizes.size', 'colors.color', 'products_attr.price', 'products.slug', 'products.id as pid', 'products_attr.id as attr_id')
            ->get();
        return view('front.cart', $result);
    }

    public function search(Request $request, $str)
    {
        $result['product'] =
            $query = DB::table('products');
        $query = $query->leftJoin('categories', 'categories.id', '=', 'products.category_id');
        $query = $query->leftJoin('products_attr', 'products.id', '=', 'products_attr.products_id');
        $query = $query->where(['products.status' => 1]);
        $query = $query->where('name', 'like', "%$str%");
        $query = $query->orwhere('model', 'like', "%$str%");
        $query = $query->orwhere('short_desc', 'like', "%$str%");
        $query = $query->orwhere('desc', 'like', "%$str%");
        $query = $query->orwhere('keywords', 'like', "%$str%");
        $query = $query->orwhere('technical_specification', 'like', "%$str%");
        $query = $query->distinct()->select('products.*');
        $query = $query->get();
        $result['product'] = $query;

        foreach ($result['product'] as $list1) {

            $query1 = DB::table('products_attr');
            $query1 = $query1->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id');
            $query1 = $query1->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id');
            $query1 = $query1->where(['products_attr.products_id' => $list1->id]);
            $query1 = $query1->get();
            $result['product_attr'][$list1->id] = $query1;
        }

        return view('front.search', $result);
    }

    public function registration(Request $request)
    {
        if ($request->session()->has('FRONT_USER_LOGIN') != null) {
            return redirect('/');
        }

        $result = [];
        return view('front.registration', $result);
    }

    public function registration_process(Request $request)
    {
        $valid = Validator::make($request->all(), [
            "name" => 'required',
            "email" => 'required|email|unique:customers,email',
            "password" => 'required',
            "mobile" => 'required|numeric|digits:10',
        ]);

        if (!$valid->passes()) {
            return response()->json(['status' => 'error', 'error' => $valid->errors()->toArray()]);
        } else {
            $rand_id = rand(111111111, 999999999);
            $arr = [
                "name" => $request->name,
                "email" => $request->email,
                "password" => Crypt::encrypt($request->password),
                "mobile" => $request->mobile,
                "status" => 1,
                "is_verify" => 0,
                "rand_id" => $rand_id,
                "created_at" => date('Y-m-d h:i:s'),
                "updated_at" => date('Y-m-d h:i:s')
            ];
            $query = DB::table('customers')->insert($arr);
            if ($query) {

                $data = ['name' => $request->name, 'rand_id' => $rand_id];
                $user['to'] = $request->email;
                Mail::send('front/email_verification', $data, function ($messages) use ($user) {
                    $messages->to($user['to']);
                    $messages->subject('Email Id Verification');
                });

                return response()->json(['status' => 'success', 'msg' => "Registration successfully. Please check your email id for verification"]);
            }
        }
    }

    public function login_process(Request $request)
    {

        $result = DB::table('customers')
            ->where(['email' => $request->str_login_email])
            ->get();

        if (isset($result[0])) {
            $db_pwd = Crypt::decrypt($result[0]->password);
            $status = $result[0]->status;
            $is_verify = $result[0]->is_verify;

            if ($is_verify == 0) {
                return response()->json(['status' => "error", 'msg' => 'Please verify your email id']);
            }
            if ($status == 0) {
                return response()->json(['status' => "error", 'msg' => 'Your account has been deactivated']);
            }



            if ($db_pwd == $request->str_login_password) {

                if ($request->rememberme === null) {
                    setcookie('login_email', $request->str_login_email, 100);
                    setcookie('login_pwd', $request->str_login_password, 100);
                } else {
                    setcookie('login_email', $request->str_login_email, time() + 60 * 60 * 24 * 100);
                    setcookie('login_pwd', $request->str_login_password, time() + 60 * 60 * 24 * 100);
                }

                $request->session()->put('FRONT_USER_LOGIN', true);
                $request->session()->put('FRONT_USER_ID', $result[0]->id);
                $request->session()->put('FRONT_USER_NAME', $result[0]->name);
                $status = "success";
                $msg = "";
            } else {
                $status = "error";
                $msg = "Please enter valid password";
            }
        } else {
            $status = "error";
            $msg = "Please enter valid email id";
        }
        return response()->json(['status' => $status, 'msg' => $msg]);
        //$request->password
    }

    public function email_verification(Request $request, $id)
    {
        $result = DB::table('customers')
            ->where(['rand_id' => $id])
            ->where(['is_verify' => 0])
            ->get();

        if (isset($result[0])) {
            DB::table('customers')
                ->where(['id' => $result[0]->id])
                ->update(['is_verify' => 1, 'rand_id' => '']);
            return view('front.verification');
        } else {
            return redirect('/');
        }
    }


    public function forgot_password(Request $request)
    {

        $result = DB::table('customers')
            ->where(['email' => $request->str_forgot_email])
            ->get();
        $rand_id = rand(111111111, 999999999);
        if (isset($result[0])) {

            DB::table('customers')
                ->where(['email' => $request->str_forgot_email])
                ->update(['is_forgot_password' => 1, 'rand_id' => $rand_id]);

            $data = ['name' => $result[0]->name, 'rand_id' => $rand_id];
            $user['to'] = $request->str_forgot_email;
            Mail::send('front/forgot_email', $data, function ($messages) use ($user) {
                $messages->to($user['to']);
                $messages->subject("Forgot Password");
            });
            return response()->json(['status' => 'success', 'msg' => 'Please check your email for password']);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'Email id not registered']);
        }
    }


    public function forgot_password_change(Request $request, $id)
    {
        $result = DB::table('customers')
            ->where(['rand_id' => $id])
            ->where(['is_forgot_password' => 1])
            ->get();

        if (isset($result[0])) {
            $request->session()->put('FORGOT_PASSWORD_USER_ID', $result[0]->id);

            return view('front.forgot_password_change');
        } else {
            return redirect('/');
        }
    }
    
    public function forgot_password_change_process(Request $request)
    {
        DB::table('customers')
            ->where(['id' => $request->session()->get('FORGOT_PASSWORD_USER_ID')])
            ->update(
                [
                    'is_forgot_password' => 0,
                    'password' => Crypt::encrypt($request->password),
                    'rand_id' => ''
                ]
            );
        return response()->json(['status' => 'success', 'msg' => 'Password changed']);
    }
}
