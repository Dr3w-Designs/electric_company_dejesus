<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUsernameToUsers extends Migration
{
    public function up()
    {
        if ($this->db->fieldExists('username', 'user_accounts')) {
            return;
        }

        $this->forge->addColumn('user_accounts', [
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'last_name',
            ],
        ]);

        $used = [];
        $users = $this->db->table('user_accounts')
            ->select('id, email')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();

        foreach ($users as $user) {
            $emailLocalPart = explode('@', strtolower((string) $user['email']), 2)[0];
            $baseUsername   = trim((string) preg_replace('/[^a-z0-9_-]+/', '_', $emailLocalPart), '_-');

            if (strlen($baseUsername) < 3) {
                $baseUsername = 'user' . $user['id'];
            }

            $baseUsername = substr($baseUsername, 0, 50);
            $username     = $baseUsername;

            if (isset($used[$username])) {
                $suffix   = '_' . $user['id'];
                $username = substr($baseUsername, 0, 50 - strlen($suffix)) . $suffix;
            }

            $used[$username] = true;

            $this->db->table('user_accounts')
                ->where('id', $user['id'])
                ->update(['username' => $username]);
        }

        $this->forge->modifyColumn('user_accounts', [
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
        ]);
        $this->forge->addUniqueKey('username', 'user_accounts_username_unique');
        $this->forge->processIndexes('user_accounts');
    }

    public function down()
    {
        if (! $this->db->fieldExists('username', 'user_accounts')) {
            return;
        }

        $this->forge->dropKey('user_accounts', 'user_accounts_username_unique');
        $this->forge->dropColumn('user_accounts', 'username');
    }
}
