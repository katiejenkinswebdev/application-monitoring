<?php

namespace App\Http\Controllers;

use App\Models\Product;
// TODO Refactor into ORM
// use App\Models\Review;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
     /**
     * Get all products.
     */

    public function getProducts()
    {
        $products = Product::all();
        // TODO Refactor into ORM
        $reviews = DB::select('SELECT reviews.id, products.id AS productid, reviews.rating, reviews.customerId, reviews.description, reviews.created FROM reviews INNER JOIN products ON reviews.productId = products.id');
        
        $complete_product_with_reviews = array();
    
        foreach ($products as $product) {
            $final_results = array();
            $result = $product;
            $review_array = array();
    
            $productID = $product->id;
    
            foreach ($reviews as $review) {
                $review_product_id = $review->productid;
    
                if ($productID == $review_product_id) {
    
                    array_push($review_array, $review);
                } 
            }
            array_push($final_results, $review_array);
            
            // $final_results_array= json_encode($final_results);
            $result['reviews'] = $final_results;
            // $final_results= json_encode($result);
    
            array_push($complete_product_with_reviews, $result);
        }
    
        return $complete_product_with_reviews;
    }
     
}