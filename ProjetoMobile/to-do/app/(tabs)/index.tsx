import { Image } from 'expo-image';
import { StyleSheet, View } from 'react-native';
import { ThemedText } from '@/components/themed-text';

export default function HomeScreen() {
  return (
    <View style={styles.container}>

      <ThemedText style={styles.welcome}>
        Bem-vindo!
      </ThemedText>

      <Image
        source={require('@/assets/images/logo.png')}
        style={styles.logo}
      />

      <ThemedText style={styles.title}>
        Banco de Sangue
      </ThemedText>

      <ThemedText style={styles.subtitle}>
        Sistema de Controle de Doadores
      </ThemedText>

      <ThemedText style={styles.text}>
        Este sistema tem como objetivo gerenciar e validar doadores de sangue,
        garantindo que cada pessoa esteja apta para realizar uma nova doação.
      </ThemedText>

      <ThemedText style={styles.text}>
        Através do controle da última doação e regras específicas (como intervalo
        entre doações para homens e mulheres), o sistema ajuda a manter a
        segurança dos doadores e a qualidade do atendimento.
      </ThemedText>

    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: "#f5f5f5",
    justifyContent: "center",
    alignItems: "center",
    padding: 20,
  },

  welcome: {
    position: "absolute",
    top: 60,
    fontSize: 32,
    fontWeight: "bold",
    color: "#b30000",
  },

  logo: {
    width: 120,
    height: 120,
    marginBottom: 20,
  },

  title: {
    fontSize: 28,
    fontWeight: "bold",
    color: "#b30000",
    marginBottom: 5,
  },

  subtitle: {
    fontSize: 18,
    color: "#d32f2f",
    marginBottom: 20,
  },

  text: {
    fontSize: 16,
    color: "#333",
    textAlign: "center",
    marginBottom: 10,
  },
});