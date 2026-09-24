<?php

class Retirada extends Model
{
    public function listarTiposSangue(): array
    {
        $sql = "
            SELECT id, tipo
            FROM tipos_sangue
            ORDER BY tipo
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function listarUbs(): array
    {
        $sql = "
            SELECT id, nome
            FROM ubs
            ORDER BY nome
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
    public function buscarEstoque(int $tipoSangueId): ?int
{
    $sql = "
        SELECT quantidade
        FROM estoque_sangue
        WHERE tipo_sangue_id = ?
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$tipoSangueId]);

    $resultado = $stmt->fetch();

    if (!$resultado) {
        return null;
    }

    return (int) $resultado['quantidade'];
}

public function cadastrar(
    int $tipoSangueId,
    int $quantidade,
    string $data,
    int $ubsId,
    string $observacao
): bool {
    $sql = "
        INSERT INTO retiradas (
            tipo_sangue_id,
            quantidade_ml,
            data_retirada,
            ubs_id,
            observacao
        )
        VALUES (?, ?, ?, ?, ?)
    ";

    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        $tipoSangueId,
        $quantidade,
        $data,
        $ubsId,
        $observacao
    ]);
}

public function atualizarEstoque(
    int $tipoSangueId,
    int $quantidade
): bool {
    $sql = "
        UPDATE estoque_sangue
        SET quantidade = quantidade - ?
        WHERE tipo_sangue_id = ?
    ";

    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        $quantidade,
        $tipoSangueId
    ]);
}

public function registrarLog(
    int $usuarioId,
    int $tipoSangueId,
    int $quantidade,
    string $ip
): bool {
    $sql = "
        INSERT INTO logs_estoque (
            usuario_id,
            acao,
            tipo_sangue_id,
            quantidade,
            ip
        )
        VALUES (?, 'RETIRADA', ?, ?, ?)
    ";

    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        $usuarioId,
        $tipoSangueId,
        $quantidade,
        $ip
    ]);
}

public function listarTodas(): array
{
    $sql = "
        SELECT
            r.quantidade_ml,
            r.data_retirada,
            r.observacao,
            ts.tipo AS tipo_sangue,
            u.nome AS ubs
        FROM retiradas r
        INNER JOIN tipos_sangue ts
            ON r.tipo_sangue_id = ts.id
        INNER JOIN ubs u
            ON r.ubs_id = u.id
        ORDER BY r.data_retirada DESC
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll();
}
}