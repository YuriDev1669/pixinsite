const express = require('express');
const bodyParser = require('body-parser');
const app = express();

// Use o middleware body-parser para analisar o corpo da solicitação JSON
app.use(bodyParser.json());

// Rota para receber notificações do webhook
app.post('/webhook', (req, res) => {
    const paymentData = req.body;

    // Verifique o status do pagamento
    const paymentStatus = paymentData.body.status;

    // Verifique se o pagamento foi aprovado
    if (paymentStatus === 'approved') {
        // O pagamento foi aprovado, faça o processamento necessário
        // Você pode atualizar o status do pedido em seu sistema ou realizar outras ações
        console.log('Pagamento aprovado:', paymentData);
    } else {
        // O pagamento foi rejeitado ou está pendente
        // Lide com esses casos de acordo com a sua lógica de negócios
        console.log('Pagamento rejeitado ou pendente:', paymentData);
    }

    res.sendStatus(200);
});

const port = process.env.PORT || 3000;
app.listen(port, () => {
    console.log(`Servidor rodando na porta ${port}`);
});
