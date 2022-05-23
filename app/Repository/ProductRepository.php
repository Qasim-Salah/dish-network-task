<?php

namespace App\Repository;


use App\Http\Controllers\API\V1\ResponseBuilder;
use App\Http\Interfaces\ProductRepositoryInterface;
use App\Http\Resources\ProductResource;
use App\Models\Product as ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class ProductRepository.
 */
class ProductRepository implements ProductRepositoryInterface
{

    /**
     * Get get ProductModel.
     *
     * @var ProductModel
     */

    protected $product;

    public function __construct(ProductModel $product)
    {
        $this->product = $product;
    }

    /**
     * Get All Product OrderBy Id Desc.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $product = $this->product->active()->latest()->get();

        return ResponseBuilder::success(ProductResource::collection($product));
    }

    /**
     * Show Product Information.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = $this->product->findOrFail($id);

        return ResponseBuilder::success(new  ProductResource($user));
    }

    /**
     * Add Product In The System.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($request)
    {
        $user = $this->product->create([
            'image' => $request->hasFile('image') ? upload_image('products', $request->file('image')) : null,
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'active' => $request->input('active'),
        ]);

        return ResponseBuilder::success(null, 'Added successfully');
    }

    /**
     * Update Product Information.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($request, $id)
    {
        $product = $this->product->findOrFail($id);

        $product->update([
            'image' => $request->hasFile('image') ? upload_image('products', $request->file('image')) : $product->image,
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'active' => $request->input('active'),
        ]);

        return ResponseBuilder::success(null, 'Updated successfully');
    }

    /**
     * Delete Product.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $product = $this->product->findOrFail($id);

        if ($product->image) {
            $image = Str::after($product->image, 'storage/products/');

            #delete from folder
            Storage::disk('public')->delete('products/' . $image);

        }
        if ($product->delete()) {
            return ResponseBuilder::success(null, 'Deleted successfully');
        }
    }
}
