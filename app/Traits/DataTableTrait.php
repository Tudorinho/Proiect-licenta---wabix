<?php
namespace App\Traits;

trait DataTableTrait {
    public function getdDtRecords($modelClass, $request)
    {
        $query = $modelClass::query();
        $query = $this->addPagination($query, $request);
        $query = $this->addFilters($query, $request);
        $query = $this->addOrder($query, $request);
//dd($query->toRawSql());
        return $query->get();
    }

    public function getDtTotalRecords($modelClass, $request)
    {
        $query = $modelClass::query();

        $query = $this->addFilters($query, $request);

        return $query->count();
    }

    public function addWhereCondition($query, $key, $value)
    {
        $dateFields = ['created_at', 'updated_at', 'date', 'due_date'];
        $numberFields = ['amount', 'estimated_value', 'hours'];

        if (in_array($key, $dateFields)){
            $explodedDate = explode('::', $value);
            if (sizeof($explodedDate) == 2){
                $query->whereBetween($key, [$explodedDate[0], $explodedDate[1]]);
            } else{
                $query->where($key, '>=', $value);
//                $query->where($key, '=', $value);
            }
        } elseif(in_array($key, $numberFields)) {
            $query->where($key, '>=', $value);
        } elseif(str_contains($key, 'id')){
            $query->where($key, '=', (int)$value);
        } else{
            $query->where($key, 'LIKE', '%'.$value.'%');
        }

        return $query;
    }

    public function addFilters($query, $request){
        if (!empty($request->columns)){
            foreach ($request->columns as $column){
                $columnName = $column['name'];
                $columnValue = $column['search']['value'];
                $isSearchable = $column['searchable'];
                if ($isSearchable == true){
                    if (!empty($columnValue)){
                        $query = $this->addWhereCondition($query, $columnName, $columnValue);
                    }
                }
            }
        }

        return $query;
    }

    public function addPagination($query, $request)
    {
        $start = $request->has('start') ? $request->start : null;
        $length = $request->has('length') ? $request->length : null;
        if (!empty($start)){
            $query->skip($start);
        }
        if (!empty($length)){
            $query->take($length);
        }

        return $query;
    }

    public function addOrder($query, $request){
        if (!empty($request->columns) && !empty($request->order[0])){
           $orderColumnIndex = $request->order[0]['column'];
           $orderColumnName = $request->columns[$orderColumnIndex]['name'];
           $orderColumnDirection = $request->order[0]['dir'];
           $isOrderable = $request->columns[$orderColumnIndex]['orderable'];

           if ($isOrderable != 'false'){
               $query->orderBy($orderColumnName, $orderColumnDirection);
           }
        }

        return $query;
    }
}
