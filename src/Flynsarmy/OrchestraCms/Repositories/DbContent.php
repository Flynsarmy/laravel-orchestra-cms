<?php namespace Flynsarmy\OrchestraCms\Repositories;

use Flynsarmy\OrchestraCms\Repositories\Interfaces\Content as RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class DbContent implements RepositoryInterface {

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Retrieve a paginated list of model instances
     *
     * @param  array                                $params array('filters' => array(), 'sortBy' => 'title')
     * @return Illuminate\Pagination\Paginator      Paginated result list
     */
    public function getAll(array $params = array())
    {
        $params = array_merge(array(
            'filters' => array(),
            'sortBy' => 'title',
            'order' => 'asc',
        ), $params);

        return $this->model
            ->with('author')
            ->orderBy($params['sortBy'], $params['order'])
            ->paginate();
    }

    public function find( $id )
    {
    	return $this->model->findOrFail($id);
    }

    public function create()
    {
        return $this->model;
    }

    public function store( array $input )
    {
        return $this->model->create( $input );
    }

    public function update( $id, array $input )
    {
        $model = $this->find( $id );
        $model->update( $input );

        return $model;
    }

    public function destroy( $id )
    {
    	$this->find( $id )->delete();
    }
}