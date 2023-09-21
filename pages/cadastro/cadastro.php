<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../../assets/css/css/style.css">
</head>

<body>
    <section class="page-form">
        <div class="cadastro-content">
            <div class="form-content">
                <div class="loading hide">
                    <div class="loading-content">
                        <div class="spinner-one">
                            <div class="spinner-two"></div>
                        </div>
                        <p class="loading-message">aaaa</p>
                    </div>
                </div>
                <div class="logo">
                    <div class="logo-content"></div>
                </div>
                <div class="form-title">
                    <h1>Cadastro</h1>
                    <p>Preencha para ter acesso ao nosso sistema</p>
                </div>
                <form method="POST" action="cadastro_action.php" class="form">
                    <div class="form-category">
                        <h2>Dados pessoais</h2>
                        <div class="form-group">
                            <label for="nome">Nome <span>*</span></label>
                            <input type="text" name="nome" id="nome" minlength="15" maxlength="80" required>
                        </div>
                        <div class="form-group">
                            <label for="data-nascimento">Data de Nascimento <span>*</span></label>
                            <input type="text" name="nascimento" id="data-nascimento" required>
                        </div>
                        <div class="form-group">
                            <label for="cpf">CPF <span>*</span></label>
                            <input type="text" name="cpf" id="cpf" required>
                        </div>
                        <div class="form-group">
                            <label for="nomeMaterno">Nome Materno <span>*</span></label>
                            <input type="text" name="nomeMaterno" id="nomeMaterno" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" required>
                        </div>
                        <div class="form-group">
                            <label for="">Sexo <span>*</span></label>
                            <select name="sexo" required>
                                <option value="" selected>Sexo</option>
                                <option value="masculino">Masculino</option>
                                <option value="feminino">Feminino</option>
                                <option value="outros">Outros</option>
                            </select>
                        </div>
                        <div class="inputs-group">
                            <div class="form-group">
                                <label for="celular">Celular <span>*</span></label>
                                <input type="text" name="celular" id="celular" placeholder="(+55) XX-XXXXXXX" required>
                            </div>
                            <div class="form-group">
                                <label for="telefone">Telefone <span>*</span></label>
                                <input type="text" name="telefone" id="telefone" placeholder="(+55) XX-XXXXXXX" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-category endereco">
                        <h2>Endereço</h2>
                        <div class="form-group">
                            <label for="cep">Cep <span>*</span></label>
                            <input type="text" name="cep" id="cep" data-input-address required>
                        </div>
                        <div class="inputs-group endereco">
                            <div class="form-group">
                                <label for="endereco">Endereço <span>*</span></label>
                                <input type="text" name="endereco" id="endereco" data-input-address required>
                            </div>
                            <div class="form-group numero">
                                <label for="numend">N° <span>*</span></label>
                                <input type="text" name="numend" id="numend" data-input-address required>
                            </div>
                        </div>
                        <div class="inputs-group">
                            <div class="form-group">
                                <label for="bairro">Bairro <span>*</span></label>
                                <input type="text" name="bairro" id="bairro" data-input-address required>
                            </div>
                            <div class="form-group">
                                <label for="cidade">Cidade <span>*</span></label>
                                <input type="text" name="cidade" id="cidade" data-input-address required>
                            </div>
                            <div class="form-group">
                                <label for="estado">Estado <span>*</span></label>
                                <select id="estado" name="estado" data-input-address required>
                                    <option selected>Estado</option>
                                    <option value="AC">Acre</option>
                                    <option value="AL">Alagoas</option>
                                    <option value="AP">Amapá</option>
                                    <option value="AM">Amazonas</option>
                                    <option value="BA">Bahia</option>
                                    <option value="CE">Ceará</option>
                                    <option value="DF">Distrito Federal</option>
                                    <option value="ES">Espírito Santo</option>
                                    <option value="GO">Goiás</option>
                                    <option value="MA">Maranhão</option>
                                    <option value="MT">Mato Grosso</option>
                                    <option value="MS">Mato Grosso do Sul</option>
                                    <option value="MG">Minas Gerais</option>
                                    <option value="PA">Pará</option>
                                    <option value="PB">Paraíba</option>
                                    <option value="PR">Paraná</option>
                                    <option value="PE">Pernambuco</option>
                                    <option value="PI">Piauí</option>
                                    <option value="RJ">Rio de Janeiro</option>
                                    <option value="RN">Rio Grande do Norte</option>
                                    <option value="RS">Rio Grande do Sul</option>
                                    <option value="RO">Rondônia</option>
                                    <option value="RR">Roraima</option>
                                    <option value="SC">Santa Catarina</option>
                                    <option value="SP">São Paulo</option>
                                    <option value="SE">Sergipe</option>
                                    <option value="TO">Tocantins</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="complemento">Complemento</label>
                            <input type="text" name="complemento" id="complemento" data-input-address>
                        </div>
                    </div>
                    <div class="form-category">
                        <h2>Login</h2>
                        <div class="form-group">
                            <label for="login">Usuario <span>*</span></label>
                            <input type="text" name="login" id="login" minlength="6" maxlength="6"1 required>
                        </div>
                        <div class="inputs-group">
                            <div class="form-group">
                                <label for="senha">Senha <span>*</span></label>
                                <input type="text" name="senha" id="senha" required>
                            </div>
                            <div class="form-group">
                                <label for="confirmar-senha">Confirmar senha <span>*</span></label>
                                <input type="text" name="confirmar-senha" id="confirmar-senha" required>
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="Cadastrar" class="btn" class="enviarForm">
                    <input type="reset" value="Limpar" id="limpar" class="btn secondary">
                </form>
            </div>
            <div class="cadastro-description">
                <div class="cadastro-description-content">
                    <h1>Lorem ipsum dolor, sit amet consectetur adipisicx! Ipsa a ratione mollitia.</h1>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicx! Ipsa a ratione mollitia.</p>
                </div>

            </div>
        </div>
        </div>
    </section>
    <!--     <script src="../../assets/js/cadastro-form.js"></script> -->
</body>

</html>