import { Link } from "expo-router";
import { useState } from "react";
import { Image, Text, TextInput, TouchableOpacity, View } from "react-native";
import { styles } from "./register";

export default function Register(){
    const [username, setUsername] = useState<string>();
    const [userpassword, setUserPassword] = useState<string>();
    const [userpassword2, setUserPassword2] = useState<string>();
    const [name, setName] = useState<string>();

    return(
        <View 
            style={styles.container}
            >
        <View style={styles.header}>
            <Image style={styles.logo} source={ require("../../assets/images/favicon.png")}/>
            <Text style={styles.title} > to-do </Text>
            <Text style={styles.texto} >Faça o seu registro </Text>
        </View>

        <View style={styles.main}>

            <Text style={styles.label}> Nome Completo: </Text>
            <TextInput 
                style={styles.input}
                placeholder="informe o seu Nome Completo"
                id="name"
                onChangeText={ ( value )=>{ setName( value ) } }
            />

            <Text style={styles.label}> Usuário: </Text>
            <TextInput 
                style={styles.input}
                placeholder="informe o seu login.."
                id="username"
                onChangeText={ ( value )=>{ setUsername( value ) } }
            />

            <Text style={styles.label}> Senha: </Text>
            <TextInput
                style={styles.input}
                placeholder="informe a sua senha..."
                id="userpassword"
                secureTextEntry
                onChangeText={ (value) => { setUserPassword(value) } }
             />

            <Text style={styles.label}> Confirmar Senha : </Text>
            <TextInput
                style={styles.input}
                placeholder="Repita sua Senha..."
                id="userpassword2"
                secureTextEntry
                onChangeText={ (value) => { setUserPassword2(value) } }
             />

             <Text>
                Já possui cadastro!,
                <Link href={"/"} style={styles.link}>
                {" "}
                faça o loogin.{" "}
                </Link>
             </Text>
             
            <TouchableOpacity 
                style={styles.butom}
                onPress={()=>{console.log("clickou no botao", name, username, userpassword, userpassword2)}}
            >
                <Text style={styles.butomTexto}> Registrar</Text>
            </TouchableOpacity> 
        </View>
        <View style={styles.footer}>
            <Text style={styles.texto}> Direito autoral by Fatec </Text>
        </View>

        </View>
    )
}