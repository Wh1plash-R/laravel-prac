<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;

class LearnerFilter
{
    /**
     * Handle the query for customers.
     *
     * @param Request $request
     * @return array
     */

    public function transform(Request $request)
    {
    $filters = [];

    foreach ($request->all() as $key => $value) {
        if (is_array($value) && isset($value['eq'])) {
            if ($key === 'name') {
                $filters[] = ['LOWER(name)', '=', strtolower($value['eq'])];
            } else {
                $filters[] = [$key, '=', $value['eq']];
            }
        }
    }

    return $filters;
    }


}
