<?php

namespace App\Http\Controllers\api\v1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\orderStateRequest;
use App\Http\Requests\orderUpdateRequest;
use App\Http\Requests\orderStoreRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Orders;
use Illuminate\Support\Facades\Validator;

class orderController extends Controller
{
    public function index(Request $req)
    { 
        //$querystringArray =['search'=>'search']; // sensible examples
        //$input = Request::input();
        $q = $req->input('search');
       // $orders = DB::table('orders')->select('orderNo','cName as title', 'cName','tel','postSent','mSent','destAr','pCode')->orderBy('orderNo','DESC')->appends($querystringArray)->paginate(8, ['*']);
        $orders = Orders::where('orderNo', 'LIKE', '%' . $q . '%')
        ->orWhere('cName', 'LIKE', '%' . $q . '%')
        ->paginate(8);
        $orders->appends(['search' => $q]);

/*
       $users = User::paginate(
        10, // per page (may be get it from request)
        ['*'], // columns to select from table (default *, means all fields)
        'page', // page name that holds the page number in the query string
        10 // current page, default 1
    );*/
        return response()->json($orders);
        /*return response()->json([
            'current_page' => 1,
            'per_page' => 5,
            'last_page' =>0,
            'data' => $orders, 'total' => count($orders)
        ]);*/
    }

    public function orderState(orderStateRequest $request)
    {

        $validator = Validator::make($request->all(), [
            'orderNo' => 'required',
            'tel' => 'required'
        ]);

        if ($validator->fails()) {
            $response = array('response' => $validator->errors(), 'success' => false);
            return response()->json($response);
        } else {
            $orderNo = $request->input('orderNo');
            $tel = $request->input('tel');

            $count = DB::table('orders')->where([
                            ['orderNo', '=', $orderNo],
                            ['tel', '=',  $tel],
                        ])->count();
            if($count==0){
                $response = array('response' => 'اطلاعاتی وجود ندارد', 'success' => false);
                return response()->json($response);
            }
            $order = DB::table('orders')->select('cName', 'postSent','mSent','destAr','pCode')->where([
                ['orderNo', '=', $orderNo],
                ['tel', '=',  $tel],
            ])->get();
                
             return response()->json($order, 201);

            //   $order =  Orders::create($request->all());
        }
           
    }


    public function show($id)
    {
        if (Auth::check()) {
            $order = Orders::find($id);
            return response()->json($order);
        }
        else{
            $response = array('success' => false,'message' => 'دسترسی غیر مجاز');
            $code=401;
       }
        return response()->json($response,  $code);
    }

    public function store(orderStoreRequest $request)
    {
          if (Auth::check()) {   
            $orderNo = $request->input('orderNo');
            $count = DB::table('orders')->where([
                ['orderNo', '=', $orderNo]
            ])->count();
            if($count>0){
                $response = array('message' => 'سفارش از قبل وجود دارد', 'success' => false);
                return response()->json($response,400);
            }
                 $order = new Orders;
                $order->orderNo = $request->input('orderNo');
                $order->cName = $request->input('cName');
                $order->tel = $request->input('tel');
                $order->save();
            //   $order =  Orders::create($request->all());
                return response()->json($order, 201);
          }
          $response = array('success' => false,'message' => 'دسترسی غیر مجاز');
          return response()->json($response,  401);
    }

    public function update(orderUpdateRequest $request)
    {       

        if (Auth::check()) {
            $id = $request->input('orderNo');
            $order = Orders::where('orderNo', $id)->firstOrFail();
            $order->tel = $request->input('tel');
            $order->cName = $request->input('cName');
            $order->postSent = $request->input('postSent');
            $order->mSent = $request->input('mSent');
            $order->destAr = $request->input('destAr');
            $order->pCode = $request->input('pCode');
            //  return response()->json($id);
            $order->save();
            $response = array("order"=>$order,"msg"=>"با موفقیت بروز شد", 'success' => true);
            return response()->json($response, 200);
            // $order->update($request->all());
        }
    }
    public function search(orderUpdateRequest $request)
    {       

        if (Auth::check()) {
            $id = $request->input('orderNo');
            $order = Orders::where('orderNo', $id)->paginate();        
          //  $response = array("order"=>$order,"msg"=>"با موفقیت بروز شد", 'success' => true);
            return response()->json($order);
            // $order->update($request->all());
        }
    }
    public function delete(Request $request, $id)
    {
      //  $order = Orders::find($id); // $order->delete();
       // $order->delete();


        $response = array('response' => 'order deleted', 'success' => true);
        return response()->json($response, 204);

        //return response()->json(null, 204);
    }
}
