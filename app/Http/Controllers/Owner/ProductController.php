<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Owner;
use App\Models\Product;

class ProductController extends Controller
{
    public function __construct()
    {
        // ownerでログインしているか確認
        $this->middleware('auth:owners');

        $this->middleware(function ($request, $next) {

            $id = $request->route()->parameter('product'); 
            if(!is_null($id)){ 
                // テーブルを確認しID情報を取得している
                $productsOwnerId = Product::findOrFail($id)->owner->id;

                // 数値型に型変換して$productIdに代入
                    $productId = (int)$productsOwnerId;
                    
                //IDがログインしているIDと違っていたら404エラーを表示
                    if($productId !== Auth::id()){ 
                        abort(404);
                    }
                }
            return $next($request);
        });
    }

    public function index()
    {

        $products = Owner::findOrFail(Auth::id())->product;
        
        // ※compactは変数と合わせる必要がある
        return view('owner.products.index',
        compact('products'));
    } 

    public function create()
    {
        // ログインしているowner IDで絞り込む
        // selectでIDとnameを表示しつつ、getしている
        // $owners = Owner::where('id', Auth::id())
        // ->select('id')
        // ->get();

        // selectで'id', 'title', 'filename'を取得
        // orderByで新しく登録した順番に並び替える
        // $images = Image::where('owner_id', Auth::id())
        // ->select('id', 'title', 'filename')
        // ->orderBy('updated_at', 'desc')
        // ->get();

        // リレーション先の情報を得る
        // eager loadingでn+1問題がでるので、
        // with('secondary')

         // with('secondary')はpublic function secondary()を
        // 設定している(動的プロパティ)
        // $categories = PrimaryCategory::with('secondary')
        // ->get();

        return view('owner.products.create');
        // ,compact('owners'));
    }

    public function store(Request $request)
    {

            // dd($request);

            // ★登録のチェックを行う為、バリデーション記述★
            $request->validate([
                'name' => 'required|string|max:50',
                'information' => 'required|string|max:1000',
                'price' => 'required|integer',
                // ★nullでもOKになるようにnullableを記述★
                'sort_order' => 'nullable|integer',
                // 'quantity' => 'required|integer',
                // 'shop_id' => 'required|exists:shops,id',
                // 'category' => 'required|exists:secondary_categories,id',

            ]);
    
            try{
                DB::transaction(function () use($request) {
                    $product = Product::create([
                        'name' => $request->name,
                        'information' => $request->information,
                        'price' => $request->price,
                        'sort_order' => $request->sort_order,
                        // 'shop_id' => $request->shop_id,
                        // 'secondary_category_id' => $request->category,

                    ]);

                    // 商品を追加or減らす(app\Constants\Common.phpを読み込む)
                //     if($request->type === \Constant::PRODUCT_LIST['add']){
                //         $newQuantity = $request->quantity;
                //     }
                //     if($request->type === \Constant::PRODUCT_LIST['reduce']){
                //         $newQuantity = $request->quantity * -1;
                //     }                    
    
                //     Stock::create([
                //         'product_id' => $product->id,
                //         // 入庫や在庫を増やす場合はtype(在庫)を1とする
                //         'type' => 1,
                //         'quantity' => $request->quantity
                //     ]);
                }, 
            );
            }catch(Throwable $e){
                Log::error($e);
                throw $e;
            }
    
            return redirect()
            ->route('owner.products.index')
            ->with(['message' => '商品登録しました。',
            'status' => 'info']);
        
    }
    
    










}
