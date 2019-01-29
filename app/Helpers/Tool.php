<?php

namespace App\Helpers;

use App\Tool as ToolModel;

class Tool
{
    public function getList(array $params = [])
    {
        $query = ToolModel::get();
        return $query;
    }

    public function getItem(ToolModel $model)
    {
        return $model;
    }

    public function store(array $data)
    {
        return ToolModel::create($data);
    }

    public function update(ToolModel $model, array $data)
    {
        $model->update($data);
        return $model;
    }

    public function destroy(ToolModel $tool)
    {
        ToolModel::destroy($tool->id);
    }
}
