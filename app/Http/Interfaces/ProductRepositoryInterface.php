<?php

namespace App\Http\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Psr\Http\Message\RequestInterface;

/**
 * Product interface for Repository.
 */
interface ProductRepositoryInterface
{
    /**
     * Get All Product.
     */

    public function index();

    /**
     * show Product Information.
     *
     * @param int $id
     */

    public function show($id);

    /**
     * Creates a Product .
     *
     * @param $request
     */

    public function store($request);

    /**
     * Update a Product Information.
     *
     * @param $request
     * @param int $id
     */

    public function update($request, $id);

    /**
     * destroy Product .
     * @param int $id
     */

    public function destroy($id);
}


