<?php


namespace App\Pkg;


use Illuminate\Http\JsonResponse;

class Demo
{
    public function show()
    {
        return Response::collection([], new DemoTransformer("default"));
    }
}

class DemoTransformer extends TransformerAbstract
{
    function default($data)
    {
        return $data->toArray();
    }
}

class Response
{
    static function collection($data, TransformerAbstract $transformer, $msg = "成功")
    {
        $new_data = (new Manager($data, $transformer))->data();

        return response()->json([
            "code" => 200,
            "msg" => $msg,
            "data" => $new_data
        ]);
    }
}
