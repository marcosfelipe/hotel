<?php

class EmployeesController extends ApplicationController
{

    public function beforeAction($action){
        $roles = [
            'all' => '2',
        ];
        parent::beforeAction($action,$roles);
    }

    private function getLevels()
    {
        return [['value' => '1', 'option' => 'Recepcionista'], ['value' => '2', 'option' => 'Gerente']];
    }

    public function index()
    {
        $this->employees = Employee::where('active=true');
    }

    public function fresh()
    {
        $this->levels = $this->getLevels();
        $this->employee = new Employee();
    }

    public function create()
    {
        $this->levels = $this->getLevels();
        $this->employee = new Employee($this->params['employee']);
        if ($this->employee->save()) {
            Flash::message('success', 'Novo funcionário criado com sucesso!');
            $this->redirect_to('/funcionarios');
        } else {
            Flash::message('danger', 'O formulário contém erros!');
        }
        $this->view = 'employees/fresh';
    }

    public function update()
    {
        $this->levels = $this->getLevels();
        $this->employee = Employee::find($this->params[':id']);
        $this->employee->setData($this->params['employee']);
        if ($this->employee->update()) {
            Flash::message('success', 'Funcionário editado com sucesso!');
            $this->redirect_to('/funcionarios');
        } else {
            Flash::message('danger', 'O formulário contém erros!');
        }
        $this->view = 'employees/edit';
    }

    public function destroy()
    {
        $this->employee = Employee::find($this->params[':id']);
        if ($this->employee->destroy()) {
            Flash::message('success', 'Funcionário excluido com sucesso!');
        } else {
            Flash::message('danger', 'Erro ao excluir o funcionário!');
        }
        $this->redirect_to('/funcionarios');
    }

    public function resetPassword()
    {
        $employee = Employee::find($this->params[':id']);
        $employee->setData(['password' => null]);
        if ($employee->update()) {
            Flash::message('success', 'Senha do funcionário restabelecida!
                No próximo acesso ao sistema uma nova senha será solicitada.');
        } else {
            Flash::message('danger', 'Erro ao restabelecer senha do funcionário!');
        }
        $this->redirect_to( $this->back() );
    }

    public function show()
    {
        $this->employee = Employee::find($this->params[':id']);
    }

    public function edit()
    {
        $this->levels = $this->getLevels();
        $this->employee = Employee::find($this->params[':id']);
    }


}