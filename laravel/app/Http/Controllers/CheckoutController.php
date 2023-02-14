<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
// TODO Refactor to ORM
// use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Exceptions\Handler;

// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Route;
// use App\Exceptions\Handler;
// use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sentry\State\Scope;

class CheckoutController extends Controller
{
    /**
     * Checkout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    function get_inventory() {
        // echo('in get_inventory');
        $inventory_results = DB::select('SELECT * FROM inventory');
        // echo ('in inventory');
        // echo json_encode($inventory_results);
        return $inventory_results;
    }

    function decrement_inventory($item) {
        echo('in decrement_inventory');
        // Cache::decrement($item->id, 1);
    }

    function is_out_of_stock($item) {
        // echo('is out of stock');
        // $inventory = $this->get_inventory();
        // echo('inventory');
        // echo $inventory;
        // echo json_decode($inventory);
        // echo($inventory_results_decode);
        // echo $item[0];
        // $item_id= json_decode($item[0]->id);
        // echo($item_id);
        // echo('item_id');
        // echo $item_id->id;

        // return $inventory->$item[0]->id <= 0;
        return true;
    }

    function process_order($cart) {
        // echo('in process_order');
        // foreach ($cart as $item) {
            // if ($this->is_out_of_stock($item)) {
                echo('out of stock, throw Exception');
                throw new Exception('Not enough inventory for this item');
                // throw new Exception("Not enough inventory for " . $item->id);
            // } else {
            //     $this->decrement_inventory($item);
            // }
        // }
    }

     function checkout(Request $request)
    {
        try {
            // app('sentry')->configureScope(static function (Scope $scope) use ($request): void {
                $checkout_payload = $request->getContent();
                $order = json_decode($checkout_payload);
                $cart = $order->cart;
                // $email = $order->email;
                // $scope->setUser(['email' => $email]);
                // $scope->setTags(["transaction_id" => $request->header('X-Transaction-ID')]);
                // $scope->setTags(["session-id" => $request->header('X-Session-Id')]);
                // $scope->setExtra("order", $cart);
                $this->process_order($order->cart);
            // });
        } catch (Exception $error) {
            report($error);
            return response("Internal Server Error", 500)->header("HTTP/1.1 500", "")->header('Content-Type', "text/html");
        }
    }
}