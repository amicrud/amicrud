<?php
namespace Amicrud\Amicrud\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CsvExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        // Convert your data to a collection and return it
        return collect($this->data);
    }

    public function headings(): array
    {
        // Return the headers as an array
        return ['Header1', 'Header2', 'Header3']; // Modify as per your data structure
    }
}
