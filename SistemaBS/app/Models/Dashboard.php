<?php

class Dashboard extends Model
{
    public function listarEstoque(): array
    {
        $sql = "
            SELECT
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

    public function listarLogs(
        ?string $data = null,
        ?int $mes = null,
        ?int $ano = null
    ): array {
        $sql = "
            SELECT
                l.id,
                l.acao,
                l.quantidade,
                l.data_hora,
                l.ip,
                u.usuario AS funcionario,
                ts.tipo AS tipo_sangue
            FROM logs_estoque l
            INNER JOIN usuarios u
                ON l.usuario_id = u.id
            INNER JOIN tipos_sangue ts
                ON l.tipo_sangue_id = ts.id
        ";

        $filtros = [];
        $parametros = [];

        if ($data !== null && $data !== '') {
            $filtros[] = "DATE(l.data_hora) = ?";
            $parametros[] = $data;
        }

        if ($mes !== null && $mes >= 1 && $mes <= 12) {
            $filtros[] = "MONTH(l.data_hora) = ?";
            $parametros[] = $mes;
        }

        if ($ano !== null && $ano > 0) {
            $filtros[] = "YEAR(l.data_hora) = ?";
            $parametros[] = $ano;
        }

        if (!empty($filtros)) {
            $sql .= " WHERE " . implode(" AND ", $filtros);
        }

        $sql .= " ORDER BY l.data_hora DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($parametros);

        return $stmt->fetchAll();
    }
}