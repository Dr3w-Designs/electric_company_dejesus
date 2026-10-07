<?php

namespace App\Controllers;

use App\Models\CustomerAccountModel;

class Accounts extends BaseController
{
    protected $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerAccountModel();
    }

    public function index()
    {
        if (session()->get('logged_in') !== true) {
            return redirect()->to(base_url('login'))
                ->with('error', 'Please log in to access customer accounts.');
        }

        $keyword = $this->request->getGet('search');
        $status  = $this->request->getGet('status');
        $type    = $this->request->getGet('type');
        $perPage = 10;

        $accounts = $this->customerModel->getFilteredAccounts(
            $keyword,
            $status,
            $type,
            $perPage
        );

        $data = [
            'accounts'            => $accounts,
            'pager'               => $this->customerModel->pager,
            'total_accounts'      => $this->customerModel->getTotalAccounts(),
            'active_accounts'     => $this->customerModel->getCountByStatus('active'),
            'inactive_accounts'   => $this->customerModel->getCountByStatus('inactive'),
            'suspended_accounts'  => $this->customerModel->getCountByStatus('suspended'),
            'current_page'        => $this->request->getGet('page') ?? 1,
            'search_keyword'      => $keyword,
            'filter_status'       => $status,
            'filter_type'         => $type,
        ];

        return view('accounts/index', $data);
    }

    public function viewAccount($id)
    {
        if (session()->get('logged_in') !== true) {
            return redirect()->to(base_url('login'))
                ->with('error', 'Please log in to access customer accounts.');
        }

        $account = $this->customerModel->find($id);

        if (!$account) {
            return redirect()->to(base_url('accounts'))->with('error', 'Account not found');
        }

        return view('accounts/view_account', ['account' => $account]);
    }

    public function newAccount()
    {
        if (session()->get('logged_in') !== true) {
            return redirect()->to(base_url('login'))
                ->with('error', 'Please log in to manage customer accounts.');
        }

        return view('accounts/form', [
            'title'      => 'Create Customer Account',
            'formTitle'  => 'Create Customer Account',
            'submitText' => 'Create Account',
            'account'    => [],
            'errors'     => session()->getFlashdata('validation') ?? [],
        ]);
    }

    public function createAccount()
    {
        if (session()->get('logged_in') !== true) {
            return redirect()->to(base_url('login'))
                ->with('error', 'Please log in to manage customer accounts.');
        }

        $accountData = $this->getAccountData();

        if (! $this->validateData(
            $accountData,
            $this->getAccountRules(),
            $this->getAccountValidationMessages()
        )) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator->getErrors());
        }

        try {
            if ($this->customerModel->insert($accountData) === false) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Unable to create the customer account.');
            }
        } catch (\Throwable $exception) {
            log_message('error', 'Unable to create customer account: {message}', [
                'message' => $exception->getMessage(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Unable to create the customer account. Please try again.');
        }

        return redirect()->to(base_url('accounts'))
            ->with('success', 'Customer account created successfully.');
    }

    public function editAccount($id)
    {
        if (session()->get('logged_in') !== true) {
            return redirect()->to(base_url('login'))
                ->with('error', 'Please log in to manage customer accounts.');
        }

        $account = $this->customerModel->find($id);

        if (! $account) {
            return redirect()->to(base_url('accounts'))->with('error', 'Account not found.');
        }

        return view('accounts/form', [
            'title'      => 'Edit Customer Account',
            'formTitle'  => 'Edit Customer Account',
            'submitText' => 'Save Changes',
            'account'    => $account,
            'errors'     => session()->getFlashdata('validation') ?? [],
        ]);
    }

    public function updateAccount($id)
    {
        if (session()->get('logged_in') !== true) {
            return redirect()->to(base_url('login'))
                ->with('error', 'Please log in to manage customer accounts.');
        }

        $account = $this->customerModel->find($id);

        if (! $account) {
            return redirect()->to(base_url('accounts'))->with('error', 'Account not found.');
        }

        $accountData = $this->getAccountData();

        if (! $this->validateData(
            $accountData,
            $this->getAccountRules((int) $id),
            $this->getAccountValidationMessages()
        )) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator->getErrors());
        }

        try {
            if (! $this->customerModel->update($id, $accountData)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Unable to update the customer account.');
            }
        } catch (\Throwable $exception) {
            log_message('error', 'Unable to update customer account {id}: {message}', [
                'id'      => $id,
                'message' => $exception->getMessage(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Unable to update the customer account. Please try again.');
        }

        return redirect()->to(base_url('accounts'))
            ->with('success', 'Customer account updated successfully.');
    }

    public function deleteAccount($id)
    {
        if (session()->get('logged_in') !== true) {
            return redirect()->to(base_url('login'))
                ->with('error', 'Please log in to manage customer accounts.');
        }

        $account = $this->customerModel->find($id);

        if (! $account) {
            return redirect()->to(base_url('accounts'))->with('error', 'Account not found.');
        }

        try {
            if (! $this->customerModel->delete($id)) {
                return redirect()->to(base_url('accounts'))
                    ->with('error', 'Unable to delete the customer account.');
            }
        } catch (\Throwable $exception) {
            log_message('error', 'Unable to delete customer account {id}: {message}', [
                'id'      => $id,
                'message' => $exception->getMessage(),
            ]);

            return redirect()->to(base_url('accounts'))
                ->with('error', 'Unable to delete the customer account. Please try again.');
        }

        return redirect()->to(base_url('accounts'))
            ->with('success', 'Customer account deleted successfully.');
    }

    private function getAccountData(): array
    {
        return [
            'account_number'  => trim((string) $this->request->getPost('account_number')),
            'customer_name'   => trim((string) $this->request->getPost('customer_name')),
            'address'         => trim((string) $this->request->getPost('address')),
            'phone'           => trim((string) $this->request->getPost('phone')),
            'email'           => trim((string) $this->request->getPost('email')),
            'meter_number'    => trim((string) $this->request->getPost('meter_number')),
            'connection_type' => trim((string) $this->request->getPost('connection_type')),
            'status'          => trim((string) $this->request->getPost('status')),
        ];
    }

    private function getAccountRules(?int $accountId = null): array
    {
        $accountNumberRule = 'required|max_length[50]|is_unique[customer_accounts.account_number]';

        if ($accountId !== null) {
            $accountNumberRule = 'required|max_length[50]|is_unique[customer_accounts.account_number,id,'
                . $accountId . ']';
        }

        return [
            'account_number'  => $accountNumberRule,
            'customer_name'   => 'required|min_length[2]|max_length[150]',
            'address'         => 'required|min_length[5]|max_length[2000]',
            'phone'           => 'permit_empty|max_length[20]',
            'email'           => 'permit_empty|valid_email|max_length[100]',
            'meter_number'    => 'permit_empty|max_length[50]',
            'connection_type' => 'required|in_list[residential,commercial,industrial]',
            'status'          => 'required|in_list[active,inactive,suspended]',
        ];
    }

    private function getAccountValidationMessages(): array
    {
        return [
            'account_number' => [
                'is_unique' => 'This account number is already in use.',
            ],
            'connection_type' => [
                'in_list' => 'Select a valid connection type.',
            ],
            'status' => [
                'in_list' => 'Select a valid account status.',
            ],
        ];
    }
}
