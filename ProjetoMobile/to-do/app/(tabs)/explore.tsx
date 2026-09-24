import { Ionicons } from "@expo/vector-icons";
import { useEffect, useState } from "react";

import {
  ActivityIndicator,
  Alert,
  FlatList,
  Modal,
  ScrollView,
  StyleSheet,
  Text,
  TextInput,
  TouchableOpacity,
  View,
} from "react-native";

import api from "../../services/api";


type Doador = {
  id: number;
  nome: string;
  cpf?: string;
  sexo?: string;
  nasc?: string;
  email?: string;
  telefone?: string;
  cep?: string;
  endereco?: string;
  numero?: string;
  bairro?: string;
  complemento?: string;
  peso?: string;
  tipo_sangue?: string;
  datedonation?: string;
  validado: number;
};


export default function TabTwoScreen() {

  const [doadores, setDoadores] = useState<Doador[]>([]);

  const [pesquisa, setPesquisa] = useState("");

  const [carregando, setCarregando] = useState(true);

  const [modalVisivel, setModalVisivel] = useState(false);

  const [
    doadorSelecionado,
    setDoadorSelecionado
  ] = useState<Doador | null>(null);

  const [emailEdit, setEmailEdit] = useState("");

  const [telefoneEdit, setTelefoneEdit] = useState("");

  const [validando, setValidando] = useState(false);


  // =========================
  // BUSCAR DOADORES
  // =========================

  async function buscarDoadores() {

    try {

      const response = await api.get("/doadores");

      setDoadores(response.data);

    } catch (error) {

      console.log(
        "Erro ao buscar doadores:",
        error
      );

    }

  }


  // =========================
  // FORMATAR DATA
  // =========================

  function formatarData(data?: string) {

    if (!data) {
      return "";
    }

    const dataConvertida = new Date(data);

    if (
      isNaN(dataConvertida.getTime()) ||
      data.startsWith("0000-00-00") ||
      dataConvertida.getFullYear() < 1901
    ) {
      return "";
    }

    return dataConvertida.toLocaleDateString(
      "pt-BR"
    );

  }


  // =========================
  // MÁSCARA TELEFONE
  // =========================

  function mascaraTelefone(valor: string) {

    valor = valor.replace(/\D/g, "");

    if (valor.length <= 10) {

      return valor.replace(
        /(\d{2})(\d{4})(\d{0,4})/,
        "($1) $2-$3"
      );

    }

    return valor.replace(
      /(\d{2})(\d{5})(\d{0,4})/,
      "($1) $2-$3"
    );

  }


  // =========================
  // ABRIR MODAL
  // =========================

  function abrirModal(doador: Doador) {

    setDoadorSelecionado(doador);

    setEmailEdit(
      doador.email || ""
    );

    setTelefoneEdit(
      mascaraTelefone(
        doador.telefone || ""
      )
    );

    setModalVisivel(true);

  }


  // =========================
  // FECHAR MODAL
  // =========================

  function fecharModal() {

    setModalVisivel(false);

    setDoadorSelecionado(null);

    setEmailEdit("");

    setTelefoneEdit("");

  }


  // =========================
  // SALVAR ALTERAÇÕES
  // =========================

  async function salvarAlteracoes() {

    if (!doadorSelecionado) {
      return;
    }

    try {

      await api.put(
        "/doadores/atualizar.php",
        {
          id: doadorSelecionado.id,
          email: emailEdit,
          telefone: telefoneEdit,
        }
      );

      Alert.alert(
        "Sucesso",
        "Dados de contato atualizados!"
      );

      await buscarDoadores();

      fecharModal();

    } catch (error: any) {

      console.log(
        "Erro ao salvar alterações:",
        error
      );

      Alert.alert(
        "Erro",
        error.response?.data?.mensagem ||
        "Não foi possível atualizar os dados."
      );

    }

  }


  // =========================
  // VALIDAR DOADOR
  // =========================

  function confirmarValidacao() {

    if (!doadorSelecionado) {
      return;
    }

    if (doadorSelecionado.validado === 1) {

      Alert.alert(
        "Doador validado",
        "Este doador já está validado."
      );

      return;

    }


    Alert.alert(
      "Validar doador",
      `Deseja validar o cadastro de ${doadorSelecionado.nome}?`,
      [
        {
          text: "Cancelar",
          style: "cancel",
        },
        {
          text: "Validar",
          onPress: validarDoador,
        },
      ]
    );

  }


  async function validarDoador() {

    if (!doadorSelecionado) {
      return;
    }

    try {

      setValidando(true);

      const response = await api.put(
        "/doadores/validar.php",
        {
          id: doadorSelecionado.id,
        }
      );


      if (response.data.sucesso) {

        Alert.alert(
          "Sucesso",
          "Doador validado com sucesso!"
        );


        // Atualiza imediatamente o modal

        setDoadorSelecionado({
          ...doadorSelecionado,
          validado: 1,
        });


        // Atualiza a lista

        await buscarDoadores();

      }

    } catch (error: any) {

      console.log(
        "Erro ao validar doador:",
        error
      );

      Alert.alert(
        "Erro",
        error.response?.data?.mensagem ||
        "Não foi possível validar o doador."
      );

    } finally {

      setValidando(false);

    }

  }


  // =========================
  // EXCLUIR DOADOR
  // =========================

  function confirmarExclusao(id: number) {

    Alert.alert(
      "Excluir doador",
      "Deseja realmente excluir este cadastro?",
      [
        {
          text: "Cancelar",
          style: "cancel",
        },
        {
          text: "Excluir",
          style: "destructive",

          onPress: async () => {

            try {

              await api.delete(
                "/doadores/excluir.php",
                {
                  data: {
                    id: id,
                  },
                }
              );

              Alert.alert(
                "Sucesso",
                "Doador excluído com sucesso!"
              );

              buscarDoadores();

            } catch (error: any) {

              console.log(
                "Erro ao excluir:",
                error
              );

              Alert.alert(
                "Erro",
                error.response?.data?.mensagem ||
                "Não foi possível excluir o doador."
              );

            }

          },
        },
      ]
    );

  }


  // =========================
  // CARREGAMENTO
  // =========================

  useEffect(() => {

    buscarDoadores().finally(() =>
      setCarregando(false)
    );


    const interval = setInterval(() => {

      buscarDoadores();

    }, 5000);


    return () =>
      clearInterval(interval);

  }, []);


  // =========================
  // PESQUISA
  // =========================

  const doadoresFiltrados =
    doadores.filter((doador) =>

      doador.nome
        .toLowerCase()
        .includes(
          pesquisa.toLowerCase()
        )

    );


  return (

    <View style={styles.screen}>

      <Text style={styles.title}>
        Validação de Doadores
      </Text>


      <TextInput
        style={styles.searchInput}
        placeholder="Pesquisar doador..."
        value={pesquisa}
        onChangeText={setPesquisa}
      />


      <View style={styles.rowHeader}>

        <Text
          style={[
            styles.headerText,
            styles.headerNome,
          ]}
        >
          Nome
        </Text>

        <Text
          style={[
            styles.headerText,
            styles.headerStatus,
          ]}
        >
          Status
        </Text>

        <Text
          style={[
            styles.headerText,
            styles.headerAcoes,
          ]}
        >
          Ações
        </Text>

      </View>


      {carregando ? (

        <ActivityIndicator
          size="large"
          color="#b30000"
        />

      ) : (

        <FlatList

          data={doadoresFiltrados}

          keyExtractor={(item) =>
            item.id.toString()
          }

          showsVerticalScrollIndicator={false}

          contentContainerStyle={
            styles.listContent
          }

          ListEmptyComponent={

            <Text style={styles.emptyText}>
              Nenhum doador encontrado.
            </Text>

          }

          renderItem={({ item }) => (

            <View style={styles.row}>

              <Text style={styles.cell}>
                {item.nome}
              </Text>


              <View style={styles.statusContainer}>

                {item.validado === 1 ? (

                  <View style={styles.statusValidado}>

                    <Text
                      style={
                        styles.statusValidadoTexto
                      }
                    >
                      Validado
                    </Text>

                  </View>

                ) : (

                  <View style={styles.statusPendente}>

                    <Text
                      style={
                        styles.statusPendenteTexto
                      }
                    >
                      Pendente
                    </Text>

                  </View>

                )}

              </View>


              <View style={styles.actions}>

                <TouchableOpacity
                  style={styles.viewButton}
                  onPress={() =>
                    abrirModal(item)
                  }
                >

                  <Ionicons
                    name="eye"
                    size={20}
                    color="#fff"
                  />

                </TouchableOpacity>


                <TouchableOpacity
                  style={styles.deleteButton}
                  onPress={() =>
                    confirmarExclusao(item.id)
                  }
                >

                  <Ionicons
                    name="trash"
                    size={20}
                    color="#fff"
                  />

                </TouchableOpacity>

              </View>

            </View>

          )}

        />

      )}


      {/* =========================
          MODAL
      ========================== */}

      <Modal
        visible={modalVisivel}
        transparent
        animationType="fade"
        onRequestClose={fecharModal}
      >

        <View style={styles.modalOverlay}>

          <View style={styles.modalBox}>

            <Text style={styles.modalTitle}>
              Dados do Doador
            </Text>


            {/* STATUS */}

            {doadorSelecionado?.validado === 1 ? (

              <View
                style={
                  styles.modalStatusValidado
                }
              >

                <Ionicons
                  name="checkmark-circle"
                  size={22}
                  color="#2e7d32"
                />

                <Text
                  style={
                    styles.modalStatusValidadoTexto
                  }
                >
                  Doador validado
                </Text>

              </View>

            ) : (

              <View
                style={
                  styles.modalStatusPendente
                }
              >

                <Ionicons
                  name="alert-circle"
                  size={22}
                  color="#b26a00"
                />

                <Text
                  style={
                    styles.modalStatusPendenteTexto
                  }
                >
                  Validação pendente
                </Text>

              </View>

            )}


            <ScrollView
              showsVerticalScrollIndicator={false}
            >

              <Info
                label="Nome"
                value={
                  doadorSelecionado?.nome
                }
              />

              <Info
                label="CPF"
                value={
                  doadorSelecionado?.cpf
                }
              />

              <Info
                label="Sexo"
                value={
                  doadorSelecionado?.sexo
                }
              />

              <Info
                label="Nascimento"
                value={
                  formatarData(
                    doadorSelecionado?.nasc
                  )
                }
              />


              <EditableInfo
                label="Email"
                value={emailEdit}
                onChangeText={setEmailEdit}
                keyboardType="email-address"
              />


              <EditableInfo
                label="Telefone"
                value={telefoneEdit}
                onChangeText={(texto) =>
                  setTelefoneEdit(
                    mascaraTelefone(texto)
                  )
                }
                keyboardType="phone-pad"
              />


              <Info
                label="CEP"
                value={
                  doadorSelecionado?.cep
                }
              />

              <Info
                label="Endereço"
                value={
                  doadorSelecionado?.endereco
                }
              />

              <Info
                label="Número"
                value={
                  doadorSelecionado?.numero
                }
              />

              <Info
                label="Bairro"
                value={
                  doadorSelecionado?.bairro
                }
              />

              <Info
                label="Complemento"
                value={
                  doadorSelecionado?.complemento
                }
              />

              <Info
                label="Peso"
                value={
                  doadorSelecionado?.peso
                }
              />

              <Info
                label="Tipo sanguíneo"
                value={
                  doadorSelecionado?.tipo_sangue
                }
              />

              <Info
                label="Última doação"
                value={
                  formatarData(
                    doadorSelecionado?.datedonation
                  )
                }
              />

            </ScrollView>


            {/* =========================
                BOTÃO VALIDAR
            ========================== */}

            {doadorSelecionado?.validado !== 1 && (

              <TouchableOpacity
                style={styles.validateButton}
                onPress={confirmarValidacao}
                disabled={validando}
              >

                {validando ? (

                  <ActivityIndicator
                    size="small"
                    color="#fff"
                  />

                ) : (

                  <>

                    <Ionicons
                      name="checkmark-circle"
                      size={21}
                      color="#fff"
                    />

                    <Text
                      style={
                        styles.validateButtonText
                      }
                    >
                      Validar Doador
                    </Text>

                  </>

                )}

              </TouchableOpacity>

            )}


            <TouchableOpacity
              style={styles.saveButton}
              onPress={salvarAlteracoes}
            >

              <Text
                style={
                  styles.saveButtonText
                }
              >
                Salvar Alterações
              </Text>

            </TouchableOpacity>


            <TouchableOpacity
              style={styles.closeButton}
              onPress={fecharModal}
            >

              <Text
                style={
                  styles.closeButtonText
                }
              >
                Fechar
              </Text>

            </TouchableOpacity>

          </View>

        </View>

      </Modal>

    </View>

  );

}


