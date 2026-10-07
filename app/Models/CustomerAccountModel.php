<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerAccountModel extends Model
{
    protected $table            = 'customer_accounts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'account_number',
        'customer_name',
        'address',
        'phone',
        'email',
        'meter_number',
        'connection_type',
        'status',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getAccountsPaginated(int $perPage = 10): array
    {
        return $this->orderBy('created_at', 'DESC')->paginate($perPage);
    }

    public function searchAccounts(string $keyword, int $perPage = 10): array
    {
        return $this->groupStart()
            ->like('account_number', $keyword)
            ->orLike('customer_name', $keyword)
            ->orLike('email', $keyword)
            ->orLike('phone', $keyword)
            ->groupEnd()
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);
    }

    public function getFilteredAccounts(
        ?string $keyword = null,
        ?string $status = null,
        ?string $type = null,
        int $perPage = 10
    ): array {
        if ($keyword) {
            $this->groupStart()
                ->like('account_number', $keyword)
                ->orLike('customer_name', $keyword)
                ->orLike('email', $keyword)
                ->orLike('phone', $keyword)
                ->groupEnd();
        }

        if ($status) {
            $this->where('status', $status);
        }

        if ($type) {
            $this->where('connection_type', $type);
        }

        return $this->orderBy('created_at', 'DESC')->paginate($perPage);
    }

    public function getAccountsByStatus(string $status, int $perPage = 10): array
    {
        return $this->where('status', $status)
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);
    }

    public function getAccountsByType(string $type, int $perPage = 10): array
    {
        return $this->where('connection_type', $type)
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);
    }

    public function getTotalAccounts(): int
    {
        return $this->countAll();
    }

    public function getCountByStatus(string $status): int
    {
        return $this->where('status', $status)->countAllResults();
    }
}
