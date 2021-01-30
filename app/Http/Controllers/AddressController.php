<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    public function index(Request $request) {
        $addresses = Address::search()->paginate(15);
        $search_params = $request->only([
            'name',
            'zip_code',
            'prefecture',
            'city',
            'address',
            'phone_number'
        ]);

        return view('index', [
            'addresses' => $addresses,
            'search_params' => $search_params
        ]);
    }

    public function csvDownload() {
        $addresses = Address::search()->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=file.csv"
        ];

        $callback = function() use($addresses) {
            $handle = fopen('php://output', 'w');

            $columns = [
                'id',
                'name',
                'zip_code',
                'prefecture',
                'city',
                'address',
                'phone_number'
            ];

            mb_convert_variables('SJIS-win', 'UTF-8', $columns);

            fputcsv($handle, $columns);

            foreach($addresses as $address) {
                $csv = [
                    $address->id,
                    $address->name,
                    $address->zip_code,
                    $address->prefecture,
                    $address->city,
                    $address->address,
                    $address->phone_number
                ];

                mb_convert_variables('SJIS-win', 'UTF-8', $csv);

                fputcsv($handle, $csv);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);

    }
}
