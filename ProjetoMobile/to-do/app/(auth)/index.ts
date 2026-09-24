import { StyleSheet } from "react-native";

export const styles = StyleSheet.create({
    container:{
        flex: 1,
        backgroundColor: "#f5f5f5", // fundo claro
        justifyContent: "center",
        alignItems: "center",
        padding: 15,
    },

    header: {
        flex: 2/3,
        width: "100%",
        alignItems: "center",
        justifyContent: "flex-end",
        gap: 20,
    },

    main:{
        flex: 1,
        width: "100%",
        justifyContent: "center",
        alignItems: "center",
        gap: 10,
    },

    footer:{
        flex: 1/3,
        width: "100%",
        justifyContent: "center",
        alignItems: "center"
    },

    logo:{
        width: 100,
        height: 110,
        borderRadius: 30
    },

    title:{
        fontSize: 36,
        fontWeight: "bold",
        color: "#b30000" // vermelho escuro
    },

    texto:{
        fontSize: 22,
        color: "#333"
    },

    input:{
        width: "100%",
        height: 46,
        backgroundColor: "#ffffff",
        color: "#000",        
        borderRadius: 10,
        fontSize: 22,
        borderWidth: 1,
        borderColor: "#ccc",
        paddingHorizontal: 10
    },

    label: {
        fontSize: 18,
        color: "#b30000",
        width: "100%"
    },

    butom:{
        backgroundColor: "#d32f2f", // vermelho principal
        width: "80%",
        borderRadius: 15,
        height: 40,
        alignItems: "center",
        justifyContent: "center",
        marginTop: 30,
    },

    butomTexto:{
        color: "#fff",
        fontSize: 24,
        fontWeight:"700"
    }
});