<?php namespace Flynsarmy\OrchestraCms\Repositories\Interfaces;

interface Content {

	public function create();
	public function getAll(array $params = array());
	public function find($id);
	public function store(array $input);
	public function update($id, array $input);
	public function destroy($id);

}