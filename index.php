<?php
  //aqui recebe os valores enviando via get pela url
    //Valor da Compra
    $Valor = $_GET['valor'];
    // Configura credenciais
    // #Pegar os dados do MP em: https://www.mercadopago.com/mlb/account/credentials?type=basic e colocar abaixo
    //Cliente Id do Mercado Pago
    $clientid = $_GET['idmp'];
    //Cliente Secret do Mercado Pago
    $clientsecret = $_GET['secretmp'];
    //número máximo de parcelas a oferecer.
    $parcelas = (int)$_GET['numeroparcelas'];
    //Nome do Pedido
    $titulopedido = $_GET['nomedopedido'];
    //Quantidade do pedido
    $quantidadepedido = $_GET['quantidadedopedido'];
    //Identificador da categoria do item.
    $categoria = $_GET['categoriadopedido'];
    //Identificador de moeda em formato ISO_4217.
    $moeda = $_GET['moedadopedido'];
    //Descrição do artigo do pedido.
    $descricao = $_GET['descricaodopedido'];
    //Como aparecerá o pagamento no extrato do cartão (ex: o MERCADOPAGO).
    $nomepagamento = $_GET['nomedopagamento'];


  include("vendor/autoload.php");

    MercadoPago\SDK::setClientId($clientid);
    MercadoPago\SDK::setClientSecret($clientsecret);

    // Cria um objeto de preferência
    $preference = new MercadoPago\Preference();
    //...
    //payment_methods = Classe que descreve os atributos e métodos de meios de pagamento.
    //
  $preference->payment_methods = array(
    //Como aparecerá o pagamento no extrato do cartão (ex: o MERCADOPAGO).
  "statement_descriptor" => $nomepagamento,
  //Você pode ativar o modo binário se o modelo de negócios exigir que a aprovação do pagamento seja 
  //instantânea. Dessa forma, o pagamento só pode ser aprovado ou recusado.
  //Se o modo binário não estiver ativado, o pagamento pode ficar pendente (no caso de exigir qualquer 
  //ação do comprador) ou em processo (se for necessária uma revisão manual).
  //Para ativá-lo, basta definir o atributo binary_mode da preferência de pagamento como true:
  "binary_mode" => false,
    //
    //excluded_payment_methods = Método que exclui por meios de pagamento específicos: Visa, Mastercard o American Express, entre outros.
  "excluded_payment_methods" => array(
    //Brasil
    //Meio de pagamento	                  ID do Tipo de pagamento.	                 ID
    //
    //Visa	                              credit_card	                               visa
    //Mastercard	                        credit_card	                               master
    //American Express	                  credit_card	                               amex
    //Hipercard	                          credit_card	                               hipercard
    //Diners Club International	          credit_card	                               diners
    //Elo	                                credit_card	                               elo
    //Cartão Mercado Livre	              credit_card	                               melicard
    //Boleto Bancario	                    ticket	                                   bolbradesco
    //Dinheiro em conta	                  account_money	                             account_money
    //Giftcard	                          digital_currency	                         giftcard
    //Pagamento na Lotérica	              ticket	                                   pec
    //Paypal	                            digital_wallet	                           paypal
    //Pix	                                bank_transfer	                             pix
    //
    array("id" => "")
  ),
    //excluded_payment_types = Método que exclui por tipo de meios de pagamento: cartão de crédito ou ticket (boleto ou pagamento em lotérica).
  "excluded_payment_types" => array(
    //Brasil
    //Meio de pagamento	                  ID do Tipo de pagamento.	                 ID
    //
    //Visa	                              credit_card	                               visa
    //Mastercard	                        credit_card	                               master
    //American Express	                  credit_card	                               amex
    //Hipercard	                          credit_card	                               hipercard
    //Diners Club International	          credit_card	                               diners
    //Elo	                                credit_card	                               elo
    //Cartão Mercado Livre	              credit_card	                               melicard
    //Boleto Bancario	                    ticket	                                   bolbradesco
    //Dinheiro em conta	                  account_money	                             account_money
    //Giftcard	                          digital_currency	                         giftcard
    //Pagamento na Lotérica	              ticket	                                   pec
    //Paypal	                            digital_wallet	                           paypal
    //Pix	                                bank_transfer	                             pix
    //
    array("id" => "ticket")
  ),
    //installments = Método que define o número máximo de parcelas a oferecer.
  "installments" => $parcelas
);
    // ...

    // Cria um item na preferência
    $item = new MercadoPago\Item();
    //Título do item, é apresentado o fluxo de pagamento.
    $item->title = $titulopedido;
    //Descrição da venda
    $item->description = $descricao;
    //Identificador da categoria do item.
    $item->category_id = $categoria;
    // quantidade da venda
    $item->quantity = $quantidadepedido;
    //Moeda do Pais da venda
    $item->currency_id = $moeda;
    //valor da compra
    $item->unit_price = $Valor;
    //
    $preference->items = array($item);
    $preference->save();
    
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8"/>
    <title>Pagamento Online</title>

    <meta http-equiv="refresh" content="0; URL='<?php echo $preference->init_point; ?>'"/>
</head>
<body>
</body>
</html>