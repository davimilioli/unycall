<?php
require_once('autoload.php');
$banco = new BancoDeDados();
$verificar = $banco->verificarUsuarioExiste();
if ($verificar == false) {
    unset($verificar);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/img/favicon.ico" type="image/x-icon">
    <title><?= APP_NAME ?></title>
    <link rel="stylesheet" href="./assets/css/css/style.css">
</head>

<body>
    <?php require_once(__DIR__ . '/layout/header.php'); ?>
    <main class="page-home">
        <section class="anuncio">
            <div class="anuncio-content container">
                <div class="anuncio-description">
                    <h1>Serviços telefônicos completos para você ter a melhor conexão</h1>
                    <p>Serviços com até <strong>80%</strong> OFF</p>
                    <ul class="list-content">
                        <li class="before">
                            Conexão confiavel
                            <span class="tooltip-trigger" data-tooltip="Oferecemos uma rede confiável e estável para garantir que suas chamadas sejam sempre claras e sem interrupções.">
                                <img src="./assets/img/icons/help.svg">
                            </span>
                        </li>
                        <li class="before">
                            Cobertura Abrangente
                            <span class="tooltip-trigger" data-tooltip="Nossa cobertura se estende a diversas áreas, garantindo que você possa se comunicar onde quer que esteja.">
                                <img src="./assets/img/icons/help.svg">
                            </span>
                        </li>
                        <li class="before">
                            Tecnologia de Ponta
                            <span class="tooltip-trigger" data-tooltip="Estamos comprometidos em usar tecnologia de ponta para proporcionar a você as mais recentes inovações em serviços telefônicos.">
                                <img src="./assets/img/icons/help.svg">
                            </span>
                        </li>
                    </ul>
                    <div class="anuncio-price">
                        <p>R$ <strong>14,99</strong> /mes*</p>
                        <p class="price-month">+ 2 Meses Grátis</p>
                    </div>
                    <div class="anuncio-temp">
                        <div class="anuncio-temp-item" id="hours">
                            24
                        </div>
                        <span>
                            :
                        </span>
                        <div class="anuncio-temp-item" id="minutes">
                            00
                        </div>
                        <span>
                            :
                        </span>
                        <div class="anuncio-temp-item" id="seconds">
                            00
                        </div>
                    </div>
                    <div class="anuncio-footer">
                        <a href="/cadastro.php" class="btn">Aproveitar Oferta</a>
                        <p class=""><img src="./assets/img/icons/shield.svg"> 30 dias para pedir reembolso</p>
                    </div>
                </div>
                <div class="anuncio-image">
                    <img src="./assets/img/undraw_sharing_articles_re_jnkp.svg">
                </div>
            </div>
        </section>
        <section class="plans">
            <div class="plans-content container">
                <h2>Escolha seu plano</h2>
                <div class="plans-cards">
                    <div class="plans-cards-item">
                        <div class="plans-cards-item-title">
                            <h3>Premium</h3>
                            <p>perfeito para pessoa fisica</p>
                        </div>
                        <div class="plans-cards-item-header">
                            <div class="item-header-promotion">
                                <div class="item-header-promotion-price">
                                    R$ 47,99
                                </div>
                                <div class="item-header-promotion-percentage">
                                    economize 73%
                                </div>
                            </div>
                            <div class="item-header-price">
                                <p>R$ <strong>12,99</strong> /mes*</p>
                                <span class="item-header-estimated">*Estimativa de gasto mensal durante 48
                                    meses. Plano
                                    é pago de forma integral.
                                </span>
                                <p class="item-header-price-month">+ 2 Meses Grátis</p>
                                <a href="/unycall/cadastro.php" class="btn">Começar agora</a>
                                <span class="item-header-estimated">
                                    R$ 22,99/mes* ao renovar
                                </span>
                            </div>
                            <div class="item-header-body">
                                <h4>Principais Recursos</h4>
                                <ul class="list-content">
                                    <li class="before">
                                        Conexão confiavel
                                        <span class="tooltip-trigger" data-tooltip="Oferecemos uma rede confiável e estável para garantir que suas chamadas sejam sempre claras e sem interrupções.">
                                            <img src="./assets/img/icons/help.svg">
                                        </span>
                                    </li>
                                    <li class="before">
                                        Cobertura Abrangente
                                        <span class="tooltip-trigger" data-tooltip="Nossa cobertura se estende a diversas áreas, garantindo que você possa se comunicar onde quer que esteja.">
                                            <img src="./assets/img/icons/help.svg">
                                        </span>
                                    </li>
                                    <li class="before">
                                        Tecnologia de Ponta
                                        <span class="tooltip-trigger" data-tooltip="Estamos comprometidos em usar tecnologia de ponta para proporcionar a você as mais recentes inovações em serviços telefônicos.">
                                            <img src="./assets/img/icons/help.svg">
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="item-header-footer">
                                <button class="btn secondary">Ver mais recursos <img src="./assets/img/icons/arrow-drop.svg" alt=""></button>
                            </div>
                        </div>
                    </div>
                    <div class="plans-cards-item active">
                        <div class="plans-cards-item-tpromo">
                            mais popular
                        </div>
                        <div class="plans-cards-item-title">
                            <h3>Business</h3>
                            <p>Otimizada para pequenos e médios negócios</p>
                        </div>
                        <div class="plans-cards-item-header">
                            <div class="item-header-promotion">
                                <div class="item-header-promotion-price">
                                    R$ 47,99
                                </div>
                                <div class="item-header-promotion-percentage">
                                    economize 73%
                                </div>
                            </div>
                            <div class="item-header-price">
                                <p>R$ <strong>17,99</strong> /mes*</p>
                                <span class="item-header-estimated">*Estimativa de gasto mensal durante 48
                                    meses. Plano
                                    é pago de forma integral.
                                </span>
                                <p class="item-header-price-month">+ 2 Meses Grátis</p>
                                <a href="/unycall/cadastro.php" class="btn">Começar agora</a>
                                <span class="item-header-estimated">
                                    R$ 22,99/mes* ao renovar
                                </span>
                            </div>
                            <div class="item-header-body">
                                <h4>Principais Recursos</h4>
                                <ul class="list-content">
                                    <li class="before">
                                        Conexão confiavel
                                        <span class="tooltip-trigger" data-tooltip="Oferecemos uma rede confiável e estável para garantir que suas chamadas sejam sempre claras e sem interrupções.">
                                            <img src="./assets/img/icons/help.svg">
                                        </span>
                                    </li>
                                    <li class="before">
                                        Cobertura Abrangente
                                        <span class="tooltip-trigger" data-tooltip="Nossa cobertura se estende a diversas áreas, garantindo que você possa se comunicar onde quer que esteja.">
                                            <img src="./assets/img/icons/help.svg">
                                        </span>
                                    </li>
                                    <li class="before">
                                        Tecnologia de Ponta
                                        <span class="tooltip-trigger" data-tooltip="Estamos comprometidos em usar tecnologia de ponta para proporcionar a você as mais recentes inovações em serviços telefônicos.">
                                            <img src="./assets/img/icons/help.svg">
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="item-header-footer">
                                <button class="btn secondary">Ver mais recursos <img src="./assets/img/icons/arrow-drop.svg" alt=""></button>
                            </div>
                        </div>
                    </div>
                    <div class="plans-cards-item">
                        <div class="plans-cards-item-title">
                            <h3>Optimization Startup</h3>
                            <p>Aproveite o desempenho otimizado e os recursos dedicados</p>
                        </div>
                        <div class="plans-cards-item-header">
                            <div class="item-header-promotion">
                                <div class="item-header-promotion-price">
                                    R$ 47,99
                                </div>
                                <div class="item-header-promotion-percentage">
                                    economize 73%
                                </div>
                            </div>
                            <div class="item-header-price">
                                <p>R$ <strong>49,99</strong> /mes*</p>
                                <span class="item-header-estimated">*Estimativa de gasto mensal durante 48
                                    meses. Plano
                                    é pago de forma integral.
                                </span>
                                <p class="item-header-price-month">+ 2 Meses Grátis</p>
                                <a href="/unycall/cadastro.php" class="btn">Começar agora</a>
                                <span class="item-header-estimated">
                                    R$ 22,99/mes* ao renovar
                                </span>
                            </div>
                            <div class="item-header-body">
                                <h4>Principais Recursos</h4>
                                <ul class="list-content">
                                    <li class="before">
                                        Conexão confiavel
                                        <span class="tooltip-trigger" data-tooltip="Oferecemos uma rede confiável e estável para garantir que suas chamadas sejam sempre claras e sem interrupções.">
                                            <img src="./assets/img/icons/help.svg">
                                        </span>
                                    </li>
                                    <li class="before">
                                        Cobertura Abrangente
                                        <span class="tooltip-trigger" data-tooltip="Nossa cobertura se estende a diversas áreas, garantindo que você possa se comunicar onde quer que esteja.">
                                            <img src="./assets/img/icons/help.svg">
                                        </span>
                                    </li>
                                    <li class="before">
                                        Tecnologia de Ponta
                                        <span class="tooltip-trigger" data-tooltip="Estamos comprometidos em usar tecnologia de ponta para proporcionar a você as mais recentes inovações em serviços telefônicos.">
                                            <img src="./assets/img/icons/help.svg">
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="item-header-footer">
                                <button class="btn secondary">Ver mais recursos <img src="./assets/img/icons/arrow-drop.svg"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="world">
            <div class="world-content container">
                <div class="world-title">
                    <h2>Estamos espalhados pelo mundo</h2>
                    <p>Nossos planos de internet, telefone e celular contam com
                        serviços nos EUA, Reino Unido, França, Índia, Cingapura, Brasil, Lituânia e Holanda.</p>
                </div>
                <img src="./assets/img/map-7442006_1280.png" alt="">
            </div>
        </section>
        <section class="solutions-company">
            <div class="solutions-company-content container">
                <div class="solutions-company-description">
                    <h2>Soluções completas para a sua empresa</h2>
                    <ul class="list-content">
                        <li>
                            Planos a partir de 78,99
                            <span class="tooltip-trigger" data-tooltip="Oferecemos uma rede confiável e estável para garantir que suas chamadas sejam sempre claras e sem interrupções.">
                                <img src="./assets/img/icons/help.svg">
                            </span>
                        </li>
                        <li>
                            Gerencie seus pontos de internet
                            <span class="tooltip-trigger" data-tooltip="Oferecemos uma rede confiável e estável para garantir que suas chamadas sejam sempre claras e sem interrupções.">
                                <img src="./assets/img/icons/help.svg">
                            </span>
                        </li>
                        <li>
                            Planos Customizados
                            <span class="tooltip-trigger" data-tooltip="Nossa cobertura se estende a diversas áreas, garantindo que você possa se comunicar onde quer que esteja.">
                                <img src="./assets/img/icons/help.svg">
                            </span>
                        </li>
                        <li>
                            Atendimento diferenciado
                            <span class="tooltip-trigger" data-tooltip="Estamos comprometidos em usar tecnologia de ponta para proporcionar a você as mais recentes inovações em serviços telefônicos.">
                                <img src="./assets/img/icons/help.svg">
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="solutions-company-image">
                    <img src="./assets/img/undraw_our_solution_re_8yk6.svg" alt="">
                </div>
            </div>
        </section>
        <section class="cards">
            <div class="cards-content container">
                <div class="cards-item">
                    <div class="cards-item-header">
                        <h3>Neymar Jr</h3>
                    </div>
                    <div class="cards-item-body">
                        <p>ri odit dignissimos vel, neque ut molestias mollitia eius tempore, totam iure aliquid
                            error!
                        </p>
                    </div>
                    <div class="cards-item-footer">
                        <div>
                            <img src="./assets/img/icons/star.svg">
                            <img src="./assets/img/icons/star.svg">
                            <img src="./assets/img/icons/star.svg">
                            <img src="./assets/img/icons/star.svg">
                            <img src="./assets/img/icons/star.svg">
                        </div>
                        <a href="#"><img src="./assets/img/icons/arrow-drop.svg" alt="" id="arrow"></a>
                    </div>
                </div>
                <div class="cards-item">
                    <div class="cards-item-header">
                        <h3>Cristiano Ronaldo</h3>
                    </div>
                    <div class="cards-item-body">
                        <p>ri odit dignissimos vel, neque ut molestias mollitia eius tempore, totam iure aliquid
                            error!
                        </p>
                    </div>
                    <div class="cards-item-footer">
                        <div>
                            <img src="./assets/img/icons/star.svg">
                            <img src="./assets/img/icons/star.svg">
                            <img src="./assets/img/icons/star.svg">
                            <img src="./assets/img/icons/star.svg">
                            <img src="./assets/img/icons/star.svg">
                        </div>
                        <a href="#"><img src="./assets/img/icons/arrow-drop.svg" alt="" id="arrow"></a>
                    </div>
                </div>
                <div class="cards-item">
                    <div class="cards-item-header">
                        <h3>Lionel Messi</h3>
                    </div>
                    <div class="cards-item-body">
                        <p>ri odit dignissimos vel, neque ut molestias mollitia eius tempore, totam iure aliquid
                            error!
                        </p>
                    </div>
                    <div class="cards-item-footer">
                        <div>
                            <img src="./assets/img/icons/star.svg">
                            <img src="./assets/img/icons/star.svg">
                            <img src="./assets/img/icons/star.svg">
                            <img src="./assets/img/icons/star.svg">
                            <img src="./assets/img/icons/star.svg">
                        </div>
                        <a href="#"><img src="./assets/img/icons/arrow-drop.svg" alt="" id="arrow"></a>
                    </div>
                </div>

            </div>
        </section>
        <section class="solutions-company">
            <div class="solutions-company-content container">
                <div class="solutions-company-image">
                    <img src="./assets/img/undraw_analysis_dq08.svg" alt="">
                </div>
                <div class="solutions-company-description">
                    <h2>Aumente a velocidade da sua internet</h2>
                    <ul class="list-content">
                        <li class="before">
                            Conexão confiavel
                            <span class="tooltip-trigger" data-tooltip="Oferecemos uma rede confiável e estável para garantir que suas chamadas sejam sempre claras e sem interrupções.">
                                <img src="./assets/img/icons/help.svg">
                            </span>
                        </li>
                        <li class="before">
                            Cobertura Abrangente
                            <span class="tooltip-trigger" data-tooltip="Nossa cobertura se estende a diversas áreas, garantindo que você possa se comunicar onde quer que esteja.">
                                <img src="./assets/img/icons/help.svg">
                            </span>
                        </li>
                        <li class="before">
                            Tecnologia de Ponta
                            <span class="tooltip-trigger" data-tooltip="Estamos comprometidos em usar tecnologia de ponta para proporcionar a você as mais recentes inovações em serviços telefônicos.">
                                <img src="./assets/img/icons/help.svg">
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="security">
            <div class="security-content container">
                <div class="security-description">
                    <img src="./assets/img/undraw_security_on_re_e491.svg" alt="">
                    <div class="security-description-list">
                        <h2>Segurança de dados</h2>
                        <ul class="list-content">
                            <li class="before">
                                Conexão confiavel
                                <span class="tooltip-trigger" data-tooltip="Oferecemos uma rede confiável e estável para garantir que suas chamadas sejam sempre claras e sem interrupções.">
                                    <img src="./assets/img/icons/help.svg">
                                </span>
                            </li>
                            <li class="before">
                                Cobertura Abrangente
                                <span class="tooltip-trigger" data-tooltip="Nossa cobertura se estende a diversas áreas, garantindo que você possa se comunicar onde quer que esteja.">
                                    <img src="./assets/img/icons/help.svg">
                                </span>
                            </li>
                            <li class="before">
                                Tecnologia de Ponta
                                <span class="tooltip-trigger" data-tooltip="Estamos comprometidos em usar tecnologia de ponta para proporcionar a você as mais recentes inovações em serviços telefônicos.">
                                    <img src="./assets/img/icons/help.svg">
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="cards">
                    <div class="cards-content container">
                        <div class="cards-item">
                            <div class="cards-item-header">
                                <h3>Neymar Jr</h3>
                            </div>
                            <div class="cards-item-body">
                                <p>ri odit dignissimos vel, neque ut molestias mollitia eius tempore, totam iure aliquid
                                    error!
                                </p>
                            </div>
                            <div class="cards-item-footer">
                                <div>
                                    <img src="./assets/img/icons/star.svg">
                                    <img src="./assets/img/icons/star.svg">
                                    <img src="./assets/img/icons/star.svg">
                                    <img src="./assets/img/icons/star.svg">
                                    <img src="./assets/img/icons/star.svg">
                                </div>
                                <a href="#"><img src="./assets/img/icons/arrow-drop.svg" alt="" id="arrow"></a>
                            </div>
                        </div>
                        <div class="cards-item">
                            <div class="cards-item-header">
                                <h3>Cristiano Ronaldo</h3>
                            </div>
                            <div class="cards-item-body">
                                <p>ri odit dignissimos vel, neque ut molestias mollitia eius tempore, totam iure aliquid
                                    error!
                                </p>
                            </div>
                            <div class="cards-item-footer">
                                <div>
                                    <img src="./assets/img/icons/star.svg">
                                    <img src="./assets/img/icons/star.svg">
                                    <img src="./assets/img/icons/star.svg">
                                    <img src="./assets/img/icons/star.svg">
                                    <img src="./assets/img/icons/star.svg">
                                </div>
                                <a href="#"><img src="./assets/img/icons/arrow-drop.svg" alt="" id="arrow"></a>
                            </div>
                        </div>
                        <div class="cards-item">
                            <div class="cards-item-header">
                                <h3>Lionel Messi</h3>
                            </div>
                            <div class="cards-item-body">
                                <p>ri odit dignissimos vel, neque ut molestias mollitia eius tempore, totam iure aliquid
                                    error!
                                </p>
                            </div>
                            <div class="cards-item-footer">
                                <div>
                                    <img src="./assets/img/icons/star.svg">
                                    <img src="./assets/img/icons/star.svg">
                                    <img src="./assets/img/icons/star.svg">
                                    <img src="./assets/img/icons/star.svg">
                                    <img src="./assets/img/icons/star.svg">
                                </div>
                                <a href="#"><img src="./assets/img/icons/arrow-drop.svg" alt="" id="arrow"></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <section class="solutions-company">
            <div class="solutions-company-content container">
                <div class="solutions-company-image">
                    <img src="./assets/img/undraw_analysis_dq08.svg" alt="">
                </div>
                <div class="solutions-company-description">
                    <h2>Aumente a velocidade da sua internet</h2>
                    <ul class="list-content">
                        <li class="before">
                            Conexão confiavel
                            <span class="tooltip-trigger" data-tooltip="Oferecemos uma rede confiável e estável para garantir que suas chamadas sejam sempre claras e sem interrupções.">
                                <img src="./assets/img/icons/help.svg">
                            </span>
                        </li>
                        <li class="before">
                            Cobertura Abrangente
                            <span class="tooltip-trigger" data-tooltip="Nossa cobertura se estende a diversas áreas, garantindo que você possa se comunicar onde quer que esteja.">
                                <img src="./assets/img/icons/help.svg">
                            </span>
                        </li>
                        <li class="before">
                            Tecnologia de Ponta
                            <span class="tooltip-trigger" data-tooltip="Estamos comprometidos em usar tecnologia de ponta para proporcionar a você as mais recentes inovações em serviços telefônicos.">
                                <img src="./assets/img/icons/help.svg">
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="join">
            <div class="join-content container">
                <a href="/unycall/cadastro.php" class="btn">Começar agora</a>
                <p class=""><img src="./assets/img/icons/shield.svg"> 30 dias para pedir reembolso</p>
            </div>
        </section>
    </main>
    <?php require_once(__DIR__ . '/layout/footer.php'); ?>
    <script src="/unycall/assets/js/home.js"></script>
</body>

</html>