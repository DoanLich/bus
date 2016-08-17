<?php
/**
 * @Author: Lich
 * @Date:   2016-08-17 00:03:39
 * @Last Modified by:   doanlich
 * @Last Modified time: 2016-08-17 09:04:55
 */
namespace App\Repositories\Contracts;

interface RepositoryInterface {

    public function all($columns = array('*'));

    public function paginate($perPage = 15, $columns = array('*'));

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function find($id, $columns = array('*'));

    public function findOrFail($id, $columns = array('*'));

    public function findBy($field, $value, $columns = array('*'));

    public function getObject();
}