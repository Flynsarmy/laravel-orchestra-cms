<?php

use Illuminate\Database\Migrations\Migration;

use Orchestra\Support\Facades\Acl;
use Orchestra\Support\Facades\App;
use Orchestra\Model\Role;

class FlynsarmyOrchestracmsSeedAcl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $admin  = Role::admin();
        $member = Role::member();
        $acl    = Acl::make('flynsarmy/orchestra-cms');

        $acl->roles()->attach(array($member->name, $admin->name));
        $acl->actions()->attach(array(
            'Create Page', 'Update Page', 'Delete Page', 'Manage Page',
            'Create Template', 'Update Template', 'Delete Template', 'Manage Template',
            'Create Partial', 'Update Partial', 'Delete Partial', 'Manage Partial',
        ));

        $acl->allow($member->name, array(
            'Create Page', 'Update Page', 'Delete Page',
            'Create Template', 'Update Template', 'Delete Template',
            'Create Partial', 'Update Partial', 'Delete Partial',
        ));

        $acl->allow($admin->name, array(
            'Create Page', 'Update Page', 'Delete Page', 'Manage Page',
            'Create Template', 'Update Template', 'Delete Template', 'Manage Template',
            'Create Partial', 'Update Partial', 'Delete Partial', 'Manage Partial',
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        App::memory()->forget('acl_flynsarmy/orchestra-cms');
    }
}
