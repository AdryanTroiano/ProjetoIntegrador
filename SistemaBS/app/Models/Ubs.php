<?php

class Ubs extends Model
{
    public function cadastrar(string $nome): bool
    {
        $sql = "
            INSERT INTO ubs (nome)
            VALUES (?)
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$nome]);
    }

    public function listarTodas(): array
    {
        $sql = "
            SELECT *
            FROM ubs
            ORDER BY nome ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function buscarPorId(int $id): ?array
{
    $sql = "
        SELECT *
        FROM ubs
        WHERE id = ?
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$id]);

    $ubs = $stmt->fetch();

    return $ubs ?: null;
}

public function atualizar(int $id, string $nome): bool
{
    $sql = "
        UPDATE ubs
        SET nome = ?
        WHERE id = ?
    ";

    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        $nome,
        $id
    ]);
}

public function possuiVinculos(int $id): bool
{
    $sql = "
        SELECT id
        FROM doacoes
        WHERE ubs_id = ?

        UNION

        SELECT id
        FROM retiradas
        WHERE ubs_id = ?
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        $id,
        $id
    ]);

    return (bool) $stmt->fetch();
}

public function excluir(int $id): bool
{
    $sql = "
        DELETE FROM ubs
        WHERE id = ?
    ";

    $stmt = $this->db->prepare($sql);

    return $stmt->execute([$id]);
}
}