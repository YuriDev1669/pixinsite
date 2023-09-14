<?php // Captura o corpo da solicitação POST
$input = file_get_contents('php://input');

// Decodifica o JSON recebido
$data = json_decode($input, true);

// Verifique se o pagamento foi aprovado
if (isset($data['type']) && $data['type'] === 'payment' && isset($data['data']['status']) && $data['data']['status'] === 'approved') {
    // Dados do pagamento bem-sucedido
    $paymentInfo = [
        'ID do Pagamento: ' => $data['data']['id'],
        'Data do Pagamento: ' => $data['data']['date_created'],
        'Valor: ' => $data['data']['transaction_amount'],
        'Moeda: ' => $data['data']['currency_id'],
        'Status: ' => $data['data']['status'],
        'ID do Comprador: ' => $data['data']['payer']['id'],
        'Email do Comprador: ' => $data['data']['payer']['email'],
        // Adicione mais informações que desejar
    ];

    // Caminho do arquivo .txt onde você deseja salvar os detalhes do pagamento
    $filePath = 'pagamentos_bem_sucedidos.txt';

    // Abre ou cria o arquivo .txt em modo de escrita (append)
    $file = fopen($filePath, 'a');

    // Verifica se o arquivo foi aberto com sucesso
    if ($file) {
        // Formata os dados em uma string
        $paymentInfoStr = "\n\n";
        foreach ($paymentInfo as $key => $value) {
            $paymentInfoStr .= $key . $value . "\n";
        }

        // Escreve os detalhes do pagamento no arquivo
        fwrite($file, $paymentInfoStr);

        // Fecha o arquivo
        fclose($file);
    } else {
        // Lidar com erro ao abrir o arquivo (por exemplo, registro de erro)
        error_log('Erro ao abrir o arquivo para registro de pagamentos bem-sucedidos.');
    }
}

// Envia uma resposta de sucesso para o Mercado Pago
http_response_code(200);
?>