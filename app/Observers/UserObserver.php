<?php

namespace App\Observers;

use zFramework\Core\Abstracts\Observer;

class UserObserver extends Observer
{
    /**
     * Insert before run that
     */
    public function oninsert()
    {
        echo "inserting";
    }

    /**
     * Insert after run that
     */
    public function oninserted(array $args)
    {
        echo "inserted: " . $args['id'];
    }

    /**
     * Update before run that
     */
    public function onupdate(array $args)
    {
        echo "updating:";
        var_dump($args['where']);
        var_dump($args['sets']);
    }

    /**
     * Update after run that
     */
    public function onupdated(array $args)
    {
        echo "updated:";
        var_dump($args);
    }

    /**
     * Delete before run that
     */
    public function ondelete(array $args)
    {
        echo "deleting:";
        var_dump($args);
    }

    /**
     * Delete after run that
     */
    public function ondeleted(array $args)
    {
        echo "deleted:";
        var_dump($args);
    }
}
