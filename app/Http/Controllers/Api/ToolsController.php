<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\DestroyToolRequest;
use App\Http\Requests\ShowToolRequest;
use App\Http\Requests\StoreToolRequest;
use App\Http\Requests\UpdateToolRequest;
use App\Helpers\Tool as ToolsHelper;
use Illuminate\Http\Request;

/**
 * @group Tools management
 *
 * APIs for Tools CRUD
 */
class ToolsController extends \App\Http\Controllers\Controller
{
    /**
     * Add
     *
     * Добавить новый инструмент, например ```php```, ```mysql```
     *
     * @bodyParam name string required Tool name. Example: sql
     * @authenticated
     */
    public function store(StoreToolRequest $request)
    {
        $data = request()->all();
        $tool = app()->make(ToolsHelper::class)->store($data);
        return response()->json($tool);
    }

    /**
     * List
     *
     * Получить список всех инструментов
     *
     * @authenticated
     */
    public function index(ShowToolRequest $request)
    {
        $data = app()->make(ToolsHelper::class)->getList();
        return response()->json($data);
    }

    /**
     * Item
     *
     * Получить данные по инструменту по его ID - {tool}
     *
     * @authenticated
     */
    public function show(ShowToolRequest $request, \App\Tool $tool)
    {
        $data = app()->make(ToolsHelper::class)->getItem($tool);
        return response()->json($data);
    }

    /**
     * Delete
     *
     * Удалить инструмент по его ID - {tool}
     *
     * @authenticated
     */
    public function destroy(DestroyToolRequest $request, \App\Tool $tool)
    {
        app()->make(ToolsHelper::class)->destroy($tool);
    }

    /**
     * Update
     *
     * Обновить инструмент по его ID - {tool}
     *
     * @bodyParam name string required Tool name. Example: php
     * @authenticated
     */
    public function update(UpdateToolRequest $request, \App\Tool $tool)
    {
        $data = request()->all();
        $responseData = app()->make(ToolsHelper::class)->update($tool, $data);
        return response()->json($responseData);
    }
}
