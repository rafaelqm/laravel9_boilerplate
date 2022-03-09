<?php

namespace App\Http\Controllers;

use App\DataTables\RoleDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Repositories\RoleRepository;
use App\Http\Controllers\AppBaseController;
use Exception;
use Illuminate\Support\Facades\Response;

class RoleController extends AppBaseController
{
    /** @var  RoleRepository */
    private $roleRepository;

    public function __construct(RoleRepository $roleRepo)
    {
        $this->roleRepository = $roleRepo;
    }

    /**
     * Display a listing of the Role.
     *
     * @param RoleDataTable $roleDataTable
     * @return Response
     */
    public function index(RoleDataTable $roleDataTable)
    {
        return $roleDataTable->render('roles.index');
    }

    /**
     * Show the form for creating a new Role.
     *
     * @return Response
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created Papel in storage.
     *
     * @param CreateRoleRequest $request
     *
     * @return Response
     */
    public function store(CreateRoleRequest $request)
    {
        $input = $request->all();

        $role = $this->roleRepository->create($input);

        flash(
            sprintf(
                "Papel %s %s",
                trans('crud.saved'),
                trans('crud.successfully')
            ),
            'success'
        );

        return redirect(route('roles.index'));
    }

    /**
     * Display the specified Role.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $role = $this->roleRepository->find($id);

        if (empty($role)) {
            flash(
                __('models/roles.singular') . ' ' . __('messages.not_found'),
                'error'
            );

            return redirect(route('roles.index'));
        }

        return view('roles.show')->with('role', $role);
    }

    /**
     * Show the form for editing the specified Role.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $role = $this->roleRepository->find($id);

        if ((int)$id === 1) {
            flash('Não é possível editar este papel', 'error');
            return redirect(route('roles.index'));
        }


        if (empty($role)) {
            flash(
                __('models/roles.singular') . ' ' . __('messages.not_found'),
                'error'
            );

            return redirect(route('roles.index'));
        }

        return view('roles.edit')->with('role', $role);
    }

    /**
     * Update the specified Papel in storage.
     *
     * @param int $id
     * @param UpdateRoleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRoleRequest $request)
    {
        if ($id === 1) {
            flash('Não é possível editar este papel', 'error');
            return redirect(route('roles.index'));
        }
        $role = $this->roleRepository->find($id);

        if (empty($role)) {
            flash(__('models/roles.singular') . ' ' . __('messages.not_found'), 'error');

            return redirect(route('roles.index'));
        }

        $role = $this->roleRepository->update($request->all(), $id);

        flash(
            sprintf(
                "Papel %s %s",
                trans('crud.updated'),
                trans('crud.successfully')
            ),
            'success'
        );

        return redirect(route('roles.index'));
    }

    /**
     * Remove the specified Papel from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if ($id <= 5) {
            return response()->json(
                [
                    'success' => false,
                    'error' => 'Não é possível remover este papel'
                ]
            );
        }

        $role = $this->roleRepository->find($id);

        if (empty($role)) {
            flash(__('models/roles.singular') . ' ' . __('messages.not_found'), 'error');

            return redirect(route('roles.index'));
        }

        $msg = sprintf(
            "Papel %s %s",
            trans('crud.deleted'),
            trans('crud.successfully')
        );
        try {
            $deleted = $this->roleRepository->delete($id);
        } catch (Exception $e) {
            $msg = 'Erro ao remover: ' . $e->getMessage();
            $deleted = false;
//            \Bugsnag::notifyException($e);
        }



        if (request()->ajax()) {
            return response()->json(
                [
                    'success' => $deleted,
                    'error' => $msg
                ]
            );
        }

        flash(
            $msg,
            'success'
        );

        return redirect(route('roles.index'));
    }
}
