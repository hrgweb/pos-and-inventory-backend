<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Log;
use Hrgweb\SalesAndInventory\Domain\Category\Data\CategoryData;
use Hrgweb\SalesAndInventory\Domain\Category\Services\CategoryService;

class CategoryController extends Controller
{
    public function store(CategoryData $category)
    {
        try {
            return CategoryService::make($category->all())->save();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }
}
