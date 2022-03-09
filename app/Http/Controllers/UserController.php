<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Response;

class UserController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the User.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('users.index');
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $people = [];

        return view('users.create')->with('people', $people);
    }

    /**
     * Store a newly created Usuário in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CreateUserRequest $request)
    {
        $input = $request->all();

        $user = $this->userRepository->create($input, auth()->user());

        flash('Usuário salvo com sucesso.', 'success');

        return redirect(route('users.index'));
    }

    /**
     * Display the specified User.
     *
     * @param int $id
     *
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->notFound();
        }

        return view('users.show')->with('user', $user);
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    private function notFound(): Application|RedirectResponse|Redirector
    {
        flash('Usuário não encontrado', 'error');

        return redirect(route('users.index'));
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param int $id
     *
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->notFound();
        }

        if (auth()->user()->level() != 5 && $user->id != auth()->user()->id) {
            flash('Você não tem permissão de editar este usuário.', 'error');
            return back();
        }

        $people = $user->userPeople;

        return view('users.edit')->with('user', $user)->with('people', $people);
    }

    /**
     * Update the specified Usuário in storage.
     *
     * @param int $id
     * @param UpdateUserRequest $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function update($id, UpdateUserRequest $request)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->notFound();
        }
        $updating_user = User::find(auth()->id());

        if (auth()->user()->level() != 5 && $user->id != auth()->user()->id) {
            flash('Você não tem permissão de editar este usuário.', 'error');
            return back();
        }

        $input = $request->all();
        $user = $this->userRepository->update($input, $id, $updating_user);

        flash("Usuário {$user->name} atualizado com sucesso.", 'success');
        if (auth()->user()->level() > 4) {
            return redirect(route('users.index'));
        }

        return redirect('/');
    }

    /**
     * Remove the specified Usuário from storage.
     *
     * @param int $id
     *
     * @return Redirector|JsonResponse
     * @throws \Exception
     *
     */
    public function destroy($id): JsonResponse|Redirector|RedirectResponse
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->notFound();
        }

        try {
            $deleted = $this->userRepository->delete($id);
            $msg = 'Usuário removido com sucesso';
        } catch (\Exception $e) {
            \Log::error($e);
            $msg = 'Erro ao remover usuário: ' . $e->getMessage();
            $deleted = false;
        }

        if (request()->ajax()) {
            return response()->json(
                [
                    'success' => $deleted,
                    'message' => $msg
                ]
            );
        }
        flash('Usuário ' . (!$deleted ? ' não ' : '') . 'removido.', ($deleted ? 'success' : 'error'));

        return redirect(route('users.index'));
    }

    public function searchUsers(Request $request)
    {
        $role_id = $request->has('role_id') ? (int) $request->get('role_id') : null;
        return $this->userRepository->searchUsers(
            $request->get('q'),
            $request->get('rule'),
            $role_id
        );
    }
}
