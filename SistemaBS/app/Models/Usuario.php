<?php

class Usuario extends Model
{
    /**
     * Busca um usuário pelo nome de usuário.
     * Utilizado no login.
     */
    public function buscarPorUsuario(string $usuario): ?array
    {
        $sql = "
            SELECT
                id,
                usuario,
                senha,
                nivel
            FROM usuarios
            WHERE usuario = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$usuario]);

        $usuarioEncontrado = $stmt->fetch();

        return $usuarioEncontrado ?: null;
    }


    /**
     * Busca um usuário pelo ID.
     * Utilizado na edição.
     */
    public function buscarPorId(int $id): ?array
    {
        $sql = "
            SELECT
                id,
                usuario,
                email,
                nivel
            FROM usuarios
            WHERE id = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        $usuario = $stmt->fetch();

        return $usuario ?: null;
    }


    /**
     * Verifica se já existe um usuário
     * cadastrado com determinado e-mail.
     */
    public function emailExiste(string $email): bool
    {
        $sql = "
            SELECT id
            FROM usuarios
            WHERE email = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);

        return (bool) $stmt->fetch();
    }


    /**
     * Verifica se o e-mail pertence a outro usuário.
     * Utilizado durante a edição.
     */
    public function emailExisteEmOutroUsuario(
        string $email,
        int $id
    ): bool {
        $sql = "
            SELECT id
            FROM usuarios
            WHERE email = ?
            AND id != ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $email,
            $id
        ]);

        return (bool) $stmt->fetch();
    }


    /**
     * Cadastra um novo usuário.
     */
    public function cadastrar(
        string $nome,
        string $email,
        string $senha,
        string $nivel
    ): bool {
        $sql = "
            INSERT INTO usuarios (
                usuario,
                email,
                senha,
                nivel
            )
            VALUES (?, ?, ?, ?)
        ";

        $senhaHash = password_hash(
            $senha,
            PASSWORD_DEFAULT
        );

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $nome,
            $email,
            $senhaHash,
            $nivel
        ]);
    }


    /**
     * Atualiza nome e e-mail,
     * mantendo a senha atual.
     */
    public function atualizar(
        int $id,
        string $nome,
        string $email
    ): bool {
        $sql = "
            UPDATE usuarios
            SET
                usuario = ?,
                email = ?
            WHERE id = ?
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $nome,
            $email,
            $id
        ]);
    }


    /**
     * Atualiza nome, e-mail e senha.
     */
    public function atualizarComSenha(
        int $id,
        string $nome,
        string $email,
        string $senha
    ): bool {
        $sql = "
            UPDATE usuarios
            SET
                usuario = ?,
                email = ?,
                senha = ?
            WHERE id = ?
        ";

        $senhaHash = password_hash(
            $senha,
            PASSWORD_DEFAULT
        );

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $nome,
            $email,
            $senhaHash,
            $id
        ]);
    }

    /**
 * Lista todos os usuários cadastrados.
 */
public function listarTodos(): array
{
    $sql = "
        SELECT
            id,
            usuario,
            email,
            nivel
        FROM usuarios
        ORDER BY usuario ASC
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll();
}
}