<?php

namespace App\Http\Controllers\API\V1;

use App\Constants\ErrorCodes;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Interfaces\ProductRepositoryInterface;
use App\Repository\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

/**
 * Product Controller for Crud Product
 */
class ProductController extends Controller
{
    /**
     * @var ProductRepositoryInterface ProductRepositoryInterface
     */
    protected $product;

    public function __construct(ProductRepositoryInterface $product)
    {
        $this->product = $product;
    }

    /**
     * Get index method from Repository.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->product->index();
    }

    /**
     * Get show method from Repository
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return $this->product->show($id);
    }

    /**
     * Get store method from Repository
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (Auth::user()->type != UserType::Normal->value) {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|unique:products,name',
                'price' => 'required|numeric|min:1|max:10000',
                'image' => 'nullable|mimes:jpg,jpeg,png,gif|max:5000',
                'active' => 'required|boolean',
            ]);

            if ($validator->fails()) {
                return ResponseBuilder::error($validator->errors()->first(), 422, ErrorCodes::VALIDATION);
            }
            return $this->product->store($request);
        }
        return ResponseBuilder::error('Something went wrong');
    }

    /**
     * Get update method from Repository
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->type != UserType::Normal->value ) {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|unique:products,name,' . $id,
                'price' => 'required|numeric|min:1|max:10000',
                'image' => 'nullable|mimes:jpg,jpeg,png,gif|max:5000',
                'active' => 'required|boolean',
            ]);

            if ($validator->fails()) {
                return ResponseBuilder::error($validator->errors()->first(), 422, ErrorCodes::VALIDATION);
            }

            return $this->product->update($request, $id);
        }
        return ResponseBuilder::error('Something went wrong');
    }

    /**
     * Get destroy method from Repository
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (Auth::user()->type != UserType::Normal->value ) {
            return $this->product->destroy($id);
        }

        return ResponseBuilder::error('Something went wrong');
    }

}
