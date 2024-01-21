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
            'buy_price'    => 'required|integer',
            'sell_price'   => 'required|integer',
            'qty'          => 'required|integer',
            'image'        => 'required|max:100', //100kb 
        ]);
        // dd($request->all());

        if ($validator->fails()) {
            // Handle validation failure, re-display the form with errors
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $product = new Product();
        $product->product_name  = $request->input('product_name');
        $product->buy_price     = $request->input('buy_price');
        $product->sell_price    = $request->input('sell_price');
        $product->qty           = $request->input('qty');


        if ($request->hasFile('image')) {
            $image                  = $request->file('image');
            $fileName               = time() . '_image_' . $image->getClientOriginalName();
            $image->storeAs('public', $fileName);

            // You can also store the path in the database if needed
            $product_url            = 'storage/' . $fileName;
            $product->image         = $product_url;
        }

        $product->save();
        return redirect()->back()->with('success', 'Product saved successfully');
    }
    public function update(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:1000',
            'buy_price'    => 'required|integer',
            'sell_price'   => 'required|integer',
            'qty'          => 'required|integer',
            'image'        => 'max:100', //100kb 
        ]);

        if ($validator->fails()) {
            // Handle validation failure, re-display the form with errors
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }


        $product->product_name  = $request->input('product_name');
        $product->buy_price     = $request->input('buy_price');
        $product->sell_price    = $request->input('sell_price');
        $product->qty           = $request->input('qty');

        if ($request->hasFile('image')) {
            $image                  = $request->file('image');
            $fileName               = time() . '_image_' . $image->getClientOriginalName();
            $image->storeAs('public', $fileName);

            // You can also store the path in the database if needed
            $product_url            = 'storage/' . $fileName;
            $product->image         = $product_url;
        }

        $product->save();

        return redirect()->back()->with('success', 'Product has been successfully updated.');
    }
    public function delete(Request $request)
    {
        $product = Product::findOrFail($request->id);

        // Delete the product
        $product->delete();

        return redirect()->back()->with(['success' => 'Product has been successfully deleted.']);
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
