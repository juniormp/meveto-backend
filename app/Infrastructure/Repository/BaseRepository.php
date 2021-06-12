<?php


namespace App\Infrastructure\Repository;

use Illuminate\Database\Eloquent\Model;

class BaseRepository implements IBaseRepository
{
    private $model;

    public function __construct(string $model)
    {
        $this->model = new $model;
    }

    public function save($model): Model
    {
        $model->save();
        return $model->refresh();
    }
}
