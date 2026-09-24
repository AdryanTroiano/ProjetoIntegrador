<?php

class Doacao extends Model
{
    // =========================
    // LISTAR DOADORES
    // =========================

    public function listarDoadores(): array
    {
        $sql = "
            SELECT
                id,
                nome,
                validado
            FROM doadores
            ORDER BY nome ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }


    // =========================
    // LISTAR UBS
    // =========================

    public function listarUbs(): array
    {
        $sql = "
            SELECT
                id,
                nome
            FROM ubs
            ORDER BY nome ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }


    // =========================
    // BUSCAR DOADOR
    // =========================

    public function buscarDoador(int $doadorId): ?array
    {
        $sql = "
            SELECT
                id,
                nome,
                tipo_sangue_id,
                validado
            FROM doadores
            WHERE id = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            $doadorId
        ]);

        $resultado = $stmt->fetch();

        return $resultado ?: null;
    }


    // =========================
    // VERIFICAR VALIDAÇÃO
    // =========================

    public function doadorEstaValidado(int $doadorId): bool
    {
        $sql = "
            SELECT validado
            FROM doadores
            WHERE id = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            $doadorId
        ]);

        $resultado = $stmt->fetch();

        if (!$resultado) {
            return false;
        }

        return (int) $resultado['validado'] === 1;
    }


    // =========================
    // TIPO SANGUÍNEO DO DOADOR
    // =========================

    public function buscarTipoSangueDoador(
        int $doadorId
    ): ?int {

        $sql = "
            SELECT tipo_sangue_id
            FROM doadores
            WHERE id = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            $doadorId
        ]);

        $resultado = $stmt->fetch();

        if (!$resultado) {
            return null;
        }

        return (int) $resultado['tipo_sangue_id'];
    }


    // =========================
    // CADASTRAR DOAÇÃO
    // =========================

    public function cadastrar(
        int $doadorId,
        int $ubsId,
        string $dataDoacao,
        int $quantidadeMl
    ): bool {

        $sql = "
            INSERT INTO doacoes (
                doador_id,
                ubs_id,
                data_doacao,
                quantidade_ml
            )
            VALUES (?, ?, ?, ?)
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $doadorId,
            $ubsId,
            $dataDoacao,
            $quantidadeMl
        ]);
    }


    // =========================
    // ATUALIZAR ÚLTIMA DOAÇÃO
    // =========================

    public function atualizarDataDoacao(
        int $doadorId,
        string $dataDoacao
    ): bool {

        $sql = "
            UPDATE doadores
            SET datedonation = ?
            WHERE id = ?
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $dataDoacao,
            $doadorId
        ]);
    }


    // =========================
    // ATUALIZAR ESTOQUE
    // =========================

    public function atualizarEstoque(
        int $tipoSangueId,
        int $quantidadeMl
    ): bool {

        $sql = "
            UPDATE estoque_sangue
            SET quantidade = quantidade + ?
            WHERE tipo_sangue_id = ?
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $quantidadeMl,
            $tipoSangueId
        ]);
    }


    // =========================
    // LISTAR DOAÇÕES
    // =========================

    public function listarTodas(): array
    {
        $sql = "
            SELECT
                d.*,
                c.nome AS doador,
                u.nome AS ubs
            FROM doacoes d

            LEFT JOIN doadores c
                ON d.doador_id = c.id

            LEFT JOIN ubs u
                ON d.ubs_id = u.id

            ORDER BY d.data_doacao DESC
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll();
    }


    // =========================
    // REGISTRAR LOG
    // =========================

    public function registrarLog(
        int $usuarioId,
        int $tipoSangueId,
        int $quantidadeMl,
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
            VALUES (?, 'DOACAO', ?, ?, ?)
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $usuarioId,
            $tipoSangueId,
            $quantidadeMl,
            $ip
        ]);
    }
}