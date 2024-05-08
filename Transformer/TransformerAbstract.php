<?php


namespace App\Pkg;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


abstract class TransformerAbstract
{
//    abstract function transform($model): array;

    protected mixed $context;

    public function __construct($context = ['default'])
    {
        $this->context = $context;
    }

    function transform($model): mixed
    {
        $result = [];

        if (!is_array($this->context)) {
            throw new \Exception("转换器参数异常");
        }

        if ($model === null) {
            return null;
        }

        foreach ($this->context as $method_name) {

            $exec = $this->$method_name($model);

            // 为了方便直接使用toArray()
            if (isset($exec->created_at)) {
                $exec["created_at"] = $model->created_at;
            }
            if (isset($exec->updated_at)) {
                $exec["updated_at"] = $model->updated_at;
            }

            $result = array_merge($result, $exec);
        }

        return $result;
    }

    function do($source)
    {
        $new = $source;

        if ($new instanceof Collection || $new instanceof LengthAwarePaginator) {
            // 查询的是数组
            foreach ($new as $k => $row) {
                $new[$k] = $this->transform($row);
            }
        } else {
            // 查询的是单个
            $new = $this->transform($new);
        }

        return $new;
    }
}
