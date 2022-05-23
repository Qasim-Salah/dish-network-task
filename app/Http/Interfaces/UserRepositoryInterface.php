<?php

namespace App\Http\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Psr\Http\Message\RequestInterface;

/**
 * User interface for Repository.
 */
interface UserRepositoryInterface
{
    /**
     * Get All User .
     */
    public function index();

    /**
     * show User Information
     * @param int $id
     */
    public function show($id);

    /**
     * Creates a User .
     *
     * @param  $request
     */
    public function store($request);

    /**
     * Update a User Information.
     *
     * @param  $request
     * @param int $id
     */
    public function update($request, $id);

    /**
     * destroy User .
     *
     * @param int $id
     */
    public function destroy($id);
}


