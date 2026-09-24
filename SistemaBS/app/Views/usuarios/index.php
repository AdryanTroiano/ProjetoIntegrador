<link rel="stylesheet" href="/SistemaBS/public/css/usuarios.css">

<div class="usuarios-listagem">

    <div class="usuarios-listagem-topo">

        <div>
            <h2>Funcionários</h2>
            <p>Gerencie os usuários cadastrados no sistema.</p>
        </div>

        <a
            href="index.php?rota=novo-usuario"
            class="usuarios-btn-novo"
        >
            Cadastrar Usuário
        </a>

    </div>

    <?php if (empty($usuarios)): ?>

        <div class="usuarios-vazio">
            Nenhum usuário cadastrado.
        </div>

    <?php else: ?>

        <div class="usuarios-tabela-container">

            <table class="usuarios-tabela">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Nível de Acesso</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($usuarios as $usuario): ?>

                        <tr>

                            <td>
                                <?= htmlspecialchars($usuario['id']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($usuario['usuario']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($usuario['email']) ?>
                            </td>

                            <td>

                                <?php if ($usuario['nivel'] === 'admin'): ?>

                                    <span class="usuarios-nivel admin">
                                        Admin
                                    </span>

                                <?php else: ?>

                                    <span class="usuarios-nivel padrao">
                                        Usuário
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>

                                <a
                                    href="index.php?rota=editar-usuario&id=<?= (int) $usuario['id'] ?>"
                                    class="usuarios-btn-editar"
                                >
                                    Editar
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    <?php endif; ?>

</div>