<?php


namespace App\Traits;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

trait ApiResponser
{
    private function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }
    public function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }
    public function showAll(Collection $collection, $code = 200)
    {
        $collection = $this->sortData($collection);
        $collection = $this->paginate($collection);
        $collection = $this->cacheResponse($collection);


        return $this->successResponse(['data' => $collection], $code);
    }
    public function showOne(Model $model, $code = 200)
    {
        return $this->successResponse(['data' => $model], $code);
    }
    public function showMessage($message, $code = 200)
    {
        return $this->successResponse(['data' => $message], $code);
    }
    protected function sortData(Collection $collection)
    {
        if (request()->has('sort_by')) {
            $attribute = request()->sort_by;
            $collection = $collection->sortBy->{$attribute};
        }
        return $collection;
    }

    protected function paginate(Collection $collection)
    {
        $rules = [
            'per_page' => 'integer|min:2|max:50',
        ];
        Validator::validate(request()->all(), $rules);
        $page = LengthAwarePaginator::resolveCurrentPage();

        $perPage = 15;
        if(request()->has('per_page'))
        {
            $perPage = (int) request()->per_page;
        }
        $results = $collection->slice(($page - 1) * $perPage, $perPage)->values();
        $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPage(),
        ]);
        $paginated->appends(request()->all());
        return $paginated;
    }
    
    protected function cacheResponse($data)
    {
        $url = request()->url();
        $queryParams = request()->query();
        ksort($queryParams);
        $queryString = http_build_query($queryParams);
        $fulUrl = "{$url}?{$queryString}";
        return Cache::remember($fulUrl,30/60,function() use($data){
            return $data;
        });
           
        
    }
}
