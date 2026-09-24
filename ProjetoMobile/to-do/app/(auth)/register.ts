import { StyleSheet } from "react-native";

export const styles = StyleSheet.create({
    container:{
        flex: 1,
        backgroundColor: "rgba(19, 19, 19, 0.13)",
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
        borderColor: "black",
        borderRadius: 30
    },
    title:{
        fontSize: 36,
        fontWeight: "bold"
    },
    texto:{
        fontSize: 22,
        color: "black"
    },
    input:{
        width: "100%",
        height: 46,
        backgroundColor: "#fff",
        color: "#000",        
        marginTop: -5,
        borderRadius: 10,
        fontSize: 22,
    },
    label: {
        fontSize: 18,
        color: "#000",
        width: "100%"
    },
    butom:{
        backgroundColor: "blue",
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
    },

    link:{
    color: "red",
    fontWeight: "800",
    fontSize: 14,
    cursor: "pointer",
}
})
