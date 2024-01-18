<?php

namespace Inventory\Supplier\Services;

use Exception;
use App\Models\Supplier;
use Illuminate\Support\Facades\Log;
use Inventory\Supplier\Dto\SupplierData;

class SupplierService
{
    public function __construct(protected array $request = [])
    {
    }

    public static function make(...$params)
    {
        return new static(...$params);
    }

    public static function all(): mixed
    {
        return Supplier::select(['id', 'name', 'description'])->get();
    }

    public static function fetch(): mixed
    {
        return SupplierData::collection(Supplier::paginate(10));
    }

    public function saveOrUpdate(): SupplierData
    {
        // check if it has supplier then update
        if ($this->request['id'] > 0) {
            Supplier::where('id', $this->request['id'])->update($this->request);

            Log::info('supplier (' . $this->request['name'] . ') was successfuly updated.');

            return SupplierData::from($this->request);
        }

        // else create
        $supplier =  Supplier::create($this->request);

        Log::info('new supplier (' . $this->request['name'] . ') saved.');

        return SupplierData::from($supplier)->additional(['created_at' => $supplier->created_at]);
    }

    public function remove(int $id) //: bool
    {
        $remove = Supplier::where('id', $id)->delete();

        if (!$remove) {
            throw new Exception('no supplier was removed. encountered an error.');
        }

        Log::info('1 supplier ' . $this->request['name'] . ' was successfuly removed.');

        return true;
    }
}
