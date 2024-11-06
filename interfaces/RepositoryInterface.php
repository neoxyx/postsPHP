<?php
namespace Interfaces;

interface RepositoryInterface {
    public function findById($id);
    public function save($data);
}
?>
