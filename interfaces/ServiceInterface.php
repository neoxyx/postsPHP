<?php

namespace Services;

interface ServiceInterface {
    /**
     * Crear una entidad en el sistema.
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Obtener una entidad por su ID.
     * @param int $id
     * @return mixed
     */
    public function getById(int $id);

    /**
     * Actualizar una entidad en el sistema.
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data);

    /**
     * Eliminar una entidad por su ID.
     * @param int $id
     * @return mixed
     */
    public function delete(int $id);

    /**
     * Listar todas las entidades.
     * @return array
     */
    public function getAll(): array;
}
