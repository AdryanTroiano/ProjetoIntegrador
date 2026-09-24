<?php

class Estoque extends Model
{
    public function listarTodos(): array
    {
        $sql = "
            SELECT
                es.tipo_sangue_id,
                ts.tipo,
                es.quantidade
            FROM estoque_sangue es
            INNER JOIN tipos_sangue ts
                ON es.tipo_sangue_id = ts.id
            ORDER BY ts.tipo
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function atualizar(
        int $tipoSangueId,
        int $quantidade
    ): bool {
        $sql = "
            UPDATE estoque_sangue
            SET quantidade = ?
            WHERE tipo_sangue_id = ?
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $quantidade,
            $tipoSangueId
        ]);
    }
}