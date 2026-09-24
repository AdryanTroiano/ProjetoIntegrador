import { Ionicons } from "@expo/vector-icons";
import { router, useLocalSearchParams } from "expo-router";
import { useEffect, useRef } from "react";
import { Animated, StyleSheet, Text, View } from "react-native";

export default function Validado() {
  const { nome } = useLocalSearchParams();

  const scale = useRef(new Animated.Value(0)).current;
  const opacity = useRef(new Animated.Value(0)).current;

  useEffect(() => {
    Animated.parallel([
      Animated.spring(scale, {
        toValue: 1,
        friction: 5,
        useNativeDriver: true,
      }),

      Animated.timing(opacity, {
        toValue: 1,
        duration: 800,
        useNativeDriver: true,
      }),
    ]).start();

    // Fecha automaticamente após 4 segundos
    const timer = setTimeout(() => {
      router.back();
    }, 4000);

    return () => clearTimeout(timer);

  }, []);

  return (
    <View style={styles.container}>
      <View style={styles.card}>

        <Animated.View
          style={[
            styles.iconContainer,
            {
              opacity,
              transform: [{ scale }],
            },
          ]}
        >
          <Ionicons
            name="checkmark-circle"
            size={120}
            color="#2e7d32"
          />
        </Animated.View>

        <Text style={styles.title}>
          Doador validado!
        </Text>

        <Text style={styles.name}>
          {nome}
        </Text>

        <Text style={styles.subtitle}>
          Cadastro aprovado com sucesso
        </Text>

      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: "#f5f5f5",
    justifyContent: "center",
    alignItems: "center",
    paddingHorizontal: 25,
  },

  card: {
    width: "100%",
    backgroundColor: "#fff",
    borderRadius: 25,
    paddingVertical: 40,
    paddingHorizontal: 25,
    alignItems: "center",

    shadowColor: "#000",
    shadowOffset: {
      width: 0,
      height: 5,
    },

    shadowOpacity: 0.15,
    shadowRadius: 10,

    elevation: 8,
  },

  iconContainer: {
    marginBottom: 10,
  },

  title: {
    fontSize: 28,
    fontWeight: "bold",
    color: "#2e7d32",
    marginTop: 10,
  },

  name: {
    fontSize: 22,
    fontWeight: "600",
    color: "#333",
    marginTop: 15,
    textAlign: "center",
  },

  subtitle: {
    fontSize: 16,
    color: "#777",
    marginTop: 10,
    textAlign: "center",
  },
});