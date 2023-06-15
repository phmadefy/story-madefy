<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    protected $table = "users_permissions";

    protected $fillable = [
        'description', 'create_user', 'update_user', 'delete_user', 'create_permission', 'update_permission', 'delete_permission',
        'create_pessoal', 'update_pessoal', 'delete_pessoal', 'create_product', 'update_product', 'delete_product',
        'create_emitente', 'update_emitente', 'delete_emitente', 'create_payments', 'update_payments', 'delete_payments',
        'create_sale', 'update_sale', 'pay_sale', 'desconto_sale', 'delete_sale', 'create_monitor', 'update_monitor', 'delete_monitor',
        'create_nfe', 'update_nfe', 'delete_nfe',
        'create_contratos', 'update_contratos', 'delete_contratos',
        'create_caixa', 'update_caixa', 'delete_caixa', 'create_contas', 'update_contas', 'pay_contas', 'delete_contas',
        'create_receitas', 'update_receitas', 'pay_receitas', 'delete_receitas', 'uuid', 'company_id',
    ];

    protected $hidden = ['id'];
}
