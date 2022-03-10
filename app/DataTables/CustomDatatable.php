<?php


namespace App\DataTables;


use Illuminate\Http\Response;
use Rap2hpoutre\FastExcel\FastExcel;
use Yajra\DataTables\QueryDataTable;
use Yajra\DataTables\Services\DataTable;

use function Yajra\DataTables\Services\queryGenerator;

class CustomDatatable extends DataTable
{
    public function excel()
    {
        $ext      = '.' . strtolower($this->excelWriter);
        $headers = [
            "Content-type" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "Content-Disposition" => 'attachment;filename="'. $this->getFilename() . $ext .'"',
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        set_time_limit(3600);

        $ext      = '.' . strtolower($this->excelWriter);
        $callback = $this->fastExcel ?
            ($this->fastExcelCallback ? $this->fastExcelCallback() : null)
            : $this->excelWriter;

       //CustomFastExcel
        return $this->buildExcelFile()->download($this->getFilename() . $ext, $callback);
    }

    /**
     * @return \Rap2hpoutre\FastExcel\FastExcel
     */
    protected function buildFastExcelFile()
    {
        $query = null;
        if (method_exists($this, 'query')) {
            $query = app()->call([$this, 'query']);
            $query = $this->applyScopes($query);
        }

        /** @var \Yajra\DataTables\DataTableAbstract $dataTable */
        $dataTable = app()->call([$this, 'dataTable'], compact('query'));
        $dataTable->skipPaging();

        if ($dataTable instanceof QueryDataTable) {
            return new CustomFastExcel($this->customQueryGenerator($dataTable));
        }

        return new CustomFastExcel($this->convertToLazyCollection($dataTable->toArray()['data']));
    }

    public function customQueryGenerator($dataTable)
    {
        foreach ($dataTable->getFilteredQuery()->cursor() as $row) {
            yield $row;
        }
    }
}
