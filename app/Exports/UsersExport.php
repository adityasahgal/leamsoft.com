<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{

    private $q;
    private $status;
    private $role;

    public function __construct($q, $status, $role)
    {

        $this->q = $q;
        $this->status = $status;
        $this->role = $role;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $q = $this->q;
        $status = $this->status;
        $role = $this->role;

        $allArr = [];
        $data = User::with('roles')
            ->when(!empty($q), function ($qry) use ($q) {
                $qry->Where('name', 'LIKE', "%{$q}%");
                $qry->Where('username', 'LIKE', "%{$q}%");
                $qry->orWhere('email', 'LIKE', "%{$q}%");
            })
            ->when(!empty($role), function ($query) use ($role) {
                $query->whereHas('roles', function ($query) use ($role) {
                    $query->whereIn('name', $role);
                });
            })
            ->when(!empty($status), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('created_at', 'DESC')
            ->get();

        foreach ($data as $row) {
            array_push($allArr, [$row->name, $row->email, $row->designation, $row->phone]);
        }

        return collect($allArr);
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Designation',
            'Contact No'
        ];
    }
}
