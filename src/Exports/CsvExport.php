<?php
namespace AmiCrud\Exports;

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
        return collect($this->data['list_contents'])->map(function ($content) {
            $dvalue = [];
            foreach($this->data['display_field'] as $value){
                $dvalue[$value] = $content->{$value};
            }
           return $dvalue;
        });
    }

    public function headings(): array
    {
        // Return the headers as an array
        return $this->data['display_field'];
    }

}