// =========================
// INFORMAÇÃO
// =========================

function Info({
  label,
  value,
}: {
  label: string;
  value?: string | number;
}) {

  return (

    <View style={styles.infoRow}>

      <Text style={styles.infoLabel}>
        {label}:
      </Text>

      <Text style={styles.infoValue}>
        {value || "Não informado"}
      </Text>

    </View>

  );

}


// =========================
// INFORMAÇÃO EDITÁVEL
// =========================

function EditableInfo({
  label,
  value,
  onChangeText,
  keyboardType,
}: {
  label: string;
  value: string;
  onChangeText: (text: string) => void;
  keyboardType?:
    | "default"
    | "email-address"
    | "phone-pad";
}) {

  return (

    <View style={styles.infoRow}>

      <Text style={styles.infoLabel}>
        {label}:
      </Text>

      <TextInput
        style={styles.editInput}
        value={value}
        onChangeText={onChangeText}
        keyboardType={keyboardType}
        placeholder={`Informe ${label.toLowerCase()}`}
      />

    </View>

  );

}


// =========================
// ESTILOS
// =========================

const styles = StyleSheet.create({

  screen: {
    flex: 1,
    backgroundColor: "#f5f5f5",
    paddingTop: 60,
    paddingHorizontal: 15,
  },


  title: {
    fontSize: 26,
    fontWeight: "bold",
    color: "#b30000",
    marginBottom: 15,
    textAlign: "center",
  },


  searchInput: {
    backgroundColor: "#fff",
    borderWidth: 1,
    borderColor: "#ddd",
    borderRadius: 8,
    padding: 12,
    marginBottom: 15,
    fontSize: 16,
  },


  // =========================
  // CABEÇALHO
  // =========================

  rowHeader: {
    flexDirection: "row",
    alignItems: "center",
    padding: 10,
    backgroundColor: "#d32f2f",
    borderRadius: 5,
    marginBottom: 5,
  },


  headerText: {
    color: "#fff",
    fontWeight: "bold",
    fontSize: 14,
  },


  headerNome: {
    flex: 1,
  },


  headerStatus: {
    width: 85,
    textAlign: "center",
  },


  headerAcoes: {
    width: 88,
    textAlign: "center",
  },


  listContent: {
    paddingBottom: 40,
  },


  // =========================
  // LINHAS
  // =========================

  row: {
    flexDirection: "row",
    padding: 12,
    backgroundColor: "#fff",
    marginBottom: 5,
    alignItems: "center",
    borderRadius: 5,
  },


  cell: {
    fontSize: 15,
    color: "#333",
    flex: 1,
    paddingRight: 5,
  },


  actions: {
    width: 88,
    flexDirection: "row",
    justifyContent: "flex-end",
    gap: 8,
  },


  viewButton: {
    backgroundColor: "#1976d2",
    width: 40,
    height: 36,
    borderRadius: 6,
    justifyContent: "center",
    alignItems: "center",
  },


  deleteButton: {
    backgroundColor: "#d32f2f",
    width: 40,
    height: 36,
    borderRadius: 6,
    justifyContent: "center",
    alignItems: "center",
  },


  // =========================
  // STATUS
  // =========================

  statusContainer: {
    width: 85,
    alignItems: "center",
  },


  statusValidado: {
    backgroundColor: "#d4edda",
    paddingVertical: 5,
    paddingHorizontal: 8,
    borderRadius: 12,
  },


  statusValidadoTexto: {
    color: "#2e7d32",
    fontSize: 11,
    fontWeight: "bold",
  },


  statusPendente: {
    backgroundColor: "#fff3cd",
    paddingVertical: 5,
    paddingHorizontal: 8,
    borderRadius: 12,
  },


  statusPendenteTexto: {
    color: "#8a5a00",
    fontSize: 11,
    fontWeight: "bold",
  },


  emptyText: {
    textAlign: "center",
    color: "#777",
    marginTop: 20,
    fontSize: 16,
  },


  // =========================
  // MODAL
  // =========================

  modalOverlay: {
    flex: 1,
    backgroundColor: "rgba(0,0,0,0.5)",
    justifyContent: "center",
    alignItems: "center",
    padding: 20,
  },


  modalBox: {
    backgroundColor: "#fff",
    width: "100%",
    maxHeight: "85%",
    borderRadius: 12,
    padding: 20,
  },


  modalTitle: {
    fontSize: 22,
    fontWeight: "bold",
    color: "#b30000",
    textAlign: "center",
    marginBottom: 15,
  },


  modalStatusValidado: {
    flexDirection: "row",
    justifyContent: "center",
    alignItems: "center",
    gap: 7,
    backgroundColor: "#e8f5e9",
    borderRadius: 8,
    padding: 10,
    marginBottom: 15,
  },


  modalStatusValidadoTexto: {
    color: "#2e7d32",
    fontWeight: "bold",
    fontSize: 15,
  },


  modalStatusPendente: {
    flexDirection: "row",
    justifyContent: "center",
    alignItems: "center",
    gap: 7,
    backgroundColor: "#fff3cd",
    borderRadius: 8,
    padding: 10,
    marginBottom: 15,
  },


  modalStatusPendenteTexto: {
    color: "#8a5a00",
    fontWeight: "bold",
    fontSize: 15,
  },


  infoRow: {
    marginBottom: 10,
    borderBottomWidth: 1,
    borderBottomColor: "#eee",
    paddingBottom: 8,
  },


  infoLabel: {
    fontWeight: "bold",
    color: "#333",
    fontSize: 15,
  },


  infoValue: {
    color: "#555",
    fontSize: 15,
    marginTop: 2,
  },


  editInput: {
    backgroundColor: "#f9f9f9",
    borderWidth: 1,
    borderColor: "#ddd",
    borderRadius: 8,
    padding: 10,
    marginTop: 5,
    color: "#333",
    fontSize: 15,
  },


  // =========================
  // VALIDAR
  // =========================

  validateButton: {
    backgroundColor: "#1976d2",
    padding: 12,
    borderRadius: 8,
    marginTop: 15,
    flexDirection: "row",
    justifyContent: "center",
    alignItems: "center",
    gap: 7,
  },


  validateButtonText: {
    color: "#fff",
    fontWeight: "bold",
    fontSize: 16,
  },


  // =========================
  // SALVAR
  // =========================

  saveButton: {
    backgroundColor: "#2e7d32",
    padding: 12,
    borderRadius: 8,
    marginTop: 10,
    alignItems: "center",
  },


  saveButtonText: {
    color: "#fff",
    fontWeight: "bold",
    fontSize: 16,
  },


  // =========================
  // FECHAR
  // =========================

  closeButton: {
    backgroundColor: "#b30000",
    padding: 12,
    borderRadius: 8,
    marginTop: 10,
    alignItems: "center",
  },


  closeButtonText: {
    color: "#fff",
    fontWeight: "bold",
    fontSize: 16,
  },

});