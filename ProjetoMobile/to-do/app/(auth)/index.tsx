import api from "../../services/api";

import { useRouter } from "expo-router";

import { useState } from "react";

import {
  ActivityIndicator,
  Image,
  Text,
  TextInput,
  TouchableOpacity,
  View,
} from "react-native";

import { styles } from "./index";

export default function Login() {
  const router = useRouter();

  const [username, setUsername] = useState("");
  const [userpassword, setUserPassword] = useState("");
  const [myError, setMyError] = useState("");
  const [carregando, setCarregando] = useState(false);

  async function onPressAcessar() {
    const usuario = username.trim();

    if (usuario === "") {
      setMyError("Usuário precisa ser preenchido...");
      return;
    }

    if (userpassword.trim() === "") {
      setMyError("Senha em branco, preenchimento obrigatório...");
      return;
    }

    try {
      setCarregando(true);
      setMyError("");

      console.log("Tentando login...", usuario);

      const response = await api.post("/auth/login.php", {
        usuario: usuario,
        senha: userpassword,
      });

      console.log("Resposta da API:", response.data);

      if (response.data.sucesso) {
        setMyError("");

        console.log(
          "Usuário autenticado:",
          response.data.usuario
        );

        router.replace("/(tabs)");
        return;
      }

      setMyError(
        response.data.mensagem ||
        "Não foi possível realizar o login."
      );
    } catch (error: any) {
      console.log(
        "Erro no login:",
        error.response?.data || error.message
      );

      if (error.response) {
        setMyError(
          error.response.data?.mensagem ||
          "Usuário ou senha incorretos."
        );
      } else if (error.request) {
        setMyError(
          "Não foi possível conectar ao servidor."
        );
      } else {
        setMyError(
          "Erro ao fazer login..."
        );
      }
    } finally {
      setCarregando(false);
    }
  }

  return (
    <View style={styles.container}>

      <View style={styles.header}>

        <Image
          style={styles.logo}
          source={require("../../assets/images/logo.png")}
        />

        <Text style={styles.texto}>
          Bem vindo ao sistema de validação.
        </Text>

        <Text
          style={{
            color: "red",
            marginTop: 10,
          }}
        >
          {myError}
        </Text>

      </View>


      <View style={styles.main}>

        <Text style={styles.label}>
          Usuário:
        </Text>

        <TextInput
          style={styles.input}
          placeholder="informe o seu usuário..."
          onChangeText={setUsername}
          value={username}
          autoCapitalize="none"
          autoCorrect={false}
          editable={!carregando}
        />


        <Text style={styles.label}>
          Senha:
        </Text>

        <TextInput
          style={styles.input}
          placeholder="informe a sua senha..."
          secureTextEntry
          onChangeText={setUserPassword}
          value={userpassword}
          editable={!carregando}
          onSubmitEditing={onPressAcessar}
        />


        <TouchableOpacity
          style={styles.butom}
          onPress={onPressAcessar}
          disabled={carregando}
        >

          {carregando ? (
            <ActivityIndicator
              size="small"
              color="#ffffff"
            />
          ) : (
            <Text style={styles.butomTexto}>
              Acessar
            </Text>
          )}

        </TouchableOpacity>

      </View>


      <View style={styles.footer}>

        <Text style={styles.texto}>
          Banco de Sangue Taquaritinga.
        </Text>

      </View>

    </View>
  );
}