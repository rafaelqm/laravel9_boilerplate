<?php

namespace App\DataTables;

use App\Models\Role;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class RoleDataTable extends DataTable
{
    //    protected $fastExcel = true; // Exportar usando Spout/FastExcel
    //    protected $fastExcelCallback = false; // Caso queira mais rápido ainda, ativar esta opção.
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable
            ->editColumn(
                'active',
                function ($obj) {
                    if (request()->get('action') !== 'csv' && request()->get('action') !== 'excel') {
                        return visualYesNo($obj->active);
                    }
                    return $obj->active ? 'Ativo' : 'Inativo';
                }
            )
            ->filterColumn(
                'created_at',
                function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y %H:%i') like ?", ["%$keyword%"]);
                }
            )
            ->editColumn(
                'created_at',
                function ($obj) {
                    return $obj->created_at->format('d/m/Y H:i');
                }
            )
            ->editColumn(
                'level',
                function ($obj) {
                    return Role::NIVEIS[$obj->level];
                }
            )
            ->addColumn('action', 'roles.datatables_actions')
            ->rawColumns(
                [
                    'active',
                    'action'
                ]
            );
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Role $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Role $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('dataTableBuilder')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrltip')
            ->pageLength(10)
            ->responsive(true)
            ->orderBy(0, 'desc')
            ->stateSave(true)
            ->language(
                asset("vendor/datatables/Portuguese-Brasil.json")
            )
            ->buttons(
                Button::make(['extend' => 'export', 'className' => DEFAULT_BUTTON]),
                Button::make(['extend' => 'print', 'className' => DEFAULT_BUTTON]),
                Button::make(['extend' => 'reset', 'className' => DEFAULT_BUTTON]),
                Button::make(['extend' => 'reload', 'className' => DEFAULT_BUTTON])
            )
            ->initComplete(
                "
                function() { multipleSearch.call(this, {$this->getInputTypeColumns()}) }
                "
            );
    }

    protected function getInputTypeColumns()
    {
        $array['active']['type'] = 'select';
        $array['active']['data'] = [
            ['description' => 'Sim', 'value' => '1'],
            ['description' => 'Não', 'value' => '0'],
        ];
        $array['level']['type'] = 'select';
        $array['level']['data'] = [
            ['description' => Role::NIVEIS[1], 'value' => '1'],
            ['description' => Role::NIVEIS[2], 'value' => '2'],
            ['description' => Role::NIVEIS[3], 'value' => '3'],
            ['description' => Role::NIVEIS[4], 'value' => '4'],
            ['description' => Role::NIVEIS[5], 'value' => '5'],
        ];

        return json_encode($array);
    }

    protected function getColumns()
    {
        return [
            'name' => [
                'title' => 'Nome'
            ],
            'slug',
            'description' => [
                'name' => 'description',
                'data' => 'description',
                'title' => 'Descrição',
                'width' => '10%',
                'class' => 'text-left'
            ],
            'level' => [
                'name' => 'level',
                'data' => 'level',
                'title' => 'Nível',
                'width' => '10%',
                'class' => 'text-left'
            ],
            'created_at' => [
                'name' => 'created_at',
                'data' => 'created_at',
                'title' => 'Cadastro em',
                'width' => '15%',
                'class' => 'text-center'
            ],
            'active' => [
                'name' => 'active',
                'data' => 'active',
                'title' => 'Ativo',
                'width' => '5%',
                'class' => 'text-center'
            ],
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->title('Ações')
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'roles_' . time();
    }
}
