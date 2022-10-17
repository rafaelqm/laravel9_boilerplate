<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->filterColumn(
                'created_at',
                function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y %H:%i') like ?", ["%$keyword%"]);
                }
            )
            ->editColumn(
                'active',
                function ($obj) {
                    if (request()->get('action') != 'csv' && request()->get('action') != 'excel') {
                        return visualYesNo($obj->active);
                    }
                    return $obj->active ? 'Ativo' : 'Inativo';
                }
            )
            ->editColumn(
                'created_at',
                function ($obj) {
                    return $obj->created_at->format('d/m/Y H:i');
                }
            )
            ->filterColumn(
                'role_names',
                function ($query, $keyword) {
                    $query->whereRaw(
                        "EXISTS (
                        SELECT 1
                        FROM roles
                        JOIN role_user ON role_user.role_id = roles.id
                        WHERE role_user.user_id = users.id
                        AND roles.name like ?
                         )",
                        ["%$keyword%"]
                    );
                }
            )
            ->addColumn('action', 'users.action')
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
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery()
            ->select(
                [
                    'users.*',
                    DB::raw(
                        "(
                        SELECT GROUP_CONCAT(roles.name SEPARATOR ', ')
                        FROM roles
                        JOIN role_user ON role_user.role_id = roles.id
                        WHERE role_user.user_id = users.id
                        ) as role_names"
                    )
                ]
            );
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
            ->pageLength(20)
            ->responsive(true)
            ->orderBy(1)
            ->language(
                asset("vendor/datatables/Portuguese-Brasil.json")
            )
            ->stateSave(true)
            ->initComplete(
                "
                function() { multipleSearch.call(this, {$this->getInputTypeColumns()}) }
                "
            )
            ->buttons(
                Button::make(
                    [
                        'extend' => 'export',
                        'className' => DEFAULT_BUTTON
                    ]
                ),
                Button::make(
                    [
                        'extend' => 'print',
                        'className' => DEFAULT_BUTTON
                    ]
                ),
                Button::make(
                    [
                        'extend' => 'reset',
                        'className' => DEFAULT_BUTTON
                    ]
                ),
                Button::make(
                    [
                        'extend' => 'reload',
                        'className' => DEFAULT_BUTTON
                    ]
                ),
                Button::make(
                    [
                        'extend' => 'colvis',
                        'text' => '<i data-toggle="tooltip" title="Colunas" class="fas fa-columns"></i>',
                        'className' => 'btn btn-sm no-corner'
                    ]
                )
            );
    }
    /**
     * Get input select
     *
     * @return string
     */
    protected function getInputTypeColumns()
    {
        $array['active']['type'] = 'select';
        $array['active']['data'] = [
            ['description' => 'Sim', 'value' => '1'],
            ['description' => 'Não', 'value' => '0'],
        ];

        return json_encode($array);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')
                ->title('#')
                ->addClass('text-right'),
            Column::make('name')
                ->title('Nome'),
            Column::make('email')
                ->title('E-Mail'),
            Column::make('role_names')
                ->title('Cargos'),
            Column::make('created_at')
                ->title('Criado')
                ->addClass('text-center'),
            Column::make('active')
                ->title('Ativo')
                ->addClass('text-center'),
            Column::computed('action')
                ->title('Ações')
                ->exportable(false)
                ->printable(false)
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
        return 'Users_' . date('YmdHis');
    }
}
