<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;
use Illuminate\Support\Facades\Validator;

class orderController extends Controller
{
    public function index()
    {
        $orders = Orders::paginate();

        return response()->json($orders);
        /*return response()->json([
            'current_page' => 1,
            'per_page' => 5,
            'last_page' =>0,
            'data' => $orders, 'total' => count($orders)
        ]);*/
    }

    public function show($id)
    {
        $order = Orders::find($id);
        return response()->json($order);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'orderNo' => 'required',
            'tel' => 'required'
        ]);

        if ($validator->fails()) {
            $response = array('response' => $validator->errors(), 'success' => false);
            return response()->json($response);
        } else {
            $order = new Orders;
            $order->orderNo = $request->input('orderNo');
            $order->tel = $request->input('tel');
            $order->save();

            //   $order =  Orders::create($request->all());
        }
        return response()->json($order, 201);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'orderNo' => 'required'
        ]);

        if ($validator->fails()) {
            $response = array('response' => $validator->errors(), 'success' => false);
            return response()->json($response);
        } else {
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

    public function delete(Request $request, $id)
    {
        $order = Orders::find($id); // $order->delete();
        $order->delete();


        $response = array('response' => 'order deleted', 'success' => true);
        return response()->json($response, 204);

        //return response()->json(null, 204);
    }
}
