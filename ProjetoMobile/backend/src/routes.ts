import { Router, Request, Response } from "express";
import pool from "./database";
import bcrypt from "bcrypt";

const router = Router();

router.post(
  "/login",
  async (req: Request, res: Response): Promise<any> => {
    console.log("Rota /login chamada");
    console.log("Body recebido:", req.body);

    try {
      const { email, senha } = req.body;

      const [rows]: any = await pool.query(
  "SELECT * FROM usuarios WHERE usuario = ?",
  [email]
);

      if (rows.length === 0) {
        return res.status(401).json({
          sucesso: false,
          mensagem: "Usuário não encontrado",
        });
      }

      const usuario = rows[0];

      console.log("Senha digitada:", senha);
      console.log("Hash do banco:", usuario.senha);

      const hashSenha = usuario.senha.replace("$2y$", "$2b$");

      const senhaValida = await bcrypt.compare(senha, hashSenha);

      if (!senhaValida) {
        return res.status(401).json({
          sucesso: false,
          mensagem: "Senha inválida",
        });
      }

      return res.json({
        sucesso: true,
        usuario: {
          id: usuario.id,
          nome: usuario.nome,
          email: usuario.email,
          nivel: usuario.nivel,
        },
      });
    } catch (error) {
      console.log(error);

      return res.status(500).json({
        sucesso: false,
        mensagem: "Erro no servidor",
      });
    }
  }
);

router.get("/teste", (req: Request, res: Response) => {
  console.log("Rota /teste acessada");

  res.json({
    mensagem: "Backend funcionando",
  });
});

router.get("/doadores", async (req: Request, res: Response): Promise<any> => {
  try {
    const [rows]: any = await pool.query(
      `
      SELECT 
        d.*,
        ts.tipo AS tipo_sangue
      FROM doadores d
      LEFT JOIN tipos_sangue ts 
        ON d.tipo_sangue_id = ts.id
      ORDER BY d.nome ASC
      `
    );

    return res.json(rows);
  } catch (error) {
    console.log(error);

    return res.status(500).json({
      mensagem: "Erro ao buscar doadores",
    });
  }
});

router.delete(
  "/doadores/:id",
  async (req: Request, res: Response): Promise<any> => {
    try {
      const { id } = req.params;

      await pool.query(
        "DELETE FROM doadores WHERE id = ?",
        [id]
      );

      return res.json({
        sucesso: true,
        mensagem: "Doador excluído com sucesso",
      });
    } catch (error) {
      console.log(error);

      return res.status(500).json({
        sucesso: false,
        mensagem: "Erro ao excluir doador",
      });
    }
  }
);

router.put("/doadores/:id", async (req: Request, res: Response): Promise<any> => {
  try {
    const { id } = req.params;

    const { telefone, email } = req.body;

    await pool.query(
      `
      UPDATE doadores
      SET telefone = ?, email = ?
      WHERE id = ?
      `,
      [telefone, email, id]
    );

    return res.json({
      sucesso: true,
      mensagem: "Dados de contato atualizados com sucesso",
    });
  } catch (error) {
    console.log(error);

    return res.status(500).json({
      sucesso: false,
      mensagem: "Erro ao atualizar dados do doador",
    });
  }

  
});

export default router;