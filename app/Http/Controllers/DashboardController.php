<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(){
        $total_product=Product::count();
        $total_stock=Product::sum('stock');
        $total_user=User::count();
        return response()->json([
            'total_product'=>$total_product,
            'total_stock'=>$total_stock,
            'total_user'=>$total_user
        ]);
    }
}
