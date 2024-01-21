<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function index()
    {
        $products = Product::orderBy('created_at', 'DESC')->paginate(5);
        return view('admin.products.index', compact('products'));
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:1000',
            'buy_price'    => 'required',
            'sell_price'   => 'required',
            'qty'          => 'required',
            'image'        => 'required',
            // 'content' => 'required|string|max:1000',
            // 'url_file' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            // Handle validation failure, re-display the form with errors
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $product = new Product();
        $product->product_name  = $request->input('product_name');
        $product->buy_price     = $request->input('buy_price');
        $product->sell_price    = $request->input('sell_price');
        $product->qty           = $request->input('qty');
        $product->image         = $request->input('image');
        $product->save();
        return redirect()->back()->with('success', 'Email Berhasil Terkirim');
    }
    // public function UploadFile(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|file|mimes:pdf|max:100', // Max 10MB
    //     ]);

    //     if ($request->file('file')->isValid()) {
    //         $file = $request->file('file');
    //         $fileName = time() . '_' . $file->getClientOriginalName();
    //         $file->move(public_path('uploads'), $fileName);
    //         Storage::disk('public')->put('uploads/' . $fileName, file_get_contents(public_path('uploads/' . $fileName)));
    //         $fileUrl = asset('storage/uploads/' . $fileName);

    //         return response()->json(['success' => 'File uploaded successfully', 'file_url' => $fileUrl]);
    //     }

    //     return response()->json(['error' => 'File upload failed']);
    // }
}
