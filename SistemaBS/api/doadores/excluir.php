import { router } from "expo-router";
import { useEffect, useRef } from "react";

import {
  Animated,
  Easing,
  StyleSheet,
  Text,
  View,
} from "react-native";

export default function Logout() {
  const opacity = useRef(
    new Animated.Value(0)
  ).current;

  const scale = useRef(
    new Animated.Value(0.8)
  ).current;

  useEffect(() => {
    Animated.parallel([
      Animated.timing(opacity, {
        toValue: 1,
        duration: 700,
        easing: Easing.out(Easing.ease),
        useNativeDriver: true,
      }),

      Animated.timing(scale, {
        toValue: 1,
        duration: 700,
        easing: Easing.out(Easing.back(1)),
        useNativeDriver: true,
      }),
    ]).start();

    const timer = setTimeout(() => {
      router.replace("/(auth)");
    }, 1500);

    return () => {
      clearTimeout(timer);
    };
  }, [opacity, scale]);

  return (
    <View style={styles.container}>
      <Animated.View
        style={[
          styles.box,
          {
            opacity,
            transform: [{ scale }],
          },
        ]}
      >
        <Text style={styles.icon}>
          👋
        </Text>

        <Text style={styles.text}>
          Saindo...
        </Text>
      </Animated.View>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: "#111",
    justifyContent: "center",
    alignItems: "center",
  },

  box: {
    alignItems: "center",
  },

  icon: {
    fontSize: 60,
    marginBottom: 15,
  },

  text: {
    fontSize: 22,
    color: "#fff",
    fontWeight: "600",
  },
});