<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Period;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        // $products = Product::select('id', 'name', 'description', 'stock', 'brand_id', 'created_at')
        //                 ->with('brand')
        //                 // ->orderBy('created_at', 'desc')
        //                 ->latest()
        //                 ->get();

        $products = Cache::remember('products', 60, function () {
            return Product::select('id', 'name', 'description', 'stock','price', 'brand_id', 'created_at')->with('brand')->latest()->get();
        });

        return view('master.products.index', ['products' => $products]);
    }

    public function list()
    {
        if (request()->ajax())
        {
            $products = DB::table('products')
                ->join('brands', 'products.brand_id', '=', 'brands.id')
                ->select('products.id', 'products.name AS productName', 'products.description AS productDescription', 'products.stock AS productStock','products.price AS productPrice',
                    'products.updated_at', 'brands.name AS brandName', 'products.created_at')
                ->orderBy('products.id', 'desc')
                ->get();

            return DataTables::of($products)
                ->addColumn('action', function ($data) {
                    //create links for edit and show functionality
                    return '<a href="'.route("products.edit", $data->id).'" class="btn btn-info btn-sm text-white mb-4">
                                <i class="la la-edit text-white" style="font-size: 1.5em;"></i>
                                Edit
                            </a>
                            <a href="'.route("products.show", $data->id).'"  class="btn btn-info btn-sm text-white mb-4"
                                style="background-color: purple; border: 1px solid purple;">
                                <i class="la la-eye text-white" style="font-size: 1.5em;"></i> View Image
                            </a>';
                })
            ->make();
        }

        return view('master.products.list');
    }

    public function create()
    {
        $brands = Brand::get();
        $categories = Category::get();
        $units = Unit::get();
        return view('master.products.create', [
            'brands' => $brands,
            'categories' => $categories,
            'units' => $units
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:products',
            'description' => 'required',
            'brand_id' => 'required',
            'category_id' => 'required',
            'unit_id' => 'required',
            'stock' => 'required',
            'price' => 'required'
            // 'image' => 'required|mimes:jpg,jpeg,png,bmp,tiff'
        ]);

        $image = $request->file('image');

        if ($request->hasFile('image')) {
            if ($image->isValid())
            {
                $destinationPath = public_path() . '/files/products/';
                $imageFile = time() . '-' . Str::random(15) . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $imageFile);
                $imageName = '/files/products/'.$imageFile;
            }
        } else {
            $imageName = '/img/no-image.png';
        }

        Product::create([
            'name' => strtoupper($request->name),
            'image' => $imageName,
            'description' => $request->description,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'part_product_id' => $request->part_product_id,
            'unit_id' => $request->unit_id,
            'period_id' => $request->period_id,
            'status' => $request->status,
            'stock' => $request->stock,
            'price' => $request->price,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('products.index')->with('success', 'Product success created');
    }

    public function show($id)
    {
        $product = Product::find($id);
        return view('master.products.show', ['product' => $product]);
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $brands = Brand::get();
        $categories = Category::get();
        $units = Unit::get();

        return view('master.products.edit', [
            'product' => $product,
            'brands' => $brands,
            'units' => $units,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            // 'image' => 'mimes:jpg,jpeg,png',
            'description' => 'required',
            'brand_id' => 'required',
            'category_id' => 'required',
            'unit_id' => 'required',
            'stock' => 'required',
            'price' => 'required'
        ]);

        $product = Product::find($id);

        $image = $request->file('image');

        if ($request->hasFile('image')) {
            if ($image->isValid() && !is_null($image))
            {
                if (file_exists(public_path().'/files'.$product->image)) {
                    unlink(public_path().'/files'.$product->image);
                }
                $destinationPath = public_path() . '/files/products/';
                $imageFile = time() . '-' . Str::random(15) . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $imageFile);
                $imageName = '/files/products/'.$imageFile;
            }
        } else {
            $imageName = $product->image;
        }

        $product->update([
            'name' => strtoupper($request->name),
            'image' => $imageName,
            'description' => $request->description,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'unit_id' => $request->unit_id,
            'period_id' => $request->period_id,
            'status' => $request->status,
            'stock' => $request->stock,
            'price' => $request->price,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('products.index')->with('success', 'Product success updated');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product success delete');
    }
}
